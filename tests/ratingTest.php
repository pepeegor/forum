<?php

use PHPUnit\Framework\TestCase;

class RatingTest extends TestCase
{
    protected $conn; // Добавляем свойство для хранения соединения

    protected function setUp(): void
    {
        $servername = "localhost";
        $username = "root"; 
        $password = "";    
        $dbname = "forum";

        $this->conn = new mysqli($servername, $username, $password, $dbname); // Устанавливаем соединение
    }

    public function testAsyncRating()
    {
        // Имитация AJAX-запроса для лайка
        $_POST['post_id'] = 1; // ID тестового сообщения
        $_POST['action'] = 'like';

        // Замер времени выполнения асинхронного запроса
        $start = microtime(true);
        require_once __DIR__ . '/../src/includes/rating.php';
        $end = microtime(true);
        $asyncTime = $end - $start;

        $this->assertLessThan(0.1, $asyncTime); // Проверяем, что время меньше 0.1 секунды
    }

    public function testSyncRating()
    {
        // Имитация синхронного обновления рейтинга
        $postId = 1; // ID тестового сообщения

        // Замер времени выполнения синхронного запроса
        $start = microtime(true);

        // Синхронное обновление лайков
        $sql = "UPDATE posts SET likes = likes + 1 WHERE id = $postId";
        $this->conn->query($sql);

        // Получение обновленного количества лайков
        $sql = "SELECT likes FROM posts WHERE id = $postId";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        $end = microtime(true);
        $syncTime = $end - $start;

        $this->assertLessThan(0.2, $syncTime); // Проверяем, что время меньше 0.2 секунды
    }

    public function testRatingPerformance()
    {
        $postId = 1; // ID тестового сообщения

        // Замер времени выполнения асинхронного запроса
        $_POST['post_id'] = $postId;
        $_POST['action'] = 'like';
        $start = microtime(true);
        require_once __DIR__ . '/../src/includes/rating.php';
        $end = microtime(true);
        $asyncTime = $end - $start;

        // Замер времени выполнения синхронного запроса
        $start = microtime(true);
        $sql = "UPDATE posts SET likes = likes + 1 WHERE id = $postId";
        $this->conn->query($sql);
        $sql = "SELECT likes FROM posts WHERE id = $postId";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        $end = microtime(true);
        $syncTime = $end - $start;

        // Сравнение времени выполнения
        $this->assertLessThan($syncTime, $asyncTime, "Асинхронный запрос должен быть быстрее синхронного");
    }
}