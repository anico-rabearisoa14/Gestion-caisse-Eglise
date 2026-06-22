<?php
include_once 'crud/eglise.php';
include_once 'includes/formStyle.php';
include_once 'includes/styles.php';

$pageTitle = "About - My PHP Project";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['ideglise'];
    $motif = $_POST['motif'];
    $montant = $_POST['montantEntre'];
    $date = $_POST['dateEntre'];

    $res = ajouterEntre($id, $motif, $montant, $date);
}

$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);

$data = [];
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    global $data;
    $data = listeInfoEntre();
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
        <button id="ajout-btn" type="button" class="normal-btn">Ajouter</button>
    </header>


    <!-- // CREATE TABLE ENTRE (
//     identre INT AUTO_INCREMENT PRIMARY KEY,
//     ideglise VARCHAR(15),
//     motif VARCHAR(50) NOT NULL,
//     montantEntre INT,
//     dateEntre DATE DEFAULT (CURRENT_DATE),
//     FOREIGN KEY (ideglise) REFERENCES EGLISE(ideglise)
// ) -->

    <!-- Table to show all records on the ENTRE table -->
    <table border="1" class="data-table">
        <thead>
            <tr>
                <th class="table-index">ID Entre</th>
                <th class="table-index">ID Eglise</th>
                <th style="max-width: 300px;">Motif</th>
                <th style=" width:150px ;max-width:160px">Montant</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $d): ?>
                <tr>
                    <td><?php echo htmlspecialchars($d['identre']) ?></td>
                    <td><?php echo htmlspecialchars($d['ideglise']) ?></td>
                    <td><?php echo htmlspecialchars($d['motif']) ?></td>
                    <td style="text-align: end;">
                        <?php echo htmlspecialchars( $formatter->formatCurrency($d['montantEntre'], 'MGA'));?></td>
                    <td><?php echo htmlspecialchars($d['dateEntre']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="pop-up-form" class="centered-modal" style="display: none;">
        <div class="wrapper">
            <div class="window-decoration">
                <button id="btn-close" class="close-btn" type="button" style="margin-bottom: 0;">X</button>
            </div>
            <h4 class="form-title">Completer le formulaire</h4>
            <hr>
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
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> My PHP Project. All rights reserved.
    </footer>
    <script src="script/action.js"></script>
</body>

</html>