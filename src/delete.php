<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die("Method not allowed.");
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    die("Invalid student ID.");
}

try {
    $sql = "DELETE FROM students WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header("Location: index.php");
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    die("Unable to delete student.");
}