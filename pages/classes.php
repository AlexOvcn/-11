<?php

class Tools
{
    static function connect(
        $host = "localhost",
        $user = "root",
        $pass = "",
        $dbname = "site_3"): bool|PDO
    {
        $cs = "mysql:host=$host;dbname=$dbname;charset=utf8;";
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
        );

        try {
            return new PDO($cs, $user, $pass, $options);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    static function register($name, $password, $imagePath, $confirm_password): bool
    {
        $name = trim($name);
        $password = trim($password);
        $imagePath = trim($imagePath);

        if ($name == "" || $password == "" || $confirm_password == '') {
            echo "<h3/><span style='color:red;'>Заполните все обязательные поля!</span><h3/>";
            return false;
        }

        if (strlen($name) < 3 || strlen($name) > 30 || strlen($password) < 3 || strlen($password) > 30) {
            echo "<h3/><span style='color:red;'>Кол-во символов должно быть от 3 до 20!</span><h3/>";
            return false;
        }

        // проверка для подтверждения пароля
        if ( $password !== $confirm_password ) {
            echo '<h3><span style="color:red;">Поля с паролем и подтверждением пароля не совпадают!</span></h3>';
            return false;
        }

        Tools::connect();
        $customer = new Customer($name, $password, $imagePath);
        $err = $customer->intoDb();
        if ($err) {
            if ($err == 1062)
                echo "<h3/><span style='color:red;'>Такой пользователь уже существует!</span><h3/>";
            else
                echo "<h3/><span style='color:red;'>Код ошибки:" . $err . "!</span><h3/>";
            return false;
        }
        return true;
    }

    static function login($name, $pass): bool
    {
        try {
            // Убираем пробелы в начале и конце строки функцией trim()
            // Преобразуем специальные символы в HTML-сущности
            $name=trim(htmlspecialchars($name));
            $pass=trim(htmlspecialchars($pass));

            // Проверка на незаполненные поля
            if ($name=="" || $pass=="") {
                echo "<h3/><span style='color:red;'>Заполните обязательные поля!</span><h3/>";
                return false;
            }
            // Проверка на количество символов
            if (strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
                echo "<h3/><span style='color:red;'>Значение должно быть от 3 до 30 символов!</span><h3/>";
                return false;
            }
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM users WHERE login='".$name."' AND password='".md5($pass)."'");
            $ps->execute();
            if ($row = $ps->fetch()) {
                $_SESSION['reg'] = $name;
                if($row['role_id'] == 1) {
                    $_SESSION['r_admin'] = $name;
                }
                return true;
            }
            // Если пользователь не найден, выводим сообщение
            else {
                echo "<h3/><span style='color:red;'>Нет такого пользователя!</span><h3/>";
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

class Rating
{
    public $id; // ID оценки
    public $item_id; // ID товара
    public $user_id; // ID пользователя
    public $rating_value; // оценка

    function __construct($item_id, $user_id, $rating_value, $id = 0)
    {
        $this->id = $id;
        $this->item_id = $item_id;
        $this->user_id = $user_id;
        $this->rating_value = $rating_value;
    }

    function intoDb()
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("INSERT INTO Rating(item_id, user_id, rating_value) VALUES (:item_id, :user_id, :rating_value)");
            // Преобразование объекта класса в массив
            $array = (array)$this;
            // Убираем из массива первый элемент ($id)
            array_shift($array);
            // Отправляем SQL-запрос
            $ps->execute($array);
            return true;
        } catch (PDOException $e) {
            $err = $e->getMessage();
            // Проверка на уникальность записи
            if (substr($err, 0, strrpos($err, ":")) == 'SQLSTATE[23000]: Integrity constraint violation')
                return 1062;
            else 
                return $e->getMessage();
        }
    }
    static function fromDb($item_id): bool|float|string
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT AVG(rating_value) AS rating FROM rating WHERE item_id=?");
            $ps->execute(array($item_id));
            $row = $ps->fetch();
            if ($row['rating'] === null) {
                return '--';
            }
            return round($row['rating'], 1);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    static function fromDbForUser($user_id, $item_id)
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT rating_value FROM rating WHERE user_id=? AND item_id=?");
            $ps->execute(array($user_id, $item_id));
            $row = $ps->fetch();
            if ($row === false) {
                return false;
            }
            return $row['rating_value'];
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

class Images
{
    public $id; // ID картинки
    public $item_id; // ID товара
    public $image_path; // Путь до картинки

    function __construct($item_id, $image_path, $id = 0)
    {
        $this->id = $id;
        $this->item_id = $item_id;
        $this->image_path = $image_path;
    }

    function intoDb()
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("INSERT INTO images(item_id, image_path) VALUES (:item_id, :image_path)");
            // Преобразование объекта класса в массив
            $array = (array)$this;
            // Убираем из массива первый элемент ($id)
            array_shift($array);
            // Отправляем SQL-запрос
            $ps->execute($array);
        } catch (PDOException $e) {
            return $err = $e->getMessage();
        }
    }
    static function drawPhoto($item_id): bool|string
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM images WHERE item_id=?");
            $ps->execute(array($item_id));
            while ($row = $ps->fetch()) {
                echo (
                    "<a href=" . $row['image_path'] . " target='_blank' >" .
                        "<img src=" . $row['image_path'] . ">" .
                    "</a>"
                );
            }
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $e;
        }
    }
}

