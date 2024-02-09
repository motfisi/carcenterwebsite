<?php
require 'config_db.php';

// Получаем идентификатор товара из запроса
$id = $_POST['id'];

// Удаляем товар из БД
$query = "DELETE FROM `cars` WHERE `id` = $id";
if ($conn->query($query)) {
    header('Location: ../catalog.php?message=deleted');
    exit();
} else {
    header('Location: ../catalog.php?message=error');
    exit();
}
?>