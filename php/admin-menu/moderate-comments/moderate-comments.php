<?php
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

// Получение ID космического объекта из URL
$cosmicObjectId = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Получение информации о космическом объекте
$sqlObject = "
    SELECT `Name`, (SELECT `Name` FROM `object-class` WHERE `ID_Object-class` = `Cosmic-objects_object-class`) AS `Class`
    FROM `cosmic-objects`
    WHERE `ID_Cosmic-objects` = ?";
$stmtObject = $conn->prepare($sqlObject);
$stmtObject->bind_param("i", $cosmicObjectId);
$stmtObject->execute();
$resultObject = $stmtObject->get_result();
$cosmicObject = $resultObject->fetch_assoc();
$stmtObject->close();

// Получение списка всех космических объектов
$sqlPlanets = "
    SELECT `ID_Cosmic-objects`, `Name`
    FROM `cosmic-objects`
    ORDER BY `ID_Cosmic-objects` ASC";
$stmtPlanets = $conn->prepare($sqlPlanets);
$stmtPlanets->execute();
$resultPlanets = $stmtPlanets->get_result();
$planets = [];

if ($resultPlanets->num_rows > 0) {
    while ($row = $resultPlanets->fetch_assoc()) {
        $planets[] = $row;
    }
}
$stmtPlanets->close();

// Определение текущей, предыдущей и следующей планеты
$currentIndex = array_search($cosmicObjectId, array_column($planets, 'ID_Cosmic-objects'));
$prevIndex = $currentIndex - 1 >= 0 ? $currentIndex - 1 : count($planets) - 1;
$nextIndex = $currentIndex + 1 < count($planets) ? $currentIndex + 1 : 0;

$prevPlanet = $planets[$prevIndex];
$nextPlanet = $planets[$nextIndex];

// Получение комментариев из базы данных для конкретного космического объекта
$sqlComments = "
    SELECT comments.ID_Comments, comments.Text, comments.Date, users.Name, users.Surname, users.Avatar, users.Admin, comments.Likes
    FROM comments 
    JOIN users ON comments.Comments_Users = users.ID_Users 
    WHERE comments.`Comments_Cosmic-objects` = ? 
    ORDER BY comments.Date DESC";
// JOIN объединяет таблицы comments и users, где поле Comments_Users в таблице comments
// соответствует полю ID_Users в таблице users. Это позволяет получить данные о пользователе
// (имя, фамилия, аватар, админ-статус), который оставил комментарий, вместе с текстом и датой комментария.
// Фильтр WHERE comments.`Comments_Cosmic-objects` = ? выбирает комментарии для конкретного космического объекта.
// ORDER BY comments.Date DESC сортирует комментарии по дате в порядке убывания, показывая самые последние комментарии первыми.

$stmtComments = $conn->prepare($sqlComments);
$stmtComments->bind_param("i", $cosmicObjectId);
$stmtComments->execute();
$resultComments = $stmtComments->get_result();
$comments = [];

if ($resultComments->num_rows > 0) {
    while($row = $resultComments->fetch_assoc()) {
        $comments[] = $row;
    }
}
$stmtComments->close();

$conn->close();
?>