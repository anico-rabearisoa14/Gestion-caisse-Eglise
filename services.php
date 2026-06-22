<?php
include_once 'crud/eglise.php';
include_once 'includes/styles.php';

include_once 'includes/formStyle.php';
$pageTitle = "Services - My PHP Project";

$pageTitle = "About - My PHP Project";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['ideglise'];
    $motif = $_POST['motif'];
    $montant = $_POST['montantSortie'];
    $date = $_POST['dateSortie'];

    $res = ajouterSortie($id, $motif, $montant, $date);
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
        <h1>Faire une decaissement</h1>
        <button id="ajout-btn" type="button" class="normal-btn">Ajouter</button>
    </header>

    <div id="pop-up-form" class="centered-modal" style="display: none;">
        <div class="wrapper">
            <div class="window-decoration">
                <button id="btn-close" class="close-btn" type="button" style="margin-bottom: 0;">X</button>
            </div>
            <h4 class="form-title">Completer le formulaire</h4>
            <hr>
            <form class="form-container" method="POST" action="">
                <label for="ideglise">ID Eglise</label>
                <input type="text" name="ideglise" value="Eg-34383" readonly>

                <label for="motif">Motif du decaissement</label>
                <input type="text" name="motif" required>

                <label for="montantEntre">Montant a retirer</label>
                <input type="number" name="montantSortie" required>

                <label for="dateEntre">Date d'operation</label>
                <input id="today-date" type="date" name="dateSortie">

                <button class="submit-btn" type="submit">Enregistrer</button>
            </form>
        </div>
    </div>



    <footer>
        &copy; <?php echo date("Y"); ?> My PHP Project. All rights reserved.
    </footer>
    <script src="script/action.js"></script>
</body>

</html>