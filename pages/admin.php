<div class="mt-3 mb-3">
    <h1 class="h1 mb-5">Консоль администратора</h1>
</div>

<?php
require_once 'classes.php';

echo "<h3 class='mb-4'>Панель создания товара</h3>";
if ( ! isset($_POST['add_item']) ) {
    ?>

    <form action="./index.php?page=4" method="POST" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="category_id" class="form-label">Категория:</label>
            <select name="category_id" class="form-select">
                <?php
                $pdo = Tools::connect();
                $list = $pdo->query("SELECT * FROM categories");
                while ($row = $list->fetch()) { ?>
                    <option value="<?php echo $row['id'] ?>">
                        <?php echo $row['category'] ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="name" class="form-label">Наименование:</label>
            <input type="text" class="form-control" name="item_name">
        </div>

        <div class="form-group mb-3">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <label for="price" class="form-label">Цена:</label>
                    <input type="number" class="form-control" name="price">
                </div>
                <div class="col-lg-6 col-sm-12">
                    <label for="sale_price" class="form-label">Цена со скидкой:</label>
                    <input type="number" class="form-control" name="price_sale">
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="info" class="form-label">Описание товара:</label>
            <textarea class="form-control" name="info"></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="image_path" class='mb-2'>Выбор изображения:</label>
            <input type="file" class="form-control" name="image_path">
        </div>

        <button type="submit" class="btn btn-primary" name="add_item">Добавить товар</button>
    </form>
    <?php
} else {

    if (!is_dir("./img")) { // если папки img не существует
        mkdir("./img", 0777, true); // пытаемся ее создать второй и третий аргумент доп настройки(читай докум.)
    }
    if (is_uploaded_file($_FILES['image_path']['tmp_name'])) {
        $path = "img/" . $_FILES['image_path']['name'];
        move_uploaded_file($_FILES['image_path']['tmp_name'], $path);
    }

    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $price_sale = $_POST['price_sale'];
    $name = trim(htmlspecialchars($_POST['item_name']));
    $info = trim(htmlspecialchars($_POST['info']));

    $item = new Item($name, $category_id, $price, $price_sale, $info, $path);
    $item->intoDb();
    echo '<h3 class="alert alert-success">Новый товар добавлен!</h3>';
}

echo "<h3 class='mb-4 mt-5'>Панель взаимодействия с категориями</h3>";
if ( ! isset($_POST['add_category']) ) {
    ?>
    <form action="./index.php?page=4" method="POST">
        <input type="text" name="name_category" class="form-control mt-2 me-3 w-25 d-inline" placeholder="Введите название категории">
        <button type='submit' name='add_category' class='btn btn-primary'>Добавить категорию</button>
    </form>
    <?php
} else {
    $category = new Category(trim(htmlspecialchars($_POST['name_category'])));
    $addCateg = $category->intoDb();
    
    if ($addCateg === 1062) {
        echo "<h3 class='alert alert-danger'>Kатегория \"" . trim(htmlspecialchars($_POST['name_category'])) . "\" уже существует!</h3>";
    } else {
        echo "<h3 class='alert alert-success'>Категория \"" . trim(htmlspecialchars($_POST['name_category'])) . "\" добавлена!</h3>";
    }
}

if ( ! isset($_POST['del_category']) ) { ?>
    <form action="./index.php?page=4" method='POST'>
        <?php Category::fromDbToSelect(); ?>
        <button type='submit' name='del_category' class='btn btn-danger'>Удалить категорию</button>
    </form>
    <?php
} else {
    $delCateg = Category::deleteFromDb($_POST['category_name']);
    
    if ($delCateg === 1451) {
        echo "<h3 class='alert alert-danger'>Категория \"{$_POST['category_name']}\" не была удалена, т.к. в ней присутствуют товары!</h3>";
    } else {
        echo "<h3 class='alert alert-success'>Категория \"{$_POST['category_name']}\" была удалена!</h3>";
    }
}

echo "<h3 class='mb-4 mt-5'>Панель загрузки фотографий для галереи товара</h3>";
if ( ! isset($_POST['add_photos']) ) {
    ?>
    <form action="./index.php?page=4" method="POST" enctype="multipart/form-data">
        <label for="item_id" class="form-label">Выбор товара:</label>
        <select name="item_id" class="form-select mb-3">
            <?php
            $pdo = Tools::connect();
            $list = $pdo->query("SELECT id, item_name FROM items");
            while ($row = $list->fetch()) { ?>
                <option value="<?php echo $row['id'] ?>">
                    <?php echo $row['item_name'] ?>
                </option>
                <?php
            }
            ?>
        </select>
        <input type="file" multiple name="downloadPhotos[]" class="form-control mb-3">
        <button type="submit" class="btn btn-primary" name="add_photos">Добавить изображения</button>
    </form>
    <?php
} else {
    if (!is_dir("./img")) { // если папки img не существует
        mkdir("./img", 0777, true); // пытаемся ее создать второй и третий аргумент доп настройки(читай докум.)
    }

    for ($i = 0; $i < count($_FILES['downloadPhotos']['name']); $i++) {
        if (is_uploaded_file($_FILES['downloadPhotos']['tmp_name'][$i])) {
            $pathGalleryPhoto = "img/" . $_FILES['downloadPhotos']['name'][$i];
            move_uploaded_file($_FILES['downloadPhotos']['tmp_name'][$i], $pathGalleryPhoto);

            $pathGalleryPhotoForBD = "../" . $pathGalleryPhoto;
            
            $thisImage = new Images($_POST['item_id'], $pathGalleryPhotoForBD);
            $thisImage->intoDb();
        }
    }

    echo "<h3 class='alert alert-success'>Галерея для выбранного товара, была изменена</h3>";
}