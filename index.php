<?php

$pageTitle = "My PHP Project";
$welcomeMessage = "Welcome to your new PHP project!";
$currentDate = date("F j, Y");
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
        <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
    </header>

    <div class="container">
        <h2><?php echo htmlspecialchars($welcomeMessage); ?></h2>
        <p>This is your starting point. Edit <code>index.php</code> to begin building your project.</p>
        <p>You can mix PHP logic with HTML freely, as shown here.</p>

        <div class="info-box">
            <strong>Today's date:</strong> <?php echo htmlspecialchars($currentDate); ?>
        </div>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($pageTitle); ?>. All rights reserved.
    </footer>

</body>
</html>
