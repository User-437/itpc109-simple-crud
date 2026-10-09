
<?php
require_once "db.php";

$stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records Management</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 40px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 12px #ddd;
        }

        h1 {
            text-align: center;
            color: #243b55;
        }

        .btn {
            padding: 9px 14px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            color: white;
            background: #2563eb;
            border: none;
            cursor: pointer;
        }

        .edit { background: #eab308; color: black; }
        .delete { background: #dc2626; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #243b55;
            color: white;
        }

        tr:nth-child(even) {
            background: #f1f5f9;
        }
    </style>
</head>

<body>
<div class="container">

    <h1>Student Records Management System</h1>

    <a href="create.php" class="btn">+ Add New Student</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student No.</th>
                <th>Full Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= (int)$student['id'] ?></td>
                <td><?= htmlspecialchars($student['student_no']) ?></td>
                <td><?= htmlspecialchars($student['full_name']) ?></td>
                <td><?= htmlspecialchars($student['course']) ?></td>
                <td><?= (int)$student['year_level'] ?></td>
                <td><?= htmlspecialchars($student['email']) ?></td>

                <td>
                    <a class="btn edit"
                       href="edit.php?id=<?= (int)$student['id'] ?>">
                       Edit
                    </a>

                    <form action="delete.php" method="POST"
                          style="display:inline;"
                          onsubmit="return confirm('Delete this student?');">
                        <input type="hidden" name="id"
                               value="<?= (int)$student['id'] ?>">
                        <button type="submit" class="btn delete">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if (empty($students)): ?>
            <tr>
                <td colspan="7">No student records found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>
