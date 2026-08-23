
<?php if (
    isset($_SESSION["role"]) &&
    $_SESSION["role"] === "admin"
): ?>

    <a href="dashboard.php" class="menu-item">
        <span>داشبورد</span>
    </a>

    <a href="products.php" class="menu-item">
        <span>مشاهده محصولات</span>
    </a>

    <a href="index.php" class="menu-item">
        <span>افزودن محصول</span>
    </a>

    <a href="user.php" class="menu-item">
        <span>کاربران</span>
    </a>

<?php endif; ?>
<aside class="sidebar">

    <div class="sidebar-title">
        پنل مدیریت
    </div>

    <nav class="sidebar-menu">
    <a href="shop.php" class="menu-item">
            <span>خانه</span>
        </a>
        <a href="products.php" class="menu-item">
            <span>مشاهده محصولات</span>
        </a>

        <a href="index.php" class="menu-item">
            <span>افزودن محصول</span>
        </a>

        <a href="user.php" class="menu-item">
            <span>کاربران</span>
        </a>

    </nav>

    <div class="sidebar-bottom">

        <button
            type="button"
            id="themeButton"
            class="menu-item theme-item btn btn-outline-secondary w-100 mt-3">

            حالت تیره

        </button>

        <a href="logout.php" class="menu-item logout-item w-100">
            <i class='fas fa-archive'></i>
            <span>خروج</span>
        </a>

    </div>

</aside>
