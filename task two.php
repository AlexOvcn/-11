<?php 

//* 4 Циклы. Часть 2

// 1 задание
echo '1) Задание <br> <br>';

// инициализация массива
$arrRandomNum = [];

// заполнение массива ста случайными числами в диапазоне от 0 - 99ти
for ($i = 0; $i < 100; $i++) {
    array_push($arrRandomNum, rand(0, 99));
}

// инициализация неопределенных переменных
$arrRandomMinValue;
$arrRandomMaxValue;

// проверка переменных на неопределенность и заполнение этих переменных соответствующим значением в соотв. с данным массивом чисел
foreach ($arrRandomNum as &$value) {
    if (!isset($arrRandomMinValue)) {
        $arrRandomMinValue = $value;
    } elseif ($value < $arrRandomMinValue) {
        $arrRandomMinValue = $value;
    }
    if (!isset($arrRandomMaxValue)) {
        $arrRandomMaxValue = $value;
    } elseif ($value > $arrRandomMaxValue) {
        $arrRandomMaxValue = $value;
    }
}

// трансформация массива в строковый тип данных
$strRandomNum = implode(" ", $arrRandomNum);

// вывод результатов
echo "<div style='width: 510px'> $strRandomNum </div><br> <br>";
echo "Maximum:  $arrRandomMaxValue <br> <br> Minimum:  $arrRandomMinValue <br> <br>";

// 2 задание
echo '2) Задание <br> <br>';

// добавление стилей для тега img
echo "<style> img{ width: 248px; height: 154px } </style>";

// вывод img
for ($i = 1; $i < 11; $i++) {
    echo "<img src='./images/image{$i}.jpg' alt='image'>";
} echo '<br> <br>';

// 3 задание
echo '3) Задание <br> <br>';

// создание и вывод таблицы умножения *очень сильно напомнило JSX
?>
<!-- основная таблица (оболочка) -->
<table>
    <tr>
        <?php
            // цикл таблиц на верхней строчке внешней таблицы
            for ($iter = 2; $iter < 7; $iter++) {
                ?>
                    <td>
                        <!-- таблицы в каждой ячейке строчек внешней таблицы -->
                        <table>
                            <?php
                                // каждая итерация - это одна строчка во внутренней таблице
                                for ($i = 1; $i < 11; $i++) {
                                    $res = $i * $iter;
                                    echo("<tr>
                                            <td>{$iter}*{$i}={$res}</td>
                                        </tr>");
                                }
                            ?>
                        </table>
                    </td>
                <?php
            }
        ?>
    </tr>
    <tr>
        <?php
            // цикл таблиц на нижней строчке внешней таблицы
            for ($iter = 7; $iter < 11; $iter++) {
                ?>
                    <td>
                        <table>
                            <?php
                                for ($i = 1; $i < 11; $i++) {
                                    $res = $i * $iter;
                                    echo("<tr>
                                            <td>{$iter}*{$i}={$res}</td>
                                        </tr>");
                                }
                            ?>
                        </table>
                    </td>
                <?php
            }
        ?>
    </tr>
</table>

<?php echo '<br> <br>';

// 4 задание
echo '4) Задание <br> <br>';

// создание и вывод таблицы
?>
<table>
    <tr style='background-color: red'>
        <td>Year</td>
        <td>Summ Start</td>
        <td>Summ End</td>
        <td>Profit</td>
    </tr>
    <?php
        // каждая итерация - это одна строчка в таблице
        $SummStart = 300;
        for ($i = 1; $i < 21; $i++) {
            $Profit = round(($SummStart * 0.2), 2);
            $SummEnd = $SummStart + $Profit;
            echo("<tr style='background-color: grey; color: white'>
                    <td>{$i}</td>
                    <td>{$SummStart}</td>
                    <td>{$SummEnd}</td>
                    <td>{$Profit}</td>
                </tr>");
            $SummStart = $SummEnd;
        }
    ?>
</table>
<?php echo '<br><br>';

// 5 задание (функция переворачивает числовое значение)
echo '5) Задание <br> <br>';

function reverseInt($int = null) {

    // проверка на непереданный аргумент
    if ($int === null) {
        echo "Не передано ни одного числа";
        return;
    }

    // преобразование в строку
    $int = strval($int);

    // инициализация переменных
    $sourseInt = '';
    $reverseInt = '';

    // заполнение переменных методом посимвольного перебора аргумента
    for ($key = 0; $key < strlen($int); $key++) {
        $sourseInt .= $int[$key];
        $reverseInt .= $int[abs($key - (strlen($int) - 1))];
    }

    // вывод переменных
    echo "<h1 style='color: red'> $sourseInt </h1>";
    echo "<h1 style='color: green'> $reverseInt </h1> <br> <br>";
}

reverseInt(347689);

// 6 задание (функция разбивает число на цифры, считает кол-во цифр в числе, находит большую из них и меньшую, их сумму, их среднее значение)
echo '6) Задание <br> <br>';

function parsingNumber($int = null) {

    // проверка на непереданный аргумент
    if ($int === null) {
        echo "число не передано";
        return;
    }

    // изменение типа данных на строковый
    $int = (string)$int;

    // иницилизация переменных
    $intLength = strlen($int);
    $divisionIntoNumbers = '';
    $intMax;
    $intMin;
    $intSumm = 0;
    $intAverage = 0;
    
    for ($i = 0; $i < $intLength; $i++) {

        // разделение на цифры
        if ($i === $intLength - 1) {
            $divisionIntoNumbers .= "{$int[$i]}";
        } else {
            $divisionIntoNumbers .= "{$int[$i]}, ";
        }
        
        // нахождение большей цифры в числе
        if (!isset($intMax)) {
            $intMax = $int[$i];
        } elseif ($intMax < $int[$i]) {
            $intMax = $int[$i];
        }

        // нахождение меньшей цифры в числе
        if (!isset($intMin)) {
            $intMin = $int[$i];
        } elseif ($intMin > $int[$i]) {
            $intMin = $int[$i];
        }

        // нахождение суммы цифр
        $intSumm += $int[$i];

        // нахождение среднего значения среди цифр (в примере почему то 4,85 похоже на поведение функции floor, но она округляет до целого числа)
        $intAverage = round(($intSumm / $intLength), 2);
    }

    // вывод результатов
    echo "<h1> Number is: $int </h1> <h2> Digits in the number: $divisionIntoNumbers </h2> <p> Count of digits: <b>{$intLength}</b>, Max:  <b>{$intMax}</b>, Min: <b>{$intMin}</b>, Summ: <b>{$intSumm}</b>, AVG: <b>{$intAverage}</b> </p>";
}

parsingNumber(5493256);