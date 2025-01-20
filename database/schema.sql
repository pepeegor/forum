-- Создание таблиц
CREATE TABLE forums (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT
);

CREATE TABLE topics (
  id INT AUTO_INCREMENT PRIMARY KEY,
  forum_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (forum_id) REFERENCES forums(id)
);

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  topic_id INT NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  likes INT DEFAULT 0,
  FOREIGN KEY (topic_id) REFERENCES topics(id)
);

-- Добавление тестовых данных
INSERT INTO forums (name, description) VALUES
('Общие вопросы', 'Обсуждение общих вопросов'),
('PHP', 'Вопросы по PHP');

INSERT INTO topics (forum_id, title) VALUES
(1, 'Приветствие'),
(2, 'Xdebug');

INSERT INTO posts (topic_id, content, likes) VALUES
(1, 'Привет всем!', 5),
(2, 'Как установить Xdebug?', 10);