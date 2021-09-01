<?php

//* 7 ООП, регулярные выражения часть 2

class Product {
    public $Name;
    public $Price;
    public $Description;
    public $Brand;

    function __construct($_name, $_price, $_description, $_brand) {
        $this->Name = $_name;
        $this->Price = $_price;
        $this->Description = $_description;
        $this->Brand = $_brand;
    }
    function getProduct() {
        reset($this);
        $firstKey = key($this);
        foreach($this as $param => $value) {
            if ($param === $firstKey) {
                echo "$param: $value";
                continue;
            }
            echo ", $param: $value";
        }
    }
}

class Phone extends Product {

    function __construct($_name, $_price, $_description, $_brand, $_cpu, $_rum,$_countSim, $_hdd, $_os) {
        parent::__construct($_name, $_price, $_description, $_brand);
        $this->CPU = $_cpu;
        $this->RAM = $_rum;
        $this->count_SIM = $_countSim;
        $this->HDD = $_hdd;
        $this->OS = $_os;
    }
}

class Monitor extends Product {

    function __construct($_name, $_price, $_description, $_brand, $_diagonal, $_frequency,$_ports) {
        parent::__construct($_name, $_price, $_description, $_brand);
        $this->Diagonal = $_diagonal;
        $this->Frequency = $_frequency;
        $this->Ports = $_ports;
    }
}

$phone1 = new Phone('iPhone12', "2000$", 'bad phone', 'apple', 'A12', '1GB', 1, "512MB", 'ios');
$phone2 = new Phone('Galaxy S20', "1100$", 'norm phone', 'samsung', 'snapdragon 550', '4GB', 2, "1TB", 'android');
$phone3 = new Phone('NOKIA X20', "500$", 'good phone', 'nokia', 'snapdragon 880', '12GB', 2, "4TB", 'android');
$monitor1 = new Monitor("GHSEJ21", "12345$", "good monik", "xiaomi", 24, "144Hz", "HDMI, DisplayPort");
$monitor2 = new Monitor("GMO2000", "20000$", "bad monik", "apple", 23.8, "55Hz", "VGA, HDMI, DisplayPort");

function getProductAll(...$products) {
    foreach($products as $key) {
        echo "<h2>";
        echo $key->getProduct() . "</h2>";
    }
}

getProductAll($phone1, $phone2, $phone3, $monitor1, $monitor2);

