<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';
session_start();

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header("Location: /php/login/index.php");
    exit();
}

$current_user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$delete_user_id = isset($data['user_id']) ? intval($data['user_id']) : null;


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

// Получение ID следующего пользователя
$next_sql = "SELECT ID_users FROM users WHERE ID_users > ? ORDER BY ID_users ASC LIMIT 1";
$next_stmt = $conn->prepare($next_sql);
$next_stmt->bind_param("i", $delete_user_id);
$next_stmt->execute();
$next_result = $next_stmt->get_result();
$next_user = $next_result->fetch_assoc();
$next_user_id = $next_user ? $next_user['ID_users'] : null;

// Если следующего пользователя нет, получить первого пользователя
if (!$next_user_id) {
    $first_sql = "SELECT ID_users FROM users ORDER BY ID_users ASC LIMIT 1";
    $first_stmt = $conn->prepare($first_sql);
    $first_stmt->execute();
    $first_result = $first_stmt->get_result();
    $first_user = $first_result->fetch_assoc();
    $next_user_id = $first_user ? $first_user['ID_users'] : null;
}

// Удаление указанного пользователя
if ($delete_user_id) {
    $sql = "DELETE FROM users WHERE ID_users = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_user_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Account deleted successfully', 'next_user_id' => $next_user_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete account']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No user ID provided']);
}

$conn->close();
?>



