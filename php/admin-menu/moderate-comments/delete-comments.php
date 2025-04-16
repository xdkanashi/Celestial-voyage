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

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Получение ID комментария из запроса
    if (isset($_GET['id'])) {
        $commentId = intval($_GET['id']);
        if ($commentId > 0) {
            // Удаление комментария из базы данных
            $sqlDelete = "DELETE FROM comments WHERE ID_Comments = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param("i", $commentId);

            if ($stmtDelete->execute()) {
                echo json_encode(['success' => true, 'message' => 'Comment deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error deleting comment.']);
            }

            $stmtDelete->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid comment ID.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Comment ID not provided.']);
    }
}

$conn->close();
?>

