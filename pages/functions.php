<?php

// Подключение к базе данных
function connect($host='localhost', $user='root', $pass='', $dbname='site_2'): mysqli
{
    return new mysqli($host,$user,$pass, $dbname);
}

// Регистрация нового пользователя
function register($name, $pass, $email): bool
{
    // Убираем пробелы в начале и конце строки функцией trim()
    // Преобразуем специальные символы в HTML-сущности
    $name=trim(htmlspecialchars($name));
    $pass=trim(htmlspecialchars($pass));
    $email=trim(htmlspecialchars($email));

    // Проверка на пустые поля
    if ($name == '' || $pass == '' || $email == '') {
        echo "<h3/><span style='color:red;'>Заполните обязательные поля!</span><h3/>";
        return false;
    }
    // Проверка на количество символов
    if (strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
        echo "<h3/><span style='color:red;'>Количество символов должно быть от 3 до 30!</span><h3/>";
        return false;
    }
    // Подключение к базе данных
    $connect = connect();
    // Подготовка SQL-запроса для новой записи в БД
    $insert = "INSERT INTO users(login, pass, email, role_id) VALUES ('$name','".md5($pass)."','$email', 2)";
    // Отправка SQL-запроса
    $connect->query($insert);
    // Получаем все ошибки
    $err = $connect->errno;

    // Проверка существования ошибок
    if ($err){
        // Проверка на SQL-ошибку 1062 (если такая запись уже существует)
        if($err == 1062)
            echo "<h3/><span style='color:red;'>Пользователь под таким логином уже существует!</span><h3/>";
        else
            echo "<h3/><span style='color:red;'>Код ошибки: ".$err."!</span><h3/>";
        return false;
    }
    return true;
}

// Аутентификация пользователя
function login($name,$pass): bool
{
    // Убираем пробелы в начале и конце строки функцией trim()
    // Преобразуем специальные символы в HTML-сущности
    $name=trim(htmlspecialchars($name));
    $pass=trim(htmlspecialchars($pass));

    // Проверка на незаполненные поля
    if ($name=="" || $pass=="") {
        echo "<h3/><span style='color:red;'>Заполните обязательные поля!</span><h3/>";
        return false;
    }
    // Проверка на количество символов
    if (strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
        echo "<h3/><span style='color:red;'>Значение должно быть от 3 до 30 символов!</span><h3/>";
        return false;
    }
    // Подключение к базе данных
    $connect = connect();
    // Подготовка SQL-запроса для проверки соответствия логина и пароля
    $sel = "SELECT * FROM users WHERE login='".$name."' AND pass='".md5($pass)."'";
    // Отправка SQL-запроса
    $res = $connect->query($sel);
    // Если запись существует, записываем в сессию пользователя
    if($row = mysqli_fetch_array($res)) {
        $_SESSION['r_user'] = $name;
        // Если пользователь является админом, добавляем в сессию новую запись
        if($row[5] == 1) {
            $_SESSION['r_admin'] = $name;
        }
        return true;
    }
    // Если пользователь не найден, выводим сообщение
    else {
        echo "<h3/><span style='color:red;'>Нет такого пользователя!</span><h3/>";
        return false;
    }
}