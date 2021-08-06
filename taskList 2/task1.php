<?php

// 1 задание
echo '1) Задание <br> <br>';

if (!isset($_POST['send']) || empty($_POST['subscribe'])) {
?>
<form action="task1.php" method='POST'>
    <input type="email" name="email" placeholder=' Your email'>
    <label>
        <input type="checkbox" name="subscribe" value="subscribe">
        Subscribe
    </label>
    <button type='submit' name='send' value='send'>Send</button>
</form>
<?php } elseif ($_POST['subscribe'] === 'subscribe'){
    echo 'Thank you';
}