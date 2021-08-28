<?php
// Подключаем файл "functions.php"
include_once('functions.php');
// Подключение к БД
$connect = connect();
// Получаем ID города из результатов GET-запроса
$city_id = $_GET['cid'];
// Готовим SQL-запрос
$select = 'SELECT * FROM cities WHERE country_id='.$city_id;
// Отправляем SQL-запрос
$res = $connect->query($select);
echo '<option value="" >Выберите город</option>';
// Перебираем результаты SQL-запроса
while ($row = mysqli_fetch_array($res)) {
    echo '<option value="'.$row[0].'">'.$row[1].'</options>';
}
// Очищаем результаты SQL-запроса
mysqli_free_result($res);