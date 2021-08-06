<?php

// 2, 3, 4, 5 задание
echo '<br> <br> 2, 3, 4, 5) Задание <br> <br>';

// создание сессии и общего кол-ва баллов
session_start();
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

// вывод сообщения при пропущенных ответах
function checkingForMissedResponses() {
    if ((isset($_SESSION['pageRestart']) && $_SESSION['pageRestart'] === 1) || (isset($_SESSION['pageRestart2']) && $_SESSION['pageRestart2'] === 1) || (isset($_SESSION['pageRestart3']) && $_SESSION['pageRestart3'] === 1)) {
        echo '<h3>Пожалуйста ответьте на все вопросы!</h3>';
    }
}

// проверка ответов
function checkingResponses() {
    $goBack = "Location: ".$_SERVER['HTTP_REFERER'];

    // шаблон добавления баллов для radio кнопок
    function radioInp($name, $numberCorrectOption, $pointsForAnswer) {
        if (!isset($_SESSION[$name])) {
            $_SESSION[$name] = 1;
            if ($_POST[$name] === $numberCorrectOption) {
                $_SESSION['score'] += $pointsForAnswer;
            }
        }
    }

    // шаблон добавления баллов для checkbox кнопок
    function checkboxInp($name, $pointsForAnswer, ...$numbersCorrectOption) {
        if (!isset($_SESSION[$name])) {
            $_SESSION[$name] = 1;
            for ($i = 0; $i < count($_POST[$name]); $i++) {
                $var = $_POST[$name][$i];
                for ($iter = 0; $iter < count($numbersCorrectOption); $iter++) {
                    $correctOption = $numbersCorrectOption[$iter];
                    if ($var === $correctOption) {
                        $_SESSION['score'] += $pointsForAnswer;
                    }
                }
            }
        }
    }

    // шаблон добавления баллов для textarea полей
    function textareaField($name, $textResponse, $pointsForAnswer) {
        if (!isset($_SESSION[$name])) {
            $_SESSION[$name] = 1;
            if (htmlentities(trim($_POST[$name])) === $textResponse) { // htmlentities() преобразует все спецсимволы в текст. символы(другая кодировка)
                $_SESSION['score'] += $pointsForAnswer;
            }
        }
    }
    if(isset($_POST['next'])) {

        if ($_POST['next'] === '1') {

            // проверка на пропущенные ответы из radio кнопок
            if ((!isset($_POST['rquest1']) || !isset($_POST['rquest2']) || !isset($_POST['rquest3']) || !isset($_POST['rquest4']) || !isset($_POST['rquest5']) || !isset($_POST['rquest6']) || !isset($_POST['rquest7']) || !isset($_POST['rquest8']) || !isset($_POST['rquest9']) || !isset($_POST['rquest10'])) && !isset($_SESSION['page0done'])) {
                $_SESSION['pageRestart'] = 1;
                header($goBack);
                return;
            } else {
                $_SESSION['pageRestart'] = 0;
                $_SESSION['page0done'] = 1;
            }
            radioInp('rquest1', '1', 1); // имя радио группы кнопок, номер правильного варианта, кол-во баллов за ответ
            radioInp('rquest2', '1', 1);
            radioInp('rquest3', '1', 1);
            radioInp('rquest4', '1', 1);
            radioInp('rquest5', '1', 1);
            radioInp('rquest6', '1', 1);
            radioInp('rquest7', '1', 1);
            radioInp('rquest8', '1', 1);
            radioInp('rquest9', '1', 1);
            radioInp('rquest10', '1', 1);
        }

        if ($_POST['next'] === '2') {

            // проверка на пропущенные ответы из checkbox кнопок
            if ((!isset($_POST['cquest1']) || !isset($_POST['cquest2']) || !isset($_POST['cquest3']) || !isset($_POST['cquest4']) || !isset($_POST['cquest5']) || !isset($_POST['cquest6']) || !isset($_POST['cquest7']) || !isset($_POST['cquest8']) || !isset($_POST['cquest9']) || !isset($_POST['cquest10'])) && !isset($_SESSION['page1done'])) {
                $_SESSION['pageRestart2'] = 1;
                header($goBack);
                return;
            } else {
                $_SESSION['pageRestart2'] = 0;
                $_SESSION['page1done'] = 1;
            }
            checkboxInp('cquest1',3 , '1', '3'); // имя чекбокс группы кнопок, кол-во баллов за ответ, а далее перечислить варианты правильных ответов
            checkboxInp('cquest2',3 , '1', '2');
            checkboxInp('cquest3',3 , '1', '4');
            checkboxInp('cquest4',3 , '1', '3', '2');
            checkboxInp('cquest5',3 , '1', '3', '4');
            checkboxInp('cquest6',3 , '1', '3');
            checkboxInp('cquest7',3 , '1', '3');
            checkboxInp('cquest8',3 , '1', '3');
            checkboxInp('cquest9',3 , '1', '3');
            checkboxInp('cquest10',3 , '1', '3');
        }

        if ($_POST['next'] === '3') {
            
            // проверка на пропущенные ответы из textarea полей
            if ((empty(trim($_POST['tquest1'])) || empty(trim($_POST['tquest2'])) || empty(trim($_POST['tquest3'])) || empty(trim($_POST['tquest4'])) || empty(trim($_POST['tquest5'])) || empty(trim($_POST['tquest6'])) || empty(trim($_POST['tquest7'])) || empty(trim($_POST['tquest8'])) || empty(trim($_POST['tquest9'])) || empty(trim($_POST['tquest10']))) && !isset($_SESSION['page2done'])) {
                $_SESSION['pageRestart3'] = 1;
                header($goBack);
                return;
            } else {
                $_SESSION['pageRestart3'] = 0;
                $_SESSION['page2done'] = 1;
            }
            textareaField('tquest1', 'answer', 5);  // имя textarea поля, правильный словесный ответ, кол-во баллов за ответ
            textareaField('tquest2', 'answer', 5);
            textareaField('tquest3', 'answer', 5);
            textareaField('tquest4', 'answer', 5);
            textareaField('tquest5', 'answer', 5);
            textareaField('tquest6', 'answer', 5);
            textareaField('tquest7', 'answer', 5);
            textareaField('tquest8', 'answer', 5);
            textareaField('tquest9', 'answer', 5);
            textareaField('tquest10', 'answer', 5);
        }
    }
}

