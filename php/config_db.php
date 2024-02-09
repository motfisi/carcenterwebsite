<?php
$host = 'localhost';
  $username = 'root';
  $password = 'rootpass';
  $dbname = 'carcenter';

// Соединяемся с БД
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$conn1 = new mysqli($host, $username, $password, $dbname);
if ($conn1->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>
