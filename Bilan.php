<?php
require 'shield.php';
$pageTitle = "Statistique du mouvement de caisse";

require_once 'crud/eglise.php';
if (isset($_SESSION['ID_EGLISE'])) {
    $bilanEntre  = getAllBilanEntre();
    $bilanSortie = getAllBilanSortie();
    $entreData  = $bilanEntre['data'];
    $sortieData = $bilanSortie['data'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eglise | Bilan</title>
    <?php include 'includes/styles.php'; ?>
</head>

<body>
    <?php include 'includes/nav.php'; ?>
    <header>
        <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
    </header>

    <main>
        <div style="height:400px;
            max-width:700px;
            margin: 0 auto;">
            <canvas id="myChart"></canvas>
        </div>
    </main>
    <footer>
        &copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($projectName); ?>. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // here to handle the statistic graph  
        const ctx = document.getElementById('myChart');
        const entreData = <?= json_encode($entreData) ?>;
        const sortieData = <?= json_encode($sortieData) ?>;
        const graphTitle = 'Visualisation  mensuel du mouvement de caisse\n (unité Ar)';

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
</body>
</html>