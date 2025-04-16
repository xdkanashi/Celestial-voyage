<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments | Celestial Voyage</title>
    <link rel="icon" href="/img/planet-32.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/transitions.css">
    <script src="/js/comments-moderate_script.js" defer></script>
</head>
<body>
    <?php include('moderate-comments.php'); ?>
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
                            <a href="/php/admin-menu/admin-menu.php" class="header_link">Admin menu</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="calendars4-intro">
        <img src="/img/svg/press-scroll.svg" alt="press and scroll" class="press-button">
        <img src="/img/svg/comments-logo.svg" alt="skills" class="comments-logo">
        <div class="navigation-buttons">
            <a href="index.php?id=<?php echo $prevPlanet['ID_Cosmic-objects']; ?>">
                <img src="/img/svg/arrow-left.svg" alt="Previous" class="prev-button">
            </a>
            <a href="index.php?id=<?php echo $nextPlanet['ID_Cosmic-objects']; ?>">
                <img src="/img/svg/arrow-right.svg" alt="Next" class="next-button">
            </a>
        </div>
        <div class="object-info">
            <p><?php echo $cosmicObject['Class'] . ": " . $cosmicObject['Name']; ?></p>
        </div>
        <div class="comments-container">
            <ul id="comments-list" class="comments-list">
                <?php foreach ($comments as $comment): ?>
                <li>
                    <div class="comment-main-level">
                        <div class="comment-avatar"><img src="<?php echo $comment['Avatar']; ?>" alt=""></div>
                        <div class="comment-box">
                            <div class="comment-head" style="background-color: rgba(138, 210, 245, 0.527); border: 2px solid rgba(138, 210, 245, 1)">
                                <h1 class="comment-name">
                                    <?php echo $comment['Name'] . ' ' . $comment['Surname']; ?>
                                    (<?php echo $comment['ID_Comments']; ?>)
                                    <?php if ($comment['Admin'] == 1): ?>
                                        <div class="comments user_status" name="Admin">Admin</div>
                                    <?php endif; ?>

                                </h1>
                                <span><?php echo $comment['Date']; ?></span>
                                <!-- Кнопка удаления комментария -->
                                <button class="delete-comment" data-comment-id="<?php echo $comment['ID_Comments']; ?>">Delete</button>
                            </div>
                            <div class="comment-content" style="background-color: rgba(138, 210, 245, 0.527); border: 2px solid rgba(138, 210, 245, 1)">
                                <?php echo $comment['Text']; ?>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <!-- Уведомления -->
            <div class="notification notification-true">
                <img src="/img/svg/notification-true.svg" alt="You successfully submitted request!" style="display: none;">
            </div>
            <div class="notification notification-false">
                <img src="/img/svg/notification-false.svg" alt="Oops! Looks like there is a problem!" style="display: none;">
            </div>
            <!-- Контейнер для сообщения -->
            <div id="response-container" style="display: none;"></div>
        </div>
    </div>
</body>
</html>


