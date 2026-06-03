<?php
require_once __DIR__ . '/../includes/layout.php';
require_once __DIR__ . '/../includes/db.php';
$courses = db()->query('SELECT c.*, l.name AS language_name FROM courses c JOIN languages l ON l.id=c.language_id ORDER BY c.id DESC')->fetchAll();
render_header('課程管理');
?>
<section class="section"><div class="container">
<h1 class="section-title">課程管理</h1>
<div class="table-wrap"><table>
<thead><tr><th>ID</th><th>語言</th><th>課程</th><th>程度</th><th>技能</th><th>每週分鐘</th><th>說明</th></tr></thead>
<tbody><?php foreach($courses as $c): ?><tr><td><?= h((string)$c['id']) ?></td><td><span class="badge"><?= h($c['language_name']) ?></span></td><td><?= h($c['title']) ?></td><td><?= h($c['level']) ?></td><td><?= h($c['skill_focus']) ?></td><td><?= h((string)$c['weekly_minutes']) ?></td><td><?= h(mb_strimwidth($c['description'],0,70,'...')) ?></td></tr><?php endforeach; ?></tbody>
</table></div>
</div></section>
<?php render_footer(); ?>
