<?php include 'cosmic-objects_filters.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planet Navigator | Celestial Voyage</title>
    <link rel="icon" href="/img/planet-32.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/transitions.css">
    <link rel="stylesheet" href="/css/style-search.css">
    <script src="/js/planets_script.js" defer></script>
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
                            <a href="/php/comments/index.php?id=<?php echo $planetId; ?>&class=<?php echo $objectClass; ?>" class="header_link">Comments</a>
                        </li>            
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <section class="planet-intro">
            <div class="planets-intro">
                <img src="/img/svg/Planets.svg" alt="Planets" class="planets-logo">
                <img src="/img/svg/press-scroll.svg" alt="press and scroll" class="press-button">
                <div class="globe-container">
                    <?php if ($planet): ?>
                        <img src="/img/svg/<?php echo $planet['Object']; ?>" alt="Globe" class="globe" onload="this.style.visibility='visible';">
                        <img src="/img/svg/Cosmonaut_3.svg" alt="Cosmonaut" class="cosmonaut3">
                        <div class="button open-button">
                            <img src="/img/svg/click-to-open.svg" alt="Click to Open">
                        </div>
                        <img src="/img/svg/text-bar.svg" alt="Text Bar" class="text-bar" style="display: none;">
                        <div class="planet-name">
                            <p><?php echo $object_class . ": " . $planet['Name']; ?></p> 
                        </div>  
                        <div class="planet-stat">
                            <div class="planet-mass">
                                <p>Mass 10²⁴: <?php echo $planet['Mass']; ?></p>
                            </div>
                            <div class="planet-area">
                                <p>Area million km²: <?php echo $planet['Area']; ?></p>
                            </div>
                            <div class="planet-speed">
                                <p>Speed km/h: <?php echo $planet['Speed']; ?></p>
                            </div>
                            <div class="planet-class">
                                <p>Type: <?php echo $object_type; ?></p>
                            </div>
                            <div class="planet-views">
                                <p>Views: <?php echo $newViews; ?></p>
                            </div>
                        </div>
                        <div id="content-data" style="display: none;"><?php echo json_encode(explode("\n", $planet['Content'])); ?></div>
                        <div class="text-bar planet-text" style="display: none;"></div>
                        <div class="text-bar planet2-text" style="display: none;"></div>
                    <?php else: ?>
                        <img src="/img/svg/earth.svg" alt="Globe" class="globe" onload="this.style.visibility='visible';">
                        <img src="/img/svg/Cosmonaut_2.svg" alt="Cosmonaut" class="cosmonaut2">
                        <div class="data-error">
                            <p>The planet you are looking for does not exist in our database.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($planet): ?>
                <div class="navigation-buttons">
                    <a href="index.php?id=<?php echo $prevPlanet['ID_Cosmic-objects']; ?>&class=<?php echo $objectClass; ?>&filter=<?php echo $filter; ?>&search=<?php echo $search; ?>">
                        <img src="/img/svg/arrow-left.svg" alt="Previous" class="prev-button">
                    </a>
                    <a href="index.php?id=<?php echo $nextPlanet['ID_Cosmic-objects']; ?>&class=<?php echo $objectClass; ?>&filter=<?php echo $filter; ?>&search=<?php echo $search; ?>">
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
                    <input type="hidden" name="class" value="<?php echo $objectClass; ?>">
                    <input type="hidden" name="search" value="<?php echo $search; ?>">
                    <button type="submit" name="filter" value="alphabetical_asc" class="<?php echo ($_GET['filter'] == 'alphabetical_asc') ? 'active-filter' : ''; ?>">Alphabetical (A-Z)</button>
                    <button type="submit" name="filter" value="alphabetical_desc" class="<?php echo ($_GET['filter'] == 'alphabetical_desc') ? 'active-filter' : ''; ?>">Alphabetical (Z-A)</button>
                    <button type="submit" name="filter" value="greatest_mass" class="<?php echo ($_GET['filter'] == 'greatest_mass') ? 'active-filter' : ''; ?>">Greatest Mass</button>
                    <button type="submit" name="filter" value="largest_area" class="<?php echo ($_GET['filter'] == 'largest_area') ? 'active-filter' : ''; ?>">Largest Area</button>
                    <button type="submit" name="filter" value="fastest_speed" class="<?php echo ($_GET['filter'] == 'fastest_speed') ? 'active-filter' : ''; ?>">Fastest Speed</button>
                    <button type="submit" name="filter" value="terrestrial_planet" class="<?php echo ($_GET['filter'] == 'terrestrial_planet') ? 'active-filter' : ''; ?>">Terrestrial Planet (<?php echo $planetCountsByType['Terrestrial Planet'] ?? 0; ?>)</button>
                    <button type="submit" name="filter" value="gas_giant" class="<?php echo ($_GET['filter'] == 'gas_giant') ? 'active-filter' : ''; ?>">Gas Giant (<?php echo $planetCountsByType['Gas Giant'] ?? 0; ?>)</button>
                    <button type="submit" name="filter" value="ice_giant" class="<?php echo ($_GET['filter'] == 'ice_giant') ? 'active-filter' : ''; ?>">Ice Giant (<?php echo $planetCountsByType['Ice Giant'] ?? 0; ?>)</button>
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










