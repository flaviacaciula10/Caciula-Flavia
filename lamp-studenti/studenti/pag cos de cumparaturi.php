<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosul de Cumparaturi</title>
    <link rel="stylesheet" href="stilizare pag pornire, logare si creare cont.css">
</head>
<body>

    <?php include 'header.php'; ?>
    
    <hr>

    <main class="continut-cos">
        <h1>Cosul Tau de Cumparaturi</h1>

        <div class="tabel-cos">
            <table>
                <thead>
                    <tr>
                        <th>Produs</th>
                        <th>Pret Unitar</th>
                        <th>Cantitate</th>
                        <th>Total</th>
                        <th>Actiuni</th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
                <tfoot>
                    <tr class="rand-total">
                        <td colspan="3">Total General:</td>
                        <td class="total-general" colspan="2">0.00 RON</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="optiuni-cos">
            <a href="pag de pornire.php" class="buton-continuare">
                Continua Cumparaturile
            </a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="pag plasare comanda.php" method="POST" id="form-comanda">
                    <input type="hidden" name="cart_data" id="cart_data_input">
                    <button type="button" onclick="submitOrder()" class="buton-comanda">
                        Plaseaza Comanda
                    </button>
                </form>
            <?php else: ?>
                <a href="pag logare.php" class="buton-comanda" style="background-color: grey;">Logheaza-te pentru a comanda</a>
            <?php endif; ?>
        </div>
    </main>
    
    <script src="cos.js?v=2"></script>
    <script>
        function submitOrder() {
            // Luam datele din localStorage
            const cart = localStorage.getItem('shoppingCart');
            
            // Verificam daca cosul e gol
            if (!cart || JSON.parse(cart).length === 0) {
                alert("Cosul este gol!");
                return;
            }

            document.getElementById('cart_data_input').value = cart;
            document.getElementById('form-comanda').submit();
        }
    </script>
</body>
</html>