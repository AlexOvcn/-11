<?php

require_once 'classes.php';
$item_id = $_POST['item_id'];
$user_id = $_POST['user_id'];
$rating_value = $_POST['rating_value'];
$objRate = new Rating($item_id, $user_id, $rating_value);
$answer = $objRate->intoDb();

if ($answer === 1062) {
    $rating = Rating::fromDbForUser($user_id, $item_id);
    echo "Вы уже поставили оценку: $rating";
} else if ($answer) {
    echo 'Ваша оценка учтена';
} else {
    echo $answer;
}