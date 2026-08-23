<?php

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: shop.php");
    exit;
}

?>
<!DOCTYPE Html>
<html lang ="fa" dir="rtl">
<head>
<meta charset="UTF-8">



<link rel="stylesheet" href="style/bootstrap.min.css">
<link rel="stylesheet"
          href="style/stiles/Vazirmatn-font-face.css">
<link rel="stylesheet" href="style/style.css">
    <title>محصولات</title>
</head>
<body>
<?php
include("aside.php");
?>
  <div class="container p-5">
    <section class="d-flex justify-content-center align-item-center vh-100">
        <fieldset>
            <form action = "save.php" method="POST">
             <div class="container card " >
               <div class=" card card-beauty p-4 ">
                <div>
                  <h1 class=" title d-flex justify-content-center align-item-center pb-3">وارد کردن مشخصات

                  </h1>
                  <label for="name" class="form-label">اسم محصول</label>
                  <input type = "text" id="name" name= "product_name" class ="form-control mb-3" placeholder="نام" maxlength="10" minlength="3"  " >
                </div>
                <div>
                   <label for="description" class="form-label">توضیحات</label>
                   <textarea type ="text" id="description" name = "product_descripe" class ="form-control mb-3" rows="2" placeholder="توضیحات" mb-3 ></textarea>
                  </div>
                <div>
                   <label for=" price" class="form-label">قیمت</label>
                   <input type="text" id="price" name="product_price"  class ="form-control mb-3" min ="100"  max="1000000000"  placeholder="قیمت"  mb-3 >
                  </div>
               <div>
              <button type="submit" class="btn btn-success mt-3 ">ارسال</button>
              </div>
              <a href="products.php" class="btn btn-primary mt-3">
               مشاهده محصولات
               </a>
            </div>
          </form>
        </fieldset>
    </section>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/theme.js"></script>
</body>
</html>





