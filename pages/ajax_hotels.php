<?php
// Подключаем файл "functions.php"
include_once('functions.php');
// Подключение к БД
$connect = connect();

$cid = $_POST['cid'];
$sel = 'SELECT id,hotel,stars,cost FROM hotels WHERE city_id=' . $cid;
$res = $connect->query($sel);
?>

    <table class="table table-striped slowShowing" id="table1">
        <tr>
            <th>Отель</th>
            <th>Стоимость</th>
            <th>Количество звезд</th>
            <th>Описание</th>
        </tr>

        <?php
        while ($row = mysqli_fetch_array($res)) { ?>
            <tr>
                <td><?php echo $row[1] ?></td>
                <td><?php echo $row[3] ?></td>
                <td><?php echo $row[2] ?></td>
                <td>
                    <a href="<?php echo "./pages/hotel_info.php?hotel=$row[0]" ?>"
                    target="_blank" class="btn btn-default btn-xs text-primary" style='padding-left: 0'>Подробнее...</a>
                </td>
            </tr>
            <?php
        } ?>
    </table>
<?php
mysqli_free_result($res);