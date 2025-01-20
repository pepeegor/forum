<?php
require_once 'src/includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];

    $sql = "INSERT INTO forums (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $description);

    if ($stmt->execute()) {
        echo "Раздел успешно добавлен!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Добавить раздел</title>
    <link rel="stylesheet" href="dist/css/styles.min.css">
    
</head>

<body>
    <div class="container">
        <h1>Добавить раздел</h1>
        <form method="post">
            Название: <input type="text" name="name"><br>
            Описание: <textarea name="description"></textarea><br>
            <input type="submit" value="Добавить">
        </form>

        <p><a href="index.php">На главную</a></p>
    </div>
    <script src="dist/js/scripts.min.js"></script>
</body>

</html>