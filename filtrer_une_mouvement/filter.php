<?php
require_once __DIR__ . '/../shield.php';
require_once __DIR__ . '/../db/databasehelper.php';


function setSessionMessage(string $type, string $body): void {
    $_SESSION['show_message'] = 'true';
    $_SESSION['message_type'] = $type;
    $_SESSION['message_body'] = $body;
}

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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $dateBegin = $_GET['date-begin'];
    $dateEnd  = $_GET['date-end'];

    $_SESSION['requested-begin-date-to-print'] = $dateBegin ?? 'N/A';
    $_SESSION['requested-end-date-to-print'] = $dateEnd ?? 'N/A';

    if (empty($dateBegin) || empty($dateEnd)) {
        $_SESSION['filter-message'] = 'Veuillez remplir tous les champs.';
        setSessionMessage('error' , $_SESSION['filter-message']);
        header('Location: ../Mouvement.php');
        exit();
    }

    if ($dateBegin > $dateEnd) {
        $_SESSION['filter-message'] = 'La date de début doit être avant la date de fin.';
        setSessionMessage('warning' , $_SESSION['filter-message']);
        header('Location: ../Mouvement.php');
        exit();
    }

    $resultSortie = handleFilter('sortie' , $dateBegin, $dateEnd);
    $resultEntre = handleFilter('entre', $dateBegin, $dateEnd);

    if (empty($resultEntre['data']) || empty($resultSortie['data'])){
        $_SESSION['filter-message'] = 'Aucun résultat trouvé.';
        setSessionMessage('info' , $_SESSION['filter-message']);
    } else {
        // sortie
        $_SESSION['filtered-data-sortie']  = $resultSortie['data'];
        $_SESSION['filtered-total-sortie'] = $resultSortie['total'];

        // entre
        $_SESSION['filtered-data-entre']  = $resultEntre['data'];
        $_SESSION['filtered-total-entre'] = $resultEntre['total'];
        
        $_SESSION['filter-message'] = 'Filtre de mouvement appliqueé';
        setSessionMessage('success' , $_SESSION['filter-message']);
        }
    header('Location: ../Mouvement.php');
    exit();
}