
<div class="mt-3 mb-3">
    <h1 class="h1">Корзина покупок</h1>
</div>
<form action="./index.php?page=2" method="post">
    <?php
    require_once 'classes.php';
    $r_user = '';
    if (!isset($_SESSION['reg']) || $_SESSION['reg'] == "") {
        $r_user = "cart";
    } else {
        $r_user = $_SESSION['reg'];
    }
    
    $item = 0;
    foreach ($_COOKIE as $key => $value) {
        $pos = strrpos($key, '_');  // ищем позицию символа "_" справа налево
        if(substr($key, 0, $pos) === $r_user) { // используя слово $key от 0 до найденной позиции соответствует логину
            $item++;
        }
    }
    if ($item === 0) {
        unset($_COOKIE['purchasing']);
    } else if ($item !== 0 && !isset($_COOKIE['purchasing'])) {
        setcookie('purchasing', 'true', time()+(60*60), '/', '', 0);
        echo "<script>window.location.reload()</script>";
    }

    if (isset($_COOKIE['purchasing']) && !isset($_POST['suborder'])) {
        $total = 0;
        $count = 0;
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">№</th>
                    <th scope="col">Фото</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Удалить</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_COOKIE as $k => $v) {
                    $pos = strpos($k, "_");
                    if (substr($k, 0, $pos) == $r_user) {
                        // Получим ID пользователя
                        $id = substr($k, $pos + 1);
                        // Создание объекта продукта по ID
                        $item = Item::fromDb($id);
                        $count++;
                        
                        if ($item===false) {
                            $productIsMissing = true;
                            ?>
                            <!-- Выводим продукты, которые находятся в корзине -->
                            <tr style='height: 67px'>
                                <th scope="row"><?php echo $count ?></th>
                                <td>
                                </td>
                                <td>Похоже что этот товар уже распродан</td>
                                <td>--</td>
                                <td>
                                    <button class='btn btn-sm btn-danger' style='margin-left:10px;'
                                    onclick="eraseCookie(<?php echo '\'' . $r_user . '_' . $id . '\', ' . $id . ', \'' . $r_user . '\''?>)" >X
                                    </button>
                                </td>
                            </tr>
                            <?php
                        } else {
                            // Увеличиваем общую стоимость покупки
                            $total += $item->price_sale;
                            $_SESSION['total'] = $total;
                            ?>
                            <!-- Выводим продукты, которые находятся в корзине -->
                            <tr style='height: 67px'>
                                <th scope="row"><?php echo $count ?></th>
                                <td><img src="<?php echo $item->image_path ?>" alt="<?php echo $item->item_name ?>" height="50px">
                                </td>
                                <td><?php echo $item->item_name ?></td>
                                <td><?php echo $item->price_sale ?></td>
                                <td>
                                    <button class='btn btn-sm btn-danger' style='margin-left:10px;'
                                    onclick="eraseCookie(<?php echo '\'' . $r_user . '_' . $id . '\', ' . $id . ', \'' . $r_user . '\''?>)" >X
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
        <hr>
        <span>Общая стоимость: <?php echo $total ?></span>
        <button type="submit" class="btn btn-success" name="suborder"
                style="margin-left:150px;" <?php if (isset($productIsMissing)) echo 'disabled'; ?> >
            Оплатить заказ
        </button>

    <?php } else if (!isset($_POST['suborder'])) {
        echo "<h4 class='text-center mt-5 pt-5'>Ваша корзина пуста!</h4>";
    } ?>

</form>

<?php
if (isset($_POST['suborder'])) {

    echo "<h3 class='text-center mt-5 pt-5'>Страница оплаты</h3>";
    if (isset($_COOKIE['total']) || isset($_SESSION['total'])) {
        echo "<h5 class='text-center mt-3'>Плати деньги! К оплате ";
        echo (isset($_COOKIE['total']) ? $_COOKIE['total'] : $_SESSION['total']);
        echo "₽</h5>";
        if (isset($_SESSION['total'])) {
            setcookie('total', $_SESSION['total'], time()+10, '/', '', 0);
        }
        unset($_SESSION['total']);
    } else {
        echo "<h5 class='text-center mt-4'>Страница более не действительна!</h5>";
    }
    

    foreach ($_COOKIE as $k => $v) {
        $pos = strpos($k, "_");
        if (substr($k, 0, $pos) == $r_user) {
            // Получение ID товара
            $id = substr($k, $pos + 1);
            // Создание объекта товара по ID
            $item = Item::fromDb($id);
            // Добавление записи о продаже в БД
            $item->sale();
        }
    }
    echo "<script src='js/scripts.js'></script>";
    echo "<script> eraseCookie( '$r_user' ) </script>";
}
?>