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

// Получение строки поиска из URL
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Получение данных для фильтрации и поиска
function getCosmicObjects($filter, $search) {
    global $conn;

    // Базовый SQL запрос
    $sql = "SELECT * FROM `cosmic-objects`";
    
    // Условия для строки поиска
    $whereClauses = [];
    $params = [];
    $paramTypes = '';

    if (!empty($search)) {
        $whereClauses[] = "`Name` LIKE ?";
        $params[] = '%' . $search . '%';
        $paramTypes .= 's';
    }

    // SQL запросы для разных фильтров
    switch ($filter) {
        case 'alphabetical_asc':
            $sql .= " ORDER BY `Name` ASC";
            break;
        case 'alphabetical_desc':
            $sql .= " ORDER BY `Name` DESC";
            break;
        case 'greatest_mass':
            $sql .= " ORDER BY `Mass` DESC";
            break;
        case 'largest_area':
            $sql .= " ORDER BY `Area` DESC";
            break;
        case 'fastest_speed':
            $sql .= " ORDER BY `Speed` DESC";
            break;
        case 'red_giant':
            $whereClauses[] = "`Cosmic-objects_type` = 5";
            break;
        case 'supergiant':
            $whereClauses[] = "`Cosmic-objects_type` = 8";
            break;
        case 'main_sequence_star':
            $whereClauses[] = "`Cosmic-objects_type` = 10";
            break;
        case 'terrestrial_planet':
            $whereClauses[] = "`Cosmic-objects_type` = 1";
            break;
        case 'gas_giant':
            $whereClauses[] = "`Cosmic-objects_type` = 2";
            break;
        case 'ice_giant':
            $whereClauses[] = "`Cosmic-objects_type` = 3";
            break;
        case 'most_viewed':
            $sql .= " ORDER BY `Views` DESC";
            break;
            case 'planets':
                $whereClauses[] = "`Cosmic-objects_object-class` = 1";
                break;
            case 'stars':
                $whereClauses[] = "`Cosmic-objects_object-class` = 2";
                break;
    }

    // Объединяем условия WHERE, если они есть
    if (count($whereClauses) > 0) {
        $sql .= " WHERE " . implode(' AND ', $whereClauses);
    }

    $stmt = $conn->prepare($sql);

    // Привязка параметров, если они есть
    if (!empty($paramTypes)) {
        $stmt->bind_param($paramTypes, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $cosmicObjects = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cosmicObjects[] = $row;
        }
    }

    return $cosmicObjects;
}

// Получение количества объектов по типам
function getObjectCountsByType() {
    global $conn;

    $sql = "SELECT type.Name AS TypeName, COUNT(*) AS Count
            FROM `cosmic-objects`
            JOIN type ON `cosmic-objects`.`Cosmic-objects_type` = type.ID_type
            GROUP BY type.Name";
    
    $result = $conn->query($sql);

    $counts = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $counts[$row['TypeName']] = $row['Count'];
        }
    }

    return $counts;
}

// Получаем список космических объектов с учетом фильтра и строки поиска
$cosmicObjects = getCosmicObjects($filter, $search);

// Получаем количество объектов по типам
$objectCountsByType = getObjectCountsByType();

$conn->close();
?>




