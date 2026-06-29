<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
// $_SESSION['requested-category-to-print'] = '';
// $_SESSION['requested-begin-date-to-print'] = '';
// $_SESSION['requested-end-date-to-print'] = '';
    require __DIR__ . '/crud/eglise.php';
    listeInfoEglise();
}
?>