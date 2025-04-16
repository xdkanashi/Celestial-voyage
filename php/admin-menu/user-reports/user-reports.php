<?php
// Подключаем файл с настройками базы данных
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';

// Получение идентификатора текущего пользователя
// Предполагаем, что есть сессия, в которой хранится ID пользователя
session_start();

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header("Location: /php/login/index.php");
    exit();
}

$current_user_id = $_SESSION['user_id'];


// Проверка, является ли пользователь администратором
function isAdmin($user_id) {
    global $conn;
    $sql = "SELECT Admin FROM users WHERE ID_users = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    return $user['Admin'] == 1;
}

if (!isAdmin($current_user_id)) {
    header("Location: /html/main.html");
    exit();
}

// Получаем ID текущего отчета
$currentId = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Получаем данные текущего отчета из базы данных
$query = "SELECT * FROM `contact-me` WHERE `ID_contact-me` = $currentId";
$result = mysqli_query($conn, $query);
$report = mysqli_fetch_assoc($result);

// Получаем ID предыдущего и следующего отчета
$prevQuery = "SELECT `ID_contact-me` FROM `contact-me` WHERE `ID_contact-me` < $currentId ORDER BY `ID_contact-me` DESC LIMIT 1";
$prevResult = mysqli_query($conn, $prevQuery);
$prevReport = mysqli_fetch_assoc($prevResult);

$nextQuery = "SELECT `ID_contact-me` FROM `contact-me` WHERE `ID_contact-me` > $currentId ORDER BY `ID_contact-me` ASC LIMIT 1";
$nextResult = mysqli_query($conn, $nextQuery);
$nextReport = mysqli_fetch_assoc($nextResult);

// Закрываем соединение с базой данных
mysqli_close($conn);
?>