add_notification.php<?php
include 'db.php';

$user_id = $_POST['user_id'];
$message = $_POST['message'];

$sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $message]);

echo json_encode(["success" => true]);
?>
