<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Celestial Voyage</title>
    <!-- Иконка для вкладки браузера -->
    <link rel="icon" href="/img/planet-32.ico" type="image/x-icon">
    <!-- Подключение таблицы сброса стилей браузера -->
    <link rel="stylesheet" href="/css/reset.css">
    <!-- Пользовательские стили -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/transitions.css">
    <!-- Подключение скрипта JavaScript с отложенной загрузкой -->
    <script src="/js/login_script.js" defer></script>
    <script src="/libs/jquery-2.1.1.js"></script>
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

    <!-- Секция ввода логина -->
    <section class="login-intro">
        <!-- Секция тела ввода логина -->
        <section class="login-body">
            <!-- Логотип входа / регистрации -->
            <img src="/img/svg/login-logo.svg" alt="Sign up / in" class="login-logo">
            <!-- Контейнер входа / регистрации -->
            <div class="login-container" id="login-container">
                <!-- Форма регистрации -->
                <div class="form-container sign-up-container">
                    <form action="sign-up.php" method="post" enctype="multipart/form-data">
                        <h3>Create Account</h3>
                        <input type="text" name="Name" placeholder="Name" maxlength="50" required />
                        <input type="text" name="Surname" placeholder="Surname" maxlength="50" required />
                        <input type="email" name="Email" placeholder="Email" maxlength="50" required />
                        <input type="date" name="Birthdate" placeholder="Birth Date" required /> 
                        <div class="password">         
                        <input id="signup-password-input" type="password" name="Password" placeholder="Password" maxlength="50" required />
                        <a href="#" class="password-control"></a>
                        </div>
                        <label for="profile-picture">
                            <h3>Choose profile picture:</h3>
                        </label>
                        <input type="file" name="Avatar" accept="image/*" id="profile-picture" />            
                        <button type="submit" name="users">Sign Up</button>
                    </form>
                </div>
                <!-- Форма входа -->
                <div class="form-container sign-in-container">
                    <form action="sign-in.php" method="post">
                        <h1>Sign in</h1>
                        <input type="email" id="email" name="Email" placeholder="Email" required />
                        <div class="password">
                            <input id="signin-password-input" type="password" name="Password" placeholder="Password" required />
                            <a href="#" class="password-control"></a>
                        </div>
                        <button type="submit" name="signin">Sign In</button>
                    </form>
                </div>
                <!-- Наложение контейнера -->
                <div class="overlay-container">
                    <!-- Наложение -->
                    <div class="overlay">
                        <!-- Наложение слева -->
                        <div class="overlay-panel overlay-left">
                            <h1>Welcome Back!</h1>
                            <p1>To keep connected with us please login with your personal info</p1>
                            <button class="ghost" id="signIn">Sign In</button>
                        </div>
                        <!-- Наложение справа -->
                        <div class="overlay-panel overlay-right">
                            <h1>Hello, Friend!</h1>
                            <p1>Enter your personal details and start journey with us</p1>
                            <button class="ghost" id="signUp">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
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
    
        <!-- Уведомления -->
        <div class="notification notification-true">
            <img src="/img/svg/notification-true.svg" alt="You successfully submitted request!" style="display: none;">
        </div>
        <div class="notification notification-false">
            <img src="/img/svg/notification-false.svg" alt="Oops! Looks like there is a problem!" style="display: none;">
        </div>

        <!-- Контейнер для ответа -->
        <div id="response-container" style="display: none;"></div>

</body>

<script>
    $('body').on('click', '.password-control', function() {
        var input = $(this).siblings('input');
        if (input.attr('type') === 'password') {
            $(this).addClass('view');
            input.attr('type', 'text');
        } else {
            $(this).removeClass('view');
            input.attr('type', 'password');
        }
        return false;
    });
</script>

</html>
