<?php
session_start();
?>

<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link href="css/catalog.css" rel="stylesheet">

  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/itc-slider1.css" rel="stylesheet">
  <link href="css/modal.css" rel="stylesheet">
  <script src="js/itc-slider.js" defer></script>
  <script src="js/order.js" defer></script>
  <title>Каталог</title>

  <!--[if lt IE 9] --> 
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> 
  <!--[endif]-->

 </head>
 <body>
 <header>
        <div class="button-container">
          <div class="center-buttons">
            <!-- Центральные кнопки -->
            <a href="index.php"><button>Главная</button></a>
            <a href="catalog.php"><button>Каталог</button></a>
            <a href="about.php"><button>О нас</button></a>

          <?php
          require 'php/config_db.php';
          $isadmin = 0;
          $user_id = 0;


// Проверяем, был ли пользователь аутентифицирован
if (isset($_SESSION['user_id'])) {
// Пользователь авторизован
$user_id = $_SESSION['user_id'];

// Получаем данные пользователя из базы данных
$query = "SELECT `name`, `isadmin`, `activated` FROM `clients` WHERE `id`='$user_id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    echo '<a href="orders.php"><button>Мои заказы</button></a>';
    echo '</div>';
    $user_data = $result->fetch_assoc();
    $name = $user_data['name'];
    $isadmin = $user_data['isadmin'];
    $activated = $user_data['activated'];
    echo '<div class="user-section">';
    echo "Привет, $name! ";
    echo '<a href="php/logout.php"><button>Выход</button></a>';
    echo '</div>';
    
    if ($activated == 0) {
      header('Location: confirm.php');
    }
    
    if ($isadmin == 1) {
      echo '<a href="admin.php"><button>АП</button></a>';
}
}
} else {
  echo '</div>';
// Пользователь не авторизован
echo '<div class="auth-buttons">';
echo '<a href="auth.php"><button>Вход</button></a>';
echo '<a href="register.php"><button>Регистрация</button></a>';
echo '</div>';
}

$conn->close();
?>

      </header>
      <?php 
require 'php/config_db.php';

// Получение списка уникальных марок из базы данных
$sql_brands = "SELECT DISTINCT `brand` FROM `cars`";
$result_brands = $conn->query($sql_brands);
$brands = array();
while ($row = $result_brands->fetch_assoc()) {
    $brands[] = $row['brand'];
}

// Получение списка уникальных моделей из базы данных
$sql_models = "SELECT DISTINCT `model` FROM `cars`";
$result_models = $conn->query($sql_models);
$models = array();
while ($row = $result_models->fetch_assoc()) {
    $models[] = $row['model'];
}

// Фильтр по марке (brand)
if (isset($_GET['brand'])) {
    $selected_brand = $_GET['brand'];
    if (!empty($selected_brand)) {
        $sql = "SELECT * FROM `cars` WHERE ";
        foreach ($selected_brand as $brand) {
            if (in_array($brand, $brands)) {
                $sql .= "brand = '$brand' OR ";
            }
        }
        $sql = rtrim($sql, " OR ");
    }
} else {
    $sql = "SELECT * FROM `cars`";
}

// Фильтр по модели (model)
if (isset($_GET['model'])) {
    $selected_model = $_GET['model'];
    if (!empty($selected_model)) {
        if (isset($selected_brand)) {
            $sql .= " AND ";
        } else {
            $sql .= " WHERE ";
        }
        $sql .= "`model` IN ('" . implode("','", $selected_model) . "')";
    }
}

// Добавление сортировки
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    switch ($sort) {
        case 'alphabet':
            $sql .= " ORDER BY brand ASC";
            break;
        case 'alphabet1':
          $sql .= " ORDER BY brand DESC";
          break;
        case 'newest':
            $sql .= " ORDER BY id DESC";
            break;
        case 'oldest':
          $sql .= " ORDER BY id ASC";
          break;
    }
}

$result = $conn->query($sql);

// HTML-форма для фильтрации и сортировки
echo "<form method='get' action='' class='filter-form'>

<br>
<label for='sort' class='sort-label'>Сортировать по:</label>
<select name='sort' id='sort' class='sort-select'>
    <option value=''>Выберите</option>
    <option value='alphabet'>По Алфавиту(от А до Я)</option>
    <option value='alphabet1'>По Алфавиту(от Я до А)</option>
    <option value='newest'>Сначала новые</option>
    <option value='oldest'>Сначала старые</option>
</select>
<button type='submit' class='apply-btn'>Применить</button>
<a href='catalog.php' class='reset-btn'>Сброс фильтров</a>
</form></div>";
echo '<div class="products">';
// Вывод найденных товаров
while ($row = $result->fetch_assoc()) {
    echo '<div class="product">';
    $id = $row['id'];
    $brand = $row['brand'];
    $model = $row['model'];
    $description = $row['description'];
    $cost = $row['price'];
    $reserved = $row['isreserved'];
    
    echo '<div class="container">';
    
    // Определение количества фотографий
    $photoCount = 0;
    for ($i = 1; $i <= 3; $i++) {
        $photoField = "photo$i";
        if (!empty($row[$photoField])) {
            $photoCount++;
        }
    }

    echo '<div class="itc-slider" data-slider="itc-slider" data-loop="true" data-autoplay="true">';
    echo '<div class="itc-slider__wrapper">';
    echo '<div class="itc-slider__items">';

    // Вывод фотографий
    for ($i = 1; $i <= $photoCount; $i++) {
        $photoField = "photo$i";
        $photoSrc = $row[$photoField];
        echo "<div class='itc-slider__item'><img src='images/$photoSrc' class='img_slider'></div>";
    }
    echo '</div>';
    echo '<button class="itc-slider__btn itc-slider__btn_prev"></button>';
    echo '<button class="itc-slider__btn itc-slider__btn_next"></button>';
    echo '</div>';
    echo '</div>';

    // Вывод информации о машине
    echo "<div class='name_car'>$brand $model</div>";
    echo "<div class='description'>$description</div>";
    echo "<div class='cost_of_car'>$cost</div>";
    echo "<div class='buttons'>";
    // Вывод кнопок в зависимости от состояния reserved и пользователя
    if ($reserved == 0) {
        echo "<div class='order_button' onclick='order($id, $user_id)'>ЗАКАЗАТЬ</div>";
    } elseif ($reserved == 1) {
        echo "<div class='reserved'>ЗАБРОНИРОВАНО</div>";
        
    }

    if($isadmin == 1 && $reserved == 0) {
      echo "<form name='delete_form' method='post' action='php/delete_product.php'>
                  <input type='hidden' name='id' value='$id'>
                  <button name='del_car' type='submit'>УДАЛИТЬ</button>
              </form>";
    }

    if($isadmin == 1 && $reserved == 1) {
        echo "<form name='delete_form' method='post' action='php/reserve.php'>
                  <input type='hidden' name='id' value='$id'>
                  <button name='del_car' type='submit'>ОТМЕНИТЬ</button>
              </form>";
      }
    
    echo "</div></div></div>";
}
echo "</div>";
$conn->close();
?>



<footer>
        +375 29 270-06-53<br>
        +375 29 624-53-80<br>
        ул. Богдана Хмельницкого, 9a
        <div class="rights">ⓒ All rights reserved. <br> Designed by <a href="https://t.me/ildjay" class="hrefs">ildjay</a>.<br>Created by <a href="https://t.me/motfisi" class="hrefs">motfisi</a>.</div>
      </footer>


 </body>
</html>