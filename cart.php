<?php

session_start();

require_once __DIR__ . '/config/database.php';


/* =========================================
   INITIAL CART
========================================= */

if (!isset($_SESSION['cart'])) {

    $_SESSION['cart'] = [];

}


/* =========================================
   ADD TO CART
========================================= */

if (
    isset($_POST['add_to_cart']) &&
    isset($_POST['product_id'])
) {

    $productId = (int) $_POST['product_id'];


    $stmt = $conn->prepare("
        SELECT *
        FROM product
        WHERE id = ?
    ");

    $stmt->execute([$productId]);

    $product = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($product) {

        $_SESSION['cart'][$productId] = 1;

    }


    header("Location: cart.php");
    exit;

}


/* =========================================
   REMOVE
========================================= */

if (
    isset($_GET['remove']) &&
    is_numeric($_GET['remove'])
) {

    $productId = (int) $_GET['remove'];

    unset($_SESSION['cart'][$productId]);

    header("Location: cart.php");
    exit;

}


/* =========================================
   GET CART PRODUCTS
========================================= */

$cartProducts = [];

$total = 0;


if (!empty($_SESSION['cart'])) {

    $ids = array_keys($_SESSION['cart']);

    $placeholders = implode(
        ',',
        array_fill(0, count($ids), '?')
    );


    $stmt = $conn->prepare("
        SELECT *
        FROM product
        WHERE id IN ($placeholders)
    ");

    $stmt->execute($ids);

    $cartProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($cartProducts as $product) {

        $total += (float) $product['price'];

    }

}

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        سبد خرید
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


            <a href="shop.php"
               class="cart-button">

                <i class="bi bi-arrow-right"></i>

                ادامه خرید

            </a>

        </div>

    </div>

</nav>



<section class="cart-section">

    <div class="container">


        <div class="section-heading">

            <div>

                <span>
                    سفارش
                </span>

                <h2>
                    سبد خرید
                </h2>

            </div>

        </div>



        <?php if (empty($cartProducts)): ?>


            <div class="empty-products">

                <div class="empty-icon">

                    <i class="bi bi-cart-x"></i>

                </div>

                <h4>
                    سبد خرید شما خالی است
                </h4>

                <p>
                    هنوز محصولی به سبد خرید اضافه نکرده‌اید.
                </p>


                <a href="shop.php"
                   class="hero-button">

                    مشاهده محصولات

                </a>

            </div>


        <?php else: ?>


            <div class="row g-4">


                <div class="col-lg-8">


                    <?php foreach ($cartProducts as $product): ?>


                        <div class="cart-product">


                            <div class="cart-product-icon">

                                <i class="bi bi-box-seam"></i>

                            </div>


                            <div class="cart-product-info">

                                <h4>

                                    <?= htmlspecialchars(
                                        $product['name']
                                    ) ?>

                                </h4>

                                <p>

                                    <?= htmlspecialchars(
                                        $product['descripe']
                                    ) ?>

                                </p>

                            </div>


                            <div class="cart-product-price">

                                <?= number_format(
                                    $product['price']
                                ) ?>

                                <span>
                                    تومان
                                </span>

                            </div>


                            <a
                                href="cart.php?remove=<?= $product['id'] ?>"
                                class="remove-cart">

                                <i class="bi bi-trash"></i>

                            </a>


                        </div>


                    <?php endforeach; ?>


                </div>



                <div class="col-lg-4">


                    <div class="cart-summary">

                        <h3>
                            خلاصه سفارش
                        </h3>


                        <div class="summary-row">

                            <span>
                                تعداد محصولات
                            </span>

                            <strong>
                                <?= count($cartProducts) ?>
                            </strong>

                        </div>


                        <div class="summary-row total">

                            <span>
                                مبلغ کل
                            </span>

                            <strong>

                                <?= number_format($total) ?>

                                تومان

                            </strong>

                        </div>


                        <button
                            class="checkout-button">

                            ادامه فرایند خرید

                            <i class="bi bi-arrow-left"></i>

                        </button>


                    </div>


                </div>


            </div>


        <?php endif; ?>


    </div>

</section>


<script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>