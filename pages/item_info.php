<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Информация о товаре</title>
</head>
<body>
    <?php

    session_start();
    require_once 'classes.php';
    $itemInfo = Item::fromDb($_GET['name']);

    if ($itemInfo === false) {
        echo "<h3 class='text-center mt-5'>Товара не существует</h3>";
        echo "<h3 class='text-center mt-3'>404</h3>";
        exit;
    }

    $arrayItemInfo = (array)$itemInfo;
    $rating_value =  Rating::fromDb($arrayItemInfo['id']);
    $userInfo = Customer::fromDb($_SESSION['reg']);
    $rating = Rating::fromDbForUser($userInfo->id, $itemInfo->id);
    
    ?> 
    <div class='container flexBlock mt-5'>
        <div style='width: 200px; height: 200px; background-image: url("../<?php echo $itemInfo->image_path ?>"); background-size: cover; background-position: center center'></div>
        <div style='padding: 0 2vw 0 2vw'>
            <h1 class="mt-3 mb-4"> <?php echo $itemInfo->item_name ?> </h1>
            <h5>Цена: <?php echo $itemInfo->price_sale ?>₽ <s style='font-size: 15px'> <?php echo $itemInfo->price ?>₽</s></h5>
            <h5>Оценка: <?php echo $rating_value ?> / 5</h5>
        </div>
        <div class='gridPhoto'> <?php Images::drawPhoto($itemInfo->id) ?> </div>
    </div>
    <div class='container'>
        <h5 class='mt-5'>Описание: <?php echo $itemInfo->info ?></h5>
            <div class='d-flex flex-column'> <h5 class='mt-3 mb-2'>Оставьте свою оценку:</h5>
            <div class='ratingStars-block'>
                <div class='ratingStars-block__star' id='HR5' style='order: 5' tabindex='-1' onclick='setRating(<?php echo "$itemInfo->id, $userInfo->id, 5" ?>)'></div>
                <div class='ratingStars-block__star' id='HR4' style='order: 4' tabindex='-1' onclick='setRating(<?php echo "$itemInfo->id, $userInfo->id, 4" ?>)'></div>
                <div class='ratingStars-block__star' id='HR3' style='order: 3' tabindex='-1' onclick='setRating(<?php echo "$itemInfo->id, $userInfo->id, 3" ?>)'></div>
                <div class='ratingStars-block__star' id='HR2' style='order: 2' tabindex='-1' onclick='setRating(<?php echo "$itemInfo->id, $userInfo->id, 2" ?>)'></div>
                <div class='ratingStars-block__star' id='HR1' style='order: 1' tabindex='-1' onclick='setRating(<?php echo "$itemInfo->id, $userInfo->id, 1" ?>)'></div>
            </div>
            <h5 class='mt-3' id='resultRatingAnswer'></h5>
        </div>
    </div>
    <script src="../js/scripts.js"></script>
    <?php echo "<script> showRating( $rating )</script>" ?>
</body>
</html>