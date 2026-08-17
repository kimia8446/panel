<?php
session_start();
include("aside.php");

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
    <link rel="stylesheet" href="style/stiles/Vazirmatn-font-face.css">   
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/sweetalert2.min.css">
    <title>مشاهده محصولات</title>

</head>

<body>
<main class="main-content">

    <div class="container-fluid">
          <div class="container mt-5">

          <div class="page-header">

<h2>
    لیست محصولات
</h2>

<a href="index.php" class="btn btn-primary">
    افزودن محصول جدید
</a>

</div>



    <?php if (empty($products)): ?>

        <div class="alert alert-info text-center">
            هنوز محصولی ثبت نشده است.
        </div>

    <?php else: ?>

        <?php foreach ($products as $product): ?>

<div class="product-card">

    <div class="product-card-header">

        <div>
            <span class="product-label">محصول</span>

            <h4 class="product-title">
                <?= htmlspecialchars($product['name']) ?>
            </h4>
        </div>

        <span class="product-id">
            #<?= $product['id'] ?>
        </span>

    </div>

    <div class="product-description">
        <?= htmlspecialchars($product['descripe']) ?>
    </div>

    <div class="product-card-footer">

        <div class="product-price">
            <?= number_format($product['price']) ?>
            <span>تومان</span>
        </div>

        <div class="product-actions">

            <form
                action="delete.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?= $product['id'] ?>"
                >

                <button
                    type="submit"
                    class="btn-product btn-delete"
                    onclick="confirmDelete(event)"
                >
                    حذف
                </button>

            </form>

            <a
                href="edit.php?id=<?= $product['id'] ?>"
                class="btn-product btn-edit"
                onclick="confirmEdit(event)"
            >
                ویرایش
            </a>

        </div>

    </div>

</div>

<?php endforeach; ?>
    <?php endif; ?>

   </div>
   </div>

        </main>
    
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/theme.js"></script>
<script src="js/sweetalert2.all.min.js"></script>

<script>
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger"
    },
    buttonsStyling: false
});

function confirmDelete(event) {

    event.preventDefault();

    const form = event.target.closest('form');

    swalWithBootstrapButtons.fire({
        title: "آیا مطمئن هستید؟",
        text: "این محصول حذف خواهد شد و قابل بازگشت نیست!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "بله، حذف کن",
        cancelButtonText: "لغو",
        reverseButtons: true
    }).then((result) => {

        if (result.isConfirmed) {
            form.submit();
        }

    });
}
function confirmEdit(event) {

event.preventDefault();

const link = event.currentTarget;

Swal.fire({
    title: "اطلاعات ویرایش شود؟",
    icon: "question",
    confirmButtonText: "بله",
    cancelButtonText: "خیر",
    showCancelButton: true,
    showCloseButton: true
}).then((result) => {

    if (result.isConfirmed) {
        window.location.href = link.href;
    }

});
}
</script>
</body>

</html>
