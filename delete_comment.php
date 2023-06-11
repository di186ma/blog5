<?php

require_once 'dbconnect.php';

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Получение идентификатора комментария
if (isset($_POST['comment_id'])) {
    $comment_id = $_POST['comment_id'];
} else {
    header("Location: index.php");
    exit();
}

// Проверка, может ли пользователь удалить этот комментарий
$query = "SELECT * FROM comments WHERE id = :comment_id AND user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':comment_id', $comment_id);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$comment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comment) {
    header("Location: index.php");
    exit();
}

// Удаление комментария
$query = "DELETE FROM comments WHERE id = :comment_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':comment_id', $comment_id);
$stmt->execute();

header("Location: index.php");
exit();
?>
