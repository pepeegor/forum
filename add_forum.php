<?php
require_once 'src/includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];

    // Валидация
    $errors = [];
    if (empty($name)) {
        $errors[] = "Название раздела не может быть пустым.";
    }
    if (strlen($name) > 255) {
        $errors[] = "Название раздела не должно превышать 255 символов.";
    }
    if (strlen($description) > 500) {
        $errors[] = "Описание раздела не должно превышать 500 символов.";
    }

    // Если ошибок нет, добавляем раздел в базу данных
    if (empty($errors)) {
        $sql = "INSERT INTO forums (name, description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $description);

        if ($stmt->execute()) {
            echo "Раздел успешно добавлен!";
        } else {
            echo "Ошибка: " . $stmt->error;
        }

        $conn->close();
    } else {
        // Выводим ошибки валидации
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</ul>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Добавить раздел</title>
    <link rel="stylesheet" href="dist/css/styles.min.css" 
    onerror="this.href='src/css/styles.css'">

</head>

<body>
    <div class="container">
        <h1>Добавить раздел</h1>
        <form method="post">
            Название: <input type="text" name="name" maxlength="255"><br>
            Описание: <textarea name="description" maxlength="500"></textarea><br>
            <input type="submit" value="Добавить">
        </form>

        <p><a href="index.php">На главную</a></p>
    </div>
    <script src="dist/js/scripts.min.js"></script>
</body>

</html>