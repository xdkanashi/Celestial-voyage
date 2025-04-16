<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';

// Получение идентификатора текущего пользователя
// Предполагаем, что есть сессия, в которой хранится ID пользователя
session_start();

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

// Получение фильтра из URL
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Получение ID пользователя из параметра URL или использование текущего пользователя
$user_id = isset($_GET['id']) ? intval($_GET['id']) : $current_user_id;


// Если администратор просматривает свой профиль, перенаправляем на профиль другого пользователя
if ($user_id == $current_user_id && isset($_GET['id'])) {
    // Попытка перенаправить на первого пользователя, который не является текущим пользователем
    $sql = "SELECT ID_users FROM users WHERE ID_users != ? ORDER BY ID_users ASC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        header("Location: index.php?id=" . $user['ID_users'] . "&filter=" . $filter);
        exit();
    } else {
        echo "No other users found.";
        exit();
    }
}

// Фильтры
// Фильтры
function getUsers($filter) {
    global $conn;

    // SQL запросы для разных фильтров
    switch ($filter) {
        case 'alphabetical_asc':
            $sql = "SELECT * FROM users ORDER BY Name ASC";
            break;
        case 'alphabetical_desc':
            $sql = "SELECT * FROM users ORDER BY Name DESC";
            break;
        case 'oldest':
            $sql = "SELECT * FROM users ORDER BY Birthdate ASC";
            break;
        case 'youngest':
            $sql = "SELECT * FROM users ORDER BY Birthdate DESC";
            break;
        case 'admins':
            $sql = "SELECT * FROM users WHERE Admin = 1";
            break;
        case 'users':
            $sql = "SELECT * FROM users WHERE Admin = 0";
            break;
        default:
            $sql = "SELECT * FROM users";
            break;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Получаем пользователей с учетом фильтра
$users = getUsers($filter);

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
    $user_id = intval($_POST['user_id']); // Извлекаем user_id из POST данных
    $name = trim($_POST['Name']);
    $surname = trim($_POST['Surname']);
    $email = trim($_POST['Email']);
    $birthdate = $_POST['Birthdate'];
    $avatar = $_FILES['Avatar'];

    // Регулярные выражения для валидации
    $email_pattern = '/^[_a-z0-9.-]+@([a-z0-9-]+\.)+[a-z]{2,}$/i';
    $name_pattern = '/^[a-zA-Z\s]+$/';
    $avatar_pattern = '/\.(jpg|jpeg|png)$/i';

    // Проверка на пустые поля
    if (empty($name) || empty($surname) || empty($email) || empty($birthdate)) {
        echo json_encode(["status" => "error", "message" => "Fill all fields"]);
        exit();
    }

    // Проверка, что имя и фамилия не содержат только пробелы
    if (ctype_space($name) || ctype_space($surname)) {
        echo json_encode(["status" => "error", "message" => "Name and Surname cannot contain only spaces."]);
        exit();
    }

    // Валидация электронной почты
    if (!preg_match($email_pattern, $email)) {
        echo json_encode(["status" => "error", "message" => "Invalid Email format."]);
        exit();
    }

    // Валидация имени и фамилии
    if (!preg_match($name_pattern, $name) || !preg_match($name_pattern, $surname)) {
        echo json_encode(["status" => "error", "message" => "Name and Surname must contain only latin letters and spaces."]);
        exit();
    }

    // Проверка даты рождения
    if (strtotime($birthdate) > time()) {
        echo json_encode(["status" => "error", "message" => "Birthdate cannot be a future date."]);
        exit();
    }

    // Проверка возраста (не более 99 лет)
    if (calculate_age($birthdate) > 99) {
        echo json_encode(["status" => "error", "message" => "Age cannot be more than 99 years."]);
        exit();
    }

    // Валидация аватарки
    if (!empty($avatar['name']) && !preg_match($avatar_pattern, $avatar['name'])) {
        echo json_encode(["status" => "error", "message" => "Avatar must be an image file (jpg, jpeg, png)."]);
        exit();
    }

    // Проверка на существующую почту, если email изменился
    $sql = "SELECT Email FROM users WHERE ID_users = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_user_email = $result->fetch_assoc()['Email'];

    if ($email !== $current_user_email) {
        $email_check_sql = "SELECT * FROM users WHERE Email = ?";
        $email_check_stmt = $conn->prepare($email_check_sql);
        $email_check_stmt->bind_param("s", $email);
        $email_check_stmt->execute();
        $email_check_result = $email_check_stmt->get_result();

        if ($email_check_result->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "An account with this email already exists."]);
            exit();
        }
    }

    // Обновление данных пользователя
    $update_sql = "UPDATE users SET Name = ?, Surname = ?, Email = ?, Birthdate = ? WHERE ID_users = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $name, $surname, $email, $birthdate, $user_id);

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
        $isAdmin = $user['Admin'];
    } else {
        echo "User not found.";
        exit();
    }

    // Получение следующего и предыдущего пользователя, исключая текущего
    $prev_sql = "SELECT ID_users FROM users WHERE ID_users < ? AND ID_users != ? ORDER BY ID_users DESC LIMIT 1";
    $next_sql = "SELECT ID_users FROM users WHERE ID_users > ? AND ID_users != ? ORDER BY ID_users ASC LIMIT 1";

    $prev_stmt = $conn->prepare($prev_sql);
    $prev_stmt->bind_param("ii", $user_id, $current_user_id);
    $prev_stmt->execute();
    $prev_result = $prev_stmt->get_result();
    $prevUser = $prev_result->fetch_assoc();

    $next_stmt = $conn->prepare($next_sql);
    $next_stmt->bind_param("ii", $user_id, $current_user_id);
    $next_stmt->execute();
    $next_result = $next_stmt->get_result();
    $nextUser = $next_result->fetch_assoc();

    // Подсчет количества пользователей по типам
    $counts_sql = "SELECT Admin, COUNT(*) as count FROM users GROUP BY Admin";
    $counts_result = $conn->query($counts_sql);
    $userCountsByType = [];
    while ($row = $counts_result->fetch_assoc()) {
        $userCountsByType[$row['Admin'] == 1 ? 'Admins' : 'Users'] = $row['count'];
    }
}

$conn->close();
?>


