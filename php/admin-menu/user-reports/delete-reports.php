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
$delete_report_id = isset($data['id']) ? intval($data['id']) : null;

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

// Получение ID следующего отчета
$next_sql = "SELECT `ID_contact-me` FROM `contact-me` WHERE `ID_contact-me` > ? ORDER BY `ID_contact-me` ASC LIMIT 1";
$next_stmt = $conn->prepare($next_sql);
$next_stmt->bind_param("i", $delete_report_id);
$next_stmt->execute();
$next_result = $next_stmt->get_result();
$next_report = $next_result->fetch_assoc();
$next_report_id = $next_report ? $next_report['ID_contact-me'] : null;

// Если следующего отчета нет, получить первый отчет
if (!$next_report_id) {
    $first_sql = "SELECT `ID_contact-me` FROM `contact-me` ORDER BY `ID_contact-me` ASC LIMIT 1";
    $first_stmt = $conn->prepare($first_sql);
    $first_stmt->execute();
    $first_result = $first_stmt->get_result();
    $first_report = $first_result->fetch_assoc();
    $next_report_id = $first_report ? $first_report['ID_contact-me'] : null;
}

// Удаление указанного отчета
if ($delete_report_id) {
    $sql = "DELETE FROM `contact-me` WHERE `ID_contact-me` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_report_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Report deleted successfully', 'next_report_id' => $next_report_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete report']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No report ID provided']);
}

$conn->close();
?>



