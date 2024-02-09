<?php
session_start();
?>

<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link href="css/about.css" rel="stylesheet">

  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/itc-slider.css" rel="stylesheet">
  <script src="js/itc-slider.js" defer></script>
  <title>О нас</title>

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
      
      <img src="images/about.png" class="img_about">
      <div class="text1">
        О НАС
      </div>
      <div class="text2">
        Всегда лучшие авто по лучшим ценам!
      </div>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d349.2501342068478!2d27.59439265106602!3d53.92347360457794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46dbcf090d6e1279%3A0x93708c2b808ff792!2z0JHQndCi0KMgLSDQmtC-0YDQv9GD0YEg4oSWMTHQsCwg0YPQuy4g0JHQvtCz0LTQsNC90LAg0KXQvNC10LvRjNC90LjRhtC60L7Qs9C-LCDQnNC40L3RgdC6LCDQnNC40L3RgdC60LDRjyDQvtCx0LvQsNGB0YLRjA!5e0!3m2!1sru!2sby!4v1702838226209!5m2!1sru!2sby" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>   
       <footer>
        +375 29 270-06-53<br>
        +375 29 624-53-80<br>
        ул. Богдана Хмельницкого, 9a
        <div class="rights">ⓒ All rights reserved. <br> Designed by <a href="https://t.me/ildjay" class="hrefs">ildjay</a>.<br>Created by <a href="https://t.me/motfisi" class="hrefs">motfisi</a>.</div>
      </footer>

 </body>
</html>