<?php
// api.php
header("Content-Type: application/json");

// Conectare la baza de date
$host = 'mysql'; // numele serviciului din docker-compose (NU localhost)
$port = 3306;
$db = 'studenti';
$user = 'user'; // din MYSQL_USER
$pass = 'password'; // din MYSQL_PASSWORD
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Eroare conectare BD: " . $e->getMessage()]);
    exit();
}

// Verificăm metoda cererii (GET sau POST)
$method = $_SERVER['REQUEST_METHOD'];

// --- SCENARIUL 1: GET (Afișare studenți) ---
if ($method === 'GET') {
    $stmt = $pdo->query("SELECT * FROM studenti ORDER BY id DESC");
    $studenti = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Trimitem datele înapoi ca JSON
    echo json_encode($studenti);
}

// --- SCENARIUL 2: POST (Adăugare student) ---
elseif ($method === 'POST') {
    // Citim JSON-ul trimis de JavaScript
    $jsonPrimit = file_get_contents("php://input");
    $data = json_decode($jsonPrimit, true);

    // Validăm dacă avem datele necesare
    if (isset($data['nume']) && isset($data['an']) && isset($data['media'])) {
        $sql = "INSERT INTO studenti (nume, an, media) VALUES (:nume, :an, :media)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':nume' => $data['nume'],
            ':an' => $data['an'],
            ':media' => $data['media']
        ]);

        echo json_encode(["status" => "success", "message" => "Student adaugat!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Date incomplete!"]);
    }
}
?>