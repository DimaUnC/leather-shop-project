<?php
$host = 'localhost';
$db   = 'leather_shop';
$user = 'root'; // По умолчанию в Debian у root нет пароля для локальных соединений
$pass = '';
$charset = 'utf8mb4';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset($charset);
} catch (mysqli_sql_exception $e) {
    throw new mysqli_sql_exception($e->getMessage(), $e->getCode());
}
?>