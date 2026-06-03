<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/layout.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/ai.php';

$pdo = db();
$languages = $pdo->query('SELECT * FROM languages ORDER BY id')->fetchAll();
$result = '';
$matchedCourses = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile = [
        'language' => trim($_POST['language'] ?? '英文'),
        'level' => trim($_POST['level'] ?? 'B1'),
        'goal' => trim($_POST['goal'] ?? ''),
        'daily_minutes' => max(10, (int)($_POST['daily_minutes'] ?? 30)),
        'weakness' => trim($_POST['weakness'] ?? '')
    ];

    $stmt = $pdo->prepare("SELECT c.*, l.name AS language_name FROM courses c JOIN languages l ON l.id = c.language_id WHERE l.name = ? AND (c.level = ? OR c.skill_focus LIKE ? OR c.description LIKE ?) ORDER BY c.id LIMIT 8");
    $weakLike = '%' . $profile['weakness'] . '%';
    $stmt->execute([$profile['language'], $profile['level'], $weakLike, $weakLike]);
    $matchedCourses = $stmt->fetchAll();

    if (!$matchedCourses) {
        $stmt = $pdo->prepare("SELECT c.*, l.name AS language_name FROM courses c JOIN languages l ON l.id = c.language_id WHERE l.name = ? ORDER BY c.id LIMIT 8");
        $stmt->execute([$profile['language']]);
        $matchedCourses = $stmt->fetchAll();
    }

    $result = ask_groq($profile, $matchedCourses);

    $log = $pdo->prepare('INSERT INTO recommendation_logs(language, level, goal, daily_minutes, weakness, ai_response) VALUES(?,?,?,?,?,?)');
    $log->execute([$profile['language'], $profile['level'], $profile['goal'], $profile['daily_minutes'], $profile['weakness'], $result]);
}

render_header('AI推薦');
?>
<section class="section">
  <div class="container">
    <h1 class="section-title">AI 語言學習推薦</h1>
    <?php if (GROQ_API_KEY === ''): ?>
      <div class="alert">目前尚未設定 Groq API Key，系統會先使用本地 fallback 推薦。請到 includes/config.php 設定。</div>
    <?php endif; ?>
    <form class="form-card" method="post">
      <div class="form-grid">
        <div class="field">
          <label>目標語言</label>
          <select name="language">
            <?php foreach ($languages as $lang): ?>
              <option value="<?= h($lang['name']) ?>"><?= h($lang['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label>目前程度</label>
          <select name="level">
            <option>A1</option><option>A2</option><option selected>B1</option><option>B2</option><option>C1</option>
          </select>
        </div>
        <div class="field">
          <label>每日可學習時間（分鐘）</label>
          <input type="number" name="daily_minutes" value="30" min="10" max="240">
        </div>
        <div class="field">
          <label>主要弱點</label>
          <input name="weakness" placeholder="例如：口說、聽力、單字、閱讀速度">
        </div>
        <div class="field full">
          <label>學習目標</label>
          <textarea name="goal" placeholder="例如：TOEIC 600 想提升到 700，想加強口說與職場英文。"></textarea>
        </div>
      </div>
      <div class="btns"><button class="btn primary" type="submit">產生推薦</button></div>
    </form>

    <?php if ($result): ?>
      <section class="section">
        <h2 class="section-title">推薦結果</h2>
        <?php if ($matchedCourses): ?>
          <p class="muted">本次系統先篩選出 <?= count($matchedCourses) ?> 筆課程資料，再交由 AI 生成建議。</p>
        <?php endif; ?>
        <div class="result"><?= h($result) ?></div>
      </section>
    <?php endif; ?>
  </div>
</section>
<?php render_footer(); ?>
