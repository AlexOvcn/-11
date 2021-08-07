<header>
    <form action="index.php" method='POST'>
        <button name='page' value='1'>Главная</button>
        <button name='page' value='2'>Загрузка файлов</button>
        <button name='page' value='3'>Галерея</button>
        <button name='page' value='4'>Регистрация</button>
    </form>

    <?php if (isset($_POST['enter_btn'])) {
        login($_POST['enter_login'], $_POST['enter_password']);
    }
    if (isset($_POST['logout_btn'])) {
        $_SESSION['signIn_name'] = null;
        $_SESSION['signIn'] = false;
        $_SESSION['failedLogin'] = true;
    }
    if (isset($_SESSION['signIn']) && $_SESSION['signIn']) { ?>
        <div class='logout'>
            <?php echo "Добро пожаловать: {$_SESSION['signIn_name']}"; ?>
            <form action="index.php" method="POST" class='log-inputs'>
                <button name='logout_btn'>Выйти</button>
            </form>
        </div>
    <?php } if ((!isset($_POST['enter_btn']) && !isset($_SESSION['failedLogin'])) || (isset($_SESSION['failedLogin']) && $_SESSION['failedLogin'])) { ?>
        <div class='login'>
            <form action="index.php" method="POST" class='log-inputs'>
                <label><input name='enter_login' type="text" placeholder='Ваш логин' minlength='2' required autocomplete="off"></label>
                <label><input name="enter_password" type="password" placeholder='Ваш пароль' minlength='2' required autocomplete="off"></label>
                <button name='enter_btn'>Войти</button>
            </form>
        </div>
    <?php }?>
</header>