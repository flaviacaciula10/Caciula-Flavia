<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navigare-principala">
    <div class="navigare-categorii">
        <a href="/categorii produse/pagina fond de ten.php">Fond de ten</a> | 
        <a href="/categorii produse/pag rujuri.php">Ruj</a> | 
        <a href="/categorii produse/pagina fard de ochi.php">Fard de pleoape</a> | 
        <a href="/categorii produse/pag mascara.php">Mascara</a> | 
        <a href="/categorii produse/pagina creion.php">Creion contur</a> | 
        <a href="/categorii produse/pagina blush.php">Blush</a> | 
        <a href="/categorii produse/pagina highlighter.php">Highlighter</a> | 
        <a href="/categorii produse/pagina primer.php">Primer</a> | 
        <a href="/categorii produse/pag pudra.php">Pudra</a> | 
        <a href="/categorii produse/pagina demachiant.php">Demachiant</a>
    </div>

    <div class="navigare-actiuni">
        <a href="/pag de pornire.php" class="buton-acasa">Acasa</a>
        <a href="/pag cos de cumparaturi.php" class="buton-cos">Cos</a>
        
        <?php if (isset($_SESSION['username'])): ?>
            <span style="color: #D81B60; font-weight: bold; margin-left:10px;">Salut, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="/logout.php" style="font-size: 0.9em;">(Iesire)</a>
        <?php else: ?>
            <a href="/pag logare.php" class="buton-acasa">Logare</a>
        <?php endif; ?>
    </div>
</nav>