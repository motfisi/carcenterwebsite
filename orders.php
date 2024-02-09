<?php
session_start();
?>

<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link href="css/catalog.css" rel="stylesheet">
  <link href="css/orders.css" rel="stylesheet">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/itc-slider1.css" rel="stylesheet">
  <script src="js/itc-slider.js" defer></script>
  <title>Заказы</title>

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
header("Location: index.php");
}

?>
      </header>
    <div class="products">
      <?php
// Подключение к базе данных


// Получение информации об автомобиле, забронированном пользователем с определенным ID и isreserved=1

$sql = "SELECT * FROM `cars` WHERE `user_reserved` = '$user_id' AND `isreserved` = '1'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
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
        if ($reserved == 1) {
            echo "<div class='reserved'>ЗАБРОНИРОВАНО ВАМИ</div>";
        }
        echo "</div></div></div>";
    }
} else {
    echo "<div class='noreserved'>Нет забронированных автомобилей для этого пользователя.</div>";
}

$conn->close();
?>
</div>

<footer>
        +375 29 270-06-53<br>
        +375 29 624-53-80<br>
        ул. Богдана Хмельницкого, 9a
        <div class="rights">ⓒ All rights reserved. <br> Designed by <a href="https://t.me/ildjay" class="hrefs">ildjay</a>.<br>Created by <a href="https://t.me/motfisi" class="hrefs">motfisi</a>.</div>
      </footer>

 </body>
</html>