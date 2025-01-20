<?php

require_once __DIR__ . '/../src/includes/database.php';

use PHPUnit\Framework\TestCase;

class LikesTest extends TestCase
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

    public function testAddLike()
    {
        $postId = 1; // ID существующего сообщения

        // Получаем начальное количество лайков
        $sql = "SELECT likes FROM posts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $stmt->bind_result($initialLikes);
        $stmt->fetch();
        $stmt->close();

        // Имитация AJAX-запроса для лайка через file_get_contents()
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query([
                    'post_id' => $postId,
                    'action' => 'like',
                ]),
            ],
        ];

        $context = stream_context_create($opts);
        $response = file_get_contents('http://localhost/forum/src/includes/rating.php', false, $context);

        // Декодируем JSON-ответ
        $responseData = json_decode($response, true);
        $newLikes = $responseData['likes'];

        // Проверка ответа сервера
        $this->assertIsNumeric($newLikes); // Проверяем, что ответ - число

        // Проверяем, что количество лайков увеличилось на 1
        $this->assertEquals($initialLikes + 1, $newLikes, "Ошибка: количество лайков не увеличилось на 1. Начальное количество: $initialLikes, новое количество: $newLikes");
    }

    public function testAddDislike()
    {
        $postId = 1; // ID существующего сообщения

        // Получаем начальное количество лайков
        $sql = "SELECT likes FROM posts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $stmt->bind_result($initialLikes);
        $stmt->fetch();
        $stmt->close();

        // Имитация AJAX-запроса для дизлайка через file_get_contents()
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query([
                    'post_id' => $postId,
                    'action' => 'dislike',
                ]),
            ],
        ];

        $context = stream_context_create($opts);
        $response = file_get_contents('http://localhost/forum/src/includes/rating.php', false, $context);

        // Декодируем JSON-ответ
        $responseData = json_decode($response, true);
        $newLikes = $responseData['likes'];

        // Проверка ответа сервера
        $this->assertIsNumeric($newLikes); // Проверяем, что ответ - число

        // Проверяем, что количество лайков уменьшилось на 1
        $this->assertEquals($initialLikes - 1, $newLikes, "Ошибка: количество лайков не уменьшилось на 1. Начальное количество: $initialLikes, новое количество: $newLikes");
    }
}