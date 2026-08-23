<?php

session_start();

require_once __DIR__ . '/config/database.php';



/* =========================================
   CSRF TOKEN
========================================= */

if (!isset($_SESSION['csrf_token'])) {

    $_SESSION['csrf_token'] = bin2hex(
        random_bytes(32)
    );

}


$username = $_SESSION["username"];


/* =========================================
   SEARCH
========================================= */

$search = trim($_GET['search'] ?? '');


/* =========================================
   CATEGORY
========================================= */

$categoryId = filter_input(
    INPUT_GET,
    'category',
    FILTER_VALIDATE_INT
);


/* =========================================
   GET PRODUCTS
========================================= */

if ($search !== '') {

    if ($categoryId) {

        $stmt = $conn->prepare("
            SELECT *
            FROM product
            WHERE category_id = :category_id
            AND (
                name LIKE :search
                OR descripe LIKE :search
            )
            ORDER BY id DESC
        ");

        $stmt->execute([
            'category_id' => $categoryId,
            'search' => "%{$search}%"
        ]);

    } else {

        $stmt = $conn->prepare("
            SELECT *
            FROM product
            WHERE name LIKE :search
               OR descripe LIKE :search
            ORDER BY id DESC
        ");

        $stmt->execute([
            'search' => "%{$search}%"
        ]);

    }

} else {

    if ($categoryId) {

        $stmt = $conn->prepare("
            SELECT *
            FROM product
            WHERE category_id = :category_id
            ORDER BY id DESC
        ");

        $stmt->execute([
            'category_id' => $categoryId
        ]);

    } else {

        $stmt = $conn->query("
            SELECT *
            FROM product
            ORDER BY id DESC
        ");

    }

}


$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>

<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        فروشگاه من
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


<!-- =====================================================
     NAVBAR
===================================================== -->

<nav class="shop-navbar">

    <div class="container">

        <div class="shop-navbar-content">


            <!-- LOGO -->

            <a href="shop.php"
               class="shop-logo">

                <span class="shop-logo-icon">

                    <i class="bi bi-bag-heart-fill"></i>

                </span>

                <span>
                    فروشگاه من
                </span>

            </a>


            <!-- MENU -->

            <div class="shop-menu">

                <a href="shop.php"
                   class="shop-menu-link active">

                    <i class="bi bi-house"></i>

                    خانه

                </a>


                <a href="#products"
                   class="shop-menu-link">

                    <i class="bi bi-grid"></i>

                    محصولات

                </a>


                <a href="#categories"
                   class="shop-menu-link">

                    <i class="bi bi-tags"></i>

                    دسته‌بندی‌ها

                </a>


                <a href="#about"
                   class="shop-menu-link">

                    <i class="bi bi-info-circle"></i>

                    درباره ما

                </a>

            </div>


            <!-- NAVBAR ACTIONS -->

            <div class="shop-navbar-actions">


                <!-- SEARCH -->

                <div class="shop-search">

                    <button
                        type="button"
                        class="shop-nav-icon"
                        id="searchButton"
                        title="جستجو">

                        <i class="bi bi-search"></i>

                    </button>


                    <form
                        action="shop.php"
                        method="GET"
                        class="shop-search-form"
                        id="searchForm">

                        <input
                            type="text"
                            name="search"
                            placeholder="جستجوی محصول..."
                            value="<?= htmlspecialchars($search) ?>"
                            autocomplete="off">

                        <button type="submit">

                            <i class="bi bi-search"></i>

                        </button>

                    </form>

                </div>


                <!-- CART -->

                <a href="cart.php"
                   class="shop-nav-icon cart-nav"
                   title="سبد خرید">

                    <i class="bi bi-cart3"></i>

                    <span class="cart-badge">

                        <?= isset($_SESSION['cart'])
                            ? count($_SESSION['cart'])
                            : 0 ?>

                    </span>

                </a>


                <!-- THEME -->

                <button
                    type="button"
                    id="themeButton"
                    class="shop-theme-button"
                    title="تغییر حالت نمایش">

                    <i class="bi bi-moon-stars-fill"></i>

                </button>


                <!-- USER -->

                <div class="shop-user-dropdown">


                    <button
                        type="button"
                        class="shop-user-button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">


                        <span class="user-avatar">

                            <i class="bi bi-person-fill"></i>

                        </span>


                        <span class="user-name">

                            <?= htmlspecialchars($username) ?>

                        </span>


                        <i class="bi bi-chevron-down"></i>


                    </button>


                    <!-- DROPDOWN -->

                    <ul class="dropdown-menu dropdown-menu-end shop-dropdown">


                        <li>

                            <div class="dropdown-user-info">

                                <span class="dropdown-avatar">

                                    <i class="bi bi-person-fill"></i>

                                </span>


                                <div>

                                    <strong>

                                        <?= htmlspecialchars($username) ?>

                                    </strong>


                                    <small>
                                        کاربر فروشگاه
                                    </small>

                                </div>

                            </div>

                        </li>


                        <li>

                            <hr class="dropdown-divider">

                        </li>


                        <!-- ADMIN PANEL -->

                        <?php if (
                            isset($_SESSION["role"]) &&
                            $_SESSION["role"] === "admin"
                        ): ?>


                            <li>

                                <a
                                    class="dropdown-item"
                                    href="dashboard.php">

                                    <i class="bi bi-speedometer2"></i>

                                    پنل مدیریت

                                </a>

                            </li>


                            <!-- PRODUCTS MANAGEMENT -->

                            <li>

                                <a
                                    class="dropdown-item"
                                    href="products.php">

                                    <i class="bi bi-box-seam"></i>

                                    مدیریت محصولات

                                </a>

                            </li>


                            <li>

                                <hr class="dropdown-divider">

                            </li>


                        <?php endif; ?>


                        <!-- LOGOUT -->

                        <li>

                            <a
                                class="dropdown-item logout-link"
                                href="logout.php">

                                <i class="bi bi-box-arrow-right"></i>

                                خروج از حساب

                            </a>

                        </li>


                    </ul>


                </div>


            </div>


        </div>

    </div>

</nav>



<!-- =====================================================
     HERO
===================================================== -->

<section class="shop-hero">

    <div class="container">

        <div class="shop-hero-content">


            <div class="shop-hero-text">


                <span class="shop-hero-badge">

                    <i class="bi bi-stars"></i>

                    فروشگاه آنلاین

                </span>


                <h1>

                    خریدی ساده،

                    <span>
                        سریع و مطمئن
                    </span>

                </h1>


                <p>

                    جدیدترین محصولات را با بهترین
                    قیمت از فروشگاه ما تهیه کنید.

                </p>


                <a
                    href="#products"
                    class="shop-hero-button">

                    مشاهده محصولات

                    <i class="bi bi-arrow-left"></i>

                </a>


            </div>


            <div class="shop-hero-visual">

                <i class="bi bi-bag-heart"></i>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     CATEGORIES
===================================================== -->

<section
    class="shop-categories"
    id="categories">

    <div class="container">


        <div class="shop-section-title">

            <span>
                دسته‌بندی
            </span>

            <h2>
                دسته‌بندی محصولات
            </h2>

        </div>


        <div class="category-list">


            <!-- همه محصولات -->

            <a
                href="shop.php#products"
                class="category-item">

                <span>

                    <i class="bi bi-grid"></i>

                </span>

                <strong>
                    همه محصولات
                </strong>

            </a>


            <!-- موبایل -->

            <a
                href="shop.php?category=1#products"
                class="category-item">

                <span>

                    <i class="bi bi-phone"></i>

                </span>

                <strong>
                    موبایل
                </strong>

            </a>


            <!-- لپ تاپ -->

            <a
                href="shop.php?category=2#products"
                class="category-item">

                <span>

                    <i class="bi bi-laptop"></i>

                </span>

                <strong>
                    لپ‌تاپ
                </strong>

            </a>


            <!-- کالای دیجیتال -->

            <div class="category-digital">


                <a
                    href="javascript:void(0)"
                    class="category-item"
                    onclick="toggleDigital()">


                    <span>

                        <i class="bi bi-cpu"></i>

                    </span>


                    <strong>
                        کالای دیجیتال
                    </strong>


                    <i class="bi bi-chevron-down category-arrow"></i>


                </a>


                <!-- SUB CATEGORIES -->

                <div
                    class="digital-subcategories"
                    id="digitalSubcategories">


                    <!-- ساعت هوشمند -->

                    <a
                        href="shop.php?category=7#products"
                        class="subcategory-item">

                        <i class="bi bi-smartwatch"></i>

                        <strong>
                            ساعت هوشمند
                        </strong>

                    </a>


                    <!-- هدست -->

                    <a
                        href="shop.php?category=8#products"
                        class="subcategory-item">

                        <i class="bi bi-headset"></i>

                        <strong>
                            هدست
                        </strong>

                    </a>


                    <!-- کنسول بازی -->

                    <a
                        href="shop.php?category=9#products"
                        class="subcategory-item">

                        <i class="bi bi-controller"></i>

                        <strong>
                            کنسول بازی
                        </strong>

                    </a>


                </div>


            </div>


            <!-- سایر محصولات -->

            <a
                href="shop.php?category=10#products"
                class="category-item">

                <span>

                    <i class="bi bi-box-seam"></i>

                </span>


                <strong>
                    سایر محصولات
                </strong>

            </a>


        </div>

    </div>

</section>



<!-- =====================================================
     PRODUCTS
===================================================== -->

<section
    class="shop-products"
    id="products">

    <div class="container">


        <div class="shop-section-header">


            <div>

                <span>
                    فروشگاه
                </span>


                <h2>


                    <?php if ($search !== ''): ?>

                        نتایج جستجو برای:

                        «<?= htmlspecialchars($search) ?>»


                    <?php else: ?>

                        جدیدترین محصولات


                    <?php endif; ?>


                </h2>

            </div>


            <span class="product-count">

                <?= count($products) ?>

                محصول

            </span>


        </div>



        <?php if (empty($products)): ?>


            <div class="shop-empty">


                <div class="shop-empty-icon">

                    <i class="bi bi-search"></i>

                </div>


                <?php if ($search !== ''): ?>


                    <h3>
                        محصولی پیدا نشد
                    </h3>


                    <p>

                        برای «<?= htmlspecialchars($search) ?>»

                        محصولی در فروشگاه پیدا نکردیم.

                    </p>


                    <a
                        href="shop.php"
                        class="shop-hero-button">

                        مشاهده همه محصولات

                    </a>


                <?php else: ?>


                    <h3>
                        هنوز محصولی ثبت نشده است
                    </h3>


                    <p>

                        محصولات ثبت شده در پنل مدیریت
                        اینجا نمایش داده می‌شوند.

                    </p>


                    <a
                        href="dashboard.php"
                        class="shop-hero-button">

                        ورود به پنل مدیریت

                    </a>


                <?php endif; ?>


            </div>


        <?php else: ?>


            <div class="row g-4">


                <?php foreach ($products as $product): ?>


                    <div
                        class="col-xl-3
                               col-lg-4
                               col-md-6">


                        <div class="shop-product-card">


                            <!-- PRODUCT IMAGE -->

                            <div class="shop-product-image">


                                <span class="product-new">

                                    جدید

                                </span>


                                <i class="bi bi-box-seam"></i>


                            </div>



                            <!-- PRODUCT INFO -->

                            <div class="shop-product-body">


                                <span class="shop-product-category">

                                    محصول فروشگاه

                                </span>


                                <h3>

                                    <?= htmlspecialchars(
                                        $product['name']
                                    ) ?>

                                </h3>


                                <p>

                                    <?= htmlspecialchars(
                                        $product['descripe']
                                    ) ?>

                                </p>


                                <!-- STOCK -->

                                <?php if ($product['stock'] > 0): ?>

                                    <small class="text-success">

                                        موجودی:

                                        <?= $product['stock'] ?>

                                        عدد

                                    </small>

                                <?php else: ?>

                                    <small class="text-danger">

                                        ناموجود

                                    </small>

                                <?php endif; ?>


                                <div class="shop-product-bottom">


                                    <!-- PRICE -->

                                    <div class="shop-price">

                                        <strong>

                                            <?= number_format(
                                                $product['price']
                                            ) ?>

                                        </strong>


                                        <span>
                                            تومان
                                        </span>

                                    </div>



                                    <!-- ACTIONS -->

                                    <div
                                        class="shop-product-actions">


                                        <!-- DETAILS -->

                                        <a
                                            href="product-detail.php?id=<?= $product['id'] ?>"
                                            class="shop-detail-button">

                                            <i class="bi bi-eye"></i>

                                        </a>



                                        <!-- ADD TO CART -->

                                        <?php if ($product['stock'] > 0): ?>


                                            <form
                                                action="cart.php"
                                                method="POST">


                                                <!-- PRODUCT ID -->

                                                <input
                                                    type="hidden"
                                                    name="product_id"
                                                    value="<?= $product['id'] ?>"
                                                >


                                                <!-- CSRF TOKEN -->

                                                <input
                                                    type="hidden"
                                                    name="csrf_token"
                                                    value="<?= htmlspecialchars(
                                                        $_SESSION['csrf_token']
                                                    ) ?>"
                                                >


                                                <button
                                                    type="submit"
                                                    name="add_to_cart"
                                                    class="shop-cart-button">


                                                    <i
                                                        class="bi bi-cart-plus">
                                                    </i>


                                                    افزودن به سبد


                                                </button>


                                            </form>


                                        <?php else: ?>


                                            <button
                                                type="button"
                                                class="shop-cart-button"
                                                disabled>


                                                <i
                                                    class="bi bi-x-circle">
                                                </i>


                                                ناموجود


                                            </button>


                                        <?php endif; ?>


                                    </div>


                                </div>


                            </div>


                        </div>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php endif; ?>


    </div>

</section>



<!-- =====================================================
     FEATURES
===================================================== -->

<section class="shop-features">

    <div class="container">

        <div class="row g-4">


            <div class="col-lg-4">

                <div class="shop-feature">


                    <div class="shop-feature-icon">

                        <i class="bi bi-truck"></i>

                    </div>


                    <div>

                        <h4>
                            ارسال سریع
                        </h4>


                        <p>
                            سفارش خود را سریع دریافت کنید.
                        </p>

                    </div>


                </div>

            </div>



            <div class="col-lg-4">

                <div class="shop-feature">


                    <div class="shop-feature-icon">

                        <i class="bi bi-shield-check"></i>

                    </div>


                    <div>

                        <h4>
                            خرید امن
                        </h4>


                        <p>
                            اطلاعات شما نزد ما محفوظ است.
                        </p>

                    </div>


                </div>

            </div>



            <div class="col-lg-4">

                <div class="shop-feature">


                    <div class="shop-feature-icon">

                        <i class="bi bi-headset"></i>

                    </div>


                    <div>

                        <h4>
                            پشتیبانی
                        </h4>


                        <p>
                            در تمام مراحل خرید همراه شما هستیم.
                        </p>

                    </div>


                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     FOOTER
===================================================== -->

<footer
    class="shop-footer"
    id="about">


    <div class="container">


        <div class="row g-5">


            <!-- STORE -->

            <div class="col-lg-5 col-md-6">


                <h3>

                    <i class="bi bi-bag-heart-fill"></i>

                    فروشگاه من

                </h3>


                <p>

                    یک تجربه ساده، سریع و مطمئن
                    برای خرید آنلاین.

                </p>


            </div>



            <!-- QUICK ACCESS -->

            <div class="col-lg-3 col-md-6">


                <h5>
                    دسترسی سریع
                </h5>


                <a href="shop.php">
                    خانه
                </a>


                <a href="#products">
                    محصولات
                </a>


                <a href="cart.php">
                    سبد خرید
                </a>


                <?php if (
                    isset($_SESSION["role"]) &&
                    $_SESSION["role"] === "admin"
                ): ?>

                    <a href="dashboard.php">
                        پنل مدیریت
                    </a>

                <?php endif; ?>


            </div>



            <!-- CONTACT -->

            <div class="col-lg-4 col-md-12">


                <h5>
                    ارتباط با ما
                </h5>


                <p>

                    <i class="bi bi-telephone"></i>

                    09120000000

                </p>


                <p>

                    <i class="bi bi-envelope"></i>

                    info@example.com

                </p>


            </div>


        </div>


        <div class="shop-footer-bottom">

            © تمامی حقوق محفوظ است.

        </div>


    </div>

</footer>



<script src="js/bootstrap.bundle.min.js"></script>

<script src="js/theme.js"></script>


</body>

</html>