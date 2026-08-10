<!DOCTYPE Html>
<html lang ="fa" dir="rtl">
<head>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="style/bootstrap.min.css">
<link rel="stylesheet" href="style/Vazirmatn-font-face.css">
<link rel="stylesheet" href="style/style.css">

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/theme.js"></script>
    <title>ثبت نام </title>
</head>
<body>
<body>
<div class="container p-5">
    <section class="d-flex justify-content-center align-item-center min-vh-100">
        <fieldset>
            <form action = "dashbord.php" method="POST">
             <div class="container card " >
               <div class=" card card-beauty p-4 ">
                <div>
                  <h1 class=" title d-flex justify-content-center align-item-center pb-3">ثبت نام/ورود</h1>
                  <label for="name" class="text-right form-label">نام</label>
                  <input type = "text" id="username" name= "username" class ="form-control mb-3" placeholder="نام" maxlength="10" >
                </div>
                <div>
                   <label for="phone" class="text-right form-label">شماره همراه</label>
                   <input  type ="tel" id="phone" name= "phone" class ="form-control mb-3" rows="2" placeholder="شماره همراه" mb-3 >
                  </div>
                  <div>
                  <div>
                   <label for="password" class="text-right form-label">رمز عبور</label>
                   <input  type ="password" id="password" name= "password" class ="form-control mb-3" rows="2" placeholder="رمز عبور" mb-3 >
                  </div>
                  <div>
                   <label for="passwordAgain" class=" text-right form-label">تکرار رمز عبور</label>
                   <input  type ="password" id="passwordAgain" name= "passwordAgain" class ="form-control mb-3" rows="2" placeholder="تکرار رمز عبور" mb-3 >
                  </div>
              <button type="submit" class="btn btn-primary mt-3 flex justify-content-center align-item-center w-100">ثبت نام</button>
              </div>
             <div class="text-right pt-2 pb-3">
              <a href="login.php">قبلاً ثبت‌نام کرده‌اید؟</a>
             </div>       
           </form>
              <button type="button" id="themeButton" class="btn btn-outline-secondary w-100 mt-3">
                حالت تیره 
             </button>
</body>