<?php

//   $err_msg = '';

if (isset($_POST["email"]) and $_POST["email"] != '') {
    try {
        $sql = 'SELECT id, email, PASSWORD FROM user WHERE email=(:email)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $_POST['email']);
        $stmt->execute();

    } catch (PDOexception $error) {
        $msg = "Ошибка аутентификации: " . $error->getMessage();
    }
    // если удалось получить строку с паролем из БД
    if ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
        if (($_POST['PASSWORD']) != $row['PASSWORD']) $msg = "Неправильный пароль!";
        else {
            // успешная аутентификация
            $_SESSION['email'] = $_POST["email"];
            $_SESSION['PASSWORD'] = $row['PASSWORD'];
            $_SESSION['id'] = $row['id'];
            //if ($row['is_teacher']==1) $_SESSION['teacher'] = true;
            $msg = "Вы успешно вошли в систему";
        }
    } else $msg = "Неправильное имя пользователя!";

}

if (isset($_GET["logout"])) {
    session_unset();
    $_SESSION['msg'] = "Вы успешно вышли из системы";
    header('Location: http://localhost');
    exit();
}