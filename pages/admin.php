<?php
// Если в сессии нет записи "r_admin"
if (!isset($_SESSION['r_admin'])) { ?>
    <h1 class='mt-5'><span style='color:red' >Эта страница только для администраторов!</span><h1/>
    <?php exit();
}
?>

<h1 class="display-3 mt-5 mt-3 mb-4">Панель администратора</h1>

<div class="row">
    <!-- Секция А: Форма для таблицы "Countries" -->
    <div class="col-sm-6 col-md-6 col-lg-6 left">

        <h2 class="mt-3 mb-4">Страны</h2>
        <?php
        // Подключение к базе данных и подготовка запроса
        $connect = connect();
        // Подготовка SQL-запроса на вывод всех стран
        $select = 'SELECT * FROM countries';
        // Отправка SQL-запроса
        $res = $connect->query($select);
        ?>

        <form action="./index.php?page=4" method="post" class="input-group" id="form_country">
            <!-- Вывод таблицы "Countries" из базы данных -->
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Id</th>
                            <th>Страна</th>
                            <th>Отметить</th>
                        </tr>
                        <!-- Перебираем все страны циклом -->
                        <?php while ($row = mysqli_fetch_array($res)) { ?>
                            <tr>
                                <!-- Выводим ID страны -->
                                <td><?php echo $row[0] ?></td>
                                <!-- Выводим название страны -->
                                <td><?php echo $row[1] ?></td>
                                <!-- Выводим checkbox для выбора страны -->
                                <td><input type="checkbox" name="<?php echo "cb_$row[0]" ?>"></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <input type="text" name="country" placeholder="Страна" class="form-control" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form- mb-3">
                        <input type="submit" name="add_country" value="Добавить" class="btn btn-sm border-success text-success btn-success bg-light">
                        <input type="submit" name="del_country" value="Удалить" class="btn btn-sm btn-danger">
                    </div>
                </div>
            </div>
        </form>

        <?php
        // Освобождение ресурсов от результатов SQL-запроса
        mysqli_free_result($res);

        // Обработка формы добавления новой страны
        if (isset($_POST['add_country'])) {
            // Получаем введенные данные из формы
            $country = trim(htmlspecialchars($_POST['country']));
            // Если форма пустая, прекращаем выполнение программы
            if ($country == "") exit();
            // Подготовка SQL-запроса на вставку новой страны
            $insert = "INSERT INTO countries(country) VALUES ('$country')";
            // Отправка SQL-запроса
            $connect->query($insert);
            ?>
            <!-- Скрипт перезагрузки страницы -->
            <script> window.location = document.URL; </script>
            <?php
        }

        // Обработка формы удаления стран
        // Если нажата кнопка удаления стран
        if (isset($_POST['del_country'])) {
            // Перебираем все страны с выбранным checkbox
            foreach ($_POST as $k => $v) {
                // Находим все checkbox, которые начинаются на cb_
                if (str_starts_with($k, "cb_")) {
                    // Отрезаем от строки символы cb_ и получаем ID страны
                    $idc = substr($k, 3);
                    // Подготовка SQL-запроса на удаление страны с нужным ID
                    $del = 'DELETE FROM countries WHERE id=' . $idc;
                    // Отправка SQL-запроса
                    $connect->query($del);
                }
            }
            ?>
            <!-- Скрипт перезагрузки страницы -->
            <script> window.location = document.URL; </script>
            <?php
        }
        ?>
    </div>

    <!-- Секция B: Форма для таблицы "Cities" -->
    <div class="col-sm-6 col-md-6 col-lg-6 right">
        <h2 class="mt-3 mb-4">Города</h2>
        <form action="./index.php?page=4" method="post" class="input-group" id="form_city">
            <?php
            // Подготовка SQL-запроса на вывод всех городов, которые принадлежат выбранной стране
            $select = 'SELECT ci.id, ci.city, co.country FROM countries co, cities ci WHERE ci.country_id=co.id';
            // Отправка SQL-запроса
            $res = $connect->query($select);
            ?>

            <!-- Вывод таблицы "Cities" из базы данных -->
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Id</th>
                            <th>Город</th>
                            <th>Страна</th>
                            <th>Отметить</th>
                        </tr>
                        <?php
                        // Преобразуем все полученные записи из БД в ассоциативный массив
                        // и перебираем все элементы массива циклом
                        while ($row = mysqli_fetch_array($res)) { ?>
                            <tr>
                                <!-- Выводим ID города -->
                                <td><?php echo $row[0] ?></td>
                                <!-- Выводим название города -->
                                <td><?php echo $row[1] ?></td>
                                <!-- Выводим название страны -->
                                <td><?php echo $row[2] ?></td>
                                <!-- Выводим checkbox для выбора города -->
                                <td><input type="checkbox" name="<?php echo "ci_$row[0]" ?>"></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <?php
                // Освобождение ресурсов от результатов SQL-запроса
                mysqli_free_result($res);
                // Подготавливаем запрос
                $res = $connect->query('SELECT * FROM countries');
                ?>

                <div class="col-6">
                    <!-- Создаем выпадающий список всех стран -->
                    <div class="form-group mb-3">
                        <select name="country_name" class="form-control" required>
                            <option value="">Выберите страну</option>
                            <?php while ($row = mysqli_fetch_array($res)) { ?>
                                <option value="<?php echo $row[0] ?>"><?php echo $row[1] ?></option>
                                <?php
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group mb-3">
                        <input type="text" name="city" placeholder="Город" class="form-control" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <input type="submit" name="add_city" value="Добавить" class="btn btn-sm border-success text-success btn-success bg-light">
                        <input type="submit" name="del_city" value="Удалить" class="btn btn-sm btn-danger">
                    </div>
                </div>
            </div>
        </form>

        <!-- Обработка формы добавления нового города -->
        <?php if (isset($_POST['add_city'])) {
            // Получаем значение из поля "city"
            $city = trim(htmlspecialchars($_POST['city']));
            // Если поле "city" пустое, то останавливаем программу
            if ($city == "") exit();
            // Получаем значение из поля "country_name"
            $country_id = $_POST['country_name'];
            // Подготавливаем запрос
            $insert = "INSERT INTO cities (city,country_id) VALUES('$city', '$country_id')";
            // Отправляем запрос
            $connect->query($insert);
            // Получаем ошибки
            $err = $connect->errno;
            // Выводим ошибки
            if ($err) {
                echo 'Код ошибки: ' . $err . '<br>';
                exit();
            } ?>
            <!-- Обновляем страницу -->
            <script> window.location = document.URL; </script>

            <?php
        } ?>

        <!-- Обработка формы удаления городов -->
        <?php if (isset($_POST['del_city'])) {
            // Удаляем все выбранные города
            foreach ($_POST as $k => $v) {
                // Получаем все поля, котрые начинаются на "ci_"
                if (str_starts_with($k, "ci_")) {
                    // Получаем номера индексов
                    $idc = substr($k, 3);
                    // Подготавливаем запрос к БД
                    $del = 'DELETE FROM cities WHERE id=' . $idc;
                    // Отправляем запрос
                    $connect->query($del);
                }
            }
            ?>
            <!-- Обновляем страницу -->
            <script> window.location = document.URL; </script>
            <?php
        } ?>

    </div>
</div>
<hr/>
<div class="row">
    <!-- Секция C: Форма для таблицы "Hotels" -->
    <div class=" col-sm-6 col-md-6 col-lg-6 left ">
        <h2 class="mt-3 mb-4">Отели</h2>
        <form action="./index.php?page=4" method="post" class="input-group" id="form_hotel">
            <?php
            // Подготавливаем запрос к БД
            $select = 'SELECT ci.id, ci.city, ho.id, ho.hotel, ho.city_id, ho.country_id, ho.stars, ho.info, co.id, co.country 
                       FROM cities ci, hotels ho, countries co WHERE ho.city_id=ci.id AND ho.country_id=co.id';
            $res = $connect->query($select);
            $err = $connect->errno;
            ?>

            <div class="row">
                <div class="col-12">
                    <!-- Вывод таблицы "Hotels" из базы данных -->
                    <table class="table table-striped">
                        <tr>
                            <th>Id</th>
                            <th>Город-страна</th>
                            <th>Отель</th>
                            <th>Оценка</th>
                            <th>Отметить</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_array($res)) { ?>
                            <tr>
                                <!-- Выводим ID отеля -->
                                <td><?php echo $row[2] ?></td>
                                <!-- Выводим название города и страны -->
                                <td><?php echo "$row[1]-$row[9]" ?></td>
                                <!-- Выводим название отеля -->
                                <td><?php echo $row[3] ?></td>
                                <!-- Выводим количество звезд -->
                                <td><?php echo $row[6] ?></td>
                                <!-- Выводим checkbox с ID отеля -->
                                <td><input type="checkbox" name="<?php echo "hb_$row[2]" ?>"></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>

                    <?php
                    // Очищаем результаты запроса
                    mysqli_free_result($res);
                    // Готовим SQL-запрос
                    $select = 'SELECT ci.id, ci.city, co.country, co.id FROM countries co, cities ci WHERE ci.country_id=co.id';
                    $res = $connect->query($select);
                    // Создаем пустой массив
                    $c_sel = array();
                    ?>

                </div>
                <div class="col-6">
                    <!-- Создаем выпадающий список городов -->
                    <div class="form-group mb-3">
                        <select name="h_city" class="form-control" required>
                            <option value="">Выберите город : страну</option>
                            <?php while ($row = mysqli_fetch_array($res)) { ?>
                                <option value="<?php echo $row[0] ?>"><?php echo "$row[1] : $row[2]" ?></option>

                                <?php
                                // Заполняем массив названиями отелей
                                $c_sel[$row[0]] = $row[3];
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <input type="text" name="hotel" placeholder="Отель" class="form-control" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <input type="text" name="cost" placeholder="Стоимость" class="form-control" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <input type="number" name="stars" min="1" max="5" placeholder="Количество звезд"
                               class="form-control" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <textarea name="info" placeholder="Описание" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <input type="submit" name="add_hotel" value="Добавить" class="btn btn-sm border-success text-success btn-success bg-light">
                        <input type="submit" name="del_hotel" value="Удалить" class="btn btn-sm btn-danger">
                    </div>
                </div>
            </div>

        </form>

        <?php
        // Очищаем результаты SQL-запроса
        mysqli_free_result($res);

        // Обработка формы добавления отелей
        if (isset($_POST['add_hotel'])) {
            // Получаем данные из поля "hotel"
            $hotel = trim(htmlspecialchars($_POST['hotel']));
            // Преобразуем данные, полученные из формы, в целочисленное значение
            $cost = intval(trim(htmlspecialchars($_POST['cost'])));
            // Получаем данные о количестве звезд
            $stars = intval($_POST['stars']);
            // Получаем данные о количестве звезд
            $info = trim(htmlspecialchars($_POST['info']));

            // Если не заполнены поля "hotel", "cost" или "stars", то останавливаем программу
            if ($hotel == "" || $cost == "" || $stars == "") exit();
            // Получаем данные из поля "h_city"
            $city_id = $_POST['h_city'];
            // Получаем ID страны, исходя из выбранного города
            $country_id = $c_sel[$city_id];
            // Готовим запрос на сохранение данных
            $insert = "INSERT INTO hotels (hotel, city_id, country_id, stars, cost, info) 
                       VALUES ('$hotel', '$city_id', '$country_id', '$stars', '$cost', '$info')";
            // Отправляем запрос
            $connect->query($insert);
            ?>
            <!-- Обновляем страницу -->
            <script> window.location = document.URL; </script>
            <?php
        }

        // Обработка формы удаления отелей
        if (isset($_POST['del_hotel'])) {
            // Перебираем все выбранные отели
            foreach ($_POST as $k => $v) {
                // Получаем все поля с именами, начинающимися на "hb_"
                if (str_starts_with($k, "hb_")) {
                    // Отделяем от строки символы "hb_"
                    $idc = substr($k, 3);
                    // Готовим запрос на удаление из БД
                    $del = 'DELETE FROM hotels WHERE id=' . $idc;
                    $connect->query($del);
                    // Получаем ошибки
                    if ($err) {
                        echo 'Код ошибки: ' . $err . '<br>';
                        exit();
                    }
                }
            }
            ?>
            <!-- Обновляем страницу -->
            <script> window.location = document.URL; </script>
            <?php
        }
        ?>
    </div>

    <!-- Секция C: Форма для таблицы "Images" -->
    <div class=" col-sm-6 col-md-6 col-lg-6 right ">
        <h2 class="mt-3 mb-5">Загрузка фотографий</h2>
        <form action="./index.php?page=4" method="post" enctype="multipart/form-data" class="input-group">

            <div class="row">
                <div class="col-6">
                    <div class="form-group mb-3">
                        <select name="hotel_id" class="form-control" required>
                            <option value="">Выберите страну, город, отель</option>
                            <?php
                            // Готовим запрос на получение данных
                            $select = 'SELECT ho.id, co.country, ci.city, ho.hotel FROM countries co,cities ci, hotels ho 
                            WHERE co.id=ho.country_id AND ci.id=ho.city_id ORDER BY co.country';
                            // Отправляем запрос
                            $res = $connect->query($select);
                            // Перебираем все записи из БД
                            while ($row = mysqli_fetch_array($res)) { ?>
                                <option value="<?php echo $row[0] ?>">
                                    <?php echo "$row[1] &nbsp;&nbsp; $row[2] &nbsp;&nbsp; $row[3]" ?>
                                </option>

                                <?php
                            }
                            // Очищаем результаты запроса
                            mysqli_free_result($res);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <input type="file" name="file[]" multiple accept="image/*" class="form-control" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <input type="submit" name="add_image" value="Добавить" class="btn btn-sm border-success text-success btn-success bg-light">
                    </div>
                </div>
            </div>

            <?php
            // Если нажата кнопка "add_image"
            if (isset($_REQUEST['add_image'])) {
                // Перебираем все выбранные файлы по именам
                foreach ($_FILES['file']['name'] as $k => $v) {
                    // Если при загрузке произошла ошибка...
                    if ($_FILES['file']['error'][$k] != 0) { ?>
                        <!-- Вывод сообщения об ошибке -->
                        <script>alert(<?php echo "Ошибка загрузки файла: $v" ?>)</script>
                        <!-- Продолжаем выполнение скрипта -->
                        <?php continue;
                    }
                    // Если файл успешно перемещен в папку "img/"
                    if (!is_dir("./img")) { // если папки img не существует
                        mkdir("./img", 0777, true); // пытаемся ее создать второй и третий аргумент доп настройки(читай докум.)
                    }
                    if (move_uploaded_file($_FILES['file']['tmp_name'][$k], substr($_SERVER['SCRIPT_FILENAME'], 0, (strrpos($_SERVER['SCRIPT_FILENAME'], '/'))) . '/img/' . $v)) {
                        // Получаем ID отеля
                        $hotel_id = $_REQUEST['hotel_id'];
                        // Готовим SQL-запрос на добавление записи в БД
                        $insert = "INSERT INTO images(hotel_id, image_path) VALUES ('$hotel_id', 'img/$v')";
                        // Отправляем SQL-запрос
                        $connect->query($insert);
                    }
                }
            }
            ?>
        </form>
    </div>
</div>

