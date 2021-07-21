<?php 

    //* 2

// 1 задание

$numOne = 10;
$numTwo = 5;

echo '1) <br> <br>' . 'numOne = ' . $numOne . '<br>' . 'numTwo = ' . $numTwo . '<br>' . '<br>';

if ($numOne % $numTwo === 0) {
    echo 'Первое число кратно второму <br><br>';
} else {
    echo 'Первое число не кратно второму <br><br>';
};

// 2 задание

$numOne = 22;
$numTwo = 18;

echo '2) <br> <br>' . 'numOne = ' . $numOne . '<br>' . 'numTwo = ' . $numTwo . '<br>' . '<br>';

switch ($numOne > $numTwo) {
    case true:
        echo 'Первое число больше, его квадрат равен ' . $numOne ** 2 . '<br>' . '<br>';
        break;
    
    case false:
        echo 'Второе число больше, его квадрат равен ' . $numTwo ** 2 . '<br>' . '<br>';
        break;
};

// 3 задание

echo '3) <br> <br>';

$currentMonth = date("n");

echo "<p style='margin: 0'> Month = " . $currentMonth . '</p>';
switch ($currentMonth) {
    case 4:
    case 6:
    case 9:
    case 11:
        echo "<p style='margin: 0'> Days in the month: 30 </p> <br> <br>";
        break;
    case 2:
        28;
        break;
    
    default:
        echo "<p style='margin: 0'> Days in the month: 31 </p> <br> <br>";
        break;
}

// 4 задание

echo '4) <br> <br>';

$currentYear = date("Y");
$allLeapYears = array();

echo "<p style='margin: 0'> Year = " . $currentYear . '</p>';
for ($i = 2020; $i < 2100; $i += 4) {
    array_push($allLeapYears, $i);
};
$res;
foreach ($allLeapYears as &$value) {
    if ($value === $currentYear) {
        $res = "<p style='margin: 0'>" . $currentYear . " is leap-year</p> <br> <br>";
        break;
    } else {
        $res = "<p style='margin: 0'>" . $currentYear . " isn't leap-year</p> <br> <br>";
    }
}

echo $res;

// 5 задание

$numOne = 9;
$numTwo = 18;

echo '5) <br> <br>' . 'numOne = ' . $numOne . '<br>' . 'numTwo = ' . $numTwo . '<br>' . '<br>';

if (($numOne % 3 === 0 && $numTwo % 3 === 0) && ($numOne !== 0 && $numTwo !== 0)) {
    echo 'Оба числа кратны 3ем и их сумма = '. $numOne + $numTwo . '<br><br>';
} elseif ($numOne !== 0 && $numTwo !== 0) {
    echo 'Одно или оба числа не кратны 3ем и отношение первого ко второму числу = ' . $numOne / $numTwo . '<br><br>';
} else {
    echo 'Неккоректный ввод <br><br>';
}

// 6 задание

$session_id = 0;

echo '6) <br> <br>';

$statusSessionID = 'Session ID = ' . $session_id;

if ($session_id === 0) {
    echo '<h2 style="margin: 0"> Please register </h2> <br> <br>' . $statusSessionID . '<br> <br> <input type="text" placeholder="Login"><br><input type="password" placeholder="Password"> <br> <br>';
} elseif ($session_id === 1) {
    echo '<h2 style="margin: 0"> You are already registered </h2> <br> <br>' . $statusSessionID . '<br> <br> <a href="#">Login</a> <br> <br>';
}

// 7 задание

echo '7) <br> <br>';

$color = 'green';
$top = 100;
$left = 100;

if ($left > 500) {
    $left = 500;
} if ($top > 500) {
    $top = 500;
}

echo 'X = ' , $left , ', Y = ' , $top , ', Color = ' , $color , "<div style='position: relative; top: {$top}px; left: {$left}px; width: 50px; height: 50px; background-color: $color'></div>";

?>