<?php

$pageTitle = "Services - My PHP Project";
$services = [
    "Web Development",
    "Database Design",
    "API Integration",
    "Maintenance & Support",
    "Video editing"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <?php include 'includes/styles.php'; ?>
</head>
<body>
    
    <?php include 'includes/nav.php'; ?>
    <header>
        <h1>Our Services</h1>
    </header>


    <div class="container">
        <h2>What We Offer</h2>
        <p>Here's an example of looping through PHP data to build HTML dynamically:</p>
        <ul>
            <?php foreach($services as $service) : ?>
                <li><?php echo htmlspecialchars($service) ?></li>
            <?php endforeach;?>
        </ul>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> My PHP Project. All rights reserved.
    </footer>

</body>
</html>
