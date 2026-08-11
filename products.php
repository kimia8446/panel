<?php
include("aside.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/config/database.php';

$stmt = $conn->query("SELECT * FROM product");

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/Vazirmatn-font-face.css">
    <link rel="stylesheet" href="style/style.css">

    <title>مشاهده محصولات</title>

</head>

<body>
<main class="main-content">

    <div class="container-fluid">
          <div class="container mt-5">

          <h2 class="text-center mb-4">
          لیست محصولات
          </h2>


    <a href="index.php" class="btn btn-primary mb-4">
        افزودن محصول جدید
    </a>



    <?php if (empty($products)): ?>

        <div class="alert alert-info text-center">
            هنوز محصولی ثبت نشده است.
        </div>

    <?php else: ?>


        <?php foreach ($products as $product): ?>

            <div class="card mb-3">

                <div class="card-body">

                    <h4>
                        <?= htmlspecialchars($product['name']) ?>
                    </h4>


                    <p>
                        <?= htmlspecialchars($product['descripe']) ?>
                    </p>


                    <h5>
                        <?= number_format($product['price']) ?>
                        تومان
                    </h5>


                    <form
                        action="delete.php"
                        method="POST"
                        class="mt-3"
                    >

                        <input
                            type="hidden"
                            name="id"
                            value="<?= $product['id'] ?>"
                        >

                        <button
                            type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('آیا از حذف این محصول مطمئن هستید؟');"
                        >
                            حذف
                        </button>

                    </form>

                </div>

            </div>

        <?php endforeach; ?>


    <?php endif; ?>

   </div>
   </div>

        </main>
    
<aside class="sidebar">
       <div class="sidebar-bottom">

           <button
               type="button"
               id="themeButton"
               class="menu-item theme-item btn btn-outline-secondary  mt-3">
               حالت تیره
            </button>

            <a href="logout.php" class="menu-item logout-item">
            <span>خروج</span>
            </a>

       </div>
</aside>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/theme.js"></script>
</body>

</html>
