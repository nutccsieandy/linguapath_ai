<?php
require_once __DIR__ . '/../includes/layout.php';
require_once __DIR__ . '/../includes/db.php';
$logs = db()->query('SELECT * FROM recommendation_logs ORDER BY id DESC LIMIT 50')->fetchAll();
render_header('AI紀錄');
?>
<section class="section"><div class="container">
<h1 class="section-title">AI 推薦紀錄</h1>
<div class="cards">
<?php foreach($logs as $log): ?>
<article class="card">
  <span class="badge"><?= h($log['language']) ?>｜<?= h($log['level']) ?></span>
  <h3><?= h(mb_strimwidth($log['goal'],0,44,'...')) ?></h3>
  <p>每日 <?= h((string)$log['daily_minutes']) ?> 分鐘｜弱點：<?= h($log['weakness']) ?></p>
  <p class="muted"><?= h($log['created_at']) ?></p>
</article>
<?php endforeach; ?>
<?php if(!$logs): ?><article class="card"><p>目前尚無推薦紀錄。</p></article><?php endif; ?>
</div>
</div></section>
<?php render_footer(); ?>
