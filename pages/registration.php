<h3>Форма регистрации</h3>
<?php

if (!isset($_POST['reg_btn'])) {?>

    <form action="index.php" method='POST' class='form registration-form'>
        <label>
            <span>E-mail:</span>
            <input type="email" name='email'>
        </label>
        <label>
            <span>Логин:</span>
            <input type="text" name='reg_login'>
        </label>
        <label>
            <span>Пароль:</span>
            <input type="password" name='reg_password'>
        </label>
        <label>
            <span>Подтверждение пароля:</span>
            <input type="password" name='reg_confirm_password'>
        </label>
        <button type="submit" name='reg_btn' value='4' class='reg_btn'>Зарегистрироваться</button>
    </form>
    <?php
} else {
    if (register($_POST['reg_login'], $_POST['reg_password'], $_POST['email'], $_POST['reg_confirm_password'])) {
        echo '<h3><span style="color:green;">Пользователь добавлен!</span></h3>';
    }
}