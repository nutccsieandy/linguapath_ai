<?php require_once __DIR__ . '/includes/layout.php'; render_header('首頁'); ?>
<section class="hero">
  <div class="container hero-grid">
    <div>
      <span class="eyebrow">AI 語言學習推薦資訊系統</span>
      <h1>把語言學習目標，轉成可執行的學習路徑。</h1>
      <p>LinguaPath AI 會依照目標語言、目前程度、每日可用時間與弱點，結合資料庫課程與 Groq 生成式 AI，產出個人化推薦方案。</p>
      <div class="btns">
        <a class="btn primary" href="recommend.php">開始 AI 推薦</a>
        <a class="btn ghost" href="history.php">查看推薦紀錄</a>
      </div>
    </div>
    <div class="hero-card">
      <h2>推薦流程</h2>
      <div class="metric-grid">
        <div class="metric"><b>01</b>輸入目標</div>
        <div class="metric"><b>02</b>課程篩選</div>
        <div class="metric"><b>03</b>AI 分析</div>
        <div class="metric"><b>04</b>紀錄追蹤</div>
      </div>
    </div>
  </div>
</section>
<section class="section">
  <div class="container">
    <h2 class="section-title">系統亮點</h2>
    <div class="cards">
      <article class="card"><div class="icon">🧠</div><h3>Groq API 串接</h3><p>支援 llama-3.1-8b-instant，可透過設定檔切換模型。</p></article>
      <article class="card"><div class="icon">📚</div><h3>資料庫導向推薦</h3><p>AI 只根據 MySQL 課程資料進行推薦，降低亂編風險。</p></article>
      <article class="card"><div class="icon">📱</div><h3>RWD 漸層 UI</h3><p>支援桌機、平板與手機瀏覽，使用卡片式介面呈現。</p></article>
    </div>
  </div>
</section>
<?php render_footer(); ?>
