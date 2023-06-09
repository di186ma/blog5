<?php

// Параметры подключения к базе данных
$host = '92.246.214.15:3306'; // Хост базы данных
$dbname = 'ais_cuguy2103_database'; // Имя базы данных
$username = 'ais_cuguy2103_database'; // Имя пользователя базы данных
$password = 'K8I4tj5RHxDFmv4tEV3K7pvX'; // Пароль пользователя базы данных

try {
    /** @var PDO|false $conn */
    $conn= new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage(), $e->getCode();
    die();
}

