<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Устанавливаем кодировку документа -->
    <meta charset="UTF-8">
    <!-- Определяем масштаб и размер экрана для мобильных устройств -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Устанавливаем заголовок страницы -->
    <title>Contact Me | Celestial Voyage</title>
    <link rel="icon" href="/img/planet-32.ico" type="image/x-icon">
    <!-- Подключаем таблицы стилей -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/transitions.css">
    <script src="/js/contact-me_script.js" defer></script> <!-- Подключаем скрипт JavaScript -->
</head>

<body>
    <!-- Верхний блок страницы -->
    <header class="header">
        <div class="wrapper">
            <div class="header_wrapper">
                <div class="header_logo">
                    <nav class="header-nav">
                        <ul class="nav-list">
                            <li class="nav-item"><a href="javascript:history.back()" class="header_logo"> &lt; Go back</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Основное содержимое страницы -->
    <main>
        <!-- Секция Контактов -->
        <section class="contact-intro">
            <div class="intro-content">
            <div id="response-container" style="display: none;">
                <!-- Ответ сервера будет отображаться здесь -->
            </div>
                <img src="/img/svg/contact-me.svg" alt="Contact me" class="contact-logo">
                <!-- Добавляем форму -->
                <form action="contact_handler.php" method="POST" class="contact-form">
                    <div class="contact-container">
                        <input type="mail" name="Email" class="email" placeholder="Enter email..."maxlength="50" required/>
                        <textarea name="Subject" type="text" class="subject" placeholder="Enter subject..." maxlength="50" required></textarea>
                        <textarea name="Content" type="text" class="content" placeholder="Enter content..." minlength="50" required></textarea>
                    </div>
                    <div class="contact-wrapper">
                    <div class="contact text-email">Email: </div>
                    <div class="contact text-subject">Subject: </div>
                    <div class="contact text-content">Content: </div>
                    </div>
                    <div class="button submit-request-bar">
                        <!-- тег <div> на <button> -->
                        <button type="submit" style="background-color: transparent; border: none;">
                        <img src="/img/svg/contact-submit-request.svg" alt="submit request">
                        </button>
                    </div>
                </form>
                <!-- Уведомления -->
                <div class="notification notification-true">
                    <img src="/img/svg/notification-true.svg" alt="You successfully submitted request!" style="display: none;">
                </div>
                <div class="notification notification-false">
                    <img src="/img/svg/notification-false.svg" alt="Oops! Looks like there is a problem!" style="display: none;">
                </div>
            </div>
        </section>
    </main>
    
    <!-- Социальные иконки -->
    <section class="social-icons">
        <a href="https://github.com" class="social-icon">
            <img src="/img/svg/github.svg" alt="GitHub">
        </a>
        <a href="https://instagram.com" class="social-icon">
            <img src="/img/svg/instagram.svg" alt="Instagram">
        </a>
        <a href="https://linkedin.com" class="social-icon">
            <img src="/img/svg/linkedin.svg" alt="LinkedIn">
        </a>
        <a href="https://behance.net" class="social-icon">
            <img src="/img/svg/behance.svg" alt="Behance">
        </a>
    </section>
</body>
</html>



