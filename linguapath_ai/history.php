<?php
require_once __DIR__ . '/includes/layout.php';
require_once __DIR__ . '/includes/db.php';
$logs = db()->query('SELECT * FROM recommendation_logs ORDER BY id DESC LIMIT 30')->fetchAll();
render_header('推薦紀錄');
?>
<section class="section"><div class="container">
  <h1 class="section-title">推薦紀錄</h1>
  <div class="table-wrap">
    <table>
      <thead><tr><th>時間</th><th>語言</th><th>程度</th><th>每日時間</th><th>弱點</th><th>目標</th></tr></thead>
      <tbody>
      <?php foreach ($logs as $log): ?>
        <tr>
          <td><?= h($log['created_at']) ?></td>
          <td><span class="badge"><?= h($log['language']) ?></span></td>
          <td><?= h($log['level']) ?></td>
          <td><?= h((string)$log['daily_minutes']) ?> 分鐘</td>
          <td><?= h($log['weakness']) ?></td>
          <td><?= h(mb_strimwidth($log['goal'], 0, 80, '...')) ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$logs): ?><tr><td colspan="6">目前尚無推薦紀錄。</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div></section>
<?php render_footer(); ?>