if ((isset($_GET['next']) && $_GET['next'] === '0') || (isset($_POST['next']) && $_POST['next'] === '0') || (!isset($_POST['next']) && !isset($_GET['next']))) {
    if (count($_POST)) {
        header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?next=0');
    }
    if (isset($_POST['next']) && $_POST['next'] === '0') {
        session_unset();
    }
    ?>
    <p></p>
    <form action="task2-5.php" method='POST' id='itsForm'>
        <?php 
            function randomQuestionsRadio($quantity) {
                $mixingArray = [];

                for ($i = 0; $i < $quantity; $i++) {
                    array_push($mixingArray, $i);
                }
                shuffle($mixingArray);

                for ($i = 0; $i < $quantity; $i++) {
                    $num = $mixingArray[$i]+1;
                    echo ("
                    <p>Question $num</p>
                    <label>Answer1<input type='radio' name='rquest{$num}' value='1'></label>
                    <label>Answer2<input type='radio' name='rquest{$num}' value='2'></label>
                    <label>Answer3<input type='radio' name='rquest{$num}' value='3'></label>
                    <label>Answer4<input type='radio' name='rquest{$num}' value='4'></label>");
                }
            }
            randomQuestionsRadio(10);
        ?>
        <br>
        <br>
        <button type='submit' name='next' value='1' >Next</button>
    </form>
    <?php
    if (isset($_SESSION['page0done'])) {
        echo '<h3>Перезаписать ответы не получиться!</h3>';
    }
    checkingForMissedResponses(); } else if ((isset($_POST['next']) && $_POST['next'] === '1') || $_GET['next'] === '1') {
    checkingResponses();
    if (count($_POST) && $_SESSION['pageRestart'] === 0) {
        header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?next=1');
    }
    echo 'Очки: ' .$_SESSION['score'];
    ?>
    <form action="task2-5.php" method='POST'>
        <?php 
            function randomQuestionsCheckbox($quantity) {
                $mixingArray = [];

                for ($i = 0; $i < $quantity; $i++) {
                    array_push($mixingArray, $i);
                }
                shuffle($mixingArray);

                for ($i = 0; $i < $quantity; $i++) {
                    $num = $mixingArray[$i]+1;
                    echo ("
                    <p>Question $num</p>
                    <label>Answer1<input type='checkbox' name='cquest{$num}[]' value='1'></label>
                    <label>Answer2<input type='checkbox' name='cquest{$num}[]' value='2'></label>
                    <label>Answer3<input type='checkbox' name='cquest{$num}[]' value='3'></label>
                    <label>Answer4<input type='checkbox' name='cquest{$num}[]' value='4'></label>");
                } //синтаксис пустого массива создаст массив в котором будут лежать по порядку ключи со значениями отмеченных кнопок обращение к массиву(cquest1) в данном примере эти значения лежат в $_SESSION т.к. $_POST чистится
            }
            randomQuestionsCheckbox(10);
        ?>
        <br>
        <br>
        <button type='submit' name='next' value='2'>Next</button>
    </form>
    <?php
    if (isset($_SESSION['page1done'])) {
        echo '<h3>Перезаписать ответы не получиться!</h3>';
    }
    checkingForMissedResponses(); } else if ((isset($_POST['next']) && $_POST['next'] === '2') || $_GET['next'] === '2') {
    checkingResponses();
    if (count($_POST) && $_SESSION['pageRestart2'] === 0) {
        header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?next=2');
    }
    echo 'Очки: ' .$_SESSION['score'];
    ?>
    <form action="task2-5.php" method='POST'>
        <?php 
            function randomQuestionsTextarea($quantity) {
                $mixingArray = [];

                for ($i = 0; $i < $quantity; $i++) {
                    array_push($mixingArray, $i);
                }
                shuffle($mixingArray);

                for ($i = 0; $i < $quantity; $i++) {
                    $num = $mixingArray[$i]+1;
                    echo ("
                    <p>Question $num</p>
                    <textarea name='tquest{$num}' cols='30' rows='1'></textarea>");
                }
            }
            randomQuestionsTextarea(10);
        ?>
        <br>
        <br>
        <button type='submit' name='next' value='3'>FINISH</button>
    </form>
    <?php
    if (isset($_SESSION['page2done'])) {
        echo '<h3>Перезаписать ответы не получиться!</h3>';
    }
    checkingForMissedResponses(); } else if ((isset($_POST['next']) && $_POST['next'] === '3') || $_GET['next'] === '3') {
    checkingResponses();
    if (count($_POST) && $_SESSION['pageRestart3'] === 0) {
        header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?next=3');
    }
    ?>
    <form action="task2-5.php" method='POST'>
        <h3>Вы набрали <?php echo $_SESSION['score']; ?> очков</h3>
        <button type='submit' name='next' value='0'>Restart</button>
    </form>
    <?php
}