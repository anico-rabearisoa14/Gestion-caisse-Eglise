<?php
session_start();
include_once 'crud/eglise.php';
$pageTitle = "Encaissement";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['ideglise'];
    $motif = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_INT);
    $montant = $_POST['montant'];
    $date = $_POST['date-operation'];
    $res = ajouterEntre($id, $motif, $montant, $date);

    if ($res) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
    }
}

$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);

$query = '';
if (isset($_SESSION['search_results'])) {
    $data  = $_SESSION['search_results'];
    $query = $_SESSION['search_query'];
    unset($_SESSION['search_results']);
    unset($_SESSION['search_query']);
} else {
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
    <?php include_once 'includes/formStyle.php'; ?>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <?php include 'includes/nav.php'; ?>
    <header>
        <h1>Liste des ecaissements</h1>
        <div class="button-container">

            <form class="search-bar" method="GET" action="crud/search.php">
                <input type="hidden" name="table" value="entre">
                <input type="text" placeholder="Rechercher..." name="query"
                    value="<?= htmlspecialchars($query ?? '') ?>">

                <?php if (!empty($query)): ?>
                    <a href="Encaisser.php" class="clear-btn" style="margin-right: 4px;">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                <?php endif; ?>

                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

            </form>

            <button id="ajout-btn" type="button" class="normal-btn"
                style="margin-left:auto; background-color:#3b4a6b;">Ajouter</button>
        </div>
    </header>

    <!-- Table to show all records on the ENTRE table -->
    <table id="data-table" border="1" class="data-table">
        <thead style="position: sticky; top:173px">
            <tr>
                <th class="table-index">ID Entre</th>
                <th class="table-index">ID Eglise</th>
                <th style="width:300px;">Motif</th>
                <th style=" width:150px ;max-width:160px">Montant</th>
                <th>Date</th>
                <th style="width: 100px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $d): ?>
                <tr id="<?php echo htmlspecialchars($d['identre']) ?>">
                    <td><?php echo htmlspecialchars($d['identre']) ?></td>
                    <td><?php echo htmlspecialchars($d['ideglise']) ?></td>
                    <td><?php echo htmlspecialchars($d['motif']) ?></td>
                    <td style="text-align: end;">
                        <?php echo htmlspecialchars($formatter->formatCurrency($d['montantEntre'], 'MGA')); ?></td>
                    <td><?php echo htmlspecialchars($d['dateEntre']) ?></td>
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

                <label for="motif">Motif</label>
                <input type="text" name="motif" required>

                <label for="montant">Montant</label>
                <input type="number" name="montant" required>

                <label for="date-operation">Date</label>
                <input id="today-date" type="date" name="date-operation">

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