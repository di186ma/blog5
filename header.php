<!DOCTYPE html>
<html>
<head>
    <title>Мой блог</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Мой блог</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="create_post.php">Создать пост</a></li>
                <li><a href="logout.php">Выйти</a></li>
            <?php else: ?>
                <li><a href="register.php">Регистрация</a></li>
                <li><a href="login.php">Войти</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
