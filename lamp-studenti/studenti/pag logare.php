<?php
require 'db.php';

$mesaj = "";

if (isset($_GET['succes'])) {
    $mesaj = "Cont creat cu succes! Te poti loga acum.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pwd'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['parola'])) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['rol'] = $user['rol'];

        header("Location: pag de pornire.php");
        exit;
    } else {
        $mesaj = "Email sau parola incorecta!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pagina Logare</title>
    <link rel="stylesheet" href="stilizare pag pornire, logare si creare cont.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <form action="" method="POST">
        <h2>Autentificare</h2>
        
        <?php if($mesaj): ?>
            <p style="color: <?php echo strpos($mesaj, 'succes') !== false ? 'green' : 'red'; ?>; text-align:center;">
                <?php echo $mesaj; ?>
            </p>
        <?php endif; ?>

        <label for="email">Email</label><br>
        <input type="email" id="Email" name="email" required> <br>
        
        <label for="pwd">Parola:</label><br>
        <input type="password" id="pwd" name="pwd" required>
        
        <button type="submit">Logheaza-te</button> <br>
        <p> Nu ai cont? <a href="pag creare cont.php">Inregistreaza-te</a></p>        
    </form>
</body>
</html>