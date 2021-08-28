<h1 class="display-3 mt-5 mt-3 mb-4">Регистрация</h1>
<?php

require_once 'functions.php';

if (!isset($_POST['reg_btn'])) {
    ?>
    <form action="./index.php?page=3" method="post" class="input-group">
        <div class="row">
            <!-- Логин -->
            <div class="col-12">
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-12">
                            <input type="text" id="login" class="form-control border-primary bg-light" name="login" placeholder='Ваш логин'>
                        </div>
                    </div>
                </div>
            </div>
            <!-- E-mail -->
            <div class="col-12">
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-12">
                            <input type="email" id="email" class="form-control border-primary bg-light" name="email" placeholder='Ваша почта'>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Пароль -->
            <div class="col-12">
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-12">
                            <input type="password" id="password" class="form-control border-primary bg-light" name="password" placeholder='Ваш пароль'>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Повтор пароля -->
            <div class="col-12">
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-12">
                            <input type="password" id="confirm_password" class="form-control border-primary bg-light" name="confirm_password" placeholder='Подтвердите пароль'>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100 p-3" name="reg_btn">Регистрация</button>
                </div>
            </div>
        </div>
    </form>
    <?php
} else {
    if (register($_POST['login'], $_POST['password'], $_POST['email'])) {
        echo "<h3/><span style='color:green;'>Новый пользователь добавлен!</span><h3/>";
    }
}
?> 