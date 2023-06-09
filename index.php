<?php

use Dotenv\Dotenv;
use Framework\Container;
use Framework\Request;
use Framework\Router;
use Framework\Application;


date_default_timezone_set('Asia/Yekaterinburg');
if ( file_exists(dirname(__FILE__).'/vendor/autoload.php') ) {
    require_once dirname(__FILE__).'/vendor/autoload.php';
}


Application::init();
die();



require_once 'dbconnect.php';

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
?>

<div class="container">
    <h2>Мои посты</h2>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#my-posts">Мои посты</a></li>
        <li><a data-toggle="tab" href="#other-posts">Посты других пользователей</a></li>
    </ul>

    <div class="tab-content">
        <div id="my-posts" class="tab-pane fade in active">
            <?php
            // Вывод моих постов
            foreach ($posts as $post) {
                if ($post['user_id'] == $_SESSION['user_id']) {
                    echo '<div class="post">';
                    echo '<h3>' . $post['title'] . '</h3>';
                    echo '<p>' . $post['content'] . '</p>';
                    echo '<p>Автор: ' . $post['email'] . '</p>';
                    echo '<p>Лайки: ' . $post['like_count'] ?? 0 . '</p>';

                    // Проверка, может ли текущий пользователь удалить этот пост

                        echo '<form method="POST" action="delete_post.php">';
                        echo '<input type="hidden" name="post_id" value="' . $post['id'] . '">';
                        echo '<button type="submit" class="btn-delete">Удалить</button>';
                        echo '</form>';


                    // Вывод комментариев
                    echo '<h4>Комментарии:</h4>';
                    $query = "SELECT comments.*, users.email
                              FROM comments
                              JOIN users ON comments.user_id = users.id
                              WHERE comments.post_id = :post_id";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':post_id', $post['id']);
                    $stmt->execute();
                    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($comments as $comment) {
                        echo '<div class="comment">';
                        echo '<p>' . $comment['comment'] . '</p>';
                        echo '<p>Автор: ' . $comment['email'] . '</p>';

                        // Проверка, может ли текущий пользователь удалить этот комментарий
                        if ($comment['user_id'] == $_SESSION['user_id']) {
                            echo '<form method="POST" action="delete_comment.php">';
                            echo '<input type="hidden" name="comment_id" value="' . $comment['id'] . '">';
                            echo '<button type="submit" class="btn-delete">Удалить</button>';
                            echo '</form>';
                        }

                        echo '</div>';
                    }

                    echo '</div>';
                    echo '<hr>';
                }
            }
            ?>
        </div>

        <div id="other-posts" class="tab-pane fade">
            <?php
            // Вывод постов других пользователей
            foreach ($posts as $post) {
                if ($post['user_id'] != $_SESSION['user_id']) {
                    echo '<div class="post">';
                    echo '<h3>' . $post['title'] . '</h3>';
                    echo '<p>' . $post['content'] . '</p>';
                    echo '<p>Автор: ' . $post['email'] . '</p>';
                    echo '<p>Лайки: ' . $post['like_count'] ?? 0 . '</p>';

                    // Вывод формы лайка
                    echo '<form method="POST" action="like.php">';
                    echo '<input type="hidden" name="post_id" value="' . $post['id'] . '">';
                    echo '<button type="submit" class="btn-like">Лайк</button>';
                    echo '</form>';

                    // Вывод комментариев
                    echo '<h4>Комментарии:</h4>';
                    $query = "SELECT comments.*, users.email
                              FROM comments
                              JOIN users ON comments.user_id = users.id
                              WHERE comments.post_id = :post_id";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':post_id', $post['id']);
                    $stmt->execute();
                    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($comments as $comment) {
                        echo '<div class="comment">';
                        echo '<p>' . $comment['comment'] . '</p>';
                        echo '<p>Автор: ' . $comment['email'] . '</p>';
                        echo '</div>';
                    }

                    // Форма для добавления комментария
                    echo '<form method="POST" action="add_comment.php">';
                    echo '<input type="hidden" name="post_id" value="' . $post['id'] . '">';
                    echo '<textarea name="comment" placeholder="Оставьте комментарий"></textarea>';
                    echo '<button type="submit">Добавить комментарий</button>';
                    echo '</form>';


                    echo '</div>';
                    echo '<hr>';
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
