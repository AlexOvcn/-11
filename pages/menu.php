<?php require_once 'classes.php' ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <?php if (isset($_SESSION['reg'])) { ?>
                    <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 1) echo 'active' ?>"
                        aria-current="page" href="./index.php?page=1">Каталог товаров</a>
                    <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 2) echo 'active' ?>"
                        href="./index.php?page=2">Корзина</a>
                <?php } ?>
                <?php if (!isset($_SESSION['reg'])) { ?>
                    <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 3) echo 'active' ?>"
                    href="./index.php?page=3">Регистрация</a>
                <?php } ?>
                <?php if (isset($_SESSION['r_admin'])) { ?>
                    <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] == 4) echo 'active' ?>"
                    href="./index.php?page=4">Консоль администратора</a>
                <?php } ?>

            </div>

                <?php if (isset($_SESSION['reg'])) {  $userInfo = Customer::fromDb($_SESSION['reg']) ?>
                    <div class='d-flex align-items-center'>
                        <div class='userInfo me-4 d-flex align-items-center'>  
                            <div class='userInfo-avatar me-2' style='background-image: url(<?php echo $userInfo->image_path ?>);'></div>
                            <p class='userInfo-login m-0'> <?php echo $_SESSION['reg'] ?> </p> 
                        </div>
                        
                        <form action="./index.php" method='POST' style='margin:0'>
                            <button type='submit' class='btn btn-secondary' name='logout_btn'>Выйти</button>
                        </form>
                    </div>
                

                <?php 
                    // Если нажата кнопка "logout_btn", очищаем сессию "reg" и "r_admin"
                    if (isset($_POST['logout_btn'])) {
                        unset($_SESSION['reg']);
                        unset($_SESSION['r_admin']);
                        ?>
                        <!-- Обновляем страницу -->
                        <script>window.location.reload()</script>
                        <?php
                    }
                } else {
                    if (isset($_POST['login_btn'])) {
                        // Если функция login() возвращает TRUE
                        if (Tools::login($_POST['login'], $_POST['pass'])) { 
                            unset($_GET['page']);
                            ?>
                            <!-- Обновляем страницу -->
                            <script>window.location.reload()</script>
                            <?php
                        }
                        // Иначе показываем форму входа в аккаунт
                    } else { ?>
                        <form action="./index.php" method='POST' style='margin:0'>
                            <input type="text" name="login" class='btn btn-light bg-light text-dark text-start' style='cursor: text' required placeholder='Ваш логин'>
                            <input type="password" name="pass" class='btn btn-light bg-light text-dark text-start' style='cursor: text' required placeholder='Ваш пароль'>
                            <button type='submit' class='btn btn-light' name='login_btn'>Войти</button>
                        </form>
                        <?php
                    }
                }
                ?>
        </div>
    </div>
</nav>