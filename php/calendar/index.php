<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmic Calendar | Celestial Voyage</title>
    <link rel="icon" href="/img/planet-32.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/reset.css"> <!-- Подключаем таблицу стилей для сброса стандартных стилей браузера -->
    <link rel="stylesheet" href="/css/style.css"> <!-- Подключаем таблицу стилей для оформления страницы -->
    <link rel="stylesheet" href="/css/transitions.css"> <!-- Подключаем таблицу стилей для анимаций -->
    <script src="/js/calendar_script.js" defer></script> <!-- Подключаем скрипт JavaScript -->
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
                            <a href="/php/my-profile/index.php" class="header_link">My Profile</a>
                        </li>
                        <li class="header_item">
                            <a href="/php/contact-me/index.php" class="header_link">Contact Me</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <section class="calendar-intro">
            <div class="calendars2-intro">
                <img src="/img/svg/cosmic-calendar.svg" alt="Cosmic calendar" class="calendars-logo">
                <img src="/img/svg/press-scroll.svg" alt="Press and scroll" class="press-button">
                <div class="globe-container">
                    <img src="/img/svg/arcturus.svg" alt="Globe" class="globe" onload="this.style.visibility='visible';">
                    <img src="/img/svg/Cosmonaut_4.svg" alt="Cosmonaut" class="cosmonaut3">
                    <div class="button open-button">
                        <img src="/img/svg/click-to-open.svg" alt="Click to Open">
                    </div>
                    <img src="/img/svg/text-bar.svg" alt="Text Bar" class="text-bar" style="display: none;">
                    <!-- Динамическое отображение данных о дате -->
                    <?php
                    require_once('calendar.php');

                    // Проверяем, что данные о дате получены
                    if (isset($data)) {
                        // Разделяем содержимое на строки
                        $contentLines = explode("\n", $data['Content']);
                        
                        // Подготовка JSON-строки для JavaScript
                        $contentJson = json_encode($contentLines);
                        
                        // Передаем строки контента в скрытый элемент для JavaScript
                        echo "<div id='content-data' style='display: none;'>{$contentJson}</div>";
                        
                        // Отображаем дату
                        echo "<div class='calendar-date'><p>Date: {$data['Date']}</p></div>";
                        
                        // Подготовка пустых `text-bar` элементов для JavaScript
                        echo "<div class='text-bar calendar-text' style='display: none;'></div>";
                        echo "<div class='text-bar calendar2-text' style='display: none;'></div>";
                    } else {
                        echo "<div class='data-error'<p>No data available for the selected date</p>";
                    }
                    ?>
                </div>
                <div class="navigation-buttons">
                    <?php
                    // Если данные о дате найдены, показываем кнопки навигации
                    if (isset($data)) {
                        $previous_Date = Date('Y-m-d', strtotime($data['Date'] . ' -1 day'));
                        $next_Date = Date('Y-m-d', strtotime($data['Date'] . ' +1 day'));
                        echo "<a href='index.php?Date=$previous_Date'><img src='/img/svg/arrow-left.svg' alt='Previous' class='prev-button'></a>";
                        echo "<a href='index.php?Date=$next_Date'><img src='/img/svg/arrow-right.svg' alt='Next' class='next-button'></a>";
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>



