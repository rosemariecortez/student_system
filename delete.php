<?php
include 'config.php';
$id = $_GET['id'] ?? 0;

// SOFT DELETE: Mark as archived, NOT permanently removed
$stmt = $conn->prepare("UPDATE students SET is_deleted = 1 WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php?archived=1");
exit;
?>