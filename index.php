<!DOCTYPE>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Интернет-магазин</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>
<body>
<!-- Подключение меню -->
<?php session_start(); require_once 'pages/menu.php'; require_once 'pages/classes.php';?>

<!-- Контент -->
<section class="content">
    <div class="container">
        <?php if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if (isset($_SESSION['reg'])) {
                if ($page == 1)
                    include_once("pages/catalog.php");
                if ($page == 2)
                    include_once("pages/cart.php");
            }
            if (!isset($_SESSION['reg'])) {
                if ($page == 3)
                    include_once("pages/registration.php");
            }
            if (isset($_SESSION['r_admin'])) {
                if ($page == 4)
                    include_once("pages/admin.php");
            }
        } else {
            ?> <h1 class="h1 mt-5">Добро пожаловать в интернет магазин</h1> <?php
        } ?>
    </div>
</section>

<!-- JavaScript -->
<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>