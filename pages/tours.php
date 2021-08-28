<h1 class="display-3 mt-5 mt-3 mb-4">Выбор тура</h1>

<?php
// Подключаемся к БД
$connect = connect();
// Получаем все страны из БД
$res = $connect->query("SELECT * FROM countries ORDER BY country");
?>

<form action="./index.php?page=1" method="post">

    <div class="row">
        <div class="col-10">
            <div class="form-group mb-3">
                <select name="country_id" class="form-control">
                    <option value="0">Выбор страны...</option>
                    <?php
                    // Перебираем все страны
                    while ($row = mysqli_fetch_array($res)) { ?>
                        <option value="<?php echo $row[0] ?>">
                            <?php echo $row[1] ?>
                        </option>
                        <?php
                    }
                    // Очищаем результаты запроса
                    mysqli_free_result($res);
                    ?>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group mb-3">
                <input type="submit" name="select_country" value="Выбрать страну"
                       class="btn btn-xs btn-primary form-control">
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['select_country'])) {
        $country_id = $_POST['country_id'];

        if ($country_id == 0) exit();
        $result = $connect->query("SELECT * FROM cities WHERE country_id=" . $country_id . " ORDER BY city");
        ?>

        <div class="row">
            <div class="col-10">
                <div class="form-group mb-3">
                    <select name="city_id" class="form-control">
                        <option value="0">Выбор города...</option>
                        <?php
                        while ($row = mysqli_fetch_array($result)) { ?>
                            <option value="<?php echo $row[0] ?>">
                                <?php echo $row[1] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group mb-3">
                    <input type="submit" name="select_city" value="Выбрать страну"
                           class="btn btn-xs btn-primary form-control">
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</form>

<?php

if (isset($_POST['select_city'])) {

    $city_id = $_POST['city_id'];
    $sel = 'SELECT co.country, ci.city, ho.hotel, ho.cost, ho.stars, ho.id 
        FROM hotels ho, cities ci, countries co WHERE ho.city_id=ci.id AND ho.country_id=co.id AND ho.city_id=' . $city_id;
    $res = $connect->query($sel);
    ?>

    <table class="table table-striped tbtours text-center">
        <thead style="font-weight: bold">
        <tr>
            <td>Отель</td>
            <td>Страна</td>
            <td>Город</td>
            <td>Цена</td>
            <td>Количество звезд</td>
            <td>Ссылка</td>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_array($res)) { ?>

            <tr id="<?php echo $row[1] ?>">
                <td><?php echo $row[2] ?></td>
                <td><?php echo $row[0] ?></td>
                <td><?php echo $row[1] ?></td>
                <td><?php echo "$row[3] ₽" ?></td>
                <td><?php echo $row[4] ?></td>
                <td>
                    <a href="<?php echo "./pages/hotel_info.php?hotel=$row[5]" ?>" target="_blank">
                        Посмотреть
                    </a>
                </td>
            </tr>

            <?php
        }
        ?>
        </tbody>
    </table>

    <?php
}