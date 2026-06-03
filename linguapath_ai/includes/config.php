<?php
declare(strict_types=1);

// LinguaPath AI 設定檔
// 正式部署請改用環境變數，不要把 API Key 上傳到公開 GitHub。

define('APP_NAME', 'LinguaPath AI');
define('DB_HOST', 'localhost');
define('DB_NAME', 'linguapath_ai');
define('DB_USER', 'root');
define('DB_PASS', 'sf6210sf');

// 可直接填入，也可設定環境變數 GROQ_API_KEY
define('GROQ_API_KEY', getenv('GROQ_API_KEY') ?: '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');
define('GROQ_MODEL', getenv('GROQ_MODEL') ?: 'llama-3.1-8b-instant');

function h(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function base_url(string $path = ''): string {
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    if (str_contains($base, '/admin')) {
        $base = dirname($base);
    }
    return $base . '/' . ltrim($path, '/');
}
