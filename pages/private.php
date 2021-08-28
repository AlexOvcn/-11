<h1 class="display-3 mt-5 mt-3 mb-4">Настройка приватности</h1>

<?php
// Подключение к БД
$connect = connect();
?>

<form action="./index.php?page=6" method="post" enctype="multipart/form-data">

    <div class="form-group mb-3 mt-3">
        <select name="user_id" class="form-control" required>
            <option value="">Выберите пользователя</option>
            <?php
            // Подготовка SQL-запроса
            $select = "SELECT * FROM users WHERE role_id=2 ORDER BY login";
            // Отправка SQL-запроса
            $res = $connect->query($select);
            // Перебор результата SQL-запроса
            while ($row = mysqli_fetch_array($res)) {
                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
            // Очистка результата SQL-запроса
            mysqli_free_result($res);
            ?>
        </select>
    </div>
    <h4>Выберите аватар для пользователя</h4>
    <div class="form-group mb-3">
        <input type="hidden" name="MAX_FILE_SIZE" value="500000"/>
        <input type="file" name="file" accept="image/*" class="form-control" required>
    </div>
    <div class="form-group mb-3">
        <input type="submit" name="add_admin" value="Сделать админом" class="btn btn-info">
    </div>
</form>

<?php
// Если нажата кнопка "add_admin"
if (isset($_POST['add_admin'])) {
    // Получаем ID пользователя
    $user_id = $_POST['user_id'];
    // Получаем временное имя файла
    $filename = $_FILES['file']['tmp_name'];
    // Открываем файл
    // Указываем, что хотим читать файл, как бинарный "rb" (r - read, b - binary)
    $file = fopen($filename, 'rb');
    // Определяем размер читаемого файла
    $img = fread($file, filesize($filename));
    // Закрываем файл
    fclose($file);
    // Прочитанный файл обрабатываем функцией addslashes(),
    // которая экранирует потенциально опасные символы
    $img = addslashes($img);
    // Подготовка SQL-запроса
    $insert = "UPDATE users SET avatar='.$img.', role_id=1 WHERE id='$user_id'";
    // Отправка SQL-запроса
    $connect->query($insert);
}
// Подготовка SQL-запроса
$sel = 'SELECT * FROM users WHERE role_id=1 ORDER BY login';
// Отправка SQL-запроса
$res = $connect->query($sel);
?>
<table class="table table-striped">
    <tr>
        <th>Id</th>
        <th>Логин</th>
        <th>Почта</th>
        <th>Аватар</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_array($res)) {
        // Кодируем бинарные данные в текстовый формат
        $img = base64_encode($row[6]);
        ?>

        <tr>
            <td><?php echo $row[0] ?></td>
            <td><?php echo $row[1] ?></td>
            <td><?php echo $row[3] ?></td>
            <td><img src="<?php echo "data:image/jpeg;charset=utf-8;base64,$img" ?>" width="30" height="30" alt></td>
        </tr>

        <?php
    }
    // Очистка результата SQL-запроса
    mysqli_free_result($res)
    ?>
</table>

