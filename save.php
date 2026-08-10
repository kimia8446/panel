<?php

include("config/database.php");

$name = trim($_POST['product_name'] ?? '');
$descripe = trim($_POST['product_descripe'] ?? '');
$price = filter_input(INPUT_POST, 'product_price', FILTER_VALIDATE_INT);

if(strlen($name) < 3){
    exit("نام محصول باید حداقل ۳ کاراکتر باشد.");
}

if(empty($name) || !$price){
    exit("لطفاً همه فیلدها را پر کنید.");
}

if($price < 100){
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

?>