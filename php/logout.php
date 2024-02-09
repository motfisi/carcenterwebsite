<?php
session_start();

// Удаляем идентификатор сессии пользователя
unset($_SESSION['user_id']);

// Очищаем данные сессии
session_unset();
session_destroy();

// Перенаправляем пользователя на страницу входа
header('Location: ../index.php');
exit();
?>
