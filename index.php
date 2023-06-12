<?php

use Dotenv\Dotenv;
use Framework\Container;


session_start(["use_strict_mode" => true]);

date_default_timezone_set('Asia/Yekaterinburg');
if ( file_exists(dirname(__FILE__).'/vendor/autoload.php') ) {
    require_once dirname(__FILE__).'/vendor/autoload.php';
}
if (file_exists(".env"))
{
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load(); //все параметры окружения помещаются в массив $_ENV
    echo "Окружение загружено<p>";
    // var_dump($_ENV);
}
else {
    echo "Ошибка загрузки ENV<br>";
}
Container::getApp()->run();


exit();



require 'dbconnect.php';

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Получение всех постов
$query = "SELECT posts.*, users.email, COUNT(likes.id) AS like_count
          FROM posts 
          JOIN users ON posts.user_id = users.id 
          LEFT JOIN likes ON posts.id = likes.post_id
          GROUP BY posts.id
          ORDER BY posts.created_at DESC";
$result = $conn->query($query);
$posts = $result->fetchAll(PDO::FETCH_ASSOC);

// Отображение шапки страницы
include 'header.php';
include 'menu.php';
include 'footer.php';
