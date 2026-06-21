<?php
include_once 'crud/eglise.php';
include_once 'includes/styles.php';

include_once 'includes/formStyle.php';
$pageTitle = "Services - My PHP Project";
$services = [
    "Web Development",
    "Database Design",
    "API Integration",
    "Maintenance & Support",
    "Video editing"
];
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
        <h1>Faire une decaissement</h1>
    </header>

    <div class="wrapper" style="display:block;">
        <h4 class="form-title">Completer le formulaire</h4>
        <hr>
        <form class="form-container" method="POST" action="">
            <label for="ideglise">ID Eglise</label>
            <input type="text" name="ideglise" value="Eg-34383" readonly>

            <label for="motif">Motif du decaissement</label>
            <input type="text" name="motif" required>

            <label for="montantEntre">Montant a retirer</label>
            <input type="number" name="montantEntre" required>

            <label for="dateEntre">Date d'operation</label>
            <input id="today-date" type="date" name="dateEntre">

            <button class="submit-btn" type="submit">Enregistrer</button>
        </form>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> My PHP Project. All rights reserved.
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const dateInput = document.getElementById("today-date");
            const today = new Date();

            // Extract components
            const year = today.getFullYear();
            // getMonth() returns 0-11, so add 1
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');

            // Format as YYYY-MM-DD
            const formattedDate = `${year}-${month}-${day}`;

            // Set the value
            dateInput.value = formattedDate;
        });
    </script>
</body>

</html>