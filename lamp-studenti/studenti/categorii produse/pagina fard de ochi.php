<?php
require '../db.php'; 
$sql = "SELECT * FROM produse WHERE id_categorie = 3";
$stmt = $pdo->query($sql);
$produse = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Magazin Machiaj - Fard de ochi</title>
  <link rel="stylesheet" href="stilizare pagini produse.css">
  <link rel="stylesheet" href="../stilizare pag pornire, logare si creare cont.css"> 
</head>
<body>
    <?php include '../header.php'; ?>
    
    <h2>Produsele din categoria: Farduri de ochi</h2>
    
    <div class="categorii-container">
        <?php foreach ($produse as $produs): ?>
            <p class="produs-card">
                <a href="#">
                    <img src="<?php echo htmlspecialchars($produs['imagine']); ?>" alt="<?php echo htmlspecialchars($produs['nume_produs']); ?>" width="200"><br>
                    <?php echo htmlspecialchars($produs['nume_produs']); ?>
                    <span class="descriere-produs"><?php echo htmlspecialchars($produs['descriere_produs']); ?></span>
                    <span class="pret-produs"><?php echo $produs['pret_produs']; ?> RON</span>
                </a>
                <button class="buton-cos-produs" data-id="<?php echo $produs['id_produs']; ?>" data-pret="<?php echo $produs['pret_produs']; ?>">Adauga in Cos</button>
            </p>
        <?php endforeach; ?>
    </div>
    <hr>
    <script src="../cos.js?v=2"></script>
</body>
</html>