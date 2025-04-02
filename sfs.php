<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$host = "localhost";
$db_name = "user_management";
$username = "root";  // Change this if needed
$password = "";
$secret_key = "your_secret_key";  // Change this

// Database Connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => "Database connection failed: " . $e->getMessage()]));
}

// Handle Request
$action = $_GET['action'] ?? '';
$data = json_decode(file_get_contents("php://input"));

// Register User
if ($action == 'register') {
    if (!empty($data->name) && !empty($data->email) && !empty($data->password)) {
        $hashed_password = password_hash($data->password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$data->name, $data->email, $hashed_password])) {
            echo json_encode(["message" => "User registered successfully"]);
        } else {
            echo json_encode(["error" => "Registration failed"]);
        }
    } else {
        echo json_encode(["error" => "Incomplete data"]);
    }
}

// Login User
elseif ($action == 'login') {
    if (!empty($data->email) && !empty($data->password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$data->email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data->password, $user['password'])) {
            $payload = [
                "user_id" => $user['id'],
                "role" => $user['role'],
                "exp" => time() + 3600
            ];
            $token = JWT::encode($payload, $secret_key, 'HS256');
            echo json_encode(["token" => $token]);
        } else {
            echo json_encode(["error" => "Invalid credentials"]);
        }
    } else {
        echo json_encode(["error" => "Incomplete data"]);
    }
}

// Protected Route (Requires Authentication)
elseif ($action == 'protected') {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        die(json_encode(["error" => "Access denied"]));
    }

    $token = str_replace("Bearer ", "", $headers['Authorization']);

    try {
        $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
        echo json_encode(["message" => "Access granted", "user_id" => $decoded->user_id, "role" => $decoded->role]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Invalid token"]);
    }
}

else {
    echo json_encode(["error" => "Invalid action"]);
}
?>
