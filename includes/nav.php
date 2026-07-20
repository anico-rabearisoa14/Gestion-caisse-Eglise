<?php
// PHP_SELF reports "/about" or "/about.php"
$currentPage = basename($_SERVER['PHP_SELF'], '.php');

function navClass($page, $currentPage) {
    return $page === $currentPage ? 'active' : '';
}
?>
<nav>
    <a href="index" class="<?php echo navClass('index', $currentPage); ?>">Acceuil</a>
    <a href="Encaisser" class="<?php echo navClass('Encaisser', $currentPage); ?>">Encaisser</a>
    <a href="Decaisser" class="<?php echo navClass('Decaisser', $currentPage); ?>">Décaisser </a>
    <a href="Bilan" class="<?php echo navClass('Bilan', $currentPage); ?>">Mouvement</a>
</nav>