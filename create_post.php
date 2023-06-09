<?php
require_once 'dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($file = fopen($_FILES['filename']['tmp_name'], 'r+')){
        //получение расширения
        $ext = explode('.', $_FILES["filename"]["name"]);
        $ext = $ext[count($ext) - 1];
        $filename = 'file' . rand(100000, 999999) . '.' . $ext;

        $resource = Container::getFileUploader()->store($file, $filename);
        $image = $resource['ObjectURL'];
    }

    $user_id = $_SESSION['user_id'];
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_POST['image'];

    $sql = "INSERT INTO posts (user_id, category_id, title, content, image) VALUES (:user_id, :category_id, :title, :content, :image)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':image', $image);

    try {
        $stmt->execute();
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}

include 'header.php';
?>

<div class="container">
    <h2>Создать пост</h2>
    <form method="POST" action="create_post.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="category">Категория:</label>
            <select class="form-control" id="category" name="category_id" required>
                <option value="1">Путешествия</option>
                <option value="2">Спорт</option>
                <option value="3">Культура</option>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Заголовок:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">Содержание:</label>
            <textarea class="form-control" id="content" name="content" required></textarea>
        </div>
        <div class="form-group">
            <label>
                Изображение: <input type="file" name="filename">
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Создать</button>
    </form>
</div>

<?php include 'footer.php'; ?>
