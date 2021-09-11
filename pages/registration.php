<div class="mt-3 mb-3">
    <h1 class="h1">Регистрация</h1>
</div>
<?php
require_once 'classes.php';

if (!isset($_POST['register'])) {
    ?>
    <form action="./index.php?page=3" method="POST" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="login" class="form-label">Логин:</label>
            <input type="text" class="form-control" name="login">
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-label">Пароль:</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group mb-3">
            <label for="confirm_password" class="form-label">Повторите пароль:</label>
            <input type="password" class="form-control" name="confirm_password">
        </div>
        <div class="form-group mb-3">
            <label for="image_path" class="form-label">Выберите изображение:</label>
            <input type="file" class="form-control" name="image_path" required>
        </div>
        <button type="submit" class="btn btn-primary" name="register">Регистрация</button>
    </form>
    <?php
} else {
    if (!is_dir("./img")) { // если папки img не существует
        mkdir("./img", 0777, true); // пытаемся ее создать второй и третий аргумент доп настройки(читай докум.)
    }
    // Загрузка изображения
    if (is_uploaded_file($_FILES['image_path']['tmp_name'])) {
        $path = "img/" . $_FILES['image_path']['name'];
        move_uploaded_file($_FILES['image_path']['tmp_name'], $path);
    }
    // Регистрация пользователя
    if (Tools::register($_POST['login'], $_POST['password'], $path, $_POST['confirm_password'])) {
        ?>
        <h3 class="alert alert-success">Новый пользователь добавлен!</h3>

        <?php
    }
}