<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>php app</title>
</head>
<body>
    <div class="container">
        <?php
        function console_log($data){ // функция имитирующая console.log из js
            if(is_array($data) || is_object($data)){
                echo("<script>console.log('php_array: ".json_encode($data)."');</script>");
            } else {
                echo("<script>console.log('php_string: {$data}');</script>");
            }
        }
        session_start();
        // $_SESSION['failedLogin'] = false;
        include_once 'pages/functions.php';
        include_once 'pages/menu.php';
        ?>
    </div>
    <div class="container mainDiv">
        <?php
            if (isset($_POST['page'])) {
                $page = $_POST['page'];

                if ($page == 1) include_once 'pages/home.php';
                if ($page == 2) {
                    if (isset($_SESSION['signIn']) && $_SESSION['signIn'] === true) {
                        include_once 'pages/upload.php';
                    } else {
                        echo "<h3>Для доступа к этому разделу нужно авторизоваться</h3>";
                    }
                }
                if ($page == 3) include_once 'pages/gallery.php';
                if ($page == 4) include_once 'pages/registration.php';

            } elseif (isset($_POST['reg_btn'])) {
                $page = $_POST['reg_btn'];
                if ($page == 4) include_once 'pages/registration.php';
            } elseif (isset($_POST['upload_btn'])) {
                $page = $_POST['upload_btn'];
                if ($page == 2) include_once 'pages/upload.php';
            } elseif (isset($_POST['viewImage'])) {
                $page = $_POST['viewImage'];
                if ($page == 3) include_once 'pages/gallery.php';
            } elseif (isset($_SESSION['failedLogin']) && $_SESSION['failedLogin']) {
                include_once 'pages/registration.php';
            } else {
                include_once 'pages/home.php';
            }
        ?>
    </div>
</body>
<script>
    let imgBlock = document.querySelector('.imgBlock');
    if (imgBlock !== null) {
        console.log(imgBlock.childNodes)
        for (let i = 0; i < imgBlock.childNodes.length; i++) {
            setTimeout(() => {
                imgBlock.childNodes[i].classList.remove("hidden");
                imgBlock.childNodes[i].classList.add("slowShow");
            }, i * 100);
        }
    }
    function showFileName() {
        let nameUploadedFileFull = document.getElementById('file').files[0].name;
        let nameUploadedFileShort = nameUploadedFileFull.substring(0, nameUploadedFileFull.lastIndexOf('.'));
        let nameUploadedFileExtension = nameUploadedFileFull.substring(nameUploadedFileFull.lastIndexOf('.') + 1);
        if (nameUploadedFileShort.length > 15) {
            nameUploadedFileShort = nameUploadedFileShort.substring(0, 20) + "...";
        }
        let showDownloadFileName = document.getElementById('showDownloadFileName').textContent = `картинку ${nameUploadedFileShort} с расширением \"${nameUploadedFileExtension}\" ?`;
    }
</script>
</html>