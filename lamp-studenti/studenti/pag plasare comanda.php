<?php
// Pornim sesiunea la inceput
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

// Daca userul nu e logat, il trimitem la logare
if (!isset($_SESSION['user_id'])) {
    header("Location: pag logare.php");
    exit;
}

// Preluam datele trimise din pagina Cosului
$cartDataJSON = isset($_POST['cart_data']) ? $_POST['cart_data'] : '';

// Verificam daca avem date. Daca nu, inseamna ca s-a intrat direct pe pagina fara cos.
if (empty($cartDataJSON)) {
    echo "<h3>Eroare: Nu exista produse in cos.</h3>";
    echo "<a href='pag cos de cumparaturi.php'>Inapoi la cos</a>";
    exit;
}

$cartArray = json_decode($cartDataJSON, true);
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Plasare comanda</title>
    <link rel="stylesheet" href="stilizare pag pornire, logare si creare cont.css">
</head>
<body>
    
    <?php include 'header.php'; ?>

    <h2 style="text-align:center; margin-top:20px;">Finalizare Comanda</h2>

    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background: #fff; border:1px solid #ddd; border-radius:8px;">
        <h3>Rezumatul comenzii:</h3>
        <ul>
            <?php if(is_array($cartArray)): ?>
                <?php foreach($cartArray as $item): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($item['name']); ?></strong> <br>
                        Cantitate: <?php echo $item['quantity']; ?> | 
                        Pret: <?php echo $item['price']; ?> RON
                        <?php $total += $item['price'] * $item['quantity']; ?>
                    </li>
                    <hr style="margin:5px 0; border:0; border-top:1px dashed #ccc;">
                <?php endforeach; ?>
            <?php else: ?>
                <li>Eroare la citirea produselor.</li>
            <?php endif; ?>
        </ul>
        <h3 style="color: #D81B60; text-align:right;">Total de plata: <?php echo number_format($total, 2); ?> RON</h3>
    </div>

    <form action="procesare_comanda.php" method="POST" style="margin-top:20px;">
        
        <input type="hidden" name="cart_data" value="<?php echo htmlspecialchars($cartDataJSON); ?>">
        <input type="hidden" name="total_plata" value="<?php echo $total; ?>">

        <h3>Date de livrare</h3>
        
        <label for="nume">Nume complet</label>
        <input type="text" id="nume" name="nume" required placeholder="Ex: Popescu Ion"> <br>

        <label for="adresa">Adresa completa</label>
        <input type="text" id="adresa" name="adresa" required placeholder="Judet, Oras, Strada..."><br>
        
        <label for="telefon">Numar de telefon</label>
        <input type="text" id="telefon" name="telefon" required placeholder="07xx xxx xxx"><br>
        
        <button type="submit" class="buton-comanda" style="width:100%;">TRIMITE COMANDA</button>
    </form>
    
    <div style="text-align:center; margin-bottom:50px;">
        <a href="pag cos de cumparaturi.php">Inapoi la cos</a>
    </div>

</body>
</html>