<?php
// Для создания БД нужно открыть эту страницу в адресной строке

include_once('functions.php');
$connect = connect();

// Запрос на создание таблицы
$db__site_2 = 'CREATE DATABASE site_2';

// Запрос на выбор БД
$db__site_2USE = 'USE site_2';

// Запрос для создания таблицы "Countries"
$countries = 'CREATE table countries(
id int not null auto_increment primary key,
country varchar(64) unique) default charset = "utf8"';

// Запрос для создания таблицы "Cities"
$cities = 'CREATE table cities(
id int not null auto_increment primary key,
city varchar(64),
country_id int,
foreign key(country_id) references countries(id) on delete cascade,
u_city varchar(128),
unique index u_city(city, country_id)) default charset="utf8"';

// Запрос для создания таблицы "Hotels"
$hotels = 'CREATE table hotels(
id int not null auto_increment primary key,
hotel varchar(64),
city_id int,
foreign key(city_id) references cities(id) on delete cascade,
country_id int,
foreign key(country_id) references countries(id) on delete cascade,
stars int,
cost int,
info varchar(1024)) default charset="utf8"';

// Запрос для создания таблицы "Images"
$images = 'CREATE table images(
id int not null auto_increment primary key,
image_path varchar(255),
hotel_id int,
foreign key(hotel_id) references hotels(id) on delete cascade) default charset="utf8"';

// Запрос для создания таблицы "Roles"
$roles = 'CREATE table roles(
id int not null auto_increment primary key,
role varchar(32)) default charset="utf8"';

// Запрос для создания таблицы "Users"
$users = 'CREATE table users(
id int not null auto_increment primary key,
login varchar(32) unique,
pass varchar(128),
email varchar(128),
discount int,
role_id int,
foreign key(role_id) references roles(id) on delete cascade,
avatar mediumblob,
comment_id int) default charset="utf8"';

// Запрос для создания таблицы "Comments"
$comments = 'CREATE table comments(
id int not null auto_increment primary key,
user_id int not null,
foreign key(user_id) references users(id) on delete cascade,
user_name varchar(15) not null,
hotel_id int not null,
foreign key(hotel_id) references hotels(id) on delete cascade,
sending_time DATETIME not null,
comments varchar(1024) not null) default charset="utf8"';

// Запрос для связи users(comment_id) с comments(id)
$usersCommentId_commentsId = 'ALTER TABLE `users` ADD FOREIGN KEY (`comment_id`) REFERENCES `comments`(`id`) ON DELETE CASCADE';

// Запрос на первоначальное заполнение таблицы roles
$insertIntoRoles = 'INSERT INTO `roles` (`id`, `role`) VALUES ("1", "admin"), ("2", "user")';

// Создаем массив запросов
$queries = array($db__site_2, $db__site_2USE, $countries, $cities, $hotels, $images, $roles, $users, $comments, $usersCommentId_commentsId, $insertIntoRoles);
foreach ($queries as $key => $query) {
    $connect->query($query);
    $err = mysqli_connect_errno();
    if ($err) {
        echo 'Ошибка запроса ' . ($key + 1) . ':' . $err . '<br>';
        exit();
    }
}