
<?php
include("aside.php");
session_start();


if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}


require_once __DIR__ . '/config/database.php';


$stmt = $conn->query(
    "SELECT id, username, phone, created_at
     FROM users
     ORDER BY id DESC"
);

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/Vazirmatn-font-face.css">
    <link rel="stylesheet" href="style/style.css">

    <title>کاربران</title>

</head>

<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">
        کاربران
    </h2>


    <?php if (empty($users)): ?>

        <div class="alert alert-info text-center">

            هنوز کاربری ثبت نام نکرده است.

        </div>

    <?php else: ?>


        <?php foreach ($users as $user): ?>

            <div class="card mb-3">

                <div class="card-body">

                    <h5>
                        <?= htmlspecialchars($user["username"]) ?>
                    </h5>

                    <p class="mb-1">
                        شماره همراه:
                        <?= htmlspecialchars($user["phone"]) ?>
                    </p>

                    <small class="text-muted">

                        تاریخ ثبت:
                        <?= htmlspecialchars($user["created_at"]) ?>

                    </small>

                </div>

            </div>

        <?php endforeach; ?>


    <?php endif; ?>


    <a href="dashboard.php" class="btn btn-primary mt-3">

        بازگشت به داشبورد

    </a>

</div>


<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/theme.js"></script>
</body>

</html>

