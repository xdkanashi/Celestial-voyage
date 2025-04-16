<?php include 'cosmic-objects_filters.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stellar Navigator | Celestial Voyage</title>
    <link rel="icon" href="/img/planet-32.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/transitions.css">
    <link rel="stylesheet" href="/css/style-search.css">
    <script src="/js/stellars_script.js" defer></script>
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
                            <a href="/php/my-profile/index.php" class="header_link">My profile</a>
                        </li> 
                        <li class="header_item">
                            <a href="/php/comments/index.php?id=<?php echo $stellarId; ?>&class=<?php echo $objectClass; ?>" class="header_link">Comments</a>
                        </li>               
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <section class="stellar-intro">
            <div class="stellars-intro">
                <img src="/img/svg/Stellars.svg" alt="Stellars" class="stellars-logo">
                <img src="/img/svg/press-scroll.svg" alt="press and scroll" class="press-button">
                <div class="globe-container">
                    <?php if ($stellar): ?>
                        <img src="/img/svg/<?php echo $stellar['Object']; ?>" alt="Globe" class="globe" onload="this.style.visibility='visible';">
                        <img src="/img/svg/Cosmonaut_4.svg" alt="Cosmonaut" class="cosmonaut4">
                        <div class="button open-button">
                            <img src="/img/svg/click-to-open.svg" alt="Click to Open">
                        </div>
                        <img src="/img/svg/text-bar.svg" alt="Text Bar" class="text-bar" style="display: none;">
                        <div class="stellar-name">
                            <p><?php echo $object_class . ": " . $stellar['Name']; ?></p> 
                        </div>  
                        <div class="stellar-stat">
                            <div class="stellar-mass">
                                <p>Mass 10²⁴: <?php echo $stellar['Mass']; ?></p>
                            </div>
                            <div class="stellar-area">
                                <p>Area million km²: <?php echo $stellar['Area']; ?></p>
                            </div>
                            <div class="stellar-speed">
                                <p>Speed km/h: <?php echo $stellar['Speed']; ?></p>
                            </div>
                            <div class="stellar-class">
                                <p>Type: <?php echo $object_type; ?></p>
                            </div>
                            <div class="stellar-views">
                                <p>Views: <?php echo $newViews; ?></p>
                            </div>
                        </div>
                        <div id="content-data" style="display: none;"><?php echo json_encode(explode("\n", $stellar['Content'])); ?></div>
                        <div class="text-bar stellar-text" style="display: none;"></div>
                        <div class="text-bar stellar2-text" style="display: none;"></div>
                        <?php else: ?>
                            <img src="/img/svg/earth.svg" alt="Globe" class="globe" onload="this.style.visibility='visible';">
                            <img src="/img/svg/Cosmonaut_1.svg" alt="Cosmonaut" class="cosmonaut1">
                            <div class="data-error">
                            <p>The stellar you are looking for does not exist in our database.</p>
                            </div>
                    <?php endif; ?>
                </div>
                <?php if ($stellar): ?>
                <div class="navigation-buttons">
                <a href="index.php?id=<?php echo $prevstellar['ID_Cosmic-objects']; ?>&class=<?php echo $objectClass; ?>&filter=<?php echo $filter; ?>">
                        <img src="/img/svg/arrow-left.svg" alt="Previous" class="prev-button">
                    </a>
                    <a href="index.php?id=<?php echo $nextstellar['ID_Cosmic-objects']; ?>&class=<?php echo $objectClass; ?>&filter=<?php echo $filter; ?>">
                        <img src="/img/svg/arrow-right.svg" alt="Next" class="next-button">
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <nav class="side-nav" id="menuToggle">
                <a id="menuToggle">
                    <span class="navClosed"></span>
                 </a>
                <form action="index.php" method="get">
                    <button type="submit" name="filter" value="alphabetical_asc" class="<?php echo ($_GET['filter'] == 'alphabetical_asc') ? 'active-filter' : ''; ?>">Alphabetical (A-Z)</button>
                    <button type="submit" name="filter" value="alphabetical_desc" class="<?php echo ($_GET['filter'] == 'alphabetical_desc') ? 'active-filter' : ''; ?>">Alphabetical (Z-A)</button>
                    <button type="submit" name="filter" value="greatest_mass" class="<?php echo ($_GET['filter'] == 'greatest_mass') ? 'active-filter' : ''; ?>">Greatest Mass</button>
                    <button type="submit" name="filter" value="largest_area" class="<?php echo ($_GET['filter'] == 'largest_area') ? 'active-filter' : ''; ?>">Largest Area</button>
                    <button type="submit" name="filter" value="fastest_speed" class="<?php echo ($_GET['filter'] == 'fastest_speed') ? 'active-filter' : ''; ?>">Fastest Speed</button>
                    <button type="submit" name="filter" value="red_giant" class="<?php echo ($_GET['filter'] == 'red_giant') ? 'active-filter' : ''; ?>">Red Giant (<?php echo $stellarCountsByType['Red Giant'] ?? 0; ?>)</button>
                    <button type="submit" name="filter" value="supergiant" class="<?php echo ($_GET['filter'] == 'supergiant') ? 'active-filter' : ''; ?>">Supergiant (<?php echo $stellarCountsByType['Supergiant'] ?? 0; ?>)</button>
                    <button type="submit" name="filter" value="main_sequence_star" class="<?php echo ($_GET['filter'] == 'main_sequence_star') ? 'active-filter' : ''; ?>">Main Sequence Star (<?php echo $stellarCountsByType['Main Sequence Star'] ?? 0; ?>)</button>
                    <button type="submit" name="filter" value="most_viewed" class="<?php echo ($_GET['filter'] == 'most_viewed') ? 'active-filter' : ''; ?>">Most Viewed</button>
                </form>
            </nav>
            <div class="search-form">
                <form action="index.php" method="get" autocomplete="on">
                    <input type="hidden" name="class" value="<?php echo $objectClass; ?>">
                    <input type="hidden" name="filter" value="<?php echo $filter; ?>">
                    <input id="search" name="search" type="text" placeholder="What looking for?" maxlength="40" value="<?php echo $search; ?>">
                    <input id="search_submit" value="Search" type="submit">
                </form>
            </div>       
        </section>
    </main>
</body>
</html>


