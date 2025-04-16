<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/db.php';
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin menu | Celestial Voyage</title>
    <link rel="icon" href="/img/planet-32.ico" type="image/x-icon">
    <!-- Подключаем таблицу стилей для сброса стандартных стилей браузера -->
    <link rel="stylesheet" href="/css/reset.css">
    <!-- Подключаем таблицу стилей для оформления страницы -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- Подключаем таблицу стилей для анимаций -->
    <link rel="stylesheet" href="/css/transitions.css">
    <!-- Подключаем скрипт JavaScript -->
    <script src="/js/skills_script.js" defer></script>
</head>
<body>
    <!-- Верхний блок страницы -->
    <header class="header">
        <!-- Обертка для центрирования содержимого -->
        <div class="wrapper">
            <!-- Обертка для элементов верхнего блока -->
            <div class="header_wrapper">
                <!-- Логотип -->
                <div class="header_logo">
                    <!-- Текстовый логотип -->
                    <a href="/html/main.html" class="header_logo">Celestial Voyage</a>
                </div>
                <!-- Навигационное меню -->
                <nav class="header_nav">
                    <!-- Список ссылок -->
                    <ul class="header_list">
                        <!-- Ссылка "Мой профиль" -->
                        <li class="header_item">
                            <a href="/php/my-profile/index.php" class="header_link">My profile</a>
                        </li>
                        <!-- Ссылка "Свяжитесь со мной" -->
                        <li class="header_item">
                            <a href="/php/contact-me/index.php" class="header_link">Contact me</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <!-- Основное содержимое страницы -->
    <main>
        <!-- Секция вступления -->
        <section class="intro-admin">
            <div class="admin-intro">
                <!-- Начальное приветствие -->
                <img src="/img/svg/admin-logo.svg" alt="admin menu" class="admin-logo">
                <div class="skills-name">Here is list of some of my admin skills</div>
                <img src="/img/svg/press-scroll.svg" alt="press and scroll" class="press-button">
                <!-- Контейнер для глобуса -->
                <div class="globe-container">
                    <img src="/img/svg/polaris.svg" alt="Globe" class="globe" onload="this.style.visibility='visible';">
                    <img src="/img/svg/Cosmonaut_2.svg" alt="Cosmonaut" class="cosmonaut2">
                </div>
                <!-- Контейнеры с навыками -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/php/admin-menu/links_admin-menu.php'; ?>
                <div class="container-wrapper" style="transform: translateX(-40%);">
                    <a href="/php/admin-menu/manage-users/index.php?id=1" class="container skills-container1">Manage <br> Users</a>
                    <a href="/php/admin-menu/manage-objects/index.php?filter=" class="container skills-container2">Manage <br> Objects</a>
                    <a href="/php/admin-menu/moderate-comments/index.php" class="container skills-container3">Moderate <br> Comments</a>
                    <a href="/php/admin-menu/user-reports/index.php?id=<?php echo $UserminId; ?>" class="container skills-container4">User <br> Reports</a>
                    <a href="/php/admin-menu/view-analytics/index.php" class="container skills-container5">View <br> Analytics</a>
                </div>
                <!-- Социальные иконки -->
                <section class="social-icons">
                    <a href="https://github.com" class="social-icon github">
                        <img src="/img/svg/github.svg" alt="GitHub">
                    </a>
                    <a href="https://instagram.com" class="social-icon instagram">
                        <img src="/img/svg/instagram.svg" alt="Instagram">
                    </a>
                    <a href="https://linkedin.com" class="social-icon linkedin">
                        <img src="/img/svg/linkedin.svg" alt="LinkedIn">
                    </a>
                    <a href="https://behance.net" class="social-icon behance">
                        <img src="/img/svg/behance.svg" alt="Behance">
                    </a>
                </section>
            </div>   
        </section>
    </main>
</body>
</html>
