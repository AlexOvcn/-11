<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Info</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/main.css" rel="stylesheet">
</head>
<!-- Функция которая изменяет полученную дату отправки сообщения из БД относительно времени на клиенте -->
<script>
    function localDate(sourceDate) {
        // разделяем полученную строку даты из php и упаковываем в массив
        let changingDateFormat = sourceDate.split(/[-: ]/);
        // создаем экземпляр даты с временем из php 
        let dateOfServer = new Date(...changingDateFormat);
        // получаем utc на клиенте в минутах(изнчально значение инверсировано)
        let utc = new Date().getTimezoneOffset();
        utc = -utc;
        // изменяем серверную дату с имеющимся utc клиента(setMinutes имеет формат времени Unix)
        setMinutes = dateOfServer.setMinutes(dateOfServer.getMinutes() + utc );
        date = new Date(setMinutes);
        // редактируем формат времени полученный в JS (например 2012-1-9 9:12:1 => 2012-01-09 09:12:01)
        let getDateForPHP = (date) => {
            function addingZero(num) {
                if (String(num).length === 1) {
                    num = `0${num}`;
                }
                return num;
            }
            let year = date.getFullYear();
            let month = date.getMonth();
            month = addingZero(month);
            let day = date.getDate();
            day = addingZero(day);
            let hours = date.getHours();
            hours = addingZero(hours);
            let minutes = date.getMinutes();
            minutes = addingZero(minutes);
            let seconds = date.getSeconds();
            seconds = addingZero(seconds);
            return `${year}-${month}-${day} <br>${hours}:${minutes}:${seconds}`;
        }
        return getDateForPHP(date);
    }
</script>
<body>
<?php
// Подключаем файл "functions.php"
require_once "functions.php";
// Если получаем переменную "hotel" в GET-запросе
if (isset($_GET['hotel'])) {
    $hotel = $_GET['hotel'];
    // Подключаемся к БД
    $connect = connect();
    // Готовим SQL-запрос
    $sel = "SELECT * FROM hotels where id='$hotel'";
    // Отправляем запрос
    $res = $connect->query($sel);
    // Преобразуем результат запроса в массив
    $row = mysqli_fetch_array($res);
    // Получаем название отеля
    $h_name = $row[1];
    // Получаем количество звезд отеля
    $h_stars = $row[4];
    // Получаем стоимость отеля
    $h_cost = $row[5];
    // Получаем информацию об отеле
    $h_info = $row[6];
    // Очищаем результаты SQL-запроса
    mysqli_free_result($res);
}
?>

<div class="container">
    <h2 class="text-uppercase text-center mt-3 mb-4"><?php echo $h_name ?></h2>

    <div class="row">
        <div class="col-12">

            <?php
            // Готовим SQL-запрос на получение путей к изображениям
            $sel = "SELECT image_path FROM images WHERE hotel_id='$hotel'";
            // Отправляем SQL-запрос
            $res = $connect->query($sel);
            ?>
            
            <h5 class="label label-info text-center mb-3 mt-3">Информация об отеле</h5>
            <div class="col-6 mx-auto mb-5"><?php echo "<h6> $h_info </h6>" ?></div>
            <h5 class="label label-info text-center mb-3">Наши фотографии</h5>
            <hr>
            <div class='imageBlock'>
                <?php
                // Перебираем результаты SQL-запроса
                while ($row = mysqli_fetch_array($res)) { ?>
                    <a href="<?php echo "../$row[0]" ?>" target='_blank' class='image'>
                        <img src="<?php echo "../$row[0]" ?>" width="300">
                    </a>
                    <?php
                }
                // Очищаем результаты SQL-запроса
                mysqli_free_result($res);
                ?>
            </div>
            <hr>

        </div>
        <h5 class="label label-info text-center mb-3 mt-5">Наша оценка и стоимость недельного проживания в одноместном номере</h5>
        <div class="col-12 mx-auto d-flex justify-content-evenly mb-5 mt-3 starsAndCostBlock">
            <div class="col-6 mx-auto d-flex justify-content-evenly mt-5 mb-5">
                <?php
                $i = 0;
                // Выводим количество изображений "star.jpg" исходя из количества звезд отеля
                for ($i = 0; $i < $h_stars; $i++) { ?>
                    <img src="../source/star.jpg" width="70" height='70' alt="Star">
                    <?php
                } ?>
            </div>
            <div class="col-6 mx-auto cost text-center">
                <p class='mt-4'><?php echo $h_cost.' $'?></p>
            </div>
        </div>
        <h5 class="label label-info text-center mb-4">Комментарии пользователей</h5>
        <div class='col-12 px-2 py-4 mb-4 bg-light commentsBlock'>
            <?php
            // Готовим SQL-запрос на получение путей к изображениям
            $sel = "SELECT C.id, C.user_id, C.user_name, C.hotel_id, C.sending_time, C.comments, U.login FROM comments AS C, users AS U WHERE C.hotel_id='$hotel' and C.user_id = U.id";
            // Отправляем SQL-запрос
            $res = $connect->query($sel);
            if ($res->num_rows === 0) {
                ?> <h6 class='text-center text-secondary my-5'>Пока еще никто не оставил комментарий!</h6> <?php
            } else {
                while ($row = mysqli_fetch_array($res)) {
                    ?>
                    <div class='comment'>
                        <div class='comment-info'>
                            <div class='comment-info__avatar'></div>
                            <p class='comment-info__userNickname'><?php echo "<span> Ник: </span>$row[2]"; ?></p>
                            <p class='comment-info__userName'><?php echo "<span> Имя: </span>$row[6]"; ?></p>
                            <p class='comment-info__sendingTime'><?php echo "<span>Дата написания:</span><br><script>document.write(localDate('$row[4]'))</script>"; ?></p>
                        </div>
                        <div class='comment-textField'>
                            <p class='comment-textField__text'><?php echo "$row[5]"; ?></p>
                        </div>
                    </div>
                    <?php
                }
                mysqli_free_result($res);
            }
            ?>
            
        </div>
    </div>
</div>
</body>
</html>
