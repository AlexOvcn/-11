<?php
// Подключаем файл "functions.php"
include_once('functions.php');
// Подключение к БД
$connect = connect();

$cid = $_POST['cid'];
$sel = 'SELECT id,hotel,stars,cost FROM hotels WHERE city_id=' . $cid;
$res = $connect->query($sel);
echo '<option value="">Выберите отель</option>';
// Перебираем результаты SQL-запроса
while ($row = mysqli_fetch_array($res)) {
    echo '<option value="'.$row[0].'">'.$row[1].'</options>';
}
// Очищаем результаты SQL-запроса
mysqli_free_result($res);