<?php
require_once __DIR__ . '/../db/databasehelper.php';
// require __DIR__ . '/../init.php';

function handleFilter($category, $dateBegin, $dateEnd): ?array
{
    global $pdo;

    switch ($category) {
        case 'entre':
            $sql = 'SELECT dateEntre AS date, motif, montantEntre AS montant 
                    FROM entre WHERE dateEntre BETWEEN :begin AND :end';
            break;
        case 'sortie':
            $sql = 'SELECT dateSortie AS date, motif, montantSortie AS montant 
                    FROM sortie WHERE dateSortie BETWEEN :begin AND :end';
            break;
        default:
            return null;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':begin' => $dateBegin, ':end' => $dateEnd]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total = array_sum(array_column($rows, 'montant'));

    return [
        'data' => $rows,
        'total' => $total
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $category  = $_GET['to-filter']  ?? null;
    $dateBegin = $_GET['date-begin'] ?? null;
    $dateEnd   = $_GET['date-end']   ?? null;

    $_SESSION['requested-category-to-print'] = $category;
    $_SESSION['requested-begin-date-to-print'] = $dateBegin;
    $_SESSION['requested-end-date-to-print'] = $dateEnd;

    if (empty($category) || empty($dateBegin) || empty($dateEnd)) {
        $_SESSION['filter-message'] = 'Veuillez remplir tous les champs.';
        header('Location: ../Bilan.php');
        exit();
    }

    if ($dateBegin > $dateEnd) {
        $_SESSION['filter-mesaage'] = 'La date de début doit être avant la date de fin.';
        header('Location: ../Bilan.php');
        exit();
    }

    $result = handleFilter($category, $dateBegin, $dateEnd);

    if (empty($result['data'])) {
        $_SESSION['filter-message'] = 'Aucun résultat trouvé.';
    } else {
        $_SESSION['filtered-data']  = $result['data'];
        $_SESSION['filtered-total'] = $result['total'];
        $_SESSION['filter-message'] = 'Trouvé.';
        }

    header('Location: ../Bilan.php');
    exit();
}