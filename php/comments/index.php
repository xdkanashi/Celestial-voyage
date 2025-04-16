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
    <script src="/js/comments_script.js" defer></script>
</head>
<body>
    <?php include('comments.php'); ?>
    <!-- Верхний блок страницы -->
    <header class="header">
        <div class="wrapper">
            <div class="header_wrapper">
                <div class="header_logo">
                    <a href="javascript:history.back()" class="header_logo">&lt; Go back</a>
                </div>
                <nav class="header_nav">
                    <ul class="nav_list">
                        <li class="header_item"><a href="/html/skills.html" class="header_link">Skills</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="comments-intro">
        <img src="/img/svg/press-scroll.svg" alt="press and scroll" class="press-button">
        <img src="/img/svg/comments-logo.svg" alt="skills" class="comments-logo">
        <div class="navigation-buttons">
            <a href="index.php?id=<?php echo $prevPlanet['ID_Cosmic-objects']; ?>&class=<?php echo $objectClass; ?>">
                <img src="/img/svg/arrow-left.svg" alt="Previous" class="prev-button">
            </a>
            <a href="index.php?id=<?php echo $nextPlanet['ID_Cosmic-objects']; ?>&class=<?php echo $objectClass; ?>">
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
                            <div class="comment-head">
                                <div class="comment-name-container">
                                    <h1 class="comment-name"><?php echo $comment['Name'] . ' ' . $comment['Surname']; ?></h1>
                                    <?php if ($comment['Admin'] == 1): ?>
                                        <div class="comments user_status" name="Admin">Admin</div>
                                    <?php endif; ?>
                                    <div class="like-container" data-comment-id="<?php echo $comment['ID_Comments']; ?>">
                                        <button class="like-button" type="button" style="background: none; border: none;">
                                            <img src="/img/profile/icons-profile/like-before.png" alt="Like" class="like-icon" data-liked="false">
                                        </button>
                                        <span class="like-count"><?php echo $comment['Likes']; ?></span>
                                    </div>
                                </div>
                                <span><?php echo $comment['Date']; ?></span>
                            </div>
                            <div class="comment-content">
                                <?php echo $comment['Text']; ?>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="comment-form">
                <form id="commentForm" action="comments.php" method="POST">
                    <input type="hidden" name="cosmicObjectId" value="<?php echo $cosmicObjectId; ?>">
                    <input type="hidden" name="objectClass" value="<?php echo $objectClass; ?>">
                    <textarea name="comment" type="text" placeholder="Enter your comment..." rows="4" cols="50"></textarea><br>
                    <div class="button submit-comment">
                        <button type="submit" style="background-color: transparent; border: none;">
                        <img src="/img/svg/comments-button.svg" alt="send comment">
                        </button>
                    </div>
                </form>
            </div>
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










