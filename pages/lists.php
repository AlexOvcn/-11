<?php
include_once('classes.php');

$cat = $_POST['category'];
$pdo = Tools::connect();
// Получение всех товаров по ID категории
$items = Item::getItems($cat);
if ($items == null) exit();
// Отображение выбранных товаров
foreach ($items as $item) {
    $item->draw();
}
