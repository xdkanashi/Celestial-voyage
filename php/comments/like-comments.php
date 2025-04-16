<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';

// Проверка, залогинен ли пользователь
$isLoggedIn = isset($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    if (!$isLoggedIn) {
        echo json_encode(['success' => false, 'message' => 'You must be logged in to like a comment.']);
        exit();
    }

    $data = json_decode(file_get_contents('php://input'), true);
    $commentId = $data['commentId'];

    // Обновление количества лайков в базе данных
    $sqlUpdateLikes = "UPDATE comments SET Likes = Likes + 1 WHERE ID_Comments = ?";
    $stmtUpdateLikes = $conn->prepare($sqlUpdateLikes);
    $stmtUpdateLikes->bind_param("i", $commentId);

    if ($stmtUpdateLikes->execute()) {
        // Получение обновленного количества лайков
        $sqlGetLikes = "SELECT Likes FROM comments WHERE ID_Comments = ?";
        $stmtGetLikes = $conn->prepare($sqlGetLikes);
        $stmtGetLikes->bind_param("i", $commentId);
        $stmtGetLikes->execute();
        $resultLikes = $stmtGetLikes->get_result();
        $likes = $resultLikes->fetch_assoc()['Likes'];

        echo json_encode(['success' => true, 'likes' => $likes]);
        $stmtGetLikes->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmtUpdateLikes->error]);
    }

    $stmtUpdateLikes->close();
    $conn->close();
    exit();
}
?>
