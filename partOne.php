<?php

//* 7 ООП, регулярные выражения часть 1

session_start();
if (!isset($_SESSION['arrayProducts'])) {
    $_SESSION['arrayProducts'] = [];
}
class Product {
    public $name;
    public $price;

    function __construct($_name, $_price) {
        $this->name = $_name;
        $this->price = $_price;
    }

    public function getProduct() {
        echo "<h2>{$this->name}: \${$this->price}</h2>";
    }
    public function  searchByName($_arrayProducts, $_nameProduct) {
        $successfulSearch = false;
        foreach($_arrayProducts as $value) {
            if ($_nameProduct === $value->name) {
                $value->getProduct();
                $successfulSearch = true;
                return;
            } else {
                $successfulSearch = false;
            }
        }
        if ($successfulSearch === false) {
            echo 'такого продукта не найдено';
        }
    }
}

if (count($_POST)) {

    if (isset($_POST['add'])) {
        $_SESSION['add'] = $_POST['add'];
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['price'] = $_POST['price'];
    }
    if (isset($_POST['search'])) {
        $_SESSION['search'] = $_POST['search'];
        $_SESSION['searchName'] = $_POST['searchName'];
    }
    
    header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    exit();
}

?> 
<form action="./partOne.php" method='POST'>
    <input type="text" name="name" required placeholder='Имя продукта'>
    <input type="text" name="price" required placeholder='Цена продукта'>
    <button type='submit' name='add' value='true'>Добавить</button>
</form>
<?php

if (isset($_SESSION['add']) && $_SESSION['add'] === 'true') {
    array_push($_SESSION['arrayProducts'], new Product($_SESSION['name'], $_SESSION['price']));
    $_SESSION['add'] = 'false';
}
if (!empty($_SESSION['arrayProducts'])) {
    echo "Все продукты находящиеся в массиве:";
    foreach($_SESSION['arrayProducts'] as $value) {
        $value->getProduct();
    }
} else {
    echo 'Здесь будут показаны ваши продукты <br>';
}


?>
<br>
<form action="./partOne.php" method='POST'>
    <input type="text" name="searchName" required placeholder='Имя продукта'>
    <button type='submit' name='search' value='true'>Поиск</button>
</form>
<?php

if (isset($_SESSION['search']) && $_SESSION['search'] === 'true') {
    if (!isset($_SESSION['arrayProducts'][0])) {
        echo 'массив продуктов пуст';
    } else {
        $_SESSION['arrayProducts'][0]->searchByName($_SESSION['arrayProducts'], $_SESSION['searchName']);
    }
    
    $_SESSION['search'] = 'false';
}