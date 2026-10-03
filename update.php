<?php
include 'config.php';
$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if(!$student) { header("Location: index.php"); exit; }

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $program = trim($_POST['program']);

    if(empty($student_id) || empty($name) || empty($program)) {
        $msg = '<p class="error">⚠️ All fields are required!</p>';
    } else {
        $stmt = $conn->prepare("UPDATE students SET student_id=?, name=?, program=? WHERE id=?");
        $stmt->execute([$student_id, $name, $program, $id]);
        header("Location: index.php?updated=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small-form">
    <h1>✏️ Edit Student Record</h1>
    <?= $msg ?? '' ?>
    <form method="POST">
        <label>Student ID <span class="required">*</span></label>
        <input type="text" name="student_id" value="<?= htmlspecialchars($student['student_id']) ?>" required>

        <label>Full Name <span class="required">*</span></label>
        <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>

        <label>Program / Course <span class="required">*</span></label>
        <input type="text" name="program" value="<?= htmlspecialchars($student['program']) ?>" required>

        <div class="btn-group">
            <button type="submit" class="btn primary">Update Record</button>
            <a href="index.php" class="btn secondary">← Cancel</a>
        </div>
    </form>
</div>
</body>
</html>