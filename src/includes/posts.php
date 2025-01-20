<?php

// Функция для создания нового сообщения
function createPost($conn, $topicId, $content) {
  // Подготавливаем SQL запрос
  $sql = "INSERT INTO posts (topic_id, content, created_at) 
          VALUES (?, ?, NOW())";

  // Используем prepared statements для защиты от SQL инъекций
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("is", $topicId, $content);

  // Выполняем запрос
  if ($stmt->execute()) {
    // Сообщение успешно добавлено
    return true;
  } else {
    // Произошла ошибка
    echo "Ошибка: " . $stmt->error;
    return false;
  }
}

?>