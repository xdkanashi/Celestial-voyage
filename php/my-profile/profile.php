<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';
session_start();

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header("Location: /php/login/index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Функция для валидации ввода
function validate_input($input, $pattern) {
    return preg_match($pattern, $input);
}

// Функция для проверки возраста
function calculate_age($birthdate) {
    $birthDate = new DateTime($birthdate);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;
    return $age;
}

// Если запрос методом POST, обрабатываем обновление профиля
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['Name']);
    $surname = trim($_POST['Surname']);
    $email = $_POST['Email'];
    $birthdate = $_POST['Birthdate'];
    $password = $_POST['Password'];
    $avatar = $_FILES['Avatar'];

    // Регулярные выражения для валидации
    $email_pattern = '/^[_a-z0-9.-]+@([a-z0-9-]+\.)+[a-z]{2,}$/i';
    $name_pattern = '/^[a-zA-Z\s]+$/'; 
    $avatar_pattern = '/\.(jpg|jpeg|png)$/i'; 
    $password_pattern = '/^(?=.*[A-Z])(?=.*\d)[^\s]+$/'; // Пароль должен содержать хотя бы одну заглавную букву, одну цифру и не содержать пробелов 

    // Проверка на пустые поля
    if (empty($name) || empty($surname) || empty($email) || empty($birthdate) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Fill all fields"]);
        exit;
    }

    // Проверка, что имя и фамилия не содержат только пробелы
    if (ctype_space($name) || ctype_space($surname)) {
        echo json_encode(["status" => "error", "message" => "Name and Surname cannot contain only spaces."]);
        exit;
    }

    // Валидация электронной почты
    if (!preg_match($email_pattern, $email)) {
        echo json_encode(["status" => "error", "message" => "Invalid Email format."]);
        exit;
    }

    // Валидация имени и фамилии
    if (!preg_match($name_pattern, $name) || !preg_match($name_pattern, $surname)) {
        echo json_encode(["status" => "error", "message" => "Name and Surname must contain only latin letters and spaces."]);
        exit;
    }

    // Проверка даты рождения
    if (strtotime($birthdate) > time()) {
        echo json_encode(["status" => "error", "message" => "Birthdate cannot be a future date."]);
        exit;
    }

    // Проверка возраста (не более 99 лет)
    if (calculate_age($birthdate) > 99) {
        echo json_encode(["status" => "error", "message" => "Age cannot be more than 99 years."]);
        exit;
    }

    // Проверка пароля
    if (ctype_space($password)) {
        echo json_encode(["status" => "error", "message" => "Password cannot contain only spaces."]);
        exit;
    }
    if (!validate_input($password, $password_pattern)) {
        echo json_encode(["status" => "error", "message" => "Password must contain at least one uppercase letter, one number, and no spaces."]);
        exit;
    }

    // Валидация аватарки
    if (!empty($avatar['name']) && !preg_match($avatar_pattern, $avatar['name'])) {
        echo json_encode(["status" => "error", "message" => "Avatar must be an image file (jpg, jpeg, png)."]);
        exit;
    }

    // Проверка на существующую почту
    $email_check_sql = "SELECT * FROM users WHERE Email = ? AND ID_users != ?";
    $email_check_stmt = $conn->prepare($email_check_sql);
    $email_check_stmt->bind_param("si", $email, $user_id);
    $email_check_stmt->execute();
    $email_check_result = $email_check_stmt->get_result();

    if ($email_check_result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "An account with this email already exists."]);
        exit;
    }

    // Обновление данных пользователя
    $update_sql = "UPDATE users SET Name = ?, Surname = ?, Email = ?, Birthdate = ?, Password = ? WHERE ID_users = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssi", $name, $surname, $email, $birthdate, $password, $user_id);

    if ($update_stmt->execute()) {
        if (!empty($avatar['name'])) {
            $uploadDir = '/img/profile/avatars-profile/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $avatar_path = $uploadDir . basename($avatar['name']);
            if (move_uploaded_file($avatar['tmp_name'], $avatar_path)) {
                $avatar_sql = "UPDATE users SET Avatar = ? WHERE ID_users = ?";
                $avatar_stmt = $conn->prepare($avatar_sql);
                $avatar_stmt->bind_param("si", $avatar_path, $user_id);
                $avatar_stmt->execute();

                // Возвращаем путь к новой аватарке в ответе
                echo json_encode(["status" => "success", "message" => "Profile updated successfully!", "avatar" => $avatar_path]);
                exit();
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to upload avatar."]);
                exit();
            }
        }

        echo json_encode(["status" => "success", "message" => "Profile updated successfully!"]);
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating profile."]);
        exit();
    }
} else {
    // Получение данных пользователя для отображения на странице профиля
    $sql = "SELECT * FROM users WHERE ID_users = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $isAdmin = $user['Admin']; // Добавлено для получения значения категории Admin
    } else {
        echo "User not found.";
        exit();
    }
}

$conn->close();
?>

