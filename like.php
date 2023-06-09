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

// Проверка, может ли пользователь лайкнуть этот пост
$query = "SELECT * FROM posts WHERE id = :post_id AND user_id != :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':post_id', $post_id);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header("Location: index.php");
    exit();
}

// Проверка, есть ли уже лайк от текущего пользователя
$query = "SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':post_id', $post_id);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$like = $stmt->fetch(PDO::FETCH_ASSOC);

if ($like) {
    // Лайк уже существует, поэтому удаляем его
    $query = "DELETE FROM likes WHERE id = :like_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':like_id', $like['id']);
    $stmt->execute();
} else {
    // Лайка нет, поэтому добавляем его
    $query = "INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
}

// Перенаправляем обратно на страницу с постами
header("Location: index.php");
exit();
