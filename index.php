<?php
$pageTitle = "New thing";
$welcomeMessage = "Biienvenu !";
$currentDate = date("F j, Y");
$projectName = 'GestionEglise';

// check if there is an Eglise
function chekAvailability() :string{ $contientUne = false; $state = ($contientUne) ? 'none' : 'block'; return $state; }
function showInfo() :string{ $contientUne = true; $state = ($contientUne) ? 'block' : 'none'; return $state; }

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
        <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
    </header>

    <div class="wrapper" style="display: none;">
        <h4 class="form-title">Ajouter votre eglise ici</h4><hr>
        <!-- should be flex the form on the middle -->
            <form class="form-container" action="">
                <label for="ideglise">ID Eglise</label><input type="text" name="ideglise" required>
                <label for="Design">Designation</label><input type="text" name="Design" required>
                <button class="submit-btn" type="submit">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="wrapper" style="display: <?php echo htmlspecialchars(showInfo()) ?>;">
        <h4 class="form-title">Informations sur l'Eglise</h4><hr>
        <div class="form-container">
            <ul class="info-liste">
                <li><b>ID : </b></li>
                <li><b>Design:</b></li>
                <li><b>Solde:</b></li>
            </ul>
        </div>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($projectName); ?>. All rights reserved.
    </footer>

</body>

</html>