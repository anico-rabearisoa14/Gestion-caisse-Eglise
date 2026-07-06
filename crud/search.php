<?php
require __DIR__ . '/../db/databasehelper.php';
// require __DIR__ . '/../init.php';

 // function to handle the search
function searchEntre(string $query, string $category): array
{
    global $pdo;
    $allowed = ['motif', 'montantEntre', 'dateEntre', 'ideglise'];
    if (!in_array($category, $allowed)) $category = 'motif';

    $stmt = $pdo->prepare("SELECT * FROM entre WHERE $category LIKE :query");
    $stmt->execute([':query' => '%' . $query . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchSortie(string $query, string $category): array
{
    global $pdo;
    $allowed = ['motif', 'montantSortie', 'dateSortie', 'ideglise'];
    if (!in_array($category, $allowed)) $category = 'motif';

    $stmt = $pdo->prepare("SELECT * FROM sortie WHERE $category LIKE :query");
    $stmt->execute([':query' => '%' . $query . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//  write answers on session and give it to the page 
$query    = trim($_GET['query'] ?? '');
$category = trim($_GET['category'] ?? 'motif');
$table    = trim($_GET['table'] ?? '');

if ($table === 'entre') {
    if ($query !== '') {
        $allowed = ['motif', 'montantEntre', 'dateEntre', 'ideglise'];
        if (!in_array($category, $allowed)) $category = 'motif';
        $_SESSION['search_results'] = searchEntre($query, $category);
        $_SESSION['search_query']   = $query;
    }
    header('Location: ../Encaisser.php');
    exit();

} elseif ($table === 'sortie') {
    if ($query !== '') {
        $allowed = ['motif', 'montantSortie', 'dateSortie', 'ideglise'];
        if (!in_array($category, $allowed)) $category = 'motif';
        $_SESSION['search_results'] = searchSortie($query, $category);
        $_SESSION['search_query']   = $query;
    }
    header('Location: ../Decaisser.php');
    exit();
}

header('Location: ../Encaisser.php');
exit();