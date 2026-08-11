<?php 
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/config/database.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    exit("شناسه محصول نامعتبر است.");
}

$stmt = $conn->prepare(
    "DELETE FROM product WHERE id = :id"
);

$stmt->execute([
    "id" => $id
]);

header("Location: products.php");
exit;
?>
