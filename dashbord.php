<?php
include("config/database.php");
require_once __DIR__ . '/config/database.php';
$stmt = $conn->query(
    "SELECT * FROM product"
);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
session_start();
if (isset($_SESSION["username"])) {
    header ("locatio:login.php");
    exit;
}
$username =$_SESSION["username"]
?>
<!DOCTYPE Html>
<html lang ="fa" dir="rtl">
<head>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="style/bootstrap.min.css">
<link rel="stylesheet" href="style/Vazirmatn-font-face.css">
<link rel="stylesheet" href="style/style.css">

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/theme.js"></script>
    <title>داشبورد</title>
</head>
<body>
<aside class="sidebar">

<div class="sidebar-title">
    پنل مدیریت
</div>

<nav class="sidebar-menu">

    <a href="products.php" class="menu-item">
        <span>مشاهده محصولات</span>
    </a>


    <a href="index.php" class="menu-item">
        <span>افزودن محصول</span>
    </a>


    <a href="#" class="menu-item">
        <span>کاربران</span>
    </a>

</nav>

<div class="sidebar-bottom">
      <button type="button" id="themeButton" class="menu-item theme-item btn btn-outline-secondary w-100 mt-3">
                حالت تیره 
       </button>
    <a href="logout.php" class="menu-item logout-item">
        <span>خروج</span>
    </a>

</div>

</aside>

<main class="main-content">

<div class="container-fluid">

    <div class="welcome-box">

        <h1>
            سلام <?= htmlspecialchars($username) ?>
        </h1>

        <p>
            به پنل مدیریت خوش آمدید.
        </p>

    </div>

</div>

</main>
