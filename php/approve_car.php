<?php
require 'config_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve'])) {
        $car_id = $_POST['id'];

        // Обновление значения isreserved в таблице cars на 1 для одобрения заказа
        $approve_query = "UPDATE `cars` SET `isreserved` = '1' WHERE `id` = $car_id";
        if ($conn->query($approve_query)) {
            echo "Заказ одобрен!";
            header('Location: ../admin.php');
        } else {
            echo "Ошибка одобрения заказа: " . $conn->error;
        }
    } elseif (isset($_POST['reject'])) {
        $car_id = $_POST['id'];

        // Обновление значения user_reserved в таблице cars на 0 для отклонения заказа
        $reject_query = "UPDATE `cars` SET `user_reserved` = '0' WHERE `id` = $car_id";
        if ($conn->query($reject_query)) {
            echo "Заказ отклонен!";
            header('Location: ../admin.php');
        } else {
            echo "Ошибка отклонения заказа: " . $conn->error;
        }
    }
}
$conn->close();
?>
