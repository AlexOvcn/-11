<?php
session_start();
include_once("pages/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Туристическое агентство</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <header class="col-12">
            <?php require_once "pages/login.php"; ?>
        </header>
    </div>
    <div class="row">
        <div class="col-12">
            <?php include_once('pages/menu.php'); ?>
        </div>
    </div>
    <div class="row">
        <section class="col-sm-12 col-md-12 col-lg-12">
            <?php if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if ($page == 1)
                    include_once("./pages/tours_ajax.php");
                if ($page == 2)
                    include_once("./pages/comments.php");
                if ($page == 3)
                    include_once("./pages/registration.php");
                if ($page == 4)
                    include_once("./pages/admin.php");
                if ($page == 6 && isset($_SESSION['r_admin']))
                    include_once("./pages/private.php");
            } ?>
        </section>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p>Туристическое агентство &copy;</p>
            </div>
        </div>
    </div>
</footer>

<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>