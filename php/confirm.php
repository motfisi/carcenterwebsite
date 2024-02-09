<?php
session_start();

// Соединение с базой данных

require 'config_db.php';


// Обработка подтверждения email

if (isset($_GET['code'])) {
    $activation_code = mysqli_real_escape_string($conn, $_GET['code']);

    // Проверка кода активации в базе данных
    $query = "SELECT * FROM `clients` WHERE `activation_code`='$activation_code'";

    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Обновляем статус активации email в базе данных
        $query = "UPDATE `clients` SET `activated`=1 WHERE `activation_code`='$activation_code'";

        if ($conn->query($query) === TRUE) {
            // Перенаправляем пользователя на страницу входа
            header('Location: ../auth.php');
            exit();
        } else {
            echo "Ошибка: " . $query . "<br>" . $conn->error;
                }
            }
        }

$conn->close();
?>

<!DOCTYPE html> <html> <head> <meta charset="utf-8">
  <link href="../css/reg.css" rel="stylesheet">
  <link href="https://fonts.cdnfonts.com/css/helvetica-neue-9" rel="stylesheet">
  <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Подтверждение email</title> 
</head> <body> 
    <center>
    <h1>STEELHEAD'S</h1>
    <h2>Подтверждение email</h2> 
    <p>На ваш email была отправлена ссылка для подтверждения. Пожалуйста, перейдите по ней.</p> </center>
</body> 
</html>