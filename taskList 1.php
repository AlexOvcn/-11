<?php

//* 6 Функции и формы. Часть 1

// 1 задание
echo '1) Задание <br> <br>';

function mathematicalExpression($intOne, $action, $intTwo) {

    $expression = "{$intOne} {$action} {$intTwo}";
    $pattern = "/^[^+\-*\/]$/";

    // регулярное выражение которое находит все что не является ( + - * / )
    if (preg_match($pattern, $action) || strlen($action) === 0 || strlen($action) > 1) {
        echo "<p> $expression = <span style='color:red'>Функция принимает только односимвольный арифметический знак действия!</span> </p>";
        return;
    }

    // на ноль делить нельзя
    if ($intTwo === 0 && $action === '/') {
        echo "<p> $expression = <span style='color:red'>Делить на ноль не получиться!</span> </p>";
        return;
    }

    // eval(запускает код который находится в строковом типе данных)
    $result = eval('return ' .$expression.';');
    echo "<p> $expression = $result </p>";
}
mathematicalExpression(15, '+', 20);
mathematicalExpression(12, '/', 0);
mathematicalExpression(4, '@', 6);

// 2 задание
echo '<br> 2) Задание <br> <br>';

function HTML_elem($tagName, $classStyle, $tagContent) {

    // функция десктруктуризирует массив в строку
    function styles($classStyle) {
        $styles = '';
        for ($i = 0; $i < count($classStyle); $i++) {
            $styles .= "$classStyle[$i]";
            if ((count($classStyle)-1) === $i) {
                return $styles;
            }
        }
    }

    // создание HTML структуры
    echo "<style> .{$tagName} {".styles($classStyle)."}</style>";
    echo "<h3 class='{$tagName}'>{$tagContent}</h3>";
}

$classStyle = ["color:yellow;", "margin:20px;", "background-color:red;"];
HTML_elem('element1', $classStyle, 'Привет');

// 3 задание
echo '<br> 3) Задание <br> <br>';

function menuCreator($menuItems, $menuItemStyles, $menuItemStylesAction, $actionOnTheItem) {

    // функция десктруктуризирует массив в строку
    function stylesForMenu($menuItemStyles) {
        $styles = '';
        for ($i = 0; $i < count($menuItemStyles); $i++) {
            $styles .= "$menuItemStyles[$i]";
            if ((count($menuItemStyles)-1) === $i) {
                return $styles;
            }
        }
    }
    echo "<style> .item {".stylesForMenu($menuItemStyles)."}  .item:{$actionOnTheItem} {".stylesForMenu($menuItemStylesAction)."}</style>";

    echo "<ul style='list-style:none; overflow: hidden'>";

    // цикл создает пункты меню
    for ($i = 0; $i < count($menuItems); $i++) {
        echo "<li class='item' tabindex='-1'>{$menuItems[$i]}</li>";
    }
    echo "</ul>";


}

$menuItems = ["Home", "About", "Contact", "Photo", "Blog"];
$menuItemStyles = ["color:yellow;", "padding:20px;", "background-color:green;", "float:left;", "user-select: none;", "transition: 0.3s;", "cursor: pointer"];
$menuItemStylesAction = ["color:green;", "background-color:yellow;"];

menuCreator($menuItems, $menuItemStyles, $menuItemStylesAction, 'focus');

// 4 задание
echo '<br> 4) Задание <br> <br>';

function randomColorGenerator() {

    $hex = '';
    for ($i = 0; $i < 6; $i++) {

        // берем рандомное число
        $randInt =  rand(0, 15);

        // конвертация из 10тиричной в 16тиричную систему
        $conversionArray = ["10"=>"A", "11"=>"B", "12"=>"C", "13"=>"D", "14"=>"E", "15"=>"F"];
        $randIntToString = (string) $randInt;
        if ($randInt > 9) {
            $hex .= $conversionArray[$randIntToString];
            continue;
        }
        $hex .= $randIntToString;
    }
    return $hex;
}

// создание блока 
echo "<div style='background-color:#".randomColorGenerator()."; width:50px;height:50px'></div>";

// 5 задание
echo '<br> <br> 5) Задание <br> <br>';

// стили для таблицы и картинки фигуры
echo "<style>
            * {
                box-sizing:border-box;
            }
            td, img {
                width:50px;
                height:50px;
                padding: 0;
            }
            table {
                border: 1px solid black;
                border-collapse: collapse;
            }
            .imgInTable {
                position: absolute;
                top: 0px;
                left: 0px;
            }
            .wrap {
                position: relative;
            }
    </style>";

// создание таблицы
function chessboard($column, $line, $nameOfFigure) {

    if ($column < 1 || $column > 8) {
        $column = 1;
    }
    if ($line < 1 || $line > 8) {
        $line = 1;
    }

    ?><div class="wrap"> <table> <?php
        for ($i = 0; $i < 8; $i++) {
            $from = ($i % 2 === 0) ? 0 : 1;
            $to = ($i % 2 === 0) ? 8 : 9;
            ?> <tr> <?php
                for ($iter = $from; $iter < $to; $iter++) {
                    $background = ($iter % 2 === 0) ? 'rgb(245, 245, 245)' : 'black';
                    ?> <td style="background-color:<?php echo $background ?>"> <?php
                    ?> </td> <?php
                }
            ?> </td> <?php
        }
    ?> </table>
        <div class='imgInTable' style="left:<?php echo ($column - 1) * 50.4?>px; top:<?php echo ($line - 1) * 50.4?>px">
            <img src="img/<?php echo $nameOfFigure; ?>.png" alt="">
        </div>
    </div> <?php
}

chessboard(2, 2, 'horse'); //  колонна, строка, назв. фигуры