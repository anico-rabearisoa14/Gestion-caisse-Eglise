<?php
require 'shield.php';
$projectName = 'GestionCaisseEglise';
$pageTitle = "Mouvement de caisse";

// Create an immutable date object
$now_date = date('Y-m-d');
$date = new DateTimeImmutable('now', new DateTimeZone('UTC'));
// Minus 10 days (returns a new object)
$newDate = $date->modify('-1 month');

$data_sortie = [];
$data_entre = [];
$totalMontantEntre = 0;
$totalMontantSortie = 0;

$show_message = $_SESSION['show_message'] ?? 'false';
$message_type = $_SESSION['message_type'] ?? 'info';
$message_body = $_SESSION['filter-message'] ?? 'not reached';

unset($_SESSION['show_message']);
unset($_SESSION['message_type']);
unset($_SESSION['filter-message']);

//  handle variables for printing 
$canPrint = false;
$category  = null;
$dateBegin = null;
$dateEnd   = null;

$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);

// get the values of the filter from the database
if (isset($_SESSION['filtered-data-sortie'])) {
    $data_sortie = $_SESSION['filtered-data-sortie'];
    $data_entre = $_SESSION['filtered-data-entre'];

    $totalMontantEntre = $_SESSION['filtered-total-entre'];
    $totalMontantSortie = $_SESSION['filtered-total-sortie'];

    $dateBegin = $_SESSION['requested-begin-date-to-print'];
    $dateEnd   = $_SESSION['requested-end-date-to-print'];
    $canPrint  = true;

    unset($_SESSION['filtered-data-sortie'], $_SESSION['filtered-data-entre']);
    unset($_SESSION['requested-category-to-print']);
    unset($_SESSION['requested-begin-date-to-print']);
    unset($_SESSION['requested-end-date-to-print']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <?php include 'includes/styles.php'; ?>
    <?php include 'includes/filtre.css.php'; ?>
</head>

<body>

    <?php include 'includes/nav.php'; ?>
    <header>
        <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
        <h1><span class="state"></span></h1>
    </header>

    <div id="container">

        <!-- get all input and submit to make the filter -->
        <form id="TriggerOnPageLoad" method="GET"
            action="filtrer_une_mouvement/filter.php" class="main-form-wrapper">

            <label for="date-begin">du </label>
            <input type="date" id="date-begin" class="date-begin" name="date-begin"
                value="<?php echo htmlspecialchars($dateBegin) ?: $newDate->format('Y-m-d') ?>" required>

            <label for="date-end">jusqu'au </label>
            <input type="date" id="date-end" class="date-end" name="date-end"
                value="<?php echo htmlspecialchars($dateEnd ?: date('Y-m-d')) ?>" required>

            <div class="button-layout" style="align-self:flex-start; margin-left:auto;">
                <!-- margin-top: 15px; -->
                <button class="submit-btn" type="submit" style="margin:0">Demander</button>
            </div>
        </form>

        <!-- afficher le resultat d'une mouvement -->
        <div class="reponse-filtre">

            <!-- boutton imprimer -->
            <form method="GET" action="print.php">
                <div> <input type="hidden" name="date-to-print-begin"
                        value="<?php echo htmlspecialchars($dateBegin ?? ''); ?>">

                    <input type="hidden" name="date-to-print-end"
                        value="<?php echo htmlspecialchars($dateEnd ?? ''); ?>">
                </div>

                <button type="submit" class="normal-btn"
                    style="background-color:transparent ;border:1px solid #3b4a6b ;width:fit-content ;color:#000e2c;
                   <?php echo !$canPrint ? 'opacity:0.4; cursor:not-allowed;' : ''; ?>">
                    Imprimer</button>
            </form>

            <!-- -->
            <p style="margin: 12px 1px;">Mouvement de caisse entre <span id="begin"><?php echo htmlspecialchars($dateBegin ?? 'N?A'); ?></span>
                et <span id="end"><?php echo htmlspecialchars($dateEnd ?? 'N?A'); ?></span></p>
            <hr>
            <!-- pour entrée -->

            <p>Mouvement d’entrée en caisse</p>
            <table id="data-table" border="1" class="filtered-data-table">
                <thead>
                    <tr>
                        <th style="min-width:85px; width:200px">Date <span><?php echo htmlspecialchars($category ?? ''); ?></span></th>
                        <th style="min-width:100px; width:300px;">Motif</th>
                        <th style="max-width:300px; width:250px; min-width:90px">Montant</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if ($data_entre): ?>
                        <?php foreach ($data_entre as $d): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($d['date']) ?></td>
                                <td><?php echo htmlspecialchars($d['motif']) ?></td>
                                <td style="text-align: end;">
                                    <?php echo htmlspecialchars($formatter->formatCurrency($d['montant'], 'MGA')); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center;">Faire une filtre</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="button-imprimer" style="display: flex; justify-content:space-between">
                <p id="montant-total">
                    <b>Total Montant
                        <span id="flux">entrant</span> :
                        <span id="total-value">
                            <?php echo htmlspecialchars($formatter->formatCurrency($totalMontantEntre, 'MGA')) ?>
                        </span>
                    </b>
                </p>
            </div>

            <!-- pour sortie -->
            <br>
            <p>Mouvement de sortie de caisse</p>
            <table id="data-table" border="1" class="filtered-data-table">
                <thead>
                    <tr>
                        <th style="min-width:85px; width:200px">Date <span><?php echo htmlspecialchars($category ?? ''); ?></span></th>
                        <th style="min-width:100px; width:300px;">Motif</th>
                        <th style="max-width:300px; width:250px; min-width:90px">Montant</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if ($data_sortie): ?>
                        <?php foreach ($data_sortie as $d): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($d['date']) ?></td>
                                <td><?php echo htmlspecialchars($d['motif']) ?></td>
                                <td style="text-align: end;">
                                    <?php echo htmlspecialchars($formatter->formatCurrency($d['montant'], 'MGA')); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center;">Faire une filtre</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="button-imprimer" style="display: flex; justify-content:space-between">
                <p id="montant-total">
                    <b>Total Montant
                        <span id="flux">sortant</span> :
                        <span id="total-value">
                            <?php echo htmlspecialchars($formatter->formatCurrency($totalMontantSortie, 'MGA')) ?>
                        </span>
                    </b>
                </p>
            </div>
        </div>
    </div>

    <div class="message-box success-box" style="display: none;">
        <input id="message-toogle" type="hidden"
            value="<?php echo htmlspecialchars($show_message) ?>">

        <input id="message-to-show-type" type="hidden"
            value="<?php echo htmlspecialchars($message_type ?: ''); ?>">

        <input id="message-to-show-body" type="hidden"
            value="<?php echo htmlspecialchars($message_body ?: ''); ?>">
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($projectName); ?>. All rights reserved.
    </footer>

    <script src="script/notification.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const category = "<?php echo htmlspecialchars($category ?: ''); ?>";
            const dateBegin = "<?php echo htmlspecialchars($dateBegin ?: ''); ?>";
            const dateEnd = "<?php echo htmlspecialchars($dateEnd ?: ''); ?>";
            const canPrint = dateBegin !== '' && dateEnd !== '';

            // Show toast based on state
            if (!canPrint) {
                toast('Veuillez faire une filtre pour imprimer', 'warning');
            } else {
                console.log(category);
                console.log(dateBegin);
                console.log(dateEnd);
                console.log(canPrint);
            }

            // Update UI state 
            const btn = document.querySelector('.reponse-filtre form button[type="submit"]');
            if (btn) {
                btn.disabled = !canPrint;
                btn.style.opacity = canPrint ? '1' : '0.4';
                btn.style.cursor = canPrint ? 'pointer' : 'not-allowed';
            }
        });
    </script>
</body>

</html>