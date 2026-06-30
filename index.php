<?php
require __DIR__ . '/init.php';
$currentDate = date("F j, Y");
$projectName = 'GestionEglise';
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
    }
    elseif($_POST['_method'] == 'UPDATE') {
    
    }
    else{
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
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <?php include 'includes/styles.php'; ?>
    <?php include 'includes/formStyle.php'; ?>
    <link rel="stylesheet" href="fonts/tabler/dist/tabler-icons-200.min.css">
    <link rel="stylesheet" href="fonts/fa/css/all.min.css">
</head>

<body>

    <?php include 'includes/nav.php'; ?>
    <header>
        <h1><?php echo htmlspecialchars($contientUne ?
                'Les renseignements de votre Eglise' : 'Ajouter une eglise') ?></h1>
    </header>

    <!--  afficher le formulaire si il n'y a pas d'eglise -->
    <div class="wrapper"
        style="display: <?php echo htmlspecialchars($contientUne ? 'none' : 'block') ?>;">
        <h4 class="form-title">Completer le form </h4>
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
                <li><b>Design:</b> <?php echo htmlspecialchars($info['Design']) ?></li>
                <li><b>Solde:</b> <?php echo htmlspecialchars($formatter->formatCurrency($info['Solde'], 'MGA')) ?><span></span></li>
            </ul>
        </div>
        <!--  -->
        <div class="button-layout" style="display: flex; justify-content:end">
            <button id="editerEglise" style="width: fit-content;"
                aria-label="Editer l'eglise" title="Editer l'eglise"><i class="fa-solid fa-pencil"></i></button>
            <button id="deleteEglise" style="width: fit-content; color:#ef4444cc;"
                aria-label="Supprimer l'eglise" title="Supprimer l'eglise"><i class="fa-solid fa-trash-can"></i></button>
        </div>
    </div>

    <!-- confirmation de suppression  -->
    <form id="pop-up-confirm" method="POST" class="centered-modal" style="display: none;">
        <div class="wrapper">
            <div class="action-title">
                <i class="ti ti-alert-triangle" style="color: red;">
                </i> Toutes les données de la base de données seront supprimées !<br> Etes vous sur de supprimer ?
            </div>
            <div class="button-layout">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id-to-delete">
                <button type="submit" id="acceptBtn" class="accept-btn">Oui</button>
                <button type="button" id="refusBtn" class="refus-btn">Non</button>
            </div>
        </div>
    </form>

    <!-- conserver les messages apres cahque actions -->
    <div class="message-box success-box" style="display: none">
        <input id="message-toogle" type="hidden" value="<?php echo htmlspecialchars($show_message) ?>">
        <input id="message-to-show-type" type="hidden" value="<?php echo htmlspecialchars($message_type ?: ''); ?>">
        <input id="message-to-show-body" type="hidden" value="<?php echo htmlspecialchars($message_body ?: ''); ?>">
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($projectName); ?>. All rights reserved.
    </footer>
    
    <script>
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

    </script>
    <script src="script/notification.js"></script>
</body>

</html>