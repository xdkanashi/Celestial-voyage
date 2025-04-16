<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM users WHERE ID_users = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    session_destroy();
    echo json_encode(['status' => 'success', 'message' => 'Account deleted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete account']);
}

$stmt->close();
$conn->close();
?>
