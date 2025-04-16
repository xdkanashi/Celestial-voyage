<?php include 'manage-objects.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmic Objects | Celestial Voyage</title>
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
                        <a href="/php/admin-menu/admin-menu.php" class="header_link">Admin menu</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<main>
    <section class="calendars6-intro">
        <div class="cosmic-objects-intro">
            <img src="/img/svg/manage-objects.svg" alt="Cosmic Objects" class="manage-objects-logo">
            <img src="/img/svg/press-scroll.svg" alt="press and scroll" class="press-button">
            <div class="table-container">
                <?php if (!empty($cosmicObjects)): ?>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th> <!-- Столбец для нумерации -->
                                    <th>Name</th>
                                    <th>Mass</th>
                                    <th>Area</th>
                                    <th>Speed</th>
                                    <th>Type</th>
                                    <th>Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cosmicObjects as $index => $object): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td> <!-- Нумерация записей -->
                                    <td><?php echo $object['Name']; ?></td>
                                    <td><?php echo $object['Mass']; ?></td>
                                    <td><?php echo $object['Area']; ?></td>
                                    <td><?php echo $object['Speed']; ?></td>
                                    <td><?php echo $object['Cosmic-objects_type']; ?></td>
                                    <td><?php echo $object['Views']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="data-error">
                        <p>No cosmic objects found in our database.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <nav class="side-nav" style="height: 940px;" id="menuToggle">
            <a id="menuToggle">
                <span class="navClosed"></span>
            </a>
            <form action="index.php" method="get">
                <input type="hidden" name="search" value="<?php echo $search; ?>">
                <button type="submit" name="filter" value="alphabetical_asc" class="<?php echo ($_GET['filter'] == 'alphabetical_asc') ? 'active-filter' : ''; ?>">Alphabetical (A-Z)</button>
                <button type="submit" name="filter" value="alphabetical_desc" class="<?php echo ($_GET['filter'] == 'alphabetical_desc') ? 'active-filter' : ''; ?>">Alphabetical (Z-A)</button>
                <button type="submit" name="filter" value="red_giant" class="<?php echo ($_GET['filter'] == 'red_giant') ? 'active-filter' : ''; ?>">Red Giant (<?php echo $objectCountsByType['Red Giant'] ?? 0; ?>)</button>
                <button type="submit" name="filter" value="supergiant" class="<?php echo ($_GET['filter'] == 'supergiant') ? 'active-filter' : ''; ?>">Supergiant (<?php echo $objectCountsByType['Supergiant'] ?? 0; ?>)</button>
                <button type="submit" name="filter" value="main_sequence_star" class="<?php echo ($_GET['filter'] == 'main_sequence_star') ? 'active-filter' : ''; ?>">Main Sequence Star (<?php echo $objectCountsByType['Main Sequence Star'] ?? 0; ?>)</button>
                <button type="submit" name="filter" value="terrestrial_planet" class="<?php echo ($_GET['filter'] == 'terrestrial_planet') ? 'active-filter' : ''; ?>">Terrestrial Planet (<?php echo $objectCountsByType['Terrestrial Planet'] ?? 0; ?>)</button>
                <button type="submit" name="filter" value="gas_giant" class="<?php echo ($_GET['filter'] == 'gas_giant') ? 'active-filter' : ''; ?>">Gas Giant (<?php echo $objectCountsByType['Gas Giant'] ?? 0; ?>)</button>
                <button type="submit" name="filter" value="ice_giant" class="<?php echo ($_GET['filter'] == 'ice_giant') ? 'active-filter' : ''; ?>">Ice Giant (<?php echo $objectCountsByType['Ice Giant'] ?? 0; ?>)</button>
                <button type="submit" name="filter" value="greatest_mass" class="<?php echo ($_GET['filter'] == 'greatest_mass') ? 'active-filter' : ''; ?>">Greatest Mass</button>
                <button type="submit" name="filter" value="largest_area" class="<?php echo ($_GET['filter'] == 'largest_area') ? 'active-filter' : ''; ?>">Largest Area</button>
                <button type="submit" name="filter" value="fastest_speed" class="<?php echo ($_GET['filter'] == 'fastest_speed') ? 'active-filter' : ''; ?>">Fastest Speed</button>
                <button type="submit" name="filter" value="most_viewed" class="<?php echo ($_GET['filter'] == 'most_viewed') ? 'active-filter' : ''; ?>">Most Viewed</button>
                <button type="submit" name="filter" value="planets" class="<?php echo ($_GET['filter'] == 'planets') ? 'active-filter' : ''; ?>">Planets</button>
                <button type="submit" name="filter" value="stars" class="<?php echo ($_GET['filter'] == 'stars') ? 'active-filter' : ''; ?>">Stars</button>
            </form>
        </nav>
        <div class="search-form">
            <form action="index.php" method="get" autocomplete="on">
                <input type="hidden" name="filter" value="<?php echo $filter; ?>">
                <input class="search-input" name="search" type="text" placeholder="What looking for?" maxlength="40" value="<?php echo $search; ?>">
                <input class="search-submit" value="Search" type="submit">
            </form>
        </div>     
    </section>
</main>
</body>
</html>



