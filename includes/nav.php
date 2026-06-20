<?php
// PHP_SELF reports "/about" or "/about.php"
$currentPage = basename($_SERVER['PHP_SELF'], '.php');

function navClass($page, $currentPage) {
    return $page === $currentPage ? 'active' : '';
}
?>
<nav>
    <a href="index" class="<?php echo navClass('index', $currentPage); ?>">Acceuil</a>
    <a href="about" class="<?php echo navClass('about', $currentPage); ?>">About</a>
    <a href="services" class="<?php echo navClass('services', $currentPage); ?>">Services</a>
    <a href="contact" class="<?php echo navClass('contact', $currentPage); ?>">Contact</a>
</nav>