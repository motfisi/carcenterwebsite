<?php
// Подключаемся к базе данных и получаем данные о товаре с заданным ID
require 'config_db.php';
$id = $_GET['id'];
$query = "SELECT * FROM `cars` WHERE `id` = '$id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Формируем ответ в формате JSON
    $response = array(
        'title' => $row['brand'] . ' ' . $row['model'],
        'price' => $row['price']
    );
    echo json_encode($response);
} else {
// Если товар с заданным ID не найден, возвращаем ошибку 404
header('HTTP/1.0 404 Not Found');
}
?>