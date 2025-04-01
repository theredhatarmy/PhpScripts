<?php
include 'db.php';

$user_id = $_GET['user_id'];

$sql = "SELECT id, message FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);

$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($notifications);
?>
