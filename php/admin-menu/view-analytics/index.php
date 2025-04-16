<?php include('view-analytics.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics | Celestial Voyage</title>
    <link rel="icon" href="/img/planet-32.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/transitions.css">
    <script src="/js/view-analytics_script.js" defer></script>
    <script src="/libs/chart.js"></script>
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
                            <a href="/php/admin-menu/admin-menu.php" class="header_link">Admin menu</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="calendars3-intro">
        <img src="/img/svg/press-scroll.svg" alt="press and scroll" class="press-button">
        <img src="/img/svg/analytics.svg" alt="skills" class="analytics-logo">
        <div class="analytics-container">
            <div class="analytics-list">
                <div class="analytics-section">
                    <h5>Most Popular Posts and Total Views</h5>
                    <canvas id="popularPostsChart"></canvas>
                </div>

                <div class="analytics-section">
                    <h5>Most Liked Comment and Total Comments</h5>
                    <canvas id="commentsChart"></canvas>
                </div>

                <div class="analytics-section">
                    <h5>Total Posts</h5>
                    <canvas id="totalPostsChart"></canvas>
                </div>

                <div class="analytics-section chart-container">
                    <h5>Posts by Type</h5>
                    <canvas id="postsByTypeChart"></canvas>
                </div>

                <div class="analytics-section chart-container">
                    <h5>User Roles Distribution</h5>
                    <canvas id="userRolesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
        // Передаем данные из PHP в JavaScript
        const popularPostsLabels = <?php echo json_encode(array_column($resultPopularPosts, 'Name')); ?>;
        const popularPostsData = <?php echo json_encode(array_column($resultPopularPosts, 'Views')); ?>;
        
        const commentsDataLikes = [<?php echo $resultPopularComment['Likes']; ?>, 0];
        const commentsDataComments = [0, <?php echo $resultTotalComments['total_comments']; ?>];
        
        const totalPostsDataPosts = [<?php echo $resultTotalPosts['total_posts']; ?>, 0];
        const totalPostsDataLikes = [0, <?php echo $resultTotalLikes['total_likes']; ?>];
        
        const postsByTypeDataPlanets = [<?php echo $resultPlanetPosts['planet_posts']; ?>, 0];
        const postsByTypeDataStars = [0, <?php echo $resultStarPosts['star_posts']; ?>];
        
        const userRolesDataAdmins = [<?php echo $resultTotalAdmins['total_admins']; ?>, 0];
        const userRolesDataUsers = [0, <?php echo $resultTotalUsers['total_users']; ?>];
    </script>
</html>

