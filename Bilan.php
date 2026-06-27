<?php
require __DIR__ . '/init.php';
$pageTitle = "Filtre mouvement";

$data = [];
$totalMontant = 0;
$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);

$category  = $_SESSION['requested-category-to-print'] ?? null;
$dateBegin = $_SESSION['requested-begin-date-to-print'] ?? null;
$dateEnd   = $_SESSION['requested-end-date-to-print'] ?? null;
$canPrint  = $category && $dateBegin && $dateEnd;

// get the values of the filter from the database
if (isset($_SESSION['filtered-data'])) {
    $data = $_SESSION['filtered-data'];
    $totalMontant = $_SESSION['filtered-total'];

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
                <select id="to-filter" name="to-filter">
                    <option value="null">Choisir</option>
                    <option value="sortie">Sortie</option>
                    <option value="entre">Entree</option>
                </select>
            </div>
            <label for="date-begin">du </label>
            <input type="date" id="date-begin" class="date-begin" name="date-begin" value="<?php echo htmlspecialchars($_SESSION['requested-begin-date-to-print'] ?: '') ?>">
            <label for="date-end">jusqu'au </label>
            <input type="date" id="date-end" class="date-end" name="date-end" value="<?php echo htmlspecialchars($_SESSION['requested-end-date-to-print'] ?: '') ?>">
            <div class="button-layout" style="margin-top: 15px;">
                <button class="submit-btn" type="submit">Demander</button>
            </div>
        </form>

        <!-- afficher le resultat d'une mouvement -->
        <div class="reponse-filtre">

            <!-- <form class="button-imprimer" method="GET" action="print.php" style="display: flex; width:100%">
                <p>Resultat :</p>
                <button type="submit" class="normal-btn"
                    style="background-color:transparent;
                border:1px solid #000e2c;
                       border-color:#3b4a6b;
                       width:fit-content;
                       align-self:flex-end;
                       color:#000e2c">Imprimer</button>
                <input type="text" name="_category" value="<?php
                //  echo htmlspecialchars($_SESSION['requested-category-to-print'] ?: 'null') ?>">
                <input type="text" name="date-to-print-begin" value="<?php 
                // echo htmlspecialchars($_SESSION['requested-begin-date-to-print'] ?: '') ?>">
                <input type="text" name="date-to-print-end" value="<?php 
                // echo htmlspecialchars($_SESSION['requested-end-date-to-print'] ?: '') ?>">

 -->


            <form method="GET" action="print.php">
                <input type="hidden" name="_category" value="<?php echo htmlspecialchars($category ?? ''); ?>">
                <input type="hidden" name="date-to-print-begin" value="<?php echo htmlspecialchars($dateBegin ?? ''); ?>">
                <input type="hidden" name="date-to-print-end" value="<?php echo htmlspecialchars($dateEnd ?? ''); ?>">

                <button type="submit"
                    class="normal-btn"
                    <?php echo !$canPrint ? 'disabled' : ''; ?>
                    style="background-color:transparent;
                   border:1px solid #3b4a6b;
                   width:fit-content;
                   color:#000e2c;
                   <?php echo !$canPrint ? 'opacity:0.4; cursor:not-allowed;' : ''; ?>">
                    Imprimer
                </button>
            </form>
            </form>

            <p>Entre <span id="begin">23-02-2023</span> et <span id="end">15-03-2023</span></p>
            <table id="data-table" border="1" class="filtered-data-table">
                <thead style="position: sticky; top:173px">
                    <tr>
                        <th style="min-width:85px; width:200px">Date</th>
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

    <footer>
        &copy; <?php echo date("Y"); ?> My PHP Project. All rights reserved.
    </footer>
    <!-- <script src="script/utilities.js"></script> -->
    <script>
        // just to handle visual text on what filter the user is doing 
        // const selectInput = document.getElementById('to-filter');
        // document.getElementsByClassName('state')[0].textContent = 'Mouvement de caisse';
        // // document.getElementsByName('_category')[0].value = 'sortie';

        // selectInput.addEventListener('input', function() {
        //     const value = selectInput.value;

        //     if (value == 'sortie') {
        //         document.getElementsByClassName('state')[0].textContent = 'Mouvement de sortie de caisse';
        //         document.getElementById('flux').textContent = 'sortant';
        //         document.getElementsByName('_category')[0].value = 'sortie';

        //     } else {
        //         document.getElementsByClassName('state')[0].textContent = "Mouvement d’entrée en caisse";
        //         document.getElementById('flux').textContent = 'entrant';
        //         document.getElementsByName('_category')[0].value = 'entre';
        //     }
        // });


document.addEventListener('DOMContentLoaded', function () {
    const category  = "<?php echo htmlspecialchars($category ?? ''); ?>";
    const dateBegin = "<?php echo htmlspecialchars($dateBegin ?? ''); ?>";
    const dateEnd   = "<?php echo htmlspecialchars($dateEnd ?? ''); ?>";
    const canPrint  = category && dateBegin && dateEnd;

    // // Show toast based on state
    // if (!canPrint) {
    //     toast('Veuillez faire une filtre avant d\'imprimer', 'warning');
    // }

    // Update UI state
    const btn = document.querySelector('.button-imprimer button[type="submit"]');
    if (btn) {
        btn.disabled = !canPrint;
        btn.style.opacity = canPrint ? '1' : '0.4';
        btn.style.cursor  = canPrint ? 'pointer' : 'not-allowed';
    }
});

        /*  listen for date input and display on the result */
        // const dateBegin = document.getElementById('date-begin');
        // const dateBeginSpan = document.getElementById('begin');
        // const dateEnd = document.getElementById('date-end');
        // const dateEndSpan = document.getElementById('end');


        // // for the beginin
        // dateBegin.addEventListener('input', function() {
        //     dateBeginSpan.textContent = dateBegin.value;
        //     document.getElementsByName('date-to-print-begin')[0].value = dateBegin.value;
        // });
        // // for the end
        // dateEnd.addEventListener('input', function() {
        //     dateEndSpan.textContent = dateEnd.value;
        //     document.getElementsByName('date-to-print-end')[0].value = dateEnd.value;
        // });

        /*  adjust date input value */
        // function adjustDate() {
        //     const begin = document.getElementsByName('date-begin');
        //     const end = document.getElementsByName('date-end');
        //     const today = new Date();

        //     // Extract components
        //     const year = today.getFullYear();
        //     // getMonth() returns 0-11, so add 1
        //     const month = String(today.getMonth() + 1).padStart(2, '0');
        //     const monthBegin = String((today.getMonth() + 1) - 1).padStart(2, '0');
        //     const day = String(today.getDate()).padStart(2, '0');

        //     // Format as YYYY-MM-DD
        //     const formattedDateBegin = `${year}-${monthBegin}-${day}`;
        //     const formattedDateEnd = `${year}-${month}-${day}`;

        //     // bind the values
        //     begin[0].value = formattedDateBegin;
        //     end[0].value = formattedDateEnd;

        //     // for the interface only (to display the actual date on the result)
        //     dateBeginSpan.textContent = dateBegin.value;
        //     dateEndSpan.textContent = dateEnd.value;
        //     // document.getElementsByName('date-to-print-end')[0].value = dateEnd.value;
        //     // document.getElementsByName('date-to-print-begin')[0].value = dateBegin.value;
        // }

        // adjustDate();
    </script>
</body>

</html>