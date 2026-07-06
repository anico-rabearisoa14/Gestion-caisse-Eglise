<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['ID_EGLISE'])) {
    header('Location: index.php');
    exit();
}
?>