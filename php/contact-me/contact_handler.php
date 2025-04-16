<?php
// Подключаем файл с настройками базы данных
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';

// Функция для валидации ввода
function validate_input($input, $pattern) {
    return preg_match($pattern, $input);
}

// Проверяем, что форма была отправлена методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $Email = $_POST['Email'];
    $Subject = $_POST['Subject'];
    $Content = $_POST['Content'];

    // Определяем регулярные выражения для валидации
    $Email_pattern = '/^[_a-z0-9.-]+@([a-z0-9-]+\.)+[a-z]{2,}$/i';
    $Subject_pattern = '/^[a-zA-Z\s]+$/'; // Subject будет содержать только буквы и пробелы
    $Content_pattern = '/^(?!.*(.)\1{4,}).+$/'; // Content не должен содержать 5 и более одинаковых символов подряд

    // Проверяем входные данные и возвращаем конкретные сообщения об ошибках
    $errors = [];

    // Проверка электронной почты
    if (!validate_input($Email, $Email_pattern)) {
        $errors[] = "Invalid Email format.";
    }

    // Проверка Subject
    if (!validate_input($Subject, $Subject_pattern)) {
        $errors[] = "Subject must contain only letters and spaces.";
    }

    // Проверка Content
    if (!validate_input($Content, $Content_pattern)) {
        $errors[] = "Content must not contain 5 or more consecutive identical characters.";
    }

    // Если есть ошибки, отправляем их обратно клиенту
    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => implode(" ", $errors)]);
        exit;
    }

    // Если валидация прошла успешно, вставляем данные в базу данных
    $query = "INSERT INTO `contact-me` (Email, Subject, Content) VALUES ('$Email', '$Subject', '$Content')";
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Form submitted successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($conn)]);
    }
} else {
    // Неправильный метод запроса
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}






