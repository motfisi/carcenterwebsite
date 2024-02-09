<?php
require 'config_db.php';

// Получаем список категорий из базы данных
$sql = "SELECT DISTINCT `name` FROM `products`";
$result = $conn->query($sql);
$names = array();
while ($row = $result->fetch_assoc()) {
    $names[] = $row['name'];
}

// Проверяем, был ли отправлен фильтр по категориям
if (isset($_GET['names'])) {
    $selected_names = $_GET['names'];
    // Делаем проверку на пустой массив
    if (!empty($selected_names)) {
        $sql = "SELECT * FROM `products` WHERE ";
        foreach ($selected_names as $name) {
            if (in_array($name, $names)) {
                $sql .= "name = '$name' OR ";
            }
        }
        $sql = rtrim($sql, " OR ");
        $result = $conn->query($sql);
    } else {
        $result = $conn->query("SELECT * FROM `products`");
    }
} else {
    $result = $conn->query("SELECT * FROM `products`");
}

// Выводим список товаров на экран
while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
          $photo = $row['photo'];
          $id = $row['id'];
          echo "<div class='section'>
                    $name
                    <br />
                    <img class='imgs' src='images/$photo'>
                    <div class='button' onclick='order($id)'>ЗАКАЗАТЬ</div>";

            if ($isadmin) {
            echo "<form name='delete_form' method='post' action='php/delete_product.php'>
            <input type='hidden' name='id' value='$id'>
            <button class='button button1' type='submit'>🗑️</button>
            </form>";
            }
               echo  "</div>";
           }
  ?>