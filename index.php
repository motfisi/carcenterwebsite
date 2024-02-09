<?php
session_start();
?>

<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link href="css/index.css" rel="stylesheet">

  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/itc-slider.css" rel="stylesheet">
  <script src="js/itc-slider.js" defer></script>
  <title>Главная</title>

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
    <div class="container">
        <div class="itc-slider" data-slider="itc-slider" data-loop="true" data-autoplay="true">
          <div class="itc-slider__wrapper">
            <div class="itc-slider__items">
              <div class="itc-slider__item">
                <img src="images/main_audi.png" class="img_slider">



              </div>
              <div class="itc-slider__item">
                <img src="images/main_benz.png" class="img_slider">



              </div>
              <div class="itc-slider__item">
                <img src="images/main_porsche.png" class="img_slider">



            </div>
          </div>
          <button class="itc-slider__btn itc-slider__btn_prev"></button>
          <button class="itc-slider__btn itc-slider__btn_next"></button>
        </div>
      </div>

 </body>
</html>