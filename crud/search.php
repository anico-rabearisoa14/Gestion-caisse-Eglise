<?php
require __DIR__ . '/../db/databasehelper.php';
require __DIR__ . '/../crud/eglise.php';

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