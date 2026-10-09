<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$student_no = trim($_POST["student_no"] ?? "");
$full_name = trim($_POST["full_name"] ?? "");
$course = trim($_POST["course"] ?? "");
$year_level = filter_input(
    INPUT_POST,
    "year_level",
    FILTER_VALIDATE_INT
);
$email = trim($_POST["email"] ?? "");

if (
    !$id ||
    $id < 1 ||
    $student_no === "" ||
    $full_name === "" ||
    $course === "" ||
    $year_level === false ||
    $year_level === null ||
    $year_level < 1 ||
    $year_level > 6 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    http_response_code(400);
    die("Invalid student information.");
}

try {
    $sql = "UPDATE students
            SET student_no = ?,
                full_name = ?,
                course = ?,
                year_level = ?,
                email = ?
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $student_no,
        $full_name,
        $course,
        $year_level,
        $email,
        $id
    ]);

    header("Location: index.php");
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    die("Unable to update student. Check that the student number is unique.");
}