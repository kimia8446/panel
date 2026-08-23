<?php

session_start();

require_once __DIR__ . '/config/database.php';


/* =========================================
   CHECK LOGIN
========================================= */

if (!isset($_SESSION["username"])) {

    header("Location: login.php");
    exit;

}


/* =========================================
   CSRF TOKEN
========================================= */

if (!isset($_SESSION['csrf_token'])) {

    $_SESSION['csrf_token'] = bin2hex(
        random_bytes(32)
    );

}


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
    isset($_POST['product_id']) &&
    isset($_POST['csrf_token'])
) {


    /* ---------- CHECK CSRF ---------- */

    if (
        !hash_equals(
            $_SESSION['csrf_token'],
            $_POST['csrf_token']
        )
    ) {

        die("Invalid CSRF Token");

    }


    /* ---------- GET PRODUCT ID ---------- */

    $productId = (int) $_POST['product_id'];


    /* ---------- GET PRODUCT ---------- */

    $stmt = $conn->prepare("
        SELECT *
        FROM product
        WHERE id = ?
    ");

    $stmt->execute([$productId]);

    $product = $stmt->fetch(PDO::FETCH_ASSOC);


    /* ---------- CHECK PRODUCT ---------- */

    if ($product) {


        /* ---------- CHECK IF ALREADY IN CART ---------- */

        if (isset($_SESSION['cart'][$productId])) {

            header("Location: cart.php");
            exit;

        }


        /* ---------- CHECK STOCK ---------- */

        if ($product['stock'] <= 0) {

            die("این محصول موجود نیست.");

        }


        /* ---------- ADD TO CART ---------- */

        $_SESSION['cart'][$productId] = 1;


        /* ---------- DECREASE STOCK ---------- */

        $stmt = $conn->prepare("
            UPDATE product
            SET stock = stock - 1
            WHERE id = ?
            AND stock > 0
        ");

        $stmt->execute([$productId]);

    }


    header("Location: cart.php");
    exit;

}


/* =========================================
   REMOVE FROM CART
========================================= */

if (
    isset($_POST['remove_from_cart']) &&
    isset($_POST['product_id']) &&
    isset($_POST['csrf_token'])
) {


    /* ---------- CHECK CSRF ---------- */

    if (
        !hash_equals(
            $_SESSION['csrf_token'],
            $_POST['csrf_token']
        )
    ) {

        die("Invalid CSRF Token");

    }


    /* ---------- GET PRODUCT ID ---------- */

    $productId = (int) $_POST['product_id'];


    /* ---------- CHECK IF PRODUCT IS IN CART ---------- */

    if (isset($_SESSION['cart'][$productId])) {


        /* ---------- RETURN STOCK ---------- */

        $stmt = $conn->prepare("
            UPDATE product
            SET stock = stock + 1
            WHERE id = ?
        ");

        $stmt->execute([$productId]);


        /* ---------- REMOVE FROM CART ---------- */

        unset($_SESSION['cart'][$productId]);

    }


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


                            <!-- REMOVE FROM CART -->

                            <form
                                action="cart.php"
                                method="POST"
                            >

                                <input
                                    type="hidden"
                                    name="product_id"
                                    value="<?= $product['id'] ?>"
                                >


                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?= htmlspecialchars(
                                        $_SESSION['csrf_token']
                                    ) ?>"
                                >


                                <button
                                    type="submit"
                                    name="remove_from_cart"
                                    class="remove-cart"
                                >

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>


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