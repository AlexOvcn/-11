<?php
include_once('classes.php');

// самостоятельно создать БД с названием site_3 и открыть данную стр в адресной строке
'CREATE DATABASE site_3';

// Подключение к БД
$pdo = Tools::connect();

// Подготовка запроса для таблицы "roles"
$roles = "CREATE TABLE roles(
    id INT NOT NULL auto_increment PRIMARY KEY, 
    role VARCHAR(32) NOT NULL UNIQUE) DEFAULT charset='utf8'";

// Подготовка запроса для таблицы "customers"
$users = "CREATE TABLE users(
    id INT NOT NULL auto_increment PRIMARY KEY,
    login VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(128) NOT NULL,
    role_id INT,
    FOREIGN KEY(role_id) REFERENCES roles(id) ON UPDATE CASCADE,
    discount INT,
    total INT,
    image_path VARCHAR(255)) DEFAULT charset='utf8'";

// Подготовка запроса для таблицы "categories"
$categories = "CREATE TABLE categories(
    id INT NOT NULL auto_increment PRIMARY KEY,
    category VARCHAR(64) NOT NULL UNIQUE) DEFAULT charset='utf8'";

// Подготовка запроса для таблицы "items"
$items = "CREATE TABLE items(
    id INT NOT NULL auto_increment PRIMARY KEY,
    item_name VARCHAR(128) NOT NULL,
    category_id INT,
    FOREIGN KEY(category_id) REFERENCES categories(id) ON UPDATE CASCADE,
    price INT NOT NULL,
    price_sale INT NOT NULL,
    info VARCHAR(256) NOT NULL,
    image_path VARCHAR(256) NOT NULL,
    action INT) DEFAULT charset='utf8'";

// Подготовка запроса для таблицы "images"
$images = "CREATE TABLE images(
    id INT NOT NULL auto_increment PRIMARY KEY,
    item_id INT,
    FOREIGN KEY(item_id) REFERENCES items(id) ON UPDATE CASCADE ON DELETE CASCADE,
    image_path VARCHAR(255)) DEFAULT charset='utf8'";

// Подготовка запроса для таблицы "sales"
$sales = "CREATE TABLE sales(
    id INT NOT NULL auto_increment PRIMARY KEY,
    user_name VARCHAR(32),
    item_name VARCHAR(128),
    price INT,
    price_sale INT,
    date_sale DATETIME) DEFAULT charset='utf8'";

// Подготовка запроса для таблицы "rating"
$rating = "CREATE TABLE rating(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    FOREIGN KEY(item_id) REFERENCES items(id) ON UPDATE CASCADE ON DELETE CASCADE,
    user_id INT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    rating_value INT NOT NULL) DEFAULT charset='utf8'";

// Подготовка запроса для ограниченного заполнения таблицы "rating" (создание уникального индекса из связи двух столбцов, чтобы один и тот же человек не смог оставить более одного отзыва на один товар)
$ratingUnique = "CREATE UNIQUE INDEX index_name ON rating(item_id, user_id)";

"SELECT AVG(rating_value) FROM rating WHERE item_id = '1'";
// Создание таблиц и БД
$pdo->exec($roles);
$pdo->exec($users);
$pdo->exec($categories);
$pdo->exec($items);
$pdo->exec($images);
$pdo->exec($sales);
$pdo->exec($rating);
$pdo->exec($ratingUnique);


// Подготовка запроса для добавления роли в БД
$addRoles = $pdo->prepare("INSERT INTO roles(role) VALUES ( :role )");

// Создаем роль "admin" и "customer"
$addRoles->execute(array('role' => 'admin'));
$addRoles->execute(array('role' => 'customer'));