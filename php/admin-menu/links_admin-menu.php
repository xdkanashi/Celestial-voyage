<?php
// Подключаем файл с настройками базы данных
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';


// Получаем минимальный ID из таблицы
$query = "SELECT MIN(`ID_contact-me`) AS min_id FROM `contact-me`";
$result = mysqli_query($conn, $query);
$minIdRow = mysqli_fetch_assoc($result);
$UserminId = $minIdRow['min_id'];