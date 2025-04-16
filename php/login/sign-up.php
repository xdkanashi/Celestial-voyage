<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';

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

// Получение данных из формы
$name = trim($_POST["Name"]);
$surname = trim($_POST["Surname"]);
$email = $_POST["Email"];
$birthdate = $_POST["Birthdate"];
$password = $_POST["Password"];
$avatar = $_FILES["Avatar"];

// Определяем регулярные выражения для валидации
$email_pattern = '/^[_a-z0-9.-]+@([a-z0-9-]+\.)+[a-z]{2,}$/i';
$name_pattern = '/^[a-zA-Z\s]+$/'; // Имя и фамилия могут содержать только буквы и пробелы
$avatar_pattern = '/\.(jpg|jpeg|png)$/i'; // Проверка на допустимые форматы файлов аватарки
$password_pattern = '/^(?=.*[A-Z])(?=.*\d)[^\s]+$/'; // Пароль должен содержать хотя бы одну заглавную букву, одну цифру и не содержать пробелов

// Проверка на пустые поля
if (empty($name) || empty($surname) || empty($email) || empty($birthdate) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Fill all fields"]);
    exit;
}

// Проверка на только пробелы в имени и фамилии
if (ctype_space($name) || ctype_space($surname)) {
    echo json_encode(["status" => "error", "message" => "Name and Surname cannot contain only spaces."]);
    exit;
}

// Проверка электронной почты
if (!validate_input($email, $email_pattern)) {
    echo json_encode(["status" => "error", "message" => "Invalid Email format."]);
    exit;
}

// Проверка имени и фамилии
if (!validate_input($name, $name_pattern) || !validate_input($surname, $name_pattern)) {
    echo json_encode(["status" => "error", "message" => "Name and Surname must contain only latin letters and spaces."]);
    exit;
}

// Проверка даты рождения
$age = calculate_age($birthdate);
if (strtotime($birthdate) > time()) {
    echo json_encode(["status" => "error", "message" => "Birthdate cannot be a future date."]);
    exit;
} elseif ($age > 99) {
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

// Проверка аватарки
if (!empty($avatar['name']) && !validate_input($avatar['name'], $avatar_pattern)) {
    echo json_encode(["status" => "error", "message" => "Avatar must be an image file (jpg, jpeg, png)."]);
    exit;
}

// Проверка на наличие повторного аккаунта по электронной почте
$email_check_sql = "SELECT * FROM users WHERE Email = ?";
$email_check_stmt = $conn->prepare($email_check_sql);
$email_check_stmt->bind_param("s", $email);
$email_check_stmt->execute();
$email_check_result = $email_check_stmt->get_result();

if ($email_check_result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "An account with this email already exists."]);
    exit;
}

// Подготовка пути для сохранения аватара
$avatar_path = null;
if (!empty($avatar['name'])) {
    $uploadDir = '/img/profile/avatars-profile/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $avatar_path = $uploadDir . basename($avatar['name']);
    if (!move_uploaded_file($avatar['tmp_name'], $avatar_path)) {
        echo json_encode(["status" => "error", "message" => "Failed to upload avatar."]);
        exit;
    }
}

// Подготовка SQL-запроса для вставки данных
$sql = "INSERT INTO users (Name, Surname, Email, Birthdate, Password, Avatar) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $surname, $email, $birthdate, $password, $avatar_path);

// Выполнение SQL-запроса
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Registration successful!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>

