<?php
require_once 'src/includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $forumId = $_POST["forum_id"];
  $title = $_POST["title"];

  // Валидация
  $errors = [];
  if (empty($title)) {
    $errors[] = "Название темы не может быть пустым.";
  }
  if (strlen($title) > 255) {
    $errors[] = "Название темы не должно превышать 255 символов.";
  }
  if (!is_numeric($forumId)) {
    $errors[] = "Некорректный ID раздела.";
  }

  // Если ошибок нет, добавляем тему в базу данных
  if (empty($errors)) {
    $sql = "INSERT INTO topics (forum_id, title) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $forumId, $title);

    if ($stmt->execute()) {
      // Редирект на страницу раздела после успешного добавления темы
      header("Location: forum.php?id=" . $forumId);
      exit();
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

// Получение списка разделов для выпадающего списка
$sql = "SELECT * FROM forums";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Добавить тему</title>
  <link rel="stylesheet" href="dist/css/styles.min.css" 
  onerror="this.href='src/css/styles.css'">
</head>

<body>
  <h1>Добавить тему</h1>
  <form method="post">
    Раздел:
    <select name="forum_id">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
        }
      }
      ?>
    </select><br>
    Название: <input type="text" name="title" maxlength="255"><br> 
    <input type="submit" value="Добавить">
  </form>

  <p><a href="index.php">На главную</a></p>
  <script src="dist/js/scripts.min.js"></script>
</body>

</html>