<?php include 'manage-users.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Celestial Voyage</title>
    <link rel="icon" href="/img/planet-32.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/transitions.css">
    <script src="/js/manage-users_script.js" defer></script>
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
    <main>
        <section class="calendars12-intro">
            <!-- Фильтры -->
            <nav class="side-nav" style="height: 435px;" id="menuToggle">
                <a id="menuToggle">
                    <span class="navClosed"></span>
                </a>
                <form action="index.php" method="get">
                    <input type="hidden" name="id" value="<?php echo $user_id; ?>">
                    <button type="submit" name="filter" value="alphabetical_asc" class="<?php echo ($filter == 'alphabetical_asc') ? 'active-filter' : ''; ?>">Alphabetical (A-Z)</button>
                    <button type="submit" name="filter" value="alphabetical_desc" class="<?php echo ($filter == 'alphabetical_desc') ? 'active-filter' : ''; ?>">Alphabetical (Z-A)</button>
                    <button type="submit" name="filter" value="oldest" class="<?php echo ($filter == 'oldest') ? 'active-filter' : ''; ?>">The Oldest</button>
                    <button type="submit" name="filter" value="youngest" class="<?php echo ($filter == 'youngest') ? 'active-filter' : ''; ?>">The Youngest</button>
                    <button type="submit" name="filter" value="admins" class="<?php echo ($filter == 'admins') ? 'active-filter' : ''; ?>">Admins (<?php echo $userCountsByType['Admins'] ?? 0; ?>)</button>
                    <button type="submit" name="filter" value="users" class="<?php echo ($filter == 'users') ? 'active-filter' : ''; ?>">Users (<?php echo $userCountsByType['Users'] ?? 0; ?>)</button>
                </form>
            </nav>

            <div class="navigation-buttons">
                <?php if ($prevUser): ?>
                    <a href="index.php?id=<?php echo $prevUser['ID_users']; ?>&filter=<?php echo $filter; ?>">
                        <img src="/img/svg/arrow-left.svg" alt="Previous" class="prev-button">
                    </a>
                <?php else: ?>
                    <div style="visibility: hidden;"></div>
                <?php endif; ?>
                <?php if ($nextUser): ?>
                    <a href="index.php?id=<?php echo $nextUser['ID_users']; ?>&filter=<?php echo $filter; ?>">
                        <img src="/img/svg/arrow-right.svg" alt="Next" class="next-button">
                    </a>
                <?php else: ?>
                    <div style="visibility: hidden;"></div>
                <?php endif; ?>
            </div>
            <img src="/img/svg/profiles-logo.svg" alt="profile" class="profile-logo">
            <div class="wrapper-profile" style="position: relative; top: 115px;">
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
                    </ul>
                </div>
                <div class="right">
                    <img class="avatar" src="<?php echo $user['Avatar'] ? $user['Avatar'] : '/img/profile/avatars-profile/astronaut.png'; ?>" alt="">
                    <form action="manage-users.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?php echo $user['ID_users']; ?>">
                        <button class="button_avatar" id="editAvatarButton" type="button">Edit Picture</button>
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
                                <input class="full_name" type="date" name="Birthdate" style="margin-bottom: 97px" value="<?php echo $user['Birthdate']; ?>">
                            </div>
                        </div>
                        <div class="bottom">
                            <button class="button_middle" id="deleteAccountButton" type="cancel" name="button">Delete Account</button>
                            <button class="button_left" id="saveChangesButton" type="submit">Save Changes</button>
                            <button class="button_right" id="cancelButton" type="button">Cancel</button>
                        </div>
                    </form>
                    <?php if ($isAdmin == 1): ?>
                        <div class="profil user_status" name="Admin">Admin</div>
                    <?php endif; ?>         
                </div>
            </div>
        </section>
    </main>  
        <div class="notification notification-true">
            <img src="/img/svg/notification-true.svg" alt="You successfully submitted request!" style="display: none;">
        </div>
        <div class="notification notification-false">
            <img src="/img/svg/notification-false.svg" alt="Oops! Looks like there is a problem!" style="display: none;">
        </div>
        <div id="response-container" style="display: none;"></div>
</body>
</html>





