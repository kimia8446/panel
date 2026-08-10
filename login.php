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
    <title>ورود</title>
</head>
<body>
<div class="container p-5">
    <section class="d-flex justify-content-center align-item-center min-vh-100">
        <fieldset>
            <form action = "index.php" method="POST">
             <div class="container card " >
               <div class=" card card-beauty p-4 ">
                <div>
                  <h1 class=" title d-flex justify-content-center align-item-center pb-3">ورود</h1>
                  <label for="name" class="form-label">نام کاربری</label>
                  <input type = "text" id="username" name= "username" class ="form-control mb-3" placeholder="نام کاربری" maxlength="10" >
                </div>
                <div>
                   <label for="password" class="form-label">رمز عبور</label>
                   <input  type ="password" id="password" name= "password" class ="form-control mb-3" rows="2" placeholder="رمز عبور" mb-3 >
                  </div>
                  <div>
              <button type="submit" class="btn btn-primary mt-3 flex justify-content-center align-item-center w-100">ورود</button>
              </div>
           </form>
              <button type="button" id="themeButton" class="btn btn-outline-secondary w-100 mt-3">
                حالت تیره 
             </button>
</body>