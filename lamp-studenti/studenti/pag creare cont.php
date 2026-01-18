<?php
require 'db.php';

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['pwd'];

    $check = $pdo->prepare("SELECT id_user FROM users WHERE email = ? OR username = ?");
    $check->execute([$email, $username]);
    
    if ($check->rowCount() > 0) {
        $mesaj = "Eroare: Email-ul sau Username-ul este deja folosit!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, email, parola, rol) VALUES (?, ?, ?, 'client')";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$username, $email, $hashed_password])) {
            header("Location: pag logare.php?succes=1");
            exit;
        } else {
            $mesaj = "A aparut o eroare la inregistrare.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Creare Cont</title>
    <link rel="stylesheet" href="stilizare pag pornire, logare si creare cont.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <form action="" method="POST">
        <h2>Inregistrare</h2>
        
        <?php if($mesaj): ?>
            <p style="color:red; text-align:center;"><?php echo $mesaj; ?></p>
        <?php endif; ?>

        <label for="username">Username (Nume Utilizator)</label>
        <input type="text" id="username" name="username" required> <br>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required> <br>

        <label for="pwd">Parola</label>
        <input type="password" id="pwd" name="pwd" required><br>

        <button type="submit">Creeaza Cont</button>
        
        <p>Ai deja cont? <a href="pag logare.php">Logheaza-te aici</a></p>
    </form>
</body>
</html>