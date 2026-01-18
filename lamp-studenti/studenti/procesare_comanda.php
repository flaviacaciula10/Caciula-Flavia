<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Eroare: Trebuie sa fii logat.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = $_SESSION['user_id'];
    
    // Decodificam datele
    $cartData = json_decode($_POST['cart_data'], true);
    $total_plata = $_POST['total_plata'];
    
    // Verificare extra: Daca cosul e gol sau datele sunt invalide
    if (!$cartData || !is_array($cartData)) {
        die("Eroare: Cosul este gol sau datele sunt invalide. <a href='pag de pornire.php'>Inapoi</a>");
    }

    try {
        $pdo->beginTransaction();

        $last_cos_id = 0;
        $produse_valide_gasite = false;

        // 1. Introducem produsele in tabelul 'cos'
        $sql_cos = "INSERT INTO cos (id_user, id_produs, cantitate_cos) VALUES (?, ?, ?)";
        $stmt_cos = $pdo->prepare($sql_cos);

        foreach ($cartData as $item) {
            // VERIFICARE IMPORTANTA: Avem ID la produs?
            if (isset($item['id']) && !empty($item['id'])) {
                $stmt_cos->execute([$id_user, $item['id'], $item['quantity']]);
                $last_cos_id = $pdo->lastInsertId();
                $produse_valide_gasite = true;
            }
        }

        if (!$produse_valide_gasite) {
            throw new Exception("Nu s-au găait produse valide în cos (lipsă ID). Te rugam sa golesti cosul si sa adaugi produsele din nou.");
        }

        // 2. Introducem comanda
        $sql_comanda = "INSERT INTO comenzi (id_user, id_cos, pret_comanda) VALUES (?, ?, ?)";
        $stmt_comanda = $pdo->prepare($sql_comanda);
        $stmt_comanda->execute([$id_user, $last_cos_id, $total_plata]);

        $pdo->commit();

        ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Comanda Reusita</title>
                <link rel="stylesheet" href="stilizare pag pornire, logare si creare cont.css">
            </head>
            <body style="text-align:center; padding-top:50px;">
                <h1 style="color:green;">Comanda a fost plasata cu succes!</h1>
                <p>Va multumim!</p>
                <p>Total: <?php echo $total_plata; ?> RON</p>
                <a href="pag de pornire.php" class="buton-acasa">Inapoi la magazin</a>

                <script>
                    localStorage.removeItem('shoppingCart');
                </script>
            </body>
            </html>
        <?php

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<h1>A aparut o problema</h1>";
        echo "<p>Eroare: " . $e->getMessage() . "</p>";
        echo "<br><a href='pag cos de cumparaturi.php'>Inapoi la Cos (Goleste cosul si incearca iar)</a>";
    }
}
?>