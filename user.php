
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


// ===============================
// PAGINATION
// ===============================

$perPage = 10;

// شماره صفحه فعلی
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// اگر صفحه کمتر از 1 بود
if ($page < 1) {
    $page = 1;
}


// ===============================
// COUNT USERS
// ===============================

if ($search !== '') {

    $countStmt = $conn->prepare(
        "SELECT COUNT(*)
         FROM users
         WHERE username LIKE :search
            OR phone LIKE :search"
    );

    $countStmt->execute([
        'search' => "%{$search}%"
    ]);

} else {

    $countStmt = $conn->query(
        "SELECT COUNT(*)
         FROM users"
    );

}

$totalUsers = $countStmt->fetchColumn();


// ===============================
// CALCULATE PAGINATION
// ===============================

$totalPages = ceil($totalUsers / $perPage);

// اگر صفحه بیشتر از آخرین صفحه بود
if ($totalPages > 0 && $page > $totalPages) {
    $page = $totalPages;
}

// شروع دریافت اطلاعات
$offset = ($page - 1) * $perPage;


// ===============================
// GET USERS
// ===============================

if ($search !== '') {

    $stmt = $conn->prepare(
        "SELECT id, username, phone, created_at
         FROM users
         WHERE username LIKE :search
            OR phone LIKE :search
         ORDER BY id DESC
         LIMIT :offset, :perPage"
    );

    $stmt->bindValue(
        ':search',
        "%{$search}%",
        PDO::PARAM_STR
    );

    $stmt->bindValue(
        ':offset',
        $offset,
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':perPage',
        $perPage,
        PDO::PARAM_INT
    );

    $stmt->execute();

} else {

    $stmt = $conn->prepare(
        "SELECT id, username, phone, created_at
         FROM users
         ORDER BY id DESC
         LIMIT :offset, :perPage"
    );

    $stmt->bindValue(
        ':offset',
        $offset,
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':perPage',
        $perPage,
        PDO::PARAM_INT
    );

    $stmt->execute();

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
<?php if ($totalPages > 1): ?>

<nav class="user-pagination" aria-label="صفحه‌بندی کاربران">

    <ul class="pagination justify-content-center">


        <!-- صفحه قبلی -->

        <?php if ($page > 1): ?>

            <li class="page-item">

                <a
                    class="page-link"
                    href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"
                >

                    <i class="bi bi-chevron-right"></i>

                </a>

            </li>

        <?php endif; ?>


        <!-- شماره صفحات -->

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>

            <li
                class="page-item <?= $i == $page ? 'active' : '' ?>"
            >

                <a
                    class="page-link"
                    href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"
                >

                    <?= $i ?>

                </a>

            </li>

        <?php endfor; ?>


        <!-- صفحه بعد -->

        <?php if ($page < $totalPages): ?>

            <li class="page-item">

                <a
                    class="page-link"
                    href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"
                >

                    <i class="bi bi-chevron-left"></i>

                </a>

            </li>

        <?php endif; ?>


    </ul>

</nav>

    <?php endif; ?>
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