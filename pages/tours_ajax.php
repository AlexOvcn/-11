<h1 class="display-3 mt-5 mt-3 mb-4">Выбор тура</h1>

<?php
// Подключение к БД
$connect = connect();
?>

<div class="form-group mb-3">
    <!-- При выборе страны запускаем функцию showCities() -->
    <select name="country_id" id="country_id" class="form-control mb-3 btn-warning border-warning bg-light" onchange="showCities(this.value)">
        <option value="t">Выберите страну</option>

        <?php
        $res = $connect->query("SELECT * FROM countries");
        while ($row = mysqli_fetch_array($res)) { ?>
            <option value="<?php echo $row[0] ?>"><?php echo $row[1] ?></option>
            <?php
        }
        ?>
    </select>
    <!-- При выборе города запускаем функцию showHotels() -->
    <select name="city_id" id="city_list" class="form-control btn-warning hiddenInput border-warning bg-light" onchange="showHotels(this.value)"></select>
</div>
<!-- Контейнер для отображения отелей -->
<div id="h" class="form-group mb-3"></div>

<!-- Подключаем скрипт обработки AJAX-запросов -->
<script src="js/ajax.js"></script>