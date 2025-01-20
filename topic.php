<?php
// Подключение к базе данных
require_once 'src/includes/database.php';
require_once 'src/includes/posts.php'; // Подключаем файл для работы с сообщениями

// Получение ID темы из GET параметра
$topicId = $_GET["id"];

// Запрос на получение данных темы
$sql = "SELECT * FROM topics WHERE id = $topicId";
$result = $conn->query($sql);
$topic = $result->fetch_assoc();

// Запрос на получение сообщений в теме
$sql = "SELECT * FROM posts WHERE topic_id = $topicId";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["content"]) && !isset($_POST["action"])) {
    $content = $_POST["content"];
    createPost($conn, $topicId, $content);

    // Редирект на ту же страницу
    header("Location: topic.php?id=" . $topicId);
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Форум - <?php echo $topic["title"]; ?></title>
    <link rel="stylesheet" href="dist/css/styles.min.css">
</head>

<di>
    <div class="container">
        <h1><?php echo $topic["title"]; ?></h1>

        <?php
        // Вывод сообщений
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div id='post-" . $row["id"] . "' class='post'>";
                echo "<p>" . $row["content"] . "</p>";
                echo "<div class='rating'>";
                echo "<span class='likes'>" . $row["likes"] . "</span>";
                echo "<button class='like-btn' data-post-id='" . $row["id"] . "'>+</button>";
                echo "<button class='dislike-btn' data-post-id='" . $row["id"] . "'>-</button>";
                // echo "<span class='dislikes'>" . $row["dislikes"] . "</span>"; // !!! Удаляем эту строку
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "Сообщений пока нет.";
        }
        ?>

        <h2>Добавить сообщение</h2>
        <form method="post">
            <textarea name="content" rows="5" cols="40"></textarea><br>
            <input type="submit" value="Отправить">
        </form>

        <p><a href="forum.php?id=<?php echo $topic["forum_id"]; ?>">Назад к разделу</a></p>
        <p><a href="index.php">На главную</a></p>
    </div>

    <script src="dist/js/scripts.min.js"></script>
    </body>

</html>