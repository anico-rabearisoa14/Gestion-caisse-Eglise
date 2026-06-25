<?php
require __DIR__ . '/init.php';
$pageTitle = "Filtre mouvement";
$mouvement = "";
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <?php include 'includes/styles.php'; ?>
    <?php include 'includes/filtre.css.php' ?>
</head>

<body>

    <?php include 'includes/nav.php'; ?>
    <header>
        <h1>Mouvement de caisse<span class="state"></span></h1>
    </header>

    <div id="container">

        <form method="POST" action="" class="main-form-wrapper">
            <div id="select-area">
                <label for="to-filter">Filtrer une </label>
                <select id="to-filter" name="to-filter">
                    <option value="sortie">Sortie</option>
                    <option value="entrer">Entree</option>
                </select>
            </div>
            <div class="input-wrapper">
                <div class="date-input">
                    <label for="date-begin">du </label>
                    <input type="date" id="date-begin" class="date-begin" name="date-begin">
                </div>
                <div class="date-input">
                    <label for="date-end">jusqu'au </label>
                    <input type="date" id="date-end" class="date-end" name="date-end">
                </div>
            </div>
            <div class="button-layout" style="margin-top: 15px;">
                <button class="submit-btn" type="submit">Demander</button>
            </div>
        </form>

        <!-- afficher le resultat d'une mouvement -->

        <div class="reponse-filtre">
            <div class="button-imprimer" style="display: flex; justify-content:space-between">
                <p>Resultat :</p>
                <button type="button" class="normal-btn" style="background-color:#3b4a6b ;">Imprimer</button>
            </div>
            <table id="data-table" border="1" class="filtered-data-table">
                <thead style="position: sticky; top:173px">
                    <tr>
                        <th style="min-width:150px; width:250px">Date</th>
                        <th style="min-width:150px; width:300px;">Motif</th>
                        <th style="max-width:300px; width:250px;">Montant</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if ($data): ?>
                        <?php foreach ($data as $d): ?>
                            <td><?php echo htmlspecialchars($d['dateEntre']) ?></td>
                            <td><?php echo htmlspecialchars($d['motif']) ?></td>
                            <td style="text-align: end;">
                                <?php echo htmlspecialchars($formatter->formatCurrency($d['montantEntre'], 'MGA')); ?>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Faire une filtre</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="button-imprimer" style="display: flex; justify-content:space-between">
                <h4>Total</h4>
                <!-- <button type="button" class="normal-btn" style="background-color:#3b4a6b ;">Imprimer</button> -->
            </div>
        </div>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> My PHP Project. All rights reserved.
    </footer>
    <script src="script/utilities.js"></script>
</body>

</html>