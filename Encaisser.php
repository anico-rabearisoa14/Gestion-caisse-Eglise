<?php
require 'shield.php';
// require __DIR__ . '/init.php';
include_once 'crud/entre.php';
$pageTitle = "Encaissement";

$show_message = $_SESSION['show_message'] ?? 'false';
$message_type = $_SESSION['message_type'] ?? '';
$message_body = $_SESSION['message_body'] ?? '';

unset($_SESSION['show_message'], $_SESSION['message_type'], $_SESSION['message_body']);

// handle the message session
function setSessionMessage(string $type, string $body): void
{
    $_SESSION['show_message'] = 'true';
    $_SESSION['message_type'] = $type;
    $_SESSION['message_body'] = $body;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $method = $_POST['_method'] ?? 'POST';

    if ($method === 'UPDATE') {
        $res = misAJourEntre(
            $_POST['id-record'],
            $_POST['ideglise'],
            $_POST['motif'],
            $_POST['ancien-montant'],
            $_POST['montant'],
            $_POST['date-operation']
        );
        setSessionMessage($res['status'], $res['message']);
    } elseif ($method === 'DELETE') {
        $res = supprimerEntre($_POST['id-to-delete']);
        setSessionMessage($res['status'], $res['message']);
    } else {
        $res = ajouterEntre(
            $_POST['ideglise'],
            $_POST['motif'],
            $_POST['montant'],
            $_POST['date-operation']
        );
        setSessionMessage(
            $res ? 'success' : 'error',
            $res ? 'Ajout reussi' : 'Echec de l\'ajout'
        );
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);

$query = '';
if (isset($_SESSION['search_results'])) {
    $data  = $_SESSION['search_results'];
    $query = $_SESSION['search_query'];
    unset($_SESSION['search_results'], $_SESSION['search_query']);
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
    <link rel="stylesheet" href="fonts/tabler/dist/tabler-icons-200.min.css">
    <link rel="stylesheet" href="fonts/fa/css/all.min.css">
    <?php include 'includes/styles.php'; ?>
    <?php include_once 'includes/formStyle.php'; ?>
</head>

<body>

    <?php include 'includes/nav.php'; ?>
    <header>
        <h1>Liste des encaissements</h1>
        <div class="button-container">
            <form class="search-bar" method="GET" action="crud/search.php" autocomplete="off">
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
            <!-- <i class="ti ti-circle-plus"></i> -->
        </div>
    </header>

    <table id="data-table" border="1" class="data-table">
        <thead style="position: sticky; top:179px">
            <tr>
                <th class="table-index">ID Entre</th>
                <th class="table-index">ID Eglise</th>
                <th style="width:300px;">Motif</th>
                <th style="width:150px;max-width:160px;">Montant</th>
                <th>Date</th>
                <th style="width: 100px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data): ?>
                <?php foreach ($data as $d): ?>
                    <tr id="<?php echo htmlspecialchars($d['identre']) ?>">
                        <td><?php echo htmlspecialchars($d['identre']) ?></td>
                        <td><?php echo htmlspecialchars($d['ideglise']) ?></td>
                        <td><?php echo htmlspecialchars($d['motif']) ?></td>
                        <td style="text-align: end;">
                            <?php echo htmlspecialchars($formatter->formatCurrency($d['montantEntre'], 'MGA')); ?>
                        </td>
                        <td><?php echo htmlspecialchars($d['dateEntre']) ?></td>
                        <td class="action-cell">
                            <button class="btn-update" title="Modifier">
                                <i class="fa-solid fa-pencil"></i>
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

    <div id="pop-up-form" class="centered-modal" style="display: none;">
        <div class="wrapper">
            <div class="window-decoration">
                <h4 class="form-title" style="margin-left: auto;">Completer le formulaire</h4>
                <button id="btn-close" class="close-btn" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <hr>
            <form class="form-container" method="POST" action="" autocomplete="off">
                <input id="_method" type="hidden" name="_method">
                <input type="hidden" id="id-record" name="id-record">
                <label for="ideglise">ID Eglise</label>
                <input type="text" name="ideglise" value="<?php echo htmlspecialchars($_SESSION['ID_EGLISE']); ?>" readonly required>

                <label for="motif">Motif</label>
                <input type="text" name="motif" required>

                <label for="montant">Montant</label>
                <input type="number" name="montant" min="10000" required>
                <input type="hidden" name="ancien-montant">

                <label for="date-operation">Date</label>
                <input id="today-date" type="date" name="date-operation">

                <button class="submit-btn" type="submit">Envoyer</button>
            </form>
        </div>
    </div>

    <form id="pop-up-confirm" method="POST" action="" class="centered-modal" style="display: none;">
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

    <div class="message-box success-box" style="display: none;">
        <input id="message-toogle" type="hidden" value="<?php echo htmlspecialchars($show_message) ?>">
        <input id="message-to-show-type" type="hidden" value="<?php echo htmlspecialchars($message_type ?: ''); ?>">
        <input id="message-to-show-body" type="hidden" value="<?php echo htmlspecialchars($message_body ?: ''); ?>">
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> My PHP Project. All rights reserved.
    </footer>
    <script src="script/action.js"></script>
    <script src="script/notification.js"></script>
</body>

</html>