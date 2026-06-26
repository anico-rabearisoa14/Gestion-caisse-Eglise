<?php
require __DIR__ . '/init.php';
$pageTitle = "Filtre mouvement";

$data = [];
$totalMontant = 0;
$mouvement = "";
$formatter = new NumberFormatter('fr_MG', NumberFormatter::CURRENCY);
if(isset($_SESSION['filtered-data'])){
    $data = $_SESSION['filtered-data'];
    $totalMontant = $_SESSION['filtered-total'];
    unset($_SESSION['filtered-data']);
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
        <form method="GET" action="filter/filter.php" class="main-form-wrapper">
            <div id="select-area">
                <label for="to-filter">Filtrer une </label>
                <select id="to-filter" name="to-filter">
                    <option value="sortie">Sortie</option>
                    <option value="entre">Entree</option>
                </select>
            </div>
                    <label for="date-begin">du </label>
                    <input type="date" id="date-begin" class="date-begin" name="date-begin">
                    <label for="date-end">jusqu'au </label>
                    <input type="date" id="date-end" class="date-end" name="date-end">
            <div class="button-layout" style="margin-top: 15px;">
                <button id="submit-on-page-load" class="submit-btn" type="submit">Demander</button>
            </div>
        </form>

        <!-- afficher le resultat d'une mouvement -->
        <div class="reponse-filtre">
            <div class="button-imprimer" style="display: flex; justify-content:space-between">
                <p>Resultat :</p>
                <button type="button" class="normal-btn" style="background-color:#3b4a6b ;">Imprimer</button>
            </div>
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
                                <?php echo htmlspecialchars($formatter->formatCurrency($d['montant'],'MGA')); ?>
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
                <p id="montant-total">Total Montant
                <span id="flux">sortant</span> : 
                <span id="total-value"> <?php echo htmlspecialchars($formatter->formatCurrency($totalMontant , 'MGA')) ?></span>
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
const selectInput = document.getElementById('to-filter');
document.getElementsByClassName('state')[0].textContent = 'Mouvement de sortie de caisse';
selectInput.addEventListener('input' , function(){
    const value = selectInput.value;

    if(value == 'sortie'){
    document.getElementsByClassName('state')[0].textContent = 'Mouvement de sortie de caisse';
    document.getElementById('flux').textContent = 'sortant';
    }
    else{
    document.getElementsByClassName('state')[0].textContent = "Mouvement d’entrée en caisse";
    document.getElementById('flux').textContent = 'entrant'}
});

const sumbitButton = document.getElementById('submit-on-page-load');

//  adjust date input value
function adjustDate() {
        const begin = document.getElementsByName('date-begin');
        const end = document.getElementsByName('date-end');
        const today = new Date();

        // Extract components
        const year = today.getFullYear();
        // getMonth() returns 0-11, so add 1
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const monthBegin = String((today.getMonth() + 1) - 1).padStart(2 , '0');
        const day = String(today.getDate()).padStart(2, '0');

        // Format as YYYY-MM-DD
        const formattedDateBegin = `${year}-${monthBegin}-${day}`;
        const formattedDateEnd =  `${year}-${month}-${day}`;
        
        // bind the values
        begin[0].value = formattedDateBegin;
        end[0].value = formattedDateEnd;
}

adjustDate();


     </script>
</body>

</html>