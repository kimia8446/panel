
<?php

session_start();

require_once __DIR__ . '/config/database.php';

$error = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

   
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";


   

    if ($username === "") {

        $error = "لطفاً نام کاربری را وارد کنید.";

    } elseif (strlen($username) < 3) {

        $error = "نام کاربری باید حداقل ۳ کاراکتر باشد.";

    } elseif ($password === "") {

        $error = "لطفاً رمز عبور را وارد کنید.";

    } elseif (strlen($password) < 6) {

        $error = "رمز عبور باید حداقل ۶ کاراکتر باشد.";

    } else {

        

        $stmt = $conn->prepare(
            "SELECT * FROM users WHERE username = :username"
        );

        $stmt->execute([
            "username" => $username
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        
        if ($user && password_verify($password, $user["password"])) {


            $_SESSION["username"] = $user["username"];
            $_SESSION["user_id"] = $user["id"];

            header("Location: shop.php");
            exit;

        } else {

          
            $error = "نام کاربری یا رمز عبور اشتباه است.";
        }
    }
}

?>


<!DOCTYPE html>

<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/stiles/Vazirmatn-font-face.css">   
    <link rel="stylesheet" href="style/style.css">

    <title>ورود</title>

</head>


<body>


<div class="container p-5">

    <section class="d-flex justify-content-center align-items-center min-vh-100">

        <fieldset>

            <form action="login.php" method="POST">

                <div class="card card-beauty p-4">


                    <h1 class="title text-center pb-3">
                        ورود
                    </h1>



                    <?php if ($error !== ""): ?>

                        <div class="alert alert-danger">

                            <?= htmlspecialchars($error) ?>

                        </div>

                    <?php endif; ?>


                 

                    <div>

                        <label
                            for="username"
                            class="form-label">

                            نام کاربری

                        </label>


                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-control mb-3"
                            placeholder="نام کاربری"
                            maxlength="100"
                            value="<?= htmlspecialchars($username ?? '') ?>"
                        >

                    </div>


                 

                    <div>

                        <label
                            for="password"
                            class="form-label">

                            رمز عبور

                        </label>


                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control mb-3"
                            placeholder="رمز عبور"
                        >

                    </div>


                   

                    <button
                        type="submit"
                        class="btn btn-primary mt-3 w-100">

                        ورود

                    </button>


                    

                    <div class="text-center mt-3">

                        <a href="sign.php">

                            حساب کاربری ندارم

                        </a>

                    </div>
                    <button
                        type="button"
                        id="themeButton"
                        class="btn btn-outline-secondary w-100 mt-3">

                        حالت تیره

                    </button>


                </div>

            </form>

        </fieldset>

    </section>

</div>


<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/theme.js"></script>

</body>

</html>

