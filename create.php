<?php
include 'config.php';
$msg = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $program = trim($_POST['program'] ?? '');

    if(empty($student_id) || empty($name) || empty($program)) {
        $msg = '<p class="error">⚠️ All fields are required!</p>';
    } else {
        try {
            $sql = "INSERT INTO students (student_id, name, program) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$student_id, $name, $program]);
            $msg = '<p class="success">✅ Record saved successfully!</p>';
        } catch(PDOException $e) {
            $msg = '<p class="error">❌ Error: Student ID already exists or invalid input.</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container small-form">
    <h1>➕ Add New Student</h1>
    <?= $msg ?>
    <form method="POST" action="">
        <label for="student_id">Student ID <span class="required">*</span></label>
        <input type="text" id="student_id" name="student_id" placeholder="e.g. 2026-001" required>

        <label for="name">Full Name <span class="required">*</span></label>
        <input type="text" id="name" name="name" placeholder="Last Name, First Name" required>

        <label for="program">Program / Course <span class="required">*</span></label>
        <input type="text" id="program" name="program" placeholder="e.g. BS Information Technology" required>

        <div class="btn-group">
            <button type="submit" class="btn primary">Save Record</button>
            <a href="index.php" class="btn secondary">← Back to List</a>
        </div>
    </form>
</div>
</body>
</html>