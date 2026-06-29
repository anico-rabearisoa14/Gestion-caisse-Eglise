<?php
require __DIR__ . '/init.php';
$pageTitle = "Filtre mouvement";

$data = [];
$totalMontant = 0;

$show_message = $_SESSION['show_message'] ?? 'false'; 
$message_type = $_SESSION['message_type'] ?? '';
$message_body = $_SESSION['message_body'] ?? '';

unset($_SESSION['show_message']);
unset($_SESSION['message_type']);
unset($_SESSION['message_body']);

//  handle variables for printing 
$canPrint = false;
$category  = null;
$dateBegin = null;
$dateEnd   = null;

$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);

// get the values of the filter from the database
if (isset($_SESSION['filtered-data'])) {
    $data = $_SESSION['filtered-data'];
    $totalMontant = $_SESSION['filtered-total'];

    $category  = $_SESSION['requested-category-to-print'] ?? null;
    $dateBegin = $_SESSION['requested-begin-date-to-print'] ?? null;
    $dateEnd   = $_SESSION['requested-end-date-to-print'] ?? null;
    $canPrint  = ($category && $dateBegin && $dateEnd);

    // remove the variables from the session
    unset($_SESSION['filtered-data']);
    unset($_SESSION['filtered-total']);
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
        <h1><span class="state"></span></h1>
    </header>

    <div id="container">

        <!-- get all input and submit to make the filter -->
        <form id="TriggerOnPageLoad" method="GET" action="filter/filter.php" class="main-form-wrapper">
            <div id="select-area">
                <label for="to-filter">Filtrer une </label>
                <select id="to-filter" name="to-filter" required>
                    <option value="" disabled selected>Choisir</option>
                    <option value="sortie">Sortie</option>
                    <option value="entre">Entrée</option>
                </select>
            </div>

            <label for="date-begin">du </label>
            <input type="date" id="date-begin" class="date-begin" name="date-begin"
                value="<?php echo htmlspecialchars($dateBegin ?: date('y-m-d')) ?>" required>

            <label for="date-end">jusqu'au </label>
            <input type="date" id="date-end" class="date-end" name="date-end"
                value="<?php echo htmlspecialchars($dateEnd ?: date('y-m-d')) ?>" required>

            <div class="button-layout" style="margin-top: 15px;">
                <button class="submit-btn" type="submit">Demander</button>
            </div>
        </form>

        <!-- afficher le resultat d'une mouvement -->
        <div class="reponse-filtre">

            <form method="GET" action="print.php">
                <input type="hidden" name="_category"
                    value="<?php echo htmlspecialchars($category ?? ''); ?>">

                <input type="hidden" name="date-to-print-begin"
                    value="<?php echo htmlspecialchars($dateBegin ?? ''); ?>">

                <input type="hidden" name="date-to-print-end"
                    value="<?php echo htmlspecialchars($dateEnd ?? ''); ?>">

                <button type="submit"
                    class="normal-btn"
                    <?php echo !$canPrint ? 'disabled' : ''; ?>
                    style="background-color:transparent ;border:1px solid #3b4a6b ;width:fit-content ;color:#000e2c;
                   <?php echo !$canPrint ? 'opacity:0.4; cursor:not-allowed;' : ''; ?>">
                    Imprimer</button>
            </form>

            <p>Entre <span id="begin"><?php echo htmlspecialchars($dateBegin ?? ''); ?></span>
             et <span id="end"><?php echo htmlspecialchars($dateEnd ?? ''); ?></span></p>
            <table id="data-table" border="1" class="filtered-data-table">
                <thead style="position: sticky; top:173px">
                    <tr>
                        <th style="min-width:85px; width:200px">Date <span><?php echo htmlspecialchars($category ?? ''); ?></span></th>
                        <th style="min-width:100px; width:300px;">Motif</th>
                        <th style="max-width:300px; width:250px; min-width:90px">Montant</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if ($data): ?>
                        <?php foreach ($data as $d): ?>
                            <td><?php echo htmlspecialchars($d['date']) ?></td>
                            <td><?php echo htmlspecialchars($d['motif']) ?></td>
                            <td style="text-align: end;">
                                <?php echo htmlspecialchars($formatter->formatCurrency($d['montant'], 'MGA')); ?>
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
                <p id="montant-total">
                    <b>Total Montant
                        <span id="flux">sortant</span> :
                        <span id="total-value">
                            <?php echo htmlspecialchars($formatter->formatCurrency($totalMontant, 'MGA')) ?>
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
        &copy; <?php echo date("Y"); ?> My PHP Project. All rights reserved.
    </footer>
    <!-- <script src="script/utilities.js"></script> -->
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const category = "<?php echo htmlspecialchars($category ?? false); ?>";
            const dateBegin = "<?php echo htmlspecialchars($dateBegin ?? false); ?>";
            const dateEnd = "<?php echo htmlspecialchars($dateEnd ?? false); ?>";
            const canPrint = category && dateBegin && dateEnd;

            // Show toast based on state
            if (!canPrint) {
                toast('Veuillez faire une filtre avant d\'imprimer', 'warning');
           }

            // Update UI state
            const btn = document.querySelector('.button-imprimer button[type="submit"]');
            if (btn) {
                btn.disabled = !canPrint;
                btn.style.opacity = canPrint ? '1' : '0.4';
                btn.style.cursor = canPrint ? 'pointer' : 'not-allowed';
            }
        });

    </script>
</body>
</html>