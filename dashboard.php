<?php
include("config/database.php");
include("aside.php");
require_once __DIR__ . '/config/database.php';
$stmt = $conn->query(
    "SELECT * FROM product"
);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION["username"];

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/stiles/Vazirmatn-font-face.css">   
    <link rel="stylesheet" href="style/style.css">

    <title>داشبورد</title>

</head>

<body>


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

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/theme.js"></script>

</body>
</html>