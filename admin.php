
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link href="css/admin.css" rel="stylesheet">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="css/itc-slider1.css" rel="stylesheet">
  <script src="js/itc-slider.js" defer></script>
  <title>Админ-панель</title>

  <!--[if lt IE 9] --> 
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> 
  <!--[endif]-->

 </head>
 <body>
 <?php
session_start();
require 'php/config_db.php';
// Проверяем, находится ли пользователь в состоянии аутентификации
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
// Получаем данные пользователя из базы данных
    $query = "SELECT `isadmin` FROM `clients` WHERE `id`='$user_id'";
    $result = $conn->query($query);

if ($result->num_rows == 1) {
    $user_data = $result->fetch_assoc();
    $isadmin = $user_data['isadmin'];
    if ($isadmin != 1) {
    header("Location: index.php");
    exit();
}
}
} else {
    header("Location: index.php");
    exit();
}
?>
    <header>
        <div class="button-container">
          <div class="center-buttons">
            <!-- Центральные кнопки -->
            <a href="index.php"><button>Главная</button></a>
            <a href="catalog.php"><button>Каталог</button></a>
            <a href="about.php"><button>О нас</button></a>

          <?php
          require 'php/config_db.php';


// Проверяем, был ли пользователь аутентифицирован
if (isset($_SESSION['user_id'])) {
// Пользователь авторизован
$user_id = $_SESSION['user_id'];
// Получаем данные пользователя из базы данных
$query = "SELECT `name`, `isadmin` FROM `clients` WHERE `id`='$user_id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    echo '<a href="orders.php"><button>Мои заказы</button></a>';
    echo '</div>';
    $user_data = $result->fetch_assoc();
    $name = $user_data['name'];
    $isadmin = $user_data['isadmin'];
    echo '<div class="user-section">';
    echo "Привет, $name! ";
    echo '<a href="php/logout.php"><button>Выход</button></a>';
    echo '</div>';
    
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


?>


      </header>

      <form name="add_car" action="php/add_car.php" method="post" enctype="multipart/form-data">
    <h1>Добавить автомобиль</h1>
    <label for="name">Бренд:</label>
    <input type="text" name="brand" id="brand" required >
    <label for="name">Модель:</label>
    <input type="text" name="model" id="model" required >
    <label for="description">Описание:</label>
    <input type="text" name="description" id="description" required >
    <label for="photo1">Фото 1:</label>
    <input type="file" name="photo1" id="photo1" required > 
    <label for="photo2">Фото 2:</label>
    <input type="file" name="photo2" id="photo2" required > 
    <label for="photo3">Фото 3:</label>
    <input type="file" name="photo3" id="photo3" > 
    <label for="price">Цена:</label>
    <input type="text" name="price" id="price" required >

    <button type="submit">Добавить товар</button>
</form>

<div class="showusers">
    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=a0897889_carcenter;charset=utf8", "a0897889_carcenter", "coJ6tThB");

// Получаем текущую страницу
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Вычисляем количество пользователей в базе данных и количество страниц
$count_users = $pdo->query("SELECT COUNT(*) FROM `clients`")->fetchColumn();
$total_pages = ceil($count_users / 25);

// Вычисляем номер первой записи для текущей страницы
$offset = ($current_page - 1) * 25;

$sort_order = isset($_GET['sort']) && $_GET['sort'] == "asc" ? "ASC" : "DESC";

// Получаем данные о пользователях из базы данных
$stmt = $pdo->prepare("SELECT `id`, `name`, `email`, `phone`, `date_register` FROM `clients` ORDER BY date_register $sort_order LIMIT :offset, 25");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Список пользователей</h1> <table> <thead> <tr> <th>ID</th> <th>Имя</th> <th>Email</th> <th>Телефон</th> <th>Дата регистрации</th> </tr> </thead> <tbody> <?php foreach ($users as $user) : ?> <tr> <td><?php 
echo $user['id']; ?></td>
<td><?php echo $user['name']; ?></td>
<td><?php echo $user['email']; ?></td>
<td><?php echo $user['phone']; ?></td>
<td><?php echo $user['date_register']; ?></td>
</tr>
<?php endforeach; ?>
</tbody>

</table> <!-- Выводим на страницу кнопки для навигации по страницам и фильтры для сортировки --> <div class="pagination"> <?php if ($current_page > 1) : ?> <a href="?page=<?php echo $current_page - 1; ?>&sort=<?php echo $sort_order; ?>">Предыдущая</a> <?php endif; ?><?php for ($i = 1; $i <= $total_pages; $i++) : ?>
<a href="?page=<?php echo $i; ?>&sort=<?php echo $sort_order; ?>"><?php echo $i; ?></a>
<?php endfor; ?>

<?php if ($current_page < $total_pages) : ?>
<a href="?page=<?php echo $current_page + 1; ?>&sort=<?php echo $sort_order; ?>">Следующая</a>
<?php endif; ?></div> <form method="get"> <fieldset> <legend>Сортировка</legend> <input type="hidden" name="page" value="1"> <label> <input type="radio" name="sort" value="desc" <?php if ($sort_order == "DESC") echo "checked"; ?>> Новые сверху </label> <label> <input type="radio" name="sort" value="asc" <?php if ($sort_order == "ASC") echo "checked"; ?>> Старые сверху </label> <button name="sort" type="submit">Применить</button> </fieldset> </form>
  



  </div>
<div class="ord">ЗАКАЗЫ</div>
<div class="products">

  <?php
// Подключение к базе данных

// Получение информации об автомобилях, забронированных пользователем с определенным ID и isreserved=1


$sql = "SELECT * FROM `cars` WHERE `user_reserved` != '0' AND isreserved = '0'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="product">';
        $id = $row['id'];
        $brand = $row['brand'];
        $model = $row['model'];
        $user_id = $row['user_reserved'];
        $reserved = $row['isreserved'];

        $sql1 = "SELECT `name`, `phone`, `email` FROM `clients` WHERE `id` = '$user_id'";
        $result1 = $conn1->query($sql1);
        if ($result1->num_rows > 0) {
        while ($row1 = $result1->fetch_assoc()) {  
          $user_name = $row1['name'];
          $user_email = $row1['email'];
          $user_phone = $row1['phone'];
        }
      }
      
        
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
        echo "<div class='customer'>Заказчик:</div>";
        echo "<div class='info'>Имя: $user_name</div>";
        echo "<div class='info'>Почта: $user_email</div>";
        echo "<div class='info'>Телефон: $user_phone</div>";

        echo "<form name ='ord' method='post' action='php/approve_car.php'>";
        echo "<input type='hidden' name='id' value='$id'>";

        echo "<button type='submit' name='approve'>Одобрить</button>";
        echo "<button type='submit' name='reject'>Отклонить</button>";

        echo "</form>";
        echo "</div></div>";
    }
} else {
  
    echo "<div class='no_orders'>Нет заказов.</div>";
}
echo "</div>";


$conn1->close();
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