<?php
// Подключение к базе данных
require_once 'src/includes/database.php';

// Получение ID раздела из GET параметра
$forumId = $_GET["id"];

// Запрос на получение данных раздела
$sql = "SELECT * FROM forums WHERE id = $forumId";
$result = $conn->query($sql);
$forum = $result->fetch_assoc();

// Запрос на получение списка тем в разделе
$sql = "SELECT * FROM topics WHERE forum_id = $forumId";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Форум - <?php echo $forum["name"]; ?></title>
    <link rel="stylesheet" href="dist/css/styles.min.css" onerror="this.href='src/css/styles.css'">
</head>

<body>
    <div class="container">
        <h1><?php echo $forum["name"]; ?></h1>
        <p><?php echo $forum["description"]; ?></p>

        <?php
        // Вывод списка тем
        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li><a href='topic.php?id=" . $row["id"] . "'>" . $row["title"] . "</a></li>";
            }
            echo "</ul>";
        } else {
            echo "Тем пока нет.";
        }

        $conn->close();
        ?>

        <p><a href="add_topic.php">Добавить тему</a></p>

        <p><a href="index.php">На главную</a></p>
    </div>

    <script src="dist/js/scripts.min.js"></script>
</body>

</html>