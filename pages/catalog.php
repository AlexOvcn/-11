<div class="mt-3 mb-3">
    <h1 class="h1">Каталог товаров</h1>
</div>

<?php
require_once 'classes.php'; 

?>

<form action="../index.php?page=1">
    <div class="form-group mb-3">
        <label for="category_id" class="form-label">Категория:</label>
        <select name="category_id" class="form-select" onchange="getItemsCategory(this.value)">
            <option value="0">Выберите категорию</option>
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

</form>

<div id="result" class="gridContainer">
    <?php
    $items = Item::getItems();

    if (empty($items)) exit();
    
    foreach ($items as $item) {
        $item->draw();
    }
    ?>
</div>