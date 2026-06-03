<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

function render_header(string $title = APP_NAME): void { ?>
<!doctype html>
<html lang="zh-Hant">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= h($title) ?>｜<?= h(APP_NAME) ?></title>
  <link rel="stylesheet" href="<?= h(base_url('assets/css/style.css')) ?>">
</head>
<body>
<header class="topbar">
  <a class="brand" href="<?= h(base_url('index.php')) ?>">
    <span class="brand-mark">L</span>
    <strong>LinguaPath AI</strong>
  </a>
  <button class="menu-btn" type="button" data-menu-btn>☰</button>
  <nav class="nav" data-nav>
    <a href="<?= h(base_url('index.php')) ?>">首頁</a>
    <a href="<?= h(base_url('recommend.php')) ?>">AI推薦</a>
    <a href="<?= h(base_url('history.php')) ?>">推薦紀錄</a>
    <a href="<?= h(base_url('admin/index.php')) ?>">後台</a>
  </nav>
</header>
<main>
<?php }

function render_footer(): void { ?>
</main>
<footer class="footer">
  <p>© <?= date('Y') ?> LinguaPath AI｜語言學習推薦資訊系統作品展示版</p>
</footer>
<script src="<?= h(base_url('assets/js/app.js')) ?>"></script>
</body>
</html>
<?php }
