<?php
session_start();
if (isset($_SESSION['user_id'])) {
    require 'config_db.php';

    $user_id = $_SESSION['user_id'];
    // Получаем данные пользователя из базы данных
    $query = "SELECT `name`, `phone`, `email` FROM `clients` WHERE `id`='$user_id'";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
    $user_data = $result->fetch_assoc();
    $name = $user_data['name'];
    $phone = $user_data['phone'];
    $email = $user_data['email'];
}
    $response = array('status' => 'authorized', 'name' => $name, 'email' => $email, 'phone' => $phone);
} else {
    $response = array('status' => 'unauthorized');
}
echo json_encode($response);
?>