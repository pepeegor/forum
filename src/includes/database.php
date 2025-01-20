<?php

$servername = "localhost";
$username = "root"; // Замени на имя пользователя твоей базы данных
$password = "";     // Замени на пароль твоей базы данных
$dbname = "forum";   // Замени на имя твоей базы данных

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
  die("Ошибка подключения: " . $conn->connect_error);
}

// Устанавливаем кодировку UTF-8
$conn->set_charset("utf8");

?>