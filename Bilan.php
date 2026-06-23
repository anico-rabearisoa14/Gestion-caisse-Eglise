<?php
require __DIR__ . '/init.php';
$pageTitle = "Contact - My PHP Project";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));

    if ($name && $email) {
        $successMessage = "Thanks, $name! We'll reach you at $email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <?php include 'includes/styles.php'; ?>
    <style>
        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 400px;
        }

        .success {
            color: #27ae60;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <?php include 'includes/nav.php'; ?>
    <header>
        <h1>Contact Us</h1>
    </header>

    <div class="container">
        <h2>Get In Touch</h2>

        <?php if ($successMessage): ?>
            <p class="success"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <form method="POST" action="contact">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <button type="submit">Send</button>
        </form>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> My PHP Project. All rights reserved.
    </footer>

</body>

</html>