<?php

// Если в сессии есть запись "r_user"
if (isset($_SESSION['r_user'])) { ?>

    <!-- Создаем приветствие с кнопкой выхода -->
    <form action="./index.php<?php if (isset($_GET['page'])) echo "?page=" . $_GET['page']; ?>"
          class="form-inline pull-right d-flex p-2 justify-content-between" method="POST">
        <h4>Привет, <span><?php echo $_SESSION['r_user'] ?></span></h4>
        <input type="submit" value="Logout" id="logout_btn" name="logout_btn" class="btn btn-danger btn-xs border-danger bg-light text-danger">
    </form>

    <?php
    // Если нажата кнопка "logout_btn", очищаем сессию "r_user" и "r_admin"
    if (isset($_POST['logout_btn'])) {
        unset($_SESSION['r_user']);
        unset($_SESSION['r_admin']);
        ?>
        <!-- Обновляем страницу -->
        <script>window.location.reload()</script>
        <?php
    }
    // Если в сессии нет записи "r_user"
} else {
    // Если нажата кнопка "login_btn"
    if (isset($_POST['login_btn'])) {
        // Если функция login() возвращает TRUE
        if (login($_POST['login'], $_POST['pass'])) { ?>
            <!-- Обновляем страницу -->
            <script>window.location.reload()</script>
            <?php
        }
        // Иначе показываем форму входа в аккаунт
    } else { ?>
        <form action="./index.php<?php if (isset($_GET['page'])) echo "?page=" . $_GET['page']; ?>"
              class="input-group input-group-sm pull-right p-2" method="POST">
            <input type="text" name="login" size="10" class="border px-2 btn btn-light" style='width: 200px; text-align: left' placeholder="login">
            <input type="password" name="pass" size="10" class="border px-2 btn btn-light" style='width: 200px; text-align: left' placeholder="password">
            <input type="submit" id="login_btn" value="Login" class="btn btn-xs border-info btn-info bg-light text-info" name="login_btn">
        </form>
        <?php
    }
}

