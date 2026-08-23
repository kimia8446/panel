<?php
session_start();

require_once __DIR__ . '/config/database.php';

if (!isset($_SESSION["username"])) {

    header("Location: login.php");
    exit;

}
require_once __DIR__ . '/config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: shop.php");
    exit;

}

$id = (int) $_GET['id'];


$stmt = $conn->prepare("
    SELECT *
    FROM product
    WHERE id = ?
");

$stmt->execute([$id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$product) {

    header("Location: shop.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($product['name']) ?>
    </title>

    <link rel="stylesheet"
          href="style/bootstrap.min.css">

    <link rel="stylesheet"
          href="style/stiles/Vazirmatn-font-face.css">

    <link rel="stylesheet"
          href="style/shop.css">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>

<body>


<nav class="shop-navbar">

    <div class="container">

        <div class="navbar-content">

            <a href="shop.php"
               class="shop-logo">

                <span class="logo-icon">
                    <i class="bi bi-bag-heart-fill"></i>
                </span>

                فروشگاه من

            </a>


            <a href="cart.php"
               class="cart-button">

                <i class="bi bi-cart3"></i>

                سبد خرید

            </a>

        </div>

    </div>

</nav>



<section class="detail-section">

    <div class="container">


        <a href="shop.php"
           class="back-link">

            <i class="bi bi-arrow-right"></i>

            بازگشت به فروشگاه

        </a>



        <div class="product-detail-card">


            <div class="row g-0">


                <!-- IMAGE -->

                <div class="col-lg-6">

                    <div class="detail-image">

                        <i class="bi bi-box-seam"></i>

                    </div>

                </div>



                <!-- INFO -->

                <div class="col-lg-6">

                    <div class="detail-info">

                        <span class="product-category">
                            محصول فروشگاه
                        </span>


                        <h1>

                            <?= htmlspecialchars(
                                $product['name']
                            ) ?>

                        </h1>


                        <div class="detail-price">

                            <?= number_format(
                                $product['price']
                            ) ?>

                            <span>
                                تومان
                            </span>

                        </div>


                        <div class="detail-divider"></div>


                        <h5>
                            توضیحات محصول
                        </h5>


                        <p class="detail-description">

                            <?= nl2br(
                                htmlspecialchars(
                                    $product['descripe']
                                )
                            ) ?>

                        </p>


                        <form action="cart.php"
                              method="POST">

                            <input
                                type="hidden"
                                name="product_id"
                                value="<?= $product['id'] ?>"
                            >


                            <button
                                type="submit"
                                name="add_to_cart"
                                class="add-cart-button">

                                <i class="bi bi-cart-plus"></i>

                                افزودن به سبد خرید

                            </button>

                        </form>


                    </div>

                </div>


            </div>

        </div>


    </div>

</section>



<script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>