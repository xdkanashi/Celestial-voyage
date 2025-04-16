<?php   // Подключение к базе данных (замените данными вашей БД)
// Подключение к базе данных (замените данными вашей БД)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "celestial_voyage";

// Создание соединения
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Проверка соединения
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 