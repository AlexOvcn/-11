<?php 

//* 3 Циклы. Часть 1

// 1 задание
echo '1) Задание <br> <br>';

function oddNumbers($from = 0, $to = null) {

    // эти переменные - крючки, чтобы цикл распознал первую итерацию
    $firstIter1 = true;
    $firstIter2 = true;

    // инициализация переменной со средним значением
    $averageValue = 0;

    // вывод  чисел по порядку
    function firstCycle($from, $to, $firstIter1, $averageValue) {
        $summValues = 0;
        $digitCounter = 0;
        for ($from; $from <= $to; $from++) {
            $oddNum;
            if ($from % 2 !== 0) {
                $digitCounter += 1;
                $summValues += $from;
                $oddNum = $from;
                if ($firstIter1) {
                    echo "<span style='font-size: 29px; color: red'>{$oddNum}</span>";
                    $firstIter1 = false;
                } else {
                    echo "<span style='font-size: 29px; color: red'>, {$oddNum}</span>";
                }
            } else {
                continue;
            }
        }
        return $averageValue = $summValues / $digitCounter;
    }
    $averageValue = firstCycle($from, $to, $firstIter1, $averageValue);

    // вывод среднего числа
    echo "<br>AVG = {$averageValue}</br>";

    // вывод чисел справа налево
    function secondCycle($from, $to, $firstIter2) {
        for ($to; $to >= $from; $to--) {
            $oddNum2;
            if ($to % 2 !== 0) {
                $oddNum2 = $to;
                if ($firstIter2) {
                    echo "<span style='font-size: 29px; color: red'>{$oddNum2}</span>";
                    $firstIter2 = false;
                } else {
                    echo "<span style='font-size: 29px; color: red'>, {$oddNum2}</span>";
                }
            } else {
                continue;
            }
        }
    }
    secondCycle($from, $to, $firstIter2);
    echo "<br><br>";
}

oddNumbers(0, 30);

// 2 задание
echo '2) Задание <br> <br>';

function searchByFourDigitNumbers($from, $to) {

    // инициализация переменных
    $mirroredNumber = 0;
    $pairNumber = 0;
    $notPairNumber = 0;
    $orderedNumber = 0;

    // заполнение переменных
    for ($i = $from; $i <= $to; $i++) {
        
        // изменение числового типа данных на строчный
        $int = strval($i);

        // условия отбора чисел и дальнейшая инкрементация к соотв. переменным
        if ($int[0] === $int[3] && $int[1] === $int[2]) {
            $mirroredNumber += 1;
        }
        if ($int % 2 === 0) {
            $pairNumber += 1;
        }
        if ($int % 2 !== 0) {
            $notPairNumber += 1;
        }
        if ($int[0] > $int[1] && $int[1] > $int[2] && $int[2] > $int[3] && $int[3] + 3 == $int[0]) {
            $orderedNumber += 1;
        }
    }

    // вывод результатов
    echo "Mirrored number: {$mirroredNumber} <br> Pair number: {$pairNumber} <br> Not pair number: {$notPairNumber} <br> Ordered number: {$orderedNumber} <br> <br>";
}
searchByFourDigitNumbers(1000, 9999);

// 3 задание
echo '3) Задание <br> <br>';

//создание шаров
function circles($width, $height, $color, $quantity) {
    echo("<style>
            .clearfix::before, .clearfix::after{
                content: '';
                display: table;
                clear: both;
            }
            .circle{
                float: left;
                width: {$width}px;
                height: {$height}px;
                border-radius: 50%;
                background-color: {$color}
            }
        </style>");
        ?>
            <div class='clearfix'> <!--  доп слой чтобы использовать clearfix -->
                <?php
                    for ($i = 0; $i < $quantity; $i++) {
                        echo "<div class='circle'></div>";
                    }
                ?>
            </div>
        <?php
}
circles(50, 50, 'blue', 10); // ширины, высота, цвет, кол-во шаров
echo "<br><br>";

// 4 задание
echo '4) Задание <br> <br>';

function fromBinaryToHexadecimal($int) {
    $Binary = strval($int);              // перевод числового типа в строковый
    $decimal = bindec($Binary);          // из двоичной в десятиричную систему
    $hexadecimal = dechex($decimal);     // из десятиричной в шестнадцатиричную систему
    return [$Binary , $hexadecimal];
}

// результативный массив в котором первый ключ - нач. значение, а второй - конечное
$resultArray = fromBinaryToHexadecimal(110110);

// вывод результатов
echo "Number: {$resultArray[0]} <br><br> Converted: $resultArray[1] <br><br>";

// 6 задание
echo '6) Задание <br> <br>';

function calendar($month = 1, $year = 1970) {

    // инициализация переменных
    $numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $numberOfWeeksInMounth = ceil($numberOfDaysInMonth / 7) + 1;
    $dateTime =  strtotime("{$year}-{$month}-01");
    $indexDayOfWeek = date("w", $dateTime);
    $day;

    // расчет отступов в начале мес. и наз. переменной (подгон выходных дней для правой стороны)
    if ($indexDayOfWeek == 0) {
        $day = 1 - ($indexDayOfWeek + 6);
    } else {
        $day = 1 - ($indexDayOfWeek - 1);
    }

    // определение стилей
    echo("<style>
            .normal {
                color: black;
            }
            .weekend {
                color: red;
            }
            .normal:hover {
                background-color: black;
                color: white;
                cursor: pointer;
            }
            .weekend:hover {
                background-color: red;
                color: white;
                cursor: pointer;
            }
        </style>");

    // создание таблицы (таблица состоит из двух циклов: первый создает строку(<tr>) недели; второй дочерний цикл заполняет строку днями(<td>))
    ?>
        <table>
            <?php
                for ($i = 0; $i < $numberOfWeeksInMounth; $i++) {
                    if ($day > $numberOfDaysInMonth) {
                        break;
                    }
                    ?>
                        <tr>
                            <?php
                                for ($it = 1; $it < 8; $it++) {
                                    $dateTime =  strtotime("{$year}-{$month}-{$day}");
                                    $indexDayOfWeek = date("w", $dateTime);
                                    if ($day > $numberOfDaysInMonth) {
                                        break;
                                    }
                                    if ($day < 1) {
                                        ?>
                                            <td>
                                                <?php
                                                    $day++;
                                                ?>
                                            </td>
                                        <?php
                                    } elseif ($indexDayOfWeek == 6 || $indexDayOfWeek == 0) {
                                        ?>
                                            <td class='weekend'>
                                                <?php
                                                    echo $day++;
                                                ?>
                                            </td>
                                        <?php
                                    } else {
                                        ?>
                                            <td class='normal'>
                                                <?php
                                                    echo $day++;
                                                ?>
                                            </td>
                                        <?php
                                    }
                                }
                            ?>
                        </tr>
                    <?php
                }
            ?>
        </table>
    <?php
}
calendar(7, 2021);  // calendar(месяц, год)

// 7 задание
echo '<br> <br> 7) Задание (во втором листе имеется похожее ДЗ, но построены по разному) <br> <br>';

// определение стилей
echo "<style> img{ width: 248px; height: 154px } .div2{ content: ''; display: table; clear: both } </style>";

// вывод img (2 цикла: один создает див, а другой заполняет его картинками)
$img = 1;
for ($iter = 0; $iter < 2; $iter++) {
    ?> 
        <div class='div2'>
            <?php
                for ($i = 1; $i < 6; $i++) {
                    echo "<img src='./images/image{$img}.jpg' alt='image'>";
                    $img++;
                }
            ?> 
        </div>
    <?php
}
