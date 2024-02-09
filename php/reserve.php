<?php
// соединяемся с базой данных (замените значения параметров на свои)
require 'config_db.php';

// получаем id продукта из формы
$id = $_POST['id'];

// получаем текущее значение поля isreserved в базе данных для выбранного продукта
$sql = "SELECT `isreserved` FROM `cars` WHERE `id`=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$isreserved = $row['isreserved'];

// обновляем значение поля isreserved на противоположное
if ($isreserved == 0) {
    $sql = "UPDATE `cars` SET `isreserved`=1 WHERE `id`=$id";
} else {
$sql = "UPDATE `cars` SET `isreserved`=0, `user_reserved`=0 WHERE `id`=$id";
}

if ($conn->query($sql) === TRUE) {
// обновление выполнено успешно
header("Location: ../catalog.php");
} else {
echo "Ошибка при обновлении: " . $conn->error;
}

$conn->close();
?>
