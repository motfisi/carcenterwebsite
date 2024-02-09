<?php
    const TOKEN = '6307260334:AAGXVzJ7EfYd9ZGsprxBjSK2qH7qu6qprjU';

// ID чата
      const CHATID = '396688171';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы заказа
    $car_id = $_POST['car_id'];
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $phone = $_POST['phone'];

    // Получаем данные о товаре из БД
    require 'config_db.php';

    $query = "UPDATE `cars` SET `user_reserved` = '$user_id' WHERE `id` = '$car_id'";
    $result = $conn->query($query);

    $query = "SELECT `brand`, `model` FROM `cars` WHERE `id` = '$car_id'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $brand = $row['brand'];
        $model = $row['model'];
        

        /*https://api.telegram.org/bot6206636684:AAH_B4YjZmdw3b9ie6O6CoE5X94WY1ht-fM/getUpdates*/
        $txt = "Заказ на товар: $brand $model\r\nИмя заказчика: $name\nТелефон заказчика: $phone\nEmail заказчика: $email\nКомментарий к заказу: $comment";

        $textSendStatus = @file_get_contents('https://api.telegram.org/bot'. TOKEN .'/sendMessage?chat_id=' . CHATID . '&parse_mode=html&text=' . urlencode($txt));
        

        // Отправляем email
        $to = 'matthew.ermakovich@gmail.com';
        $subject = 'Новый заказ на ' . $brand;
        $message = "Заказ на товар: $brand $model\r\nИмя заказчика: $name\r\nТелефон заказчика: $phone\r\nEmail заказчика: $email\r\nКомментарий к заказу: $comment";
        $headers = "From: order@example.com\r\n" .
                   "Reply-To: $email\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            echo "Ваш заказ был принят, мы свяжемся с вами в ближайшее время для уточнения деталей.";
            header('Location: ../catalog.php');
} else {
    echo "Ошибка отправки заказа. Попробуйте еще раз.";
}
} else {
    echo "Товар не найден";
}
$conn->close();
}
?>