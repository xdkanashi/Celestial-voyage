<?php include('user-reports.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Устанавливаем кодировку документа -->
    <meta charset="UTF-8">
    <!-- Определяем масштаб и размер экрана для мобильных устройств -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Устанавливаем заголовок страницы -->
    <title>User Reports | Celestial Voyage</title>
    <link rel="icon" href="/img/planet-32.ico" type="image/x-icon">
    <!-- Подключаем таблицы стилей -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/transitions.css">
    <script src="/js/user-reports_script.js" defer></script> <!-- Подключаем скрипт JavaScript -->
</head>
<body>
<header class="header">
        <div class="wrapper">
            <div class="header_wrapper">
                <div class="header_logo">
                    <a href="/html/main.html" class="header_logo">Celestial Voyage</a>
                </div>
                <nav class="header_nav">
                    <ul class="header_list">
                        <li class="header_item">
                            <a href="/html/skills.html" class="header_link">Skills</a>
                        </li>
                        <li class="header_item">
                            <a href="/php/admin-menu/admin-menu.php" class="header_link">Admin menu</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <!-- Основное содержимое страницы -->
    <main>
        <!-- Секция Контактов -->
        <section class="calendars13-intro">
            <div class="navigation-buttons">
                <?php if ($prevReport): ?>
                    <a href="index.php?id=<?php echo $prevReport['ID_contact-me']; ?>">
                        <img src="/img/svg/arrow-left.svg" alt="Previous" class="prev-button">
                    </a>
                <?php else: ?>
                    <div style="visibility: hidden;"></div>
                <?php endif; ?>
                <?php if ($nextReport): ?>
                    <a href="index.php?id=<?php echo $nextReport['ID_contact-me']; ?>">
                        <img src="/img/svg/arrow-right.svg" alt="Next" class="next-button">
                    </a>
                <?php else: ?>
                    <div style="visibility: hidden;"></div>
                <?php endif; ?>
            </div>
            <div class="intro-content">
                <div id="response-container" style="display: none;">
                    <!-- Ответ сервера будет отображаться здесь -->
                </div>
                <img src="/img/svg/reports-logo.svg" alt="Contact me" class="contact-logo">
                <!-- Отображаем данные из базы данных -->
                <div class="contact-container">
                    <input type="email" class="email" value="<?php echo ($report['Email']); ?>" readonly />
                    <textarea class="subject" readonly><?php echo ($report['Subject']); ?></textarea>
                    <textarea class="content" style="height: 300px;" readonly><?php echo ($report['Content']); ?></textarea>
                </div>
                <div class="contact-wrapper">
                    <div class="contact text-email">Email: </div>
                    <div class="contact text-subject">Subject: </div>
                    <div class="contact text-content">Content: </div>
                </div>
                <div class="button delete-button">
                    <!-- Измените тег <div> на <button> -->
                    <button type="button" id="deleteReportButton" data-id="<?php echo $report['ID_contact-me']; ?>" style="background-color: transparent; border: none;">
                    <img src="/img/svg/delete-button.svg" alt="delete button">
                    </button>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

