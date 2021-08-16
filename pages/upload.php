<h3>Форма загрузки</h3>
<?php

// $_FILES['myFile']-название импута['name']-исходное имя файла['tmp_name']-путь к временному файлу['size']-размер загруженного файла['error']-0(файл успешно загружен), 1-2(превышен макс. размер который задан в php.ini а вторая который задан в форме), 3(файл получен частично), 4(файл не загружен) это основные ошибки

if (!isset($_POST['upload_btn'])) {
?>

<form action="index.php" method='POST' enctype="multipart/form-data" class='form'>
    <input type="hidden" name='MAX_FILE_SIZE' value='1048576'>   <!-- инпут с таким именем позволяет настроить размер загружаемого файла, макс. размер указываем в value(сейчас 1мб в байтах)-->
    <label>
        <span>Выберите изображение</span>
        <br><br>
        <label class='inputFileBlock'>
            <div class="inputFileBlock-icon"></div>
            <p>Выбрать картинку</p>
            <input type="file" name='file' accept='image/*' class='inputFileBlock-input' id="file" onchange="showFileName()">      <!-- атрибут accept  проверяет тип загружаемого файла -->
        </label>
    </label>
    <label class='wrap-upload_btn'>
        <button type='submit' name='upload_btn' value='2' class='buttonAsText'>Загрузить</button>
        <p id='showDownloadFileName'></p>
    </label>
</form>

<?php
} else {
    if (isset($_POST['upload_btn'])) {
        // вывод ошибок
        if ($_FILES['file']['error'] !=0) {
            echo "<h3><span style='color:red;'>Код ошибки загрузки файла: {$_FILES['file']['error']}</span></h3>";
            exit(); // остановка скрипта
        }

        $fullname = $_FILES['file']['name'];                                          // полное имя файла
        $expansion = strtolower(substr($fullname, (strrpos($fullname, '.')+1)));      // находим расширение файла (strrpos ищет справа налево первое вхождение символа, substr выводит строку отрезая все до точки и включая ее, strtolower приводит к нижнему регистру)
        $fileName = substr($fullname, 0, (strlen($fullname) - strlen($expansion)-1)); // находим имя файла без расшир. (с помощью strlen находим кол-во символов у полного названия, вычитаем кол-во символов расширения и вычитаем точку,в функции substr указываем начало "0" и длину строки которую хотим взять, а остальное обрезается)

        if (is_uploaded_file($_FILES['file']['tmp_name'])) { // is_uploaded_file -файл загружен (указание импут загрузки и места временного хранения файла)
            if (!is_dir("./img")) { // если папки img не существует
                mkdir("./img", 0777, true); // пытаемся ее создать второй и третий аргумент доп настройки(читай докум.)
            }
            move_uploaded_file($_FILES['file']['tmp_name'], "./img/{$fileName}.{$expansion}"); // move_uploaded_file -переместить файл(первый аргумент -откуда перемещаем, второй -куда + указываем уже обработанное исходное название)
        }
        echo "<h3><span style='color:green;'>Файл успешно загружен</span></h3>";
        ?>
        <form action="index.php" method='POST'>
            <button name='page' value='2' style='display: block; margin: 0 auto;' class='buttonAsText backBtn'>Назад</button>
        </form>
        <?php
    }
}