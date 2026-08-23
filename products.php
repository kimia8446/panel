<?php

session_start();

if (
    !isset($_SESSION["username"]) ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "admin"
) {

    header("Location: login.php");
    exit;

}

require_once __DIR__ . '/config/database.php';

$stmt = $conn->query("SELECT * FROM product ORDER BY id DESC");

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/bootstrap.min.css">

    <link rel="stylesheet"
          href="style/stiles/Vazirmatn-font-face.css">

    <link rel="stylesheet"
          href="style/style.css">

    <link rel="stylesheet"
          href="style/sweetalert2.min.css">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <title>مشاهده محصولات</title>

</head>


<body>

<?php include("aside.php"); ?>


<main class="main-content">

    <div class="container-fluid">


        <!-- =====================================
             PAGE HEADER
        ====================================== -->

        <div class="products-page-header">

            <div>

                <span class="products-page-label">
                    مدیریت فروشگاه
                </span>

                <h2>
                    محصولات
                </h2>

                <p>
                    لیست محصولات ثبت شده در فروشگاه
                </p>

            </div>


            <a href="index.php"
               class="btn btn-primary">

                <i class="bi bi-plus-lg"></i>

                افزودن محصول جدید

            </a>

        </div>



        <!-- =====================================
             PRODUCTS TABLE
        ====================================== -->

        <?php if (empty($products)): ?>

            <div class="alert alert-info text-center">

                <i class="bi bi-box-seam"></i>

                هنوز محصولی ثبت نشده است.

            </div>

        <?php else: ?>


            <div class="products-table-card">


                <!-- TABLE HEADER -->

                <div class="products-table-header">

                    <div>

                        <h4>
                            لیست محصولات
                        </h4>

                        <span>
                            <?= count($products) ?> محصول
                        </span>

                    </div>

                </div>



                <!-- RESPONSIVE TABLE -->

                <div class="table-responsive">

                    <table class="table products-table align-middle mb-0">


                        <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                نام محصول
                            </th>

                            <th>
                                توضیحات
                            </th>

                            <th>
                                قیمت
                            </th>

                            <th class="text-center">
                                عملیات
                            </th>

                        </tr>

                        </thead>


                        <tbody>


                        <?php foreach ($products as $product): ?>


                            <tr>


                                <!-- ID -->

                                <td>

                                    <span class="product-number">

                                        #<?= $product['id'] ?>

                                    </span>

                                </td>



                                <!-- NAME -->

                                <td>

                                    <div class="product-name">

                                        <div class="product-icon">

                                            <i class="bi bi-box-seam"></i>

                                        </div>

                                        <strong>

                                            <?= htmlspecialchars($product['name']) ?>

                                        </strong>

                                    </div>

                                </td>



                                <!-- DESCRIPTION -->

                                <td>

                                    <div class="product-description-table">

                                        <?= htmlspecialchars($product['descripe']) ?>

                                    </div>

                                </td>



                                <!-- PRICE -->

                                <td>

                                    <div class="product-price-table">

                                        <?= number_format($product['price']) ?>

                                        <span>
                                            تومان
                                        </span>

                                    </div>

                                </td>



                                <!-- ACTIONS -->

                                <td>

                                    <div class="product-actions-table">


                                        <!-- EDIT -->

                                        <a
                                            href="edit.php?id=<?= $product['id'] ?>"
                                            class="btn btn-sm btn-warning product-edit-btn"
                                            onclick="confirmEdit(event)"
                                        >

                                            <i class="bi bi-pencil"></i>

                                            ویرایش

                                        </a>



                                        <!-- DELETE -->

                                        <form
                                            action="delete.php"
                                            method="POST"
                                            class="d-inline"
                                        >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $product['id'] ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger product-delete-btn"
                                                onclick="confirmDelete(event)"
                                            >

                                                <i class="bi bi-trash"></i>

                                                حذف

                                            </button>

                                        </form>


                                    </div>

                                </td>


                            </tr>


                        <?php endforeach; ?>


                        </tbody>

                    </table>

                </div>

            </div>


        <?php endif; ?>


    </div>

</main>



<script src="js/bootstrap.bundle.min.js"></script>

<script src="js/theme.js"></script>

<script src="js/sweetalert2.all.min.js"></script>


<script>


/* =========================================
   DELETE CONFIRM
========================================= */

const swalWithBootstrapButtons = Swal.mixin({

    customClass: {

        confirmButton: "btn btn-success mx-2",

        cancelButton: "btn btn-danger mx-2"

    },

    buttonsStyling: false

});


function confirmDelete(event) {

    event.preventDefault();

    const form = event.target.closest("form");


    swalWithBootstrapButtons.fire({

        title: "آیا مطمئن هستید؟",

        text: "این محصول حذف خواهد شد و قابل بازگشت نیست.",

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



/* =========================================
   EDIT CONFIRM
========================================= */

function confirmEdit(event) {

    event.preventDefault();

    const link = event.currentTarget;


    Swal.fire({

        title: "ویرایش محصول؟",

        text: "اطلاعات این محصول ویرایش شود؟",

        icon: "question",

        showCancelButton: true,

        confirmButtonText: "بله، ویرایش",

        cancelButtonText: "لغو",

        reverseButtons: true

    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href = link.href;

        }

    });

}

</script>


</body>

</html>