<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="./index.php?page=1"
                   class="nav-link <?php if ((isset($_GET['page']) && $_GET['page'] == 1) || !isset($_GET['page'])) echo 'active' ?>">
                    Туры
                </a>
            </li>
            <li class="nav-item">
                <a href="./index.php?page=2"
                   class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 2) echo 'active' ?>">
                    Отзыв
                </a>
            </li>
            <li class="nav-item">
                <a href="./index.php?page=3"
                   class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 3) echo 'active' ?>">
                    Регистрация
                </a>
            </li>
            <li class="nav-item">
                <a href="./index.php?page=4"
                   class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 4) echo 'active' ?>">
                    Админка
                </a>
            </li>
            <?php
            // Если в сессии есть запись "r_admin"
            if (isset($_SESSION['r_admin'])) {
                ?>
                <li class="nav-item">
                    <a href="./index.php?page=6"
                       class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 6) echo 'active' ?>">
                        Приватность сайта
                    </a>
                </li>
                <?php }?>
        </ul>
    </div>
</nav>
<?php
    if (!isset($_SESSION['r_admin']) && isset($_GET['page']) && $_GET['page'] == 6) {
        echo "<h1 class='mt-5'><span style='color:red' >Вы потеряли свои права, покиньте страницу!</span><h1/>";
    }
?>