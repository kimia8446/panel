<?php
include("config/database.php");
require_once __DIR__ . '/config/database.php';
$stmt = $conn->query(
    "SELECT * FROM product"
);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE Html>
<html lang ="fa" dir="rtl">
<head>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="style/bootstrap.min.css">
<link rel="stylesheet" href="style/Vazirmatn-font-face.css">
<link rel="stylesheet" href="style/main.css">

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
    <title>مشاهده محصولات</title>
</head>
<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">لیست محصولات</h2>

    <a href="index.php" class="btn btn-primary mb-3">
        افزودن محصول جدید
    </a>

    <?php foreach($products as $product){

echo $product['name'];
echo $product['descripe'];
echo $product['price'];

} ?>

        <div class="card mb-3">

            <div class="card-body">

                <h4>
                    <?= htmlspecialchars($product['name']) ?>
                </h4>

                <p>
                    <?= htmlspecialchars($product['descripe']) ?>
                </p>

                <h5>
                    <?= number_format($product['price']) ?> تومان
                </h5>

                <form action="delete.php" method="POST">

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $product['id'] ?>"
                    >

                    <button
                        type="submit"
                        class="btn btn-danger"
                        onclick="return confirm('آیا از حذف این محصول مطمئن هستید؟');">

                        حذف

                    </button>

                </form>

            </div>

        </div>

</div>

</body>

</html>