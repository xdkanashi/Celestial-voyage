<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';
session_start();

header('Content-Type: application/json');

$email = $_POST['Email'];
$password = $_POST['Password'];

if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Please enter both email and password"]);
    exit();
}

$sql = "SELECT ID_users, Password FROM users WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($password === $user['Password']) { // Проверка пароля без хеширования
        $_SESSION['user_id'] = $user['ID_users'];
        echo json_encode(["status" => "success", "message" => "Login successful!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Incorrect password"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}

$conn->close();
?>

