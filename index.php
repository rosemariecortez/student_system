<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Record Module</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>📋 Student Record Module</h1>
        <p class="subtitle">Manage student records — Create, Update, Archive</p>
    </header>

    <a href="create.php" class="btn primary">+ Add New Student</a>

    <section class="card">
        <h2>📑 Active Students</h2>
        <?php
        $stmt = $conn->prepare("SELECT * FROM students WHERE is_deleted = 0 ORDER BY id DESC");
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="table-wrapper">
        <table>
            <tr>
                <th>Student ID</th>
                <th>Full Name</th>
                <th>Program</th>
                <th>Actions</th>
            </tr>
            <?php if(count($students) > 0): ?>
                <?php foreach($students as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['student_id']) ?></td>
                    <td><?= htmlspecialchars($s['name']) ?></td>
                    <td><?= htmlspecialchars($s['program']) ?></td>
                    <td>
                        <a href="update.php?id=<?= $s['id'] ?>" class="btn small edit">Edit</a>
                        <a href="delete.php?id=<?= $s['id'] ?>" class="btn small archive" onclick="return confirm('Archive this record? It will NOT be deleted permanently.')">Archive</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">No active records found.</td></tr>
            <?php endif; ?>
        </table>
        </div>
    </section>

    <section class="card archived">
        <h3>📦 Archived Records</h3>
        <?php
        $stmt2 = $conn->prepare("SELECT * FROM students WHERE is_deleted = 1 ORDER BY id DESC");
        $stmt2->execute();
        $archived = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="table-wrapper">
        <table>
            <tr>
                <th>Student ID</th>
                <th>Full Name</th>
                <th>Program</th>
            </tr>
            <?php if(count($archived) > 0): ?>
                <?php foreach($archived as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['student_id']) ?></td>
                    <td><?= htmlspecialchars($a['name']) ?></td>
                    <td><?= htmlspecialchars($a['program']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3" class="text-center">No archived records.</td></tr>
            <?php endif; ?>
        </table>
        </div>
    </section>
</div>
</body>
</html>