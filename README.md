# LinguaPath AI 語言學習推薦資訊系統

一套使用 PHP + MySQL + Groq API 製作的語言學習推薦系統，提供使用者依照目標語言、目前程度、學習目標、每日時間與弱點，取得 AI 產生的個人化學習建議。

## 功能特色

- RWD 響應式介面
- 漸層色塊與卡片式 UI
- 使用者輸入學習條件
- MySQL 課程資料篩選
- Groq API 生成學習建議
- 推薦紀錄儲存
- 後台可查看課程與推薦紀錄
- 未設定 API Key 時仍可使用本地 fallback 推薦

## 環境需求

- PHP 8.0+
- MySQL / MariaDB
- Apache / XAMPP / Laragon
- Groq API Key

## 安裝方式

1. 將專案放到網站根目錄，例如：

```text
xampp/htdocs/linguapath_ai
```

2. 建立資料庫：

```sql
CREATE DATABASE linguapath_ai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. 匯入：

```text
database.sql
```

4. 修改設定檔：

```text
includes/config.php
```

設定資料庫帳號密碼與 Groq API Key。

```php
define('GROQ_API_KEY', '你的 Groq API Key');
```

建議正式部署時使用環境變數，不要把 API Key 上傳到 GitHub。

## 預設後台位置

```text
/admin/index.php
```

本版本為作品展示版，後台未加入登入權限。正式版請補上 admin login 與權限控管。

## 專案定位

本系統適合作為：

- 資訊系統開發作品
- AI API 串接作品
- LMS / 語言學習平台延伸專案
- PHP + MySQL CRUD 與 AI 推薦整合展示
