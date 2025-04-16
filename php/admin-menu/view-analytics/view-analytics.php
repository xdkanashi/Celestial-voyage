<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';

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


// Выполнение запросов и получение данных
$queryPopularPosts = "SELECT `Name`, Views FROM `cosmic-objects` ORDER BY Views DESC";
$resultPopularPosts = $conn->query($queryPopularPosts)->fetch_all(MYSQLI_ASSOC);

$queryTotalViews = "SELECT SUM(Views) AS total_views FROM `cosmic-objects`";
$resultTotalViews = $conn->query($queryTotalViews)->fetch_assoc();

$queryPopularComment = "SELECT ID_Comments, Text, Likes FROM comments ORDER BY Likes DESC LIMIT 1";
$resultPopularComment = $conn->query($queryPopularComment)->fetch_assoc();

$queryTotalLikes = "SELECT SUM(Likes) AS total_likes FROM comments";
$resultTotalLikes = $conn->query($queryTotalLikes)->fetch_assoc();

$queryTotalPosts = "SELECT COUNT(*) AS total_posts FROM `cosmic-objects`";
$resultTotalPosts = $conn->query($queryTotalPosts)->fetch_assoc();

$queryPlanetPosts = "SELECT COUNT(*) AS planet_posts FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = 1";
$resultPlanetPosts = $conn->query($queryPlanetPosts)->fetch_assoc();

$queryStarPosts = "SELECT COUNT(*) AS star_posts FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = 2";
$resultStarPosts = $conn->query($queryStarPosts)->fetch_assoc();

$queryTotalComments = "SELECT COUNT(*) AS total_comments FROM comments";
$resultTotalComments = $conn->query($queryTotalComments)->fetch_assoc();

$queryTotalAccounts = "SELECT COUNT(*) AS total_accounts FROM users";
$resultTotalAccounts = $conn->query($queryTotalAccounts)->fetch_assoc();

$queryTotalAdmins = "SELECT COUNT(*) AS total_admins FROM users WHERE Admin = 1";
$resultTotalAdmins = $conn->query($queryTotalAdmins)->fetch_assoc();

$queryTotalUsers = "SELECT COUNT(*) AS total_users FROM users WHERE Admin = 0";
$resultTotalUsers = $conn->query($queryTotalUsers)->fetch_assoc();

?>
