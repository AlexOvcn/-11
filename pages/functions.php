<?php

$users = 'pages/users.txt';

function register($name, $pass, $email, $confirm_password) {
    
    $name = trim(htmlspecialchars($name)); // trim удаляет пробелы с начала и конца строки
    $pass = trim(htmlspecialchars($pass)); // htmlspecialchars превращает весь текст в просто текст
    $email = trim(htmlspecialchars($email));
    $confirm_password = trim(htmlspecialchars($confirm_password));

    // проверка на пустоту
    if ($name == '' || $pass == '' || $email == '' || $confirm_password == '') {
        echo '<h3><span style="color:red;">Заполните все обязательные поля</span></h3>';
        return false;
    }

    // проверка на вводимую длину
    if(strlen($name) < 3 || // strlen считает кол-во символов в строке
    strlen($name) > 20 ||
    strlen($pass) < 3 ||
    strlen($pass) > 20) {
        echo '<h3><span style="color:red;">Кол-во символов должно быть от 3 до 20</span></h3>';
        return false;
    }

    // проверка на уникальность логина
    global $users;
    $file = fopen($users, 'a+'); // fopen открывает файл второй аргумент это алгоритм поведения (см. в док.) (открытие)
    while ($line = fgets($file, 128)) { // fgets получаем содержимое открытого ранее файла, второй аргумент это кол-во первых считываемых символов (чтение), цикл while позволяет за каждую итерацию получать новую строку txt файла
        $readName = substr($line, 0, strpos($line, ':')); // substr возвращает строку от и до указанного индекса буквы, strpos дает индекс первого вхождения указанного символа или строки
        if ($readName == $name) {
            echo '<h3><span style="color:red;">Такой логин уже существует!</span></h3>';
            return false;
        }
    }

    // проверка для подтверждения пароля
    if ( $pass !== $confirm_password ) {
        echo '<h3><span style="color:red;">Поля с паролем и подтверждением пароля не совпадают!</span></h3>';
        return false;
    }

    // добавление нового пользователя
    $line = "{$name}:" . md5($pass) . ":{$email}\r\n"; // md5 это шифровка пороля \n – это символ новой строки, а \r – возврат каретки
    fputs($file, $line); // указываем файл с которым собираемся взаимодействовать а вторым аргументом указываем что хотим внести в него (запись)
    fclose($file); // закрытие указанного файла (закрытие)
    return true;
}

// нового пользователя скрипт добавляет в текстовый файл 'pages/users.txt' где значения полей через двоеточие расположены друг за другом в строчку, при каждом добавлении пользователя срабатывает цикл который читает каждую строчку слева направо, а первым значением до первого вхождения двоеточия является логин который он сверяет с введенным логином, а пароль находится в захешированном виде

function login($login, $pass) {
    $pass = md5($pass);
    global $users;
    $file = fopen($users, 'a+');
    while ($line = fgets($file, 128)) {
        $loginFromFile = substr($line, 0, strpos($line, ':'));
        $indent = strlen($login)+1;
        $passFromFile = substr($line, $indent, (strpos($line, ':', $indent) - $indent));
        if ($login === $loginFromFile || $pass === $passFromFile) {
            $_SESSION['signIn'] = true;
            $_SESSION['failedLogin'] = false;
            $_SESSION['signIn_name'] = $login;
            echo "<script>alert('Вы успешно зашли')</script>";
            return true;
        }
    }
    fclose($file);
    $_SESSION['signIn'] = false;
    $_SESSION['failedLogin'] = true;
    echo "<script>alert('Неправильно введенные данные')</script>";
    return false;
}