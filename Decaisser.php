<?php
require __DIR__ . '/init.php';
include_once 'crud/sortie.php';
$pageTitle = "Decaissement";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $method = $_POST['_method'] ?? 'POST';

    if ($method === 'UPDATE') {
        // Handle UPDATE
        $id       = $_POST['id-record'];
        $ideglise = $_POST['ideglise'];
        $motif    = $_POST['motif'];
        $montant  = $_POST['montant'];
        $date     = $_POST['date-operation'];

        $res = misAJourSortie($id, $ideglise, $motif, $montant, $date);
        if ($res['success']) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    } elseif($method == 'DELETE') {
        $id = $_POST['id-to-delete'];
        $res = supprimerSortie($id);
        if($res['success']){
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
    else{
        // Handle POST (insert)
        $id     = $_POST['ideglise'];
        $motif  = $_POST['motif'];
        $montant = $_POST['montant'];
        $date   = $_POST['date-operation'];

        $res = ajouterSortie($id, $motif, $montant, $date);
        if ($res) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

//  currency formatter
$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);

// handle search option
$query = '';
if (isset($_SESSION['search_results'])) {
    $data  = $_SESSION['search_results'];
    $query = $_SESSION['search_query'];
    unset($_SESSION['search_results']);
    unset($_SESSION['search_query']);
} else {
    $data = listeInfoSortie();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <?php include 'includes/styles.php'; ?>
    <?php include_once 'includes/formStyle.php'; ?>
    
</head>

<body>

    <?php include 'includes/nav.php'; ?>
    <header>
        <h1>Liste des decaissements</h1>
        <div class="button-container">

            <form class="search-bar" method="GET" action="crud/search.php" autocomplete="off">
                <input type="hidden" name="table" value="sortie">
                <input type="text" placeholder="Rechercher..." name="query"
                    value="<?= htmlspecialchars($query ?? '') ?>">

                <?php if (!empty($query)): ?>
                    <a href="Decaisser.php" class="clear-btn" style="margin-right: 4px;">
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

<!-- lister toutes le records dans la base de donne -->
    <table id="data-table" border="1" class="data-table">
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
            <?php if ($data): ?>
                <?php foreach ($data as $d): ?>
                    <tr id="<?php echo htmlspecialchars($d['idsortie']) ?>">

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
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Aucune donnée disponible</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- ajouter nouveau record -->
    <div id="pop-up-form" class="centered-modal" style="display: none;">
        <div class="wrapper">
            <div class="window-decoration">
                <button id="btn-close" class="close-btn" type="button" style="margin-bottom: 0;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <h4 class="form-title">Completer le formulaire</h4>
            <hr>
            <form class="form-container" method="POST" action="" autocomplete="off">

                <input id="_method" type="hidden" name="_method">
                <input type="hidden" id="id-record" name="id-record">
                <label for="ideglise">ID Eglise</label>
                <input type="text" name="ideglise" value="<?php echo htmlspecialchars($_SESSION['ID_EGLISE']); ?>">

                <label for="motif">Motif du decaissement</label>
                <input type="text" name="motif" required>

                <label for="montant">Montant a retirer</label>
                <input type="number" name="montant" min="10000" required>

                <label for="date-opertaion">Date d'operation</label>
                <input id="today-date" type="date" name="date-operation">

                <button class="submit-btn" type="submit">Enregistrer</button>
            </form>
        </div>
    </div>

 <!-- confirmation prompt avant supprimer -->
    <form id="pop-up-confirm" method="POST" class="centered-modal" style="display: none;">
        <div class="wrapper">
            <div class="action-title">Etes vous sur de supprimer</div>
            <div class="button-layout">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id-to-delete">
                <button type="submit" id="acceptBtn" class="accept-btn">Oui</button>
                <button type="button" id="refusBtn" class="refus-btn">Non</button>
            </div>
        </div>
    </form>

<div class="message-box success-box">
  <p class="message-success">Suppression reussie</p>
</div>

    <footer>
        &copy; <?php echo date("Y"); ?> My PHP Project. All rights reserved.
    </footer>
    <script src="script/action.js"></script>
</body>

</html>