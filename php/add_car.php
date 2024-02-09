<?php
require 'config_db.php';

// Обработка данных формы для добавления товара
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $photo1 = $_FILES['photo1']['name'] ?? null;
    $tmp_name1 = $_FILES['photo1']['tmp_name'] ?? null;
    $photo2 = $_FILES['photo2']['name'] ?? null;
    $tmp_name2 = $_FILES['photo2']['tmp_name'] ?? null;
    $photo3 = $_FILES['photo3']['name'] ?? null;
    $tmp_name3 = $_FILES['photo3']['tmp_name'] ?? null;

    // Загрузка файла фото товара
// Генерация уникальных имен файлов


$uniqueName1 = null;
$uniqueName2 = null;
$uniqueName3 = null;

// Загрузка файла фото товара
if ($photo1 && $tmp_name1) {
    $uniqueName1 = uniqid() . '_' . $photo1;
    $target_dir = '../images/';
    $target_file = $target_dir . basename($uniqueName1);
    if (move_uploaded_file($tmp_name1, $target_file)) {
        // Файл успешно загружен
    } else {
        header('Location: add_car.php?message=error&error=upload');
        exit();
    }
}

if ($photo2 && $tmp_name2) {
    $uniqueName2 = uniqid() . '_' . $photo2;
    $target_file = $target_dir . basename($uniqueName2);
    if (move_uploaded_file($tmp_name2, $target_file)) {
        // Файл успешно загружен
    } else {
        header('Location: add_car.php?message=error&error=upload');
        exit();
    }
}

if ($photo3 && $tmp_name3) {
    $uniqueName3 = uniqid() . '_' . $photo3;
    $target_file = $target_dir . basename($uniqueName3);
    if (move_uploaded_file($tmp_name3, $target_file)) {
        // Файл успешно загружен
    } else {
        header('Location: add_car.php?message=error&error=upload');
        exit();
    }
}

// Добавление товара в БД с уникальными именами файлов
$query = "INSERT INTO `cars` (`brand`, `model`, `description`, `photo1`, `photo2`, `photo3`, `price`) VALUES ('$brand', '$model', '$description', '$uniqueName1', '$uniqueName2', '$uniqueName3', '$price')";
if ($conn->query($query)) {
    header('Location: ../admin.php?message=success');
    exit();
} else {
    header('Location: add_car.php?message=error&error=conn');
    exit();
}
}
?>
