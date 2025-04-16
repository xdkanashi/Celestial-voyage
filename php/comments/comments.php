<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';

// Проверка, залогинен ли пользователь
$isLoggedIn = isset($_SESSION['user_id']);

// Обработка отправки комментария
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    header('Content-Type: application/json');

    if (!$isLoggedIn) {
        echo json_encode(['success' => false, 'message' => 'You must be logged in to post a comment.']);
        exit();
    }

    $comment = trim($_POST['comment']);
    $userId = $_SESSION['user_id'];
    $cosmicObjectId = $_POST['cosmicObjectId'];
    $objectClass = $_POST['objectClass'];

    // Валидация комментария
    if (empty($comment)) {
        echo json_encode(['success' => false, 'message' => 'Comment cannot be empty or just spaces.']);
        exit();
    }

    // Регулярное выражение для проверки допустимых символов (латинские буквы, цифры, пробелы и знаки препинания)
    $pattern = '/^[a-zA-Z0-9\s.,!?\'"()-]+$/';
    if (!preg_match($pattern, $comment)) {
        echo json_encode(['success' => false, 'message' => 'Comment contains invalid characters.']);
        exit();
    }

    $sqlInsert = "INSERT INTO comments (Comments_Users, Text, Date, `Comments_Cosmic-objects`) VALUES (?, ?, NOW(), ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $userId, $comment, $cosmicObjectId);

    if ($stmtInsert->execute()) {
        $insertedId = $stmtInsert->insert_id;
        // Получение информации о новом комментарии
        $sqlComment = "
            SELECT comments.Text, comments.Date, users.Name, users.Surname, users.Avatar, comments.Likes, comments.ID_Comments
            FROM comments 
            JOIN users ON comments.Comments_Users = users.ID_Users 
            WHERE comments.ID_Comments = ?";
        $stmtComment = $conn->prepare($sqlComment);
        $stmtComment->bind_param("i", $insertedId);
        $stmtComment->execute();
        $resultComment = $stmtComment->get_result();
        $newComment = $resultComment->fetch_assoc();
        echo json_encode(['success' => true, 'message' => 'Comment added successfully.', 'comment' => $newComment]);
        $stmtComment->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmtInsert->error]);
    }

    $stmtInsert->close();
    exit();
}


// Получение ID космического объекта из URL
$cosmicObjectId = isset($_GET['id']) ? intval($_GET['id']) : 1;
$objectClass = isset($_GET['class']) ? intval($_GET['class']) : 1;

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

// Получение списка всех планет
$sqlPlanets = "
    SELECT `ID_Cosmic-objects`, `Name`
    FROM `cosmic-objects`
    WHERE `Cosmic-objects_object-class` = ?
    ORDER BY `ID_Cosmic-objects` ASC";
$stmtPlanets = $conn->prepare($sqlPlanets);
$stmtPlanets->bind_param("i", $objectClass);
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