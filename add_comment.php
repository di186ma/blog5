<?php

require_once 'dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment'])) {
        $comment = $_POST['comment'];
        $post_id = $_POST['post_id'];
        $user_id = $_SESSION['user_id'];

        $query = "INSERT INTO comments (comment, post_id, user_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $comment);
        $stmt->bindParam(2, $post_id);
        $stmt->bindParam(3, $user_id);
        $stmt->execute();

        ob_end_clean(); // Очищаем буфер вывод
        header("Location: index.php");
        exit();
    }
}