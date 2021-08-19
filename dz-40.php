<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>dz-40</title>
</head>
<body>
    <section>
        <?php
        session_start();

        // защита от повторной отправки формы
        if (count($_POST)) {
            setcookie('request', $_POST['request'], time()+1, '/', '', 0);
        }
        if (count($_POST)) {
            header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        }
        ?>
        <form action="dz-40.php" method="POST" >
            <button name="request" value="1">Количество инструкторов по каждой секции</button>
            <button name="request" value="2">Количество посетителей фитнес клуба, которые пользуются услугами определенного мобильного оператора</button>
            <button name="request" value="3">Число посетителей с одинаковыми именами, которые занимаются у определенного инструктора</button>
            <button name="request" value="4">Информация о посетителях, которые посетили фитнес-зал минимальное количество раз</button>
        </form>
        <h2>Ответ от базы данных</h2>
        <?php

        if (isset($_COOKIE['request'])) {
             if($link = @mysqli_connect('localhost', 'root', '')) { // подключение к серверу MySQL, false при неудачной попытке, знак @ подавляет вывод ошибки от неудачного подключения
                $_SESSION['BD_successful_connection'] = true;
                $DB_selected = mysqli_select_db($link, 'fitness_club'); // выбор БД
            } else {
                echo "<h4 class='err'>Нет соединения с БД</h4>";
                echo "<p class='err'>Код ошибки: " . mysqli_connect_errno() . "</p>";
                echo "<p class='err'>Текст ошибки: " . mysqli_connect_error() . "</p>";
                exit; // весь скрипт что ниже не выполнится
            }
        }

        ?>
        <table class='slow_showing'>
            <?php
                if (isset($_COOKIE['request'])) {
                    if ($_COOKIE['request'] === '1') {

                        $response = mysqli_query($link, "SELECT COUNT(I.id) AS 'Количество инструкторов', SS.section_name AS 'Название спортивной секции' FROM instructors AS I, sports_sections AS SS WHERE SS.id = I.id_sports_section GROUP BY SS.section_name"); // получение ответа в виде объекта
                        
                        echo "<tr><th>Количество инструкторов</th><th>Название спортивной секции</th></tr>";
                        while ($row=mysqli_fetch_array($response)) {    // функция обрабатывает ответ и возвращает комбинированный массив, то есть, как численный так и ассоциативный, а цикл позволяет обрабатывать каждую отдельную строку за одну иттерацию, дойдя до конца возвращает false и останавливается
                            echo "<tr><td>{$row['Количество инструкторов']}</td><td>{$row['Название спортивной секции']}</td></tr>";
                        }
                    }
                    if ($_COOKIE['request'] === '2') {

                        $response = mysqli_query($link, "SELECT COUNT(V.id) AS 'Количество посетителей', V.mobile_operator AS 'Мобильный оператор' FROM visitors AS V GROUP BY V.mobile_operator");
                        
                        echo "<tr><th>Количество посетителей</th><th>Мобильный оператор</th></tr>";
                        while ($row=mysqli_fetch_array($response)) {
                            echo "<tr><td>{$row[0]}</td><td>{$row[1]}</td></tr>";
                        }
                    }
                    if ($_COOKIE['request'] === '3') {

                        $response = mysqli_query($link, "SELECT COUNT(V.id) AS 'Число посетителей', 'Грифель' AS 'Имя инструктора' FROM visitors AS V, instructors AS I WHERE V.instructor_id = I.id AND V.firstname LIKE 'Леонид' AND I.lastname LIKE 'Грифель'");
                        
                        echo "<tr><th>Число посетителей</th><th>Имя инструктора</th></tr>";
                        while ($row=mysqli_fetch_array($response)) {
                            echo "<tr><td>{$row[0]}</td><td>{$row[1]}</td></tr>";
                        }
                    }
                    if ($_COOKIE['request'] === '4') {

                        $response = mysqli_query($link, "SELECT V.id, V.firstname, V.lastname, V.instructor_id, V.mobile_operator, (1st_quarter_2020+2nd_quarter_2020+3rd_quarter_2020+4th_quarter_2020+1st_quarter_2021+2nd_quarter_2021+3rd_quarter_2021+4th_quarter_2021) AS 'number of visits'
                        FROM visitors AS V, list_of_visits AS LV
                        WHERE (1st_quarter_2020+2nd_quarter_2020+3rd_quarter_2020+4th_quarter_2020+1st_quarter_2021+2nd_quarter_2021+3rd_quarter_2021+4th_quarter_2021) <= 30 AND V.id = LV.id
                        GROUP BY V.id");
                        
                        echo "<tr><th>id</th><th>Имя</th><th>Фамилия</th><th>id инструктора</th><th>Моб. оператор</th><th>Число посещений</th></tr>";
                        while ($row=mysqli_fetch_array($response)) {
                            echo "<tr><td>{$row[0]}</td><td>{$row[1]}</td><td>{$row[2]}</td><td>{$row[3]}</td><td>{$row[4]}</td><td>{$row[5]}</td></tr>";
                        }
                    }
                } else {
                    echo "<tr><th>Здесь будет показан ответ</tr></th>";
                }
            ?>
        </table>
    </section>
</body>
</html>