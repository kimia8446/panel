<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/config/database.php';

$name = trim($_POST['product_name'] ?? '');
$descripe = trim($_POST['product_descripe'] ?? '');
$price = filter_input(
    INPUT_POST,
    'product_price',
    FILTER_VALIDATE_INT
);

if (empty($name)) {
    exit("لطفاً نام محصول را وارد کنید.");
}

if (strlen($name) < 3) {
    exit("نام محصول باید حداقل ۳ کاراکتر باشد.");
}

if (empty($descripe)) {
    exit("لطفاً توضیحات را وارد کنید.");
}

if ($price === false || $price === null) {
    exit("لطفاً قیمت را وارد کنید.");
}

if ($price < 100) {
    exit("قیمت باید بیشتر از 100 باشد.");
}

$sql = "INSERT INTO product(name, descripe, price)
        VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->execute([
    $name,
    $descripe,
    $price
]);

header("Location: products.php");
exit;