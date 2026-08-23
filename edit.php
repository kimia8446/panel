<?php 
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    exit("شناسه محصول نامعتبر است.");
}
$stmt = $conn->prepare(
    "SELECT * FROM product WHERE id = :id"
);

$stmt->execute([
    "id" => $id
]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    exit("محصول موردنظر پیدا نشد.");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["product_name"] ?? "");
    $descripe = trim($_POST["product_descripe"] ?? "");
    $price = filter_input(
        INPUT_POST,
        'product_price',
        FILTER_VALIDATE_INT
    );
    if (strlen($name) < 3) {
        exit("نام محصول باید حداقل ۳ کاراکتر باشد.");
    }
    
    if (!$price || $price < 100) {
        exit("قیمت باید حداقل ۱۰۰ باشد.");
    }

$stmt = $conn->prepare(
    "UPDATE product
     SET name = :name,
         descripe = :descripe,
         price = :price
     WHERE id = :id"
);

$stmt->execute([
    "name" => $name,
    "descripe" => $descripe,
    "price" => $price,
    "id" => $id
]);

header("Location: products.php");
exit;
}
?>


<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
<script>
function showResult(str) {
  if (str.length==0) {
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","livesearch.php?q="+str,true);
  xmlhttp.send();
}
</script>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="style/bootstrap.min.css">
<link rel="stylesheet" href="style/stiles/Vazirmatn-font-face.css">   
<link rel="stylesheet" href="style/style.css">
<link rel="stylesheet" href="style/sweetalert2.min.css">

    <title>ویرایش محصول</title>

</head>

<body>

<?php include("aside.php"); ?>

<main class="main-content">

    <div class="container-fluid">

        <div class="welcome-box">

            <h2 class="mb-4">
                ویرایش محصول
            </h2>
            <form method="POST">
            <label
                        for="name"
                        class="form-label"
                    >
                        نام محصول
            </label>

                    <input
                        type="text"
                        id="name"
                        name="product_name"
                        class="form-control"
                        value="<?= htmlspecialchars($product['name']) ?>"
                        minlength="3"
                        required
                    >

         <div class="mb-3">

        <label
    for="description"
    class="form-label"
>
    توضیحات
</label>

<textarea
    id="description"
    name="product_descripe"
    class="form-control"
    rows="4"
><?= htmlspecialchars($product['descripe']) ?></textarea>

</div>
<div class="mb-3">

<label
    for="price"
    class="form-label"
>
    قیمت
</label>

<input
    type="number"
    id="price"
    name="product_price"
    class="form-control"
    value="<?= htmlspecialchars($product['price']) ?>"
    min="100"
    required
>

</div>
<button
                    type="submit"
                    class="btn btn-success"
                    onclick="confirmEdit(event)"
                >
                    ذخیره تغییرات
                </button>


                <a
                    href="products.php"
                    class="btn btn-secondary"
                >
                    انصراف
                </a>

            </form>

        </div>

    </div>
</div>
</main>
</form>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/theme.js"></script>
<script src="js/sweetalert2.all.min.js"></script>
<script>
function confirmEdit(event) {

event.preventDefault();

const form = event.target.closest('form');

Swal.fire({
    title: "آیا از ذخیره تغییرات مطمئنی؟",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "ذخیره شود",
    cancelButtonText: "انصراف"
}).then((result) => {

    if (result.isConfirmed) {

        // فرم را واقعاً ارسال می‌کند
        form.submit();

    }

});
}
</script>
</body>

</html>