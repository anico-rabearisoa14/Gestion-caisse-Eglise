<?php
// about.php
$pageTitle = "About - My PHP Project";
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
        <h1>About Us</h1>
    </header>
    
    <div class="container">
        <h2>About This Project</h2>
        <p>This is the About page. Replace this content with your real project info.</p>
        <p>Notice the nav and styles are shared across every page via <code>include</code> — edit them once in <code>includes/</code> and every page updates.</p>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> My PHP Project. All rights reserved.
    </footer>

</body>
</html>
