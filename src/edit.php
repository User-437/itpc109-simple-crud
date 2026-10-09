<?php
require_once "db.php";

// Validate the student ID
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    die("Invalid student ID.");
}

// Retrieve the existing student information
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    http_response_code(404);
    die("Student not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }
        .container {
            max-width: 450px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 12px #ddd;
        }
        h2 { text-align: center; }
        label {
            display: block;
            margin-top: 15px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }
        button {
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        a { display: block; margin-top: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Student</h2>

    <form action="update.php" method="POST">

        <input type="hidden" name="id"
               value="<?= (int)$student['id'] ?>">

        <label>Student Number</label>
        <input type="text" name="student_no"
               value="<?= htmlspecialchars($student['student_no'], ENT_QUOTES, 'UTF-8') ?>"
               required>

        <label>Full Name</label>
        <input type="text" name="full_name"
               value="<?= htmlspecialchars($student['full_name'], ENT_QUOTES, 'UTF-8') ?>"
               required>

        <label>Course</label>
        <input type="text" name="course"
               value="<?= htmlspecialchars($student['course'], ENT_QUOTES, 'UTF-8') ?>"
               required>

        <label>Year Level</label>
        <input type="number" name="year_level"
               min="1" max="6"
               value="<?= (int)$student['year_level'] ?>"
               required>

        <label>Email</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8') ?>"
               required>

        <button type="submit">Update Student</button>
    </form>

    <a href="index.php">← Back to Student List</a>
</div>

</body>
</html>