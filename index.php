<?php
require __DIR__ . '/init.php';
$projectName = 'GestionCaisseEglise';
$pageTitle = 'Acceuil';

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

// check if there is an Eglise
require_once 'crud/eglise.php';
if ($info = listeInfoEglise()) {
    $contientUne = true;
    $bilanEntre  = getAllBilanEntre();
    $bilanSortie = getAllBilanSortie();
    $entreData  = $bilanEntre['data'];
    $sortieData = $bilanSortie['data'];
} else {
    $contientUne = false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['_method'] == 'DELETE') {
        $result = supprimerEglise(trim($_POST['id-to-delete']));
        setSessionMessage(
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    } elseif ($_POST['_method'] == 'UPDATE') {
        $result = misAJourEglise($_POST['id-to-edit'], $_POST['new-name']);
        setSessionMessage($result['success'] ? 'success' : 'error', $result['message']);
    } else {
        $id = $_POST['ideglise'];
        $design = $_POST['Design'];
        $result = createEglise($id, $design, 0);
        if ($result) {
            setSessionMessage(
                $result ? 'success' : 'error',
                $result ? 'Ajout reussi' : 'Echec de l\'ajout'
            );
        }
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eglise | <?php echo htmlspecialchars($pageTitle); ?></title>
    <?php include 'includes/styles.php'; ?>
    <?php include 'includes/formStyle.php'; ?>
    <link rel="stylesheet" href="fonts/tabler/dist/tabler-icons-200.min.css">
    <link rel="stylesheet" href="fonts/fa/css/all.min.css">
</head>

<body>

    <?php include 'includes/nav.php'; ?>
    <header>
        <h1><?php echo htmlspecialchars($contientUne ?
                'Les renseignements de votre Église' : 'Ajouter une eglise') ?></h1>
    </header>

    <!--  afficher le formulaire si il n'y a pas d'eglise -->
    <div class="wrapper"
        style="display: <?php echo htmlspecialchars($contientUne ? 'none' : 'block') ?>;">
        <h4 class="form-title">Completer les informations</h4>
        <hr>
        <form class="form-container" method="POST" action="">
            <label for="ideglise">ID Eglise</label>
            <input type="text" name="ideglise" required>
            <label for="Design">Designation</label>
            <input type="text" name="Design" required>
            <button class="submit-btn" type="submit">Ajouter</button>
        </form>
    </div>

    <!-- sinon afficher les infos a propos de l'eglise -->
    <div class="wrapper"
        style="display: <?php echo htmlspecialchars($contientUne ? 'block' : 'none') ?>;">
        <h4 class="form-title"><i class="ti ti-info-circle"></i> Informations sur l'Eglise </h4>
        <hr>
        <div class="form-container">
            <ul class="info-liste">
                <li><b>ID : </b> <span id="id-eglise"><?php echo htmlspecialchars($info['ideglise']) ?></span></li>
                <li><b>Design:</b> <span id="nom-eglise"><?php echo htmlspecialchars($info['Design']) ?></span></li>
                <li><b>Solde:</b> <?php echo htmlspecialchars($formatter->formatCurrency($info['Solde'], 'MGA')) ?><span></span></li>
            </ul>
        </div>

        <!--  -->
        <div class="button-layout" style="display: flex; justify-content:end">
            <button id="editerEglise" style="width: fit-content;"
                aria-label="Editer l'eglise" title="Editer le nom l'eglise"><i class="fa-solid fa-pencil"></i></button>
            <button id="deleteEglise" style="width: fit-content; color:#ef4444cc;"
                aria-label="Supprimer l'eglise" title="Supprimer l'eglise"><i class="fa-solid fa-trash-can"></i></button>
            <!-- <button id="deleteEglise" style="width: fit-content; color:#ef4444cc;"
                aria-label="Bilan" title="Voir le bilan graphiquement"><i class="fa-solid fa-bar-chart"></i></button> -->

        </div>

    </div>
    <div style="height:400px;
            max-width:700px;
            margin: 0 auto;">
        <canvas id="myChart"></canvas>
    </div>

    <!-- confirmation de suppression  -->
    <form id="pop-up-confirm" method="POST" class="centered-modal" style="display: none;">
        <div class="wrapper">
            <div class="action-title">
                <i class="ti ti-alert-triangle" style="color: red;">
                </i> Toutes les données de la base de données seront supprimées !<br>
                Etes vous sur de supprimer ?
            </div>
            <div class="button-layout">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id-to-delete">
                <button type="submit" id="acceptBtn" class="accept-btn">Oui</button>
                <button type="button" id="refusBtn" class="refus-btn">Non</button>
            </div>
        </div>
    </form>

    <!-- conserver les messages apres chaque actions -->
    <div class="message-box success-box" style="display: none">
        <input id="message-toogle" type="hidden" value="<?php echo htmlspecialchars($show_message) ?>">
        <input id="message-to-show-type" type="hidden" value="<?php echo htmlspecialchars($message_type ?: ''); ?>">
        <input id="message-to-show-body" type="hidden" value="<?php echo htmlspecialchars($message_body ?: ''); ?>">
    </div>

    <!-- editer formulaire -->
    <div id="edit-form" class="centered-modal" style="display: none;">
        <div class="wrapper">
            <div class="window-decoration">
                <h4 class="form-title" style="margin-left: auto;">Editer le nom de l'eglise</h4>
                <button id="btn-close" class="close-btn" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <hr>
            <form method="POST" class="form-container" action="" autocomplete="off">
                <input type="hidden" name="_method" value="UPDATE">
                <input type="hidden" name="id-to-edit" value="<?php echo htmlspecialchars($_SESSION['ID_EGLISE']) ?>">
                <label for="new-name">Nouveau nom :</label>
                <input type="text" name="new-name">
                <button type="submit" class="submit-btn">Enregistrer</button>
            </form>
        </div>
    </div>

    <!-- button pour ajouter une nouvel eglise  -->
    <!-- <div class="main-add-button" style=" display: <?php echo htmlspecialchars($contientUne ? 'block' : 'none') ?>;position: fixed; bottom:90px ; right:40px">
        <button class="normal-btn" type="button" title="ajouter une nouvelle eglise"
            style="display:flex; 
            justify-content:center;
            align-items:center;
            padding:0px;
            font-size: 2rem; border-radius:60% ;width:50px;height:50px ; font-weight:bold">
            <i class="ti ti-plus"></i>
        </button>
    </div> -->

    <footer>
        &copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($projectName); ?>. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // handle delete button action
        document.getElementById('deleteEglise').addEventListener('click', function() {
            const id = document.getElementById('id-eglise').textContent;
            console.log(id);
            document.getElementsByName('id-to-delete')[0].value = id;
            document.getElementById('pop-up-confirm').style.display = '';
        });

        document.getElementById('refusBtn').addEventListener('click', function() {
            document.getElementsByName('id-to-delete')[0].value = null;
            document.getElementById('pop-up-confirm').style.display = 'none';
        });

        // handle update button action
        document.getElementById('editerEglise').addEventListener('click', function() {
            const oldName = document.getElementById('nom-eglise').textContent;
            document.getElementsByName('new-name')[0].value = oldName;
            document.getElementById('edit-form').style.display = '';
        });

        document.getElementById('btn-close').addEventListener('click', function() {
            document.getElementById('edit-form').style.display = 'none';
        });


        // here to handle the statistic graph  
        const ctx = document.getElementById('myChart');
        const entreData = <?= json_encode($entreData) ?>;
        const sortieData = <?= json_encode($sortieData) ?>;
        const graphTitle = 'Visualisation  mensuel du mouvement de caisse\n (unité Ar)';
        ctx.style.display = 'none';
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Janvier ', 'Février ', 'Mars ', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août ', 'Semptembre', 'Octobre', 'Novembre', 'Decembre'],
                datasets: [{
                        label: 'Entre',
                        data: entreData,
                        // [12, 19, 3, 5, 2, 3 ,12, 19, 3, 5, 2, 3],
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1,
                        borderRadius: 10
                    },
                    {
                        label: 'Sortie',
                        data: sortieData,
                        // [8, 14, 9, 12, 6, 15,8,14, 9, 12, 6, 15],
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgb(255, 99, 132)',
                        borderWidth: 1,
                        borderRadius: 10
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: graphTitle
                    }
                }
            }
        });
    </script>
    <script src="script/notification.js"></script>
</body>

</html>