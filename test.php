<?php

// Список файлов, которые вы хотите протестировать
$scripts = [
    'php/add_car.php',
    'php/approve_car.php',
    'php/check_auth.php',
    'php/config_db.php',
    'php/confirm.php',
    'php/delete_product.php',
    'php/get_car.php',
    'php/login.php',
    'php/logout.php',
    'php/reg.php',
    'php/reserve.php',
    'php/send_mail.php',
    // Добавьте сюда все нужные скрипты для тестирования
];

// Функция для тестирования скриптов
function runTests($scripts)
{
    $errors = [];
    
    // Проходимся по каждому скрипту и тестируем его
    foreach ($scripts as $script) {
        ob_start(); // Начинаем буферизацию вывода
        
        // Запускаем скрипт и проверяем на наличие ошибок
        include $script;
        $output = ob_get_clean(); // Получаем содержимое буфера вывода
        
        if (strpos($output, 'error') !== false) {
            $errors[] = "Ошибка в скрипте: $script";
        }
    }
    
    return $errors;
}

// Запускаем тесты
$testErrors = runTests($scripts);

// Проверяем наличие ошибок
if (empty($testErrors)) {
    echo "Тест успешно пройден. Ни один скрипт не выдал ошибку.";
} else {
    // Выводим найденные ошибки
    foreach ($testErrors as $error) {
        echo "$error<br>";
    }
}
?>
