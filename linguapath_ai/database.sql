CREATE DATABASE IF NOT EXISTS linguapath_ai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE linguapath_ai;

DROP TABLE IF EXISTS recommendation_logs;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS languages;

CREATE TABLE languages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  code VARCHAR(20) NOT NULL,
  description TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  language_id INT NOT NULL,
  title VARCHAR(120) NOT NULL,
  level VARCHAR(30) NOT NULL,
  skill_focus VARCHAR(80) NOT NULL,
  weekly_minutes INT NOT NULL DEFAULT 150,
  description TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_courses_language FOREIGN KEY(language_id) REFERENCES languages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE recommendation_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  language VARCHAR(50) NOT NULL,
  level VARCHAR(30) NOT NULL,
  goal VARCHAR(255) NOT NULL,
  daily_minutes INT NOT NULL,
  weakness VARCHAR(255) NOT NULL,
  ai_response MEDIUMTEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO languages(name, code, description) VALUES
('英文','en','適合 TOEIC、口說、聽力、學術與職場英文。'),
('日文','ja','適合 JLPT、旅遊會話與商務溝通。'),
('韓文','ko','適合韓語基礎、TOPIK 與生活會話。');

INSERT INTO courses(language_id, title, level, skill_focus, weekly_minutes, description) VALUES
(1,'TOEIC 600 到 700 聽讀強化','B1','listening,reading',210,'針對 TOEIC 中級學習者，強化聽力題型、閱讀速度與核心字彙。'),
(1,'職場英文口說情境訓練','B1','speaking',150,'以自我介紹、會議、簡報、面試與客戶溝通作為口說主題。'),
(1,'英文核心單字與句型養成','A2','vocabulary,grammar',120,'建立高頻單字、基礎文法與常用句型，適合基礎補強。'),
(1,'AI 英文對話每日練習','B1','speaking,listening',180,'透過每日短對話與跟讀練習，提升反應速度與口說流暢度。'),
(2,'日文 N5 入門文法與五十音','A1','grammar,vocabulary',150,'從五十音、基本句型、助詞與日常單字開始建立日文基礎。'),
(2,'日文旅遊會話實戰','A2','speaking,listening',120,'以點餐、問路、購物與住宿為主題，建立旅遊實用會話能力。'),
(3,'韓文發音與生活會話入門','A1','speaking,listening',120,'學習韓文字母、發音規則與常見生活對話。'),
(3,'TOPIK 初級單字與閱讀','A2','reading,vocabulary',150,'針對 TOPIK 初級準備，強化單字、短文閱讀與基本文法。');