class Customer
{
    public $id; // ID пользователя
    public $login; // Логин пользователя
    public $password; // Пароль пользователя
    public $role_id; // Роль пользователя
    public $discount; // Персональная скидка пользователя
    public $total; // Общая сумма покупок пользователя
    public $image_path; // Путь к изображению пользователя

    function __construct($login, $password, $image_path, $id = 0)
    {
        $this->login = $login;
        $this->password = md5($password);
        $this->image_path = $image_path;
        $this->id = $id;
        $this->total = 0;
        $this->discount = 0;
        $this->role_id = 2;
    }

    function intoDb()
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("INSERT INTO users(login, password, role_id, discount, total, image_path) VALUES (:login, :password, :role_id, :discount, :total, :image_path)");
            // Преобразование объекта класса в массив
            $array = (array)$this;
            // Убираем из массива первый элемент ($id)
            array_shift($array);
            // Отправляем SQL-запрос
            $ps->execute($array);
        } catch (PDOException $e) {
            $err = $e->getMessage();
            // Проверка на уникальность записи
            if (substr($err, 0, strrpos($err, ":")) == 'SQLSTATE[23000]: Integrity constraint violation')
                return 1062;
            else
                return $e->getMessage();
        }
    }

    static function fromDb($login): bool|Customer
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM users WHERE login=?");
            $ps->execute(array($login));
            $row = $ps->fetch();

            return new Customer(
                $row['login'],
                $row['password'],
                $row['image_path'],
                $row['id']
            );
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

class Category
{
    public $id, $category;

    function __construct($category, $id = 0)
    {
        $this->id = $id;
        $this->category = $category;
    }
    function intoDb()
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("INSERT INTO categories(category) VALUES (:category)");
            $array = (array)$this;
            array_shift($array);
            $ps->execute($array);
        } catch(PDOException $e)
        {
            $err = $e->getMessage();
            // Проверка на уникальность записи
            if (substr($err, 0, strrpos($err, ":")) == 'SQLSTATE[23000]: Integrity constraint violation')
                return 1062;
            else
                return $e->getMessage();
        }
    }
    static function fromDbToSelect()
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM categories");
            $ps->execute();
            
            echo "<select name='category_name' class='form-select w-25 d-inline me-3'>";
            echo "<option>Выберите категорию</option>";
            while ($row = $ps->fetch()) {
                echo "<option>" . $row['category'] . "</option>";
            }
            echo "</select>";
        } catch(PDOException $e)
        {
            return $e->getMessage();
        }
    }
    static function deleteFromDb($category)
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("DELETE FROM categories WHERE category = ?");
            $ps->execute(array($category));
        } catch(PDOException $e)
        {
            $err = $e->getMessage();
            // Проверка на ограничение внешнего ключа, категория не может удалиться потому что есть строчка из таблицы items которая ссылается на нее и имеет ограничение на удаление RESTRICT
            if (substr($err, 0, strrpos($err, ":")) == 'SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row')
                return 1451;
            else
                return $e->getMessage();
        }
    }
}

