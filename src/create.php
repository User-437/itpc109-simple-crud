
<?php
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_no = trim($_POST["student_no"] ?? "");
    $full_name = trim($_POST["full_name"] ?? "");
    $course = trim($_POST["course"] ?? "");
    $year_level = filter_var(
        $_POST["year_level"] ?? null,
        FILTER_VALIDATE_INT
    );
    $email = trim($_POST["email"] ?? "");

    if (
        $student_no === "" ||
        $full_name === "" ||
        $course === "" ||
        $year_level === false ||
        $year_level < 1 ||
        $year_level > 6 ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        $error = "Please enter valid student information.";
    } else {
        try {
            $sql = "INSERT INTO students
                    (student_no, full_name, course, year_level, email)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $student_no,
                $full_name,
                $course,
                $year_level,
                $email
            ]);

            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $error = "Unable to save student. The student number may already exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>

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
            cursor: pointer;
            border-radius: 5px;
        }
        a { display: block; margin-top: 15px; }
        .error { color: red; }
    </style>
</head>
<body>

<div class="container">

    <h2>Add New Student</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">

        <label>Student Number</label>
        <input type="text" name="student_no" required>

        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>Course</label>
        <input type="text" name="course" required>

        <label>Year Level</label>
        <input type="number" name="year_level"
               min="1" max="6" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <button type="submit">Save Student</button>

    </form>

    <a href="index.php">← Back to Student List</a>

</div>
</body>
</html>
