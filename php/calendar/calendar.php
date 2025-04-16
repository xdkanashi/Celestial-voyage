<?php
// Подключаем файл с настройками базы данных
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';

// Получаем дату из параметра URL или используем текущую дату по умолчанию
$Date = isset($_GET['Date']) ? $_GET['Date'] : Date('Y-m-d');

// Запрос данных о дате из базы данных
$query = "SELECT * FROM `cosmic_calendar` WHERE `Date` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $Date);
$stmt->execute();
$result = $stmt->get_result();

// Инициализация переменной данных о дате
$data = null;

// Если данные о дате найдены, заполняем переменную $data
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
}

// Освобождаем ресурсы и закрываем подготовленное выражение
$stmt->close();
?>