class Item
{
    public $id, $item_name, $category_id, $price, $price_sale, $info, $image_path, $action;

    function __construct($item_name, $category_id, $price, $price_sale,
                         $info, $image_path, $action = 0, $id = 0)
    {
        $this->id = $id;
        $this->item_name = $item_name;
        $this->category_id = $category_id;
        $this->price = $price;
        $this->price_sale = $price_sale;
        $this->info = $info;
        $this->image_path = $image_path;
        $this->action = $action;
    }

    /*
     * Запись нового товара в БД
     */
    function intoDb()
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("INSERT INTO items (item_name, category_id, price, price_sale, info, image_path, action) VALUES (:item_name, :category_id, :price, :price_sale, :info, :image_path, :action)");
            $array = (array)$this;
            array_shift($array);
            $ps->execute($array);
        } catch(PDOException $e)
        {
            return $e->getMessage();
        }
    }

    /*
     * Получение товара из БД по id
     */
    static function fromDb($id)
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM items WHERE id=?");
            $ps->execute(array($id));
            $row = $ps->fetch();

            if ($row === false) {
                return false;
            }

            return new Item(
                $row['item_name'],
                $row['category_id'],
                $row['price'],
                $row['price_sale'],
                $row['info'],
                $row['image_path'],
                $row['action'],
                $row['id']);
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /*
     * Получение товаров по категории из БД
     */
    static function getItems($category_id = 0): bool|array
    {
        $items = false;
        try {
            $pdo = Tools::connect();
            if($category_id == 0) {
                $ps = $pdo->prepare('select * from items');
                $ps->execute();
            } else {
                $ps = $pdo->prepare ('select * from items where category_id=?');
                $ps->execute(array($category_id));
            }
            while ($row = $ps->fetch()) {
                $item = new Item(
                    $row['item_name'],
                    $row['category_id'],
                    $row['price'],
                    $row['price_sale'],
                    $row['info'],
                    $row['image_path'],
                    $row['action'],
                    $row['id']
                );
                $items[] = $item;
            }
            return $items;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /*
     * Генерация верстки карточки товара
     */
    function draw()
    {
        if ( ! isset($_SESSION['reg']) || $_SESSION['reg'] == "") {
            $r_user = 'cart_'.$this->id;
        } else {
            $r_user = $_SESSION['reg'].'_'.$this->id;
        }

        echo '<div class="card">';
        echo '<img src="'.$this->image_path.'" class="card-img-top" alt="'.$this->item_name.'">';
        echo '<div>';
        echo '<h5 class="card-title">';
        echo '<a href="pages/item_info.php?name='.$this->id.'" target="_blank">'.$this->item_name.'</a></h5>';
        echo '<p class="card-text">'.$this->info.'</p>';
        echo '<div class="card-price">';
        echo '<span class="text-danger" style="font-size:24px;margin-right: 10px;">'.$this->price_sale.' ₽</span>';
        echo '<span><s>'.$this->price.' ₽</s></span></div>';
        echo "<button class='btn btn-primary' onclick=createCookie('".$r_user."','".$this->id."')>В корзину</button>";
        echo '</div></div>';
    }

    function sale()
    {
        try {
            $pdo = Tools::connect();
            $r_user = 'cart';
            if( isset($_SESSION['reg']) && $_SESSION['reg'] != "" ) {
                $r_user = $_SESSION['reg'];
            }

            // Устанавливаем общую сумму покупки
            $sql = "UPDATE users SET total = total + ? WHERE login = ?";
            $ps = $pdo->prepare($sql);
            $ps->execute(array($this->price_sale, $r_user));
            //Inserting info about sold item into table Sales
            $ins = "INSERT INTO sales (user_name,item_name,price,price_sale,date_sale) VALUES (?,?,?,?,?)";
            $ps = $pdo->prepare($ins);
//            $ps->execute(array($r_user, $this->item_name,$this->price,$this->price_sale, @date("Y/m/d H:i:s")));
            $ps->execute(array("$r_user", "$this->item_name","$this->price","$this->price_sale", @gmdate("Y-m-d H:i:s")));

            //Удаляем продукт из БД
            // $del = "DELETE FROM Items WHERE id = ?";
            // $ps = $pdo->prepare($del);
            // $ps->execute(array($this->id));

        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}