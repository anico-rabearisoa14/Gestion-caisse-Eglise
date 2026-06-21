<?php
include_once 'crud/eglise.php';
include_once 'includes/formStyle.php';
$pageTitle = "About - My PHP Project";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['ideglise'];
    $motif = $_POST['motif'];
    $montant = $_POST['montantEntre'];
    $date = $_POST['dateEntre'];

    $res = ajouterEntre($id, $motif, $montant, $date);
}

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
        <h1>Ajouter une entree</h1>
    </header>

    <div class="wrapper" style="display: <?php echo htmlspecialchars($contientUne ? 'none' : 'block') ?>;">
        <h4 class="form-title">Completer le formulaire</h4>
        <hr>

        <!-- CREATE TABLE ENTRE (
    identre INT AUTO_INCREMENT PRIMARY KEY,
    ideglise VARCHAR(15),
    motif VARCHAR(50) NOT NULL,
    montantEntre INT,
    dateEntre DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (ideglise) REFERENCES EGLISE(ideglise)
); -->
        <!-- should be flex the form on the middle -->
        <form class="form-container" method="POST" action="">
            <label for="ideglise">ID Eglise</label>
            <input type="text" name="ideglise" value="Eg-34383" readonly>

            <label for="motif">Motif</label>
            <input type="text" name="motif" required>

            <label for="montantEntre">Montant</label>
            <input type="number" name="montantEntre" required>

            <label for="dateEntre">Date</label>
            <input id="today-date" type="date" name="dateEntre">

            <button class="submit-btn" type="submit">Envoyer</button>
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