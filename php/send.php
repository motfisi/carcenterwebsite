<?php
$name = $_POST['name'];
$number = $_POST['number'];
$email = $_POST['email'];
$name = htmlspecialchars($name);
$number = htmlspecialchars($number);
$email = htmlspecialchars($email);
$name = urldecode($name);
$number = urldecode($number);
$email = urldecode($email);
$name = trim($name);
$number = trim($number);
$email = trim($email);
//echo $fio;
//echo "<br>";
//echo $email;
if (mail("matthew.ermakovich@gmail.com", "Заявка с сайта", "Имя: ".$name.". \nE-mail: ".$email."\nНомер: ".$number,"From: matthewclashroyale1@gmail.com \r\n"))
 {     echo "сообщение успешно отправлено";
} else {
    echo "при отправке сообщения возникли ошибки";
}?>