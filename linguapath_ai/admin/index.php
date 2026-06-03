<?php
require_once __DIR__ . '/../includes/layout.php';
require_once __DIR__ . '/../includes/db.php';
$pdo = db();
$courseCount = (int)$pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn();
$logCount = (int)$pdo->query('SELECT COUNT(*) FROM recommendation_logs')->fetchColumn();
$langCount = (int)$pdo->query('SELECT COUNT(*) FROM languages')->fetchColumn();
render_header('後台首頁');
?>
<section class="container">
  <div class="admin-hero">
    <h1>系統後台</h1>
    <p>作品展示版後台：可查看課程資料與 AI 推薦紀錄。正式版建議補上管理員登入與 CRUD 權限。</p>
  </div>
  <div class="cards">
    <article class="card"><div class="icon">🌐</div><h3>語言數</h3><p><b><?= $langCount ?></b> 種語言</p></article>
    <article class="card"><div class="icon">📘</div><h3>課程數</h3><p><b><?= $courseCount ?></b> 筆課程</p></article>
    <article class="card"><div class="icon">🤖</div><h3>推薦紀錄</h3><p><b><?= $logCount ?></b> 筆紀錄</p></article>
  </div>
  <div class="btns">
    <a class="btn primary" href="courses.php">課程管理</a>
    <a class="btn ghost" href="logs.php">AI 紀錄</a>
  </div>
</section>
<?php render_footer(); ?>
