<?php

require_once __DIR__ . '/../src/includes/database.php';
require_once __DIR__ . '/../src/includes/posts.php';

use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{

    protected $conn;

    protected function setUp(): void
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "forum";

        $this->conn = new mysqli($servername, $username, $password, $dbname); // Устанавливаем соединение
    }

    public function testCreatePost()
    {
        $topicId = 1; // ID существующей темы
        $content = 'Тестовое сообщение';

        $result = createPost($this->conn, $topicId, $content);

        $this->assertTrue($result); // Проверяем, что функция вернула true

        // Проверяем, что сообщение добавлено в базу данных
        $sql = "SELECT COUNT(*) FROM posts WHERE topic_id = ? AND content = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $topicId, $content);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $this->assertGreaterThan(0, $count); 
    }
}