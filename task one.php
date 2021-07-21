<?php 

$name = 'Alex';

echo '1) Hello! My name is ' . $name . '</br>' . '</br>';

$age = 23;

echo "2) I'm " . $age . '</br>' . '</br>';

$a = 5;
$b = 10;

echo '3) Результат операции с использованием двух переменных' . '</br> </br>' . 'a = ' . $a . '</br>' . 'b = ' . $b . '</br>' . 'a + b = ' . $a + $b . '</br>' . '</br>';

echo '4) Две переменных из прошлого задания поменяны местами без исп. 3ей переменной' . '</br> </br>' . 'a = ' . $a = $b . '</br>' . 'b = ' . $b = $a . '</br>' . 'a + b = ' . $a + $b . '</br>' . '</br>';

echo '5)' . '</br> </br>' . ("<p style='font-size: 18px; margin: 0 0 18px 0'>Некий вопрос с одним правильным вариантом ответа</p><label style='color: red'><input type='radio' name='rad'/> Некий неправильный ответ</label><br><label style='color: green'><input type='radio' name='rad'/> Некий правильный ответ</label><br><label style='color: red'><input type='radio' name='rad'/> Некий неправильный ответ</label><br><label style='color: red'><input type='radio' name='rad'/> Некий неправильный ответ</label><br>") . ("<p style='font-size: 18px'>Некий вопрос с несколькими правильными вариантами ответа</p><label style='color: red'><input type='checkbox'/> Некий неправильный ответ</label><br><label style='color: green'><input type='checkbox'/> Некий правильный ответ</label><br><label style='color: red'><input type='checkbox'/> Некий неправильный ответ</label><br><label style='color: green'><input type='checkbox'/> Некий правильный ответ</label><br>") . ("<p style='font-size: 18px'>Некий вопрос</p><textarea placeholder='Нужно написать некий развернутый ответ' style='resize: none' rows='10' cols='45' ></textarea> <br> <br>");

$background_color = 'background-color: blue; ';
$color = 'color: red; ';
$width = 'width: 100px; ';
$height = 'height: 100px; ';

$tag = "<div style='" . $background_color . $color . $width . $height ."'> Hello </div>" ;

echo '6) </br> </br>' . $background_color . '<br>' . $color . '<br>' .  $width . '<br>' .  $height . '<br>' . '<br>'.  $tag;

?>