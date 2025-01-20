<!DOCTYPE html>
<html>

<head>
  <title>Форум</title>
  <link rel="stylesheet" href="dist/css/styles.min.css">
</head>

<body>
  <header>
    <div class="container">
      <h1>Добро пожаловать на форум!</h1>
      <p><a href="add_forum.php">Добавить раздел</a></p>
    </div>
  </header>

  <main>
    <div class="container">
      <?php
      // Подключение к базе данных
      require_once 'src/includes/database.php';

      // Запрос на получение списка разделов форума
      $sql = "SELECT * FROM forums";
      $result = $conn->query($sql);

      // Вывод списка разделов
      if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
          echo "<li><a href='forum.php?id=" . $row["id"] . "'>" . $row["name"] . "</a></li>";
        }
        echo "</ul>";
      } else {
        echo "Разделов пока нет.";
      }

      $conn->close();
      ?>
    </div>
  </main>

  <script src="dist/js/scripts.min.js"></script>
</body>

</html>