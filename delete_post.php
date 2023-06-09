<?php
session_start();
require_once 'dbconnect.php';

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Получение идентификатора поста
if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
} else {
    header("Location: index.php");
    exit();
}

// Проверка, может ли пользователь удалить этот пост
$query = "SELECT * FROM posts WHERE id = :post_id AND user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':post_id', $post_id);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header("Location: index.php");
    exit();
}

// Удаление поста
$query = "DELETE FROM posts WHERE id = :post_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':post_id', $post_id);
$stmt->execute();

// Удаление связанных с постом лайков
$query = "DELETE FROM likes WHERE post_id = :post_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':post_id', $post_id);
$stmt->execute();

// Удаление связанных с постом комментариев
$query = "DELETE FROM comments WHERE post_id = :post_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':post_id', $post_id);
$stmt->execute();

header("Location: index.php");
exit();
?>
