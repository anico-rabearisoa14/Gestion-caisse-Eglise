<?php
include_once 'crud/eglise.php';
$pageTitle = "Services - My PHP Project";

$pageTitle = "About - My PHP Project";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['ideglise'];
    $motif = $_POST['motif'];
    $montant = $_POST['montantSortie'];
    $date = $_POST['dateSortie'];
    $res = ajouterSortie($id, $motif, $montant, $date);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);
$data = listeInfoSortie();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <?php include 'includes/styles.php'; ?>
    <?php include_once 'includes/formStyle.php'; ?>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <?php include 'includes/nav.php'; ?>
    <header>
        <h1>Liste des decaissements</h1>
        <div class="button-container">
            <div class="search-bar">
                <input type="text" placeholder="Rechercher...">
                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
            <button id="ajout-btn" type="button" class="normal-btn"
                style="margin-left:auto; background-color:#3b4a6b;">Ajouter</button>
        </div>
    </header>


    <table border="1" class="data-table">
        <thead style="position: sticky; top:173px">
            <tr>
                <th class="table-index">ID Entre</th>
                <th class="table-index">ID Eglise</th>
                <th style="width:300px;">Motif</th>
                <th style=" width:150px ;max-width:160px;">Montant</th>
                <th>Date</th>
                <th style="width: 100px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $d): ?>
                <tr>
                    <td><?php echo htmlspecialchars($d['idsortie']) ?></td>
                    <td><?php echo htmlspecialchars($d['ideglise']) ?></td>
                    <td><?php echo htmlspecialchars($d['motif']) ?></td>
                    <td style="text-align: end;">
                        <?php echo htmlspecialchars($formatter->formatCurrency($d['montantSortie'], 'MGA')); ?></td>
                    <td><?php echo htmlspecialchars($d['dateSortie']) ?></td>
                    <td class="action-cell">
                        <button class="btn-update" title="Modifier">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button class="btn-delete" title="Supprimer">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div id="pop-up-form" class="centered-modal" style="display: none;">
        <div class="wrapper">
            <div class="window-decoration">
                <button id="btn-close" class="close-btn" type="button" style="margin-bottom: 0;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
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