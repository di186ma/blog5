<h1>Посты:</h1>
<?php
$sql = "SELECT p.id, p.title, p.content, p.image, p.created_at, u.email
                FROM posts p
                INNER JOIN users u ON p.user_id = u.id";
$result = $conn->query($sql);

while ($row = $result->fetch()) {
//style="max-width: 18rem;"


    echo '<div class="card">';
    echo '<div class="card-header">ID: ' . $row["id"] . '</div>';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $row["title"] . '</h5>';
    echo '<p class="card-text">' . $row["content"] . '</p>';
    if (!empty($row["image"])) {
        echo '<img src="' . $row["image"] . '" class="img-fluid" alt="Изображение">';
    }
    echo '</div>';
    echo '<div class="card-footer">';
    echo 'Дата создания: ' . $row["created_at"] . '<br>';
    echo 'Автор: ' . $row["email"];
    echo '</div>';
    echo '</div>';
    echo '<br>';
}