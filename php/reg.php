<?php
session_start();

// Соединение с базой данных

require 'config_db.php';

// Обработка формы регистрации

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = hash('sha256', $password);
    $phone = mysqli_real_escape_string($conn, $_POST['tel']);

    // Проверка на существующий email в базе данных
    $query = "SELECT * FROM `clients` WHERE `email`='$email'";

    $result = $conn->query($query);

    if ($result->num_rows == 0) {
        $activation_code = bin2hex(random_bytes(16));
        $activated = 0;

        // Добавляем нового пользователя в базу данных
        $query = "INSERT INTO `clients` (`name` , `email`, `password`, `phone`, `activation_code`, `activated`) VALUES ('$name', '$email', '$hashed_password', '$phone', '$activation_code', '$activated')";

            if ($conn->query($query) === TRUE) {
        // Отправляем email со ссылкой для подтверждения почты
        $to = $email;
        $subject = 'Подтверждение регистрации на сайте';
        $message = 'Пожалуйста, подтвердите свой email, перейдя по ссылке: http://a0897889.xsph.ru/php/confirm.php?code='.$activation_code;
        $headers = 'From: noreply@mysite.com' . "\r\n" .
            'Reply-To: noreply@mysite.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        // Перенаправляем пользователя на страницу подтверждения email
        header('Location: ../confirm.php');
        exit();
    } else {
        echo "Ошибка: " . $query . "<br>" . $conn->error;
    }
} else {
    // Email уже зарегистрирован
    $_SESSION['error'] = 'Этот email уже зарегистрирован на сайте. Пожалуйста, используйте другой email адрес.';
    header('Location: ../register.php');
}

$conn->close();
}

?>