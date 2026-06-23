<?php
require __DIR__ . '/init.php';
$currentDate = date("F j, Y");
$projectName = 'GestionEglise';

// check if there is an Eglise
require_once 'crud/eglise.php';
if ($info = listeInfoEglise()) {
    $contientUne = true;
} else {
    $contientUne = false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['ideglise'];
    $design = $_POST['Design'];
    $result = createEglise($id, $design, 10000);
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
    </div>

     <!-- sinon afficher les infos a propos de l'eglise -->
    <div class="wrapper"
         style="display: <?php echo htmlspecialchars($contientUne ? 'block' : 'none') ?>;">
        <h4 class="form-title">Informations sur l'Eglise </h4>
        <hr>
        <div class="form-container">
            <ul class="info-liste">
                <li><b>ID : </b> <?php echo htmlspecialchars($info['ideglise']) ?></li>
                <li><b>Design:</b> <?php echo htmlspecialchars($info['Design']) ?></li>
                <li><b>Solde:</b> <?php echo htmlspecialchars($formatter->formatCurrency($info['Solde'], 'MGA')) ?><span></span></li>
            </ul>
        </div>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($projectName); ?>. All rights reserved.
    </footer>

</body>

</html>