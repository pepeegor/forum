<?php
// Подключение к базе данных
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    $postId = intval($_POST["post_id"]); // Валидация
    $action = $_POST["action"];

    // Обновляем рейтинг в базе данных
    if ($action == "like") {
        $sql = "UPDATE posts SET likes = likes + 1 WHERE id = $postId";
    } else { // $action == "dislike"
        $sql = "UPDATE posts SET likes = likes - 1 WHERE id = $postId";
    }

    if ($conn->query($sql) === TRUE) { // Проверка результата
        // Возвращаем обновленное количество лайков
        $sql = "SELECT likes FROM posts WHERE id = $postId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $likes = $row["likes"];
            echo $likes; // Возврат в формате JSON
        } else {
            echo json_encode(['error' => 'Сообщение не найдено']);
        }
    } else {
        echo json_encode(['error' => 'Ошибка обновления рейтинга: ' . $conn->error]);
    }
}


?>