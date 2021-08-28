<h1 class="display-3 mt-5 mt-3 mb-4">Добавить отзыв об отеле</h1>

<?php
if (isset($_SESSION['r_user'])) {
    if (isset($_POST["btn_comment_add"])) {
        $sending_time = gmdate("Y-m-d H:i:s");
        // Подключение к базе данных и подготовка запроса
        $connect = connect();
        // Подготовка SQL-запроса на вывод всех стран
        $select = "INSERT INTO `comments` (`id`, `user_id`, `user_name`, `hotel_id`, `sending_time`, `comments`) VALUES (NULL, (SELECT U.id FROM users AS U WHERE '{$_SESSION['r_user']}' = U.login), '{$_POST['user_name']}', '{$_POST['selectHotel']}', '$sending_time', '{$_POST['textarea']}')";
        // Отправка SQL-запроса
        $res = $connect->query($select);
        ?><h3 style='color: green'>Ваш комментарий был добавлен</h3><?php
    } else {
        include_once('functions.php');
        $connect = connect();
        $sel = 'SELECT id,country FROM countries';
        $res = $connect->query($sel);
        ?>
            <form action="index.php?page=2" method='POST'>
                <input type="text" name="user_name" class='btn btn-info bg-light' style='padding: .375rem .75rem; text-align:left; cursor: auto' placeholder='Ваше имя' required minlength="2" maxlength="10">
                <select name="selectCountry" class='btn btn-info bg-light' style='padding: .375rem .75rem;' onchange="showCities(this.value)">
                    <option value="">Выберите страну</option>
                    <?php
                    while ($row = mysqli_fetch_array($res)) {
                        echo '<option value="'.$row[0].'">'.$row[1].'</options>';
                    }
                    mysqli_free_result($res);
                    ?>
                </select>
                <select name="selectCity" id="city_list" class="hiddenInput btn btn-info bg-light" onchange="showHotels_list(this.value)"></select>
                <select name="selectHotel" id="hotel_list" class="hiddenInput btn btn-info bg-light" onchange="showTextarea(this.value)"></select>
                <textarea name="textarea" id="textarea_comment" class="hiddenInput btn btn-info bg-light" style='display: block; margin: 20px 0; text-align:left; cursor: auto' cols="100" rows="10" placeholder='Ваш комментарий' required minlength="10" maxlength="1024"></textarea>
                <button type="submit" id='btn_comment_add' name='btn_comment_add' class='hiddenInput btn btn-sm border-success text-success btn-success bg-light' value='1'>Добавить комментарий</button>
            </form>
            <script src="js/ajax.js"></script>
        <?php
    }
} else {
    echo "<h1 class='mt-5'><span style='color:red'>Чтобы оставить комментарий пройдите авторизацию!</span><h1/>";
}