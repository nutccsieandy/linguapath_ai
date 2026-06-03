<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

function build_course_text(array $courses): string {
    if (!$courses) {
        return "目前資料庫沒有完全符合條件的課程，請依使用者需求提出保守建議。";
    }

    $lines = [];
    foreach ($courses as $course) {
        $lines[] = sprintf(
            "課程ID：%s｜課程：%s｜語言：%s｜程度：%s｜技能：%s｜每週建議：%s 分鐘｜說明：%s",
            $course['id'],
            $course['title'],
            $course['language_name'],
            $course['level'],
            $course['skill_focus'],
            $course['weekly_minutes'],
            $course['description']
        );
    }
    return implode("\n", $lines);
}

function fallback_recommendation(array $profile, array $courses): string {
    $courseNames = array_map(fn($c) => '「' . $c['title'] . '」', $courses);
    $courseText = $courseNames ? implode('、', $courseNames) : '基礎聽力、核心單字、情境口說練習';

    return "## 本地推薦結果\n\n" .
        "由於尚未設定 Groq API Key，系統先依照資料庫與規則產生推薦。\n\n" .
        "### 推薦課程\n" . $courseText . "\n\n" .
        "### 推薦理由\n" .
        "你的目標語言是 {$profile['language']}，目前程度為 {$profile['level']}，目標是 {$profile['goal']}。每日可投入 {$profile['daily_minutes']} 分鐘，因此建議採取短時間、高頻率、弱點優先的學習策略。\n\n" .
        "### 4 週學習安排\n" .
        "第 1 週：建立核心單字與基本句型。\n\n" .
        "第 2 週：加強聽力輸入與跟讀。\n\n" .
        "第 3 週：進行情境口說與短文輸出。\n\n" .
        "第 4 週：模擬測驗並修正弱點。\n\n" .
        "### 注意事項\n" .
        "不要只背單字，請把單字放進句子與情境中練習。若目標是考試，至少每週安排一次小測驗。";
}

function ask_groq(array $profile, array $courses): string {
    if (trim(GROQ_API_KEY) === '') {
        return fallback_recommendation($profile, $courses);
    }

    $courseText = build_course_text($courses);
    $prompt = "你是一位專業語言學習顧問。請根據使用者資料與系統提供的課程資料，產生個人化語言學習推薦。\n\n" .
        "限制：\n" .
        "1. 不可編造不存在於課程資料中的課程。\n" .
        "2. 必須根據使用者程度、目標、每日時間與弱點推薦。\n" .
        "3. 請用繁體中文回答。\n" .
        "4. 回答要具體，適合作為資訊系統推薦結果。\n\n" .
        "使用者資料：\n" .
        "目標語言：{$profile['language']}\n" .
        "目前程度：{$profile['level']}\n" .
        "學習目標：{$profile['goal']}\n" .
        "每日時間：{$profile['daily_minutes']} 分鐘\n" .
        "弱點：{$profile['weakness']}\n\n" .
        "課程資料：\n{$courseText}\n\n" .
        "請輸出：\n" .
        "1. 推薦課程\n2. 推薦理由\n3. 4週學習計畫\n4. 每日任務\n5. 弱點改善建議";

    $payload = [
        'model' => GROQ_MODEL,
        'messages' => [
            ['role' => 'system', 'content' => '你是專業、務實、保守且具體的語言學習顧問。'],
            ['role' => 'user', 'content' => $prompt]
        ],
        'temperature' => 0.35,
        'max_tokens' => 1200
    ];

    $ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . GROQ_API_KEY,
            'Content-Type: application/json'
        ],
        CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
        CURLOPT_TIMEOUT => 25
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false || $status < 200 || $status >= 300) {
        return "## AI 串接失敗\n\nGroq API 暫時無法回應。HTTP 狀態：{$status}\n\n錯誤訊息：" . ($error ?: '請檢查 API Key、模型名稱或伺服器網路。') . "\n\n" . fallback_recommendation($profile, $courses);
    }

    $json = json_decode($response, true);
    return $json['choices'][0]['message']['content'] ?? fallback_recommendation($profile, $courses);
}
