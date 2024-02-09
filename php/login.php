<?php
session_start();

// Проверяем, была ли отправлена форма
if (isset($_POST['submit'])) {
// Соединяемся с базой данных
require 'config_db.php';

// Получаем данные из формы
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$hashed_password = hash('sha256', $password);

// Проверяем наличие пользователя в базе данных
$query = "SELECT * FROM `clients` WHERE `email`='$email' AND `password`='$hashed_password'";

$result = $conn->query($query);

if ($result->num_rows == 1) {
    // Пользователь найден, сохраняем идентификатор сессии и перенаправляем на главную страницу
    $_SESSION['user_id'] = $result->fetch_assoc()['id'];
    header('Location: ../index.php');
    exit();
} else {
    // Пользователь не найден в базе данных или не подтвердил регистрацию
     $_SESSION['error'] = 'Неверный email или пароль.';
     header('Location: ../auth.php');
}

$conn->close();
}
?>
