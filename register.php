<?php
require_once 'dbconnect.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    try {
        $stmt->execute();
        $user_id = $conn->lastInsertId();
        $_SESSION['user_id'] = $user_id;
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}

include 'header.php';
?>

<div class="container">
    <h2>Регистрация</h2>
    <form method="POST" action="register.php">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </form>
</div>

<?php include 'footer.php'; ?>
