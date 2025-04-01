<?php
include 'db.php';

$user_id = $_POST['user_id'];

$sql = "UPDATE notifications SET is_read = 1 WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);

echo json_encode(["success" => true]);
?>
