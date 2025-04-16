<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';

// Получение фильтра из URL
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Получение строки поиска из URL
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Получение класса объекта из параметра URL (1 для планет или 2 для звезд)
$objectClass = isset($_GET['class']) ? intval($_GET['class']) : 2;

// Получение ID объекта из параметра URL или использование первого объекта в классе
$stellarId = isset($_GET['id']) ? intval($_GET['id']) : null;

function getstellars($filter, $objectClass, $search) {
    global $conn;

    // SQL запросы для разных фильтров
    switch ($filter) {
        case 'alphabetical_asc':
            $sql = "SELECT * FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = ? AND `Name` LIKE ? ORDER BY `Name` ASC";
            break;
        case 'alphabetical_desc':
            $sql = "SELECT * FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = ? AND `Name` LIKE ? ORDER BY `Name` DESC";
            break;
        case 'greatest_mass':
            $sql = "SELECT * FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = ? AND `Name` LIKE ? ORDER BY `Mass` DESC";
            break;
        case 'largest_area':
            $sql = "SELECT * FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = ? AND `Name` LIKE ? ORDER BY `Area` DESC";
            break;
        case 'fastest_speed':
            $sql = "SELECT * FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = ? AND `Name` LIKE ? ORDER BY `Speed` DESC";
            break;
        case 'red_giant':
            $sql = "SELECT * FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = ? AND `Cosmic-objects_type` = 5 AND `Name` LIKE ?";
            break;
        case 'supergiant':
            $sql = "SELECT * FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = ? AND `Cosmic-objects_type` = 8 AND `Name` LIKE ?";
            break;
        case 'main_sequence_star':
            $sql = "SELECT * FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = ? AND `Cosmic-objects_type` = 10 AND `Name` LIKE ?";
            break;
        case 'most_viewed':
            $sql = "SELECT * FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = ? AND `Name` LIKE ? ORDER BY `Views` DESC";
            break;
        default:
            $sql = "SELECT * FROM `cosmic-objects` WHERE `Cosmic-objects_object-class` = ? AND `Name` LIKE ?";
            break;
    }

    // Добавление символа % для поиска по префиксу
    // % в конце строки означает, что название планеты должно начинаться с первых 3 букв строки $search
    $search = substr($search, 0, 3) . '%';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $objectClass, $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $stellars = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $stellars[] = $row;
        }
    }

    return $stellars;
}

function getstellarCountsByType($objectClass) {
    global $conn;
    $sql = "SELECT `type`.`Name` AS `TypeName`, COUNT(*) AS `Count`
            FROM `cosmic-objects`
            JOIN `type` ON `cosmic-objects`.`Cosmic-objects_type` = `type`.`ID_type`
            WHERE `cosmic-objects`.`Cosmic-objects_object-class` = ?
            GROUP BY `type`.`Name`"; // Группировка по имени типа объектов
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $objectClass);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $counts = [];
    while ($row = $result->fetch_assoc()) {
        $counts[$row['TypeName']] = $row['Count']; // Заполнение массива с количеством объектов по типам
    }
    
    return $counts;
}

try {
    // Подавление ошибок PHP
    error_reporting(0);
    ini_set('display_errors', 0);

    // Получаем список планет с учетом фильтра и строки поиска
    $stellars = getstellars($filter, $objectClass, $search);

    // Получаем количество планет по типам
    $stellarCountsByType = getstellarCountsByType($objectClass);

    // Если ID планеты не задан, выбираем первую планету из списка
    if (!$stellarId && count($stellars) > 0) {
        $stellarId = $stellars[0]['ID_Cosmic-objects'];
    }

    // Запрос данных о планете из базы данных с учетом класса объекта
    $sql = "SELECT * FROM `cosmic-objects` WHERE `ID_Cosmic-objects` = ? AND `Cosmic-objects_object-class` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $stellarId, $objectClass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stellar = $result->fetch_assoc();

        // Увеличение количества просмотров на 1
        $newViews = $stellar['Views'] + 1;
        $update_sql = "UPDATE `cosmic-objects` SET `Views` = ? WHERE `ID_Cosmic-objects` = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $newViews, $stellarId);
        $update_stmt->execute();

        // Получение класса объекта
        $sql_class = "SELECT `Name` FROM `object-class` WHERE `ID_Object-class` = ?";
        $stmt_class = $conn->prepare($sql_class);
        $stmt_class->bind_param("i", $stellar['Cosmic-objects_object-class']);
        $stmt_class->execute();
        $result_class = $stmt_class->get_result();
        $object_class = $result_class->num_rows > 0 ? $result_class->fetch_assoc()['Name'] : 'Unknown';

        // Получение типа объекта
        $sql_type = "SELECT `Name` FROM `type` WHERE `ID_type` = ?";
        $stmt_type = $conn->prepare($sql_type);
        $stmt_type->bind_param("i", $stellar['Cosmic-objects_type']);
        $stmt_type->execute();
        $result_type = $stmt_type->get_result();
        $object_type = $result_type->num_rows > 0 ? $result_type->fetch_assoc()['Name'] : 'Unknown';

    } else {
        $stellar = null;
    }

    // Определение индексов текущей, предыдущей и следующей планет
    $currentIndex = array_search($stellarId, array_column($stellars, 'ID_Cosmic-objects'));
    $prevIndex = $currentIndex - 1 >= 0 ? $currentIndex - 1 : count($stellars) - 1;
    $nextIndex = $currentIndex + 1 < count($stellars) ? $currentIndex + 1 : 0;

    $prevstellar = $stellars[$prevIndex];
    $nextstellar = $stellars[$nextIndex];

    // Проверка, если есть поиск и найденные планеты, перенаправление на страницу без параметра search
    if (!empty($search) && count($stellars) > 0) {
        $url = "index.php?id=$stellarId&class=$objectClass&filter=$filter";
        header("Location: $url");
        exit();
    }

} catch (Exception $e) {
    $stellar = null;
}

// Восстановление уровня отчетности об ошибках
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn->close();
?>
