<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coșul de Cumparaturi - Magazinul Tau de Cosmetice</title>
    <link rel="stylesheet" href="stilizare pag pornire, logare si creare cont.css">
</head>
<body>

    <?php include 'header.php'; ?>
    
    <hr>

    <main class="continut-cos">
        <h1>Coșul Tau de Cumparaturi</h1>

        <div class="tabel-cos">
            <table>
                <thead>
                    <tr>
                        <th>Produs</th>
                        <th>Preț Unitar</th>
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
            <a href="pag de pornire.html" class="buton-continuare">
                Continua Cumparaturile
            </a>
            <a href="pag plasare comanda.html" class="buton-comanda">
                Plaseaza Comanda
            </a>
        </div>
    </main>
    
    <script src="cos.js"></script>
    </body>
</html>