
<?php

session_start();

include("aside.php");

if (!isset($_SESSION["username"])) {

    header("Location: login.php");
    exit;

}

require_once __DIR__ . '/config/database.php';


// ===============================
// SEARCH
// ===============================

$search = trim($_GET['search'] ?? '');

if ($search !== '') {

    $stmt = $conn->prepare(
        "SELECT id, username, phone, created_at
         FROM users
         WHERE username LIKE :search
            OR phone LIKE :search
         ORDER BY id DESC"
    );

    $stmt->execute([
        'search' => "%{$search}%"
    ]);

} else {

    $stmt = $conn->query(
        "SELECT id, username, phone, created_at
         FROM users
         ORDER BY id DESC"
    );

}

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
          href="style/bootstrap.min.css">

    <link rel="stylesheet"
          href="style/stiles/Vazirmatn-font-face.css">

    <link rel="stylesheet"
          href="style/style.css">

    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <title>
        کاربران
    </title>

</head>


<body>

<main class="main-content">
<div class="container mt-5">


    <!-- HEADER -->

    <div class="user-page-header">

        <h2 class="textuser">

            اسامی کاربران

        </h2>


        <!-- SEARCH -->

        <form
            action="user.php"
            method="GET"
            class="user-search-form">

            <input
                type="text"
                name="search"
                placeholder="جستجوی کاربر..."
                value="<?= htmlspecialchars($search) ?>"
                autocomplete="off">


            <button
                type="submit"
                title="جستجو">

                <i class="bi bi-search"></i>

            </button>

        </form>

    </div>



    <!-- USERS -->

    <?php if (empty($users)): ?>


        <div class="alert alert-info text-center">

            <?php if ($search !== ''): ?>

                کاربری با عبارت

                «<?= htmlspecialchars($search) ?>»

                پیدا نشد.

            <?php else: ?>

                هنوز کاربری ثبت نام نکرده است.

            <?php endif; ?>

        </div>


    <?php else: ?>


        <div class="users-list">

    <div class="users-list-header">

        <span>نام کاربری</span>

        <span>شماره همراه</span>

        <span>تاریخ ثبت</span>

    </div>


    <?php foreach ($users as $user): ?>

        <div class="user-list-item">

            <div class="user-username">

                <i class="bi bi-person-circle"></i>

                <?= htmlspecialchars($user["username"]) ?>

            </div>


            <div class="user-phone">

                <?= htmlspecialchars($user["phone"]) ?>

            </div>


            <div class="user-date">

                <?= htmlspecialchars($user["created_at"]) ?>

            </div>

        </div>

    <?php endforeach; ?>

</div>
    <?php endif; ?>



    <!-- BACK BUTTON -->

    <a
        href="dashboard.php"
        class="btn btn-primary btn-redirect mt-3">

        بازگشت به داشبورد

    </a>


</div>


</div>

</main>
<script src="js/bootstrap.bundle.min.js"></script>

<script src="js/theme.js"></script>


</body>

</html>