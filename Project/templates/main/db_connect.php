<?php
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "finaldb";

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
  die("Ошибка соединения: " . $conn->connect_error);
}
