<?php include 'profile.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Celestial Voyage</title>
    <link rel="icon" href="/img/planet-32.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/reset.css"> <!-- Подключаем таблицу стилей для сброса стандартных стилей браузера -->
    <link rel="stylesheet" href="/css/style.css"> <!-- Подключаем таблицу стилей для оформления страницы -->
    <link rel="stylesheet" href="/css/transitions.css">
    <script src="/js/profile_script.js" defer></script>
    <script src="/libs/jquery-2.1.1.js"></script>
</head>
<body>
   <!-- Верхний блок страницы -->
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
                            <a href="/php/contact-me/index.php" class="header_link">Contact Me</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <section class="profile-intro">
            <img src="/img/svg/profile-logo.svg" alt="skills" class="profile-logo">
            <div class="wrapper-profile">
                <!-- Левая панель -->
                <div class="left">
                    <ul>
                        <li>
                            <img class="icon" src="/img/profile/icons-profile/profile-profile.png" alt="">
                            <button class="profile">Profile Settings</button>
                        </li>
                        <li>
                            <img class="icon" src="/img/profile/icons-profile/profile-notification.png" alt="">
                            <button class="list_item">Notifications</button>
                        </li>
                        <li>
                            <img class="icon" src="/img/profile/icons-profile/profile-description.png" alt="">
                            <button class="list_item">Billing Information</button>
                        </li>
                        <li>
                            <img class="icon" src="/img/profile/icons-profile/profile-settings.png" alt="">
                            <button class="list_item">General</button>
                        </li>
                        <?php if ($isAdmin == 1): // Добавлено условие для отображения элемента только для администраторов ?>
                        <li>
                            <a href="/php/admin-menu/admin-menu.php">
                                <img class="icon" src="/img/profile/icons-profile/profile-admin.png" alt="">
                                <button class="list_item">Admin menu</button>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li>
                        <img class="icon" src="/img/profile/icons-profile/profile-sign-out.png" alt="">
                        <button id="signOutButton" class="list_item">Sign out</button>
                    </li>
                    </ul>
                </div>
                <!-- Правая панель -->
                <div class="right">
                    <img class="avatar" src="<?php echo $user['Avatar'] ? $user['Avatar'] : '/img/profile/avatars-profile/astronaut.png'; ?>" alt="">
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        <button class="button_avatar" id="editAvatarButton" type="button">Edit Picture</button></a>
                        <input type="file" name="Avatar" id="avatar" style="display: none;">
                        <div class="form">
                            <div class="field">
                                <label for="name">Name</label>
                                <input class="full_name" type="text" name="Name" maxlength="50" value="<?php echo $user['Name']; ?>">
                            </div>
                            <div class="field">
                                <label for="surname">Surname</label>
                                <input class="full_name" type="text" name="Surname" maxlength="50" value="<?php echo $user['Surname']; ?>">
                            </div>
                            <div class="field">
                                <label for="email">Email</label>
                                <input class="full_name" type="email" name="Email" maxlength="50" value="<?php echo $user['Email']; ?>">
                            </div>
                            <div class="field">
                                <label for="birthdate">Birthdate</label>
                                <input class="full_name" type="date" name="Birthdate" value="<?php echo $user['Birthdate']; ?>">
                            </div>
                            <div class="field">
                                <label for="password">Password</label>
                                <div class="password">
                                <input id="password-input" class="full_name" type="password" name="Password" maxlength="50" value="<?php echo $user['Password']; ?>">
                                <a href="#" class="password-control"></a>
                                </div>
                            </div>
                        </div>
                        <div class="bottom">
                            <button class="button_middle" id="deleteAccountButton" type="cancel" name="button">Delete Account</button></a>
                            <button class="button_left" id="saveChangesButton" type="submit">Save Changes</button>
                            <button class="button_right" id="cancelButton" type="button">Cancel</button></a>
                        </div>
                    </form>
                    <?php if ($isAdmin == 1): // Добавлено условие для отображения элемента только для администраторов ?>
                        <div class="profil user_status" name="Admin">Admin</div>
                    <?php endif; ?>           
                </div>
            </div>
        </section>
    </main>
    <!-- Социальные иконки -->
    <section class="social-icons">
        <!-- Ссылка на GitHub -->
        <a href="https://github.com" class="social-icon">
            <img src="/img/svg/github.svg" alt="GitHub">
        </a>
        <!-- Ссылка на Instagram -->
        <a href="https://instagram.com" class="social-icon">
            <img src="/img/svg/instagram.svg" alt="Instagram">
        </a>
        <!-- Ссылка на LinkedIn -->
        <a href="https://linkedin.com" class="social-icon">
            <img src="/img/svg/linkedin.svg" alt="LinkedIn">
        </a>
        <!-- Ссылка на Behance -->
        <a href="https://behance.net" class="social-icon">
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
        if ($('#password-input').attr('type') == 'password') {
            $(this).addClass('view');
            $('#password-input').attr('type', 'text');
        } else {
            $(this).removeClass('view');
            $('#password-input').attr('type', 'password');
        }
        return false;
    });
</script>
</html>