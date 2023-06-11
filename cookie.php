<?php
if(isset($_GET['logout']))
{
    setcookie("email","di186ma@gmail.com",time()-999999);
}
if(isset($_GET['login'])){
    setcookie("email",$_GET['login'],time()+15000);
}
if (isset($_COOKIE['email']))
{
    echo ('Привет, '.$_COOKIE['email'].'!');
    echo ('<a href=cookie.php?logout=1>Выйти из системы<a>');
}
else{
    echo ('<a href=cookie.php?login=di186ma@gmail.com>Войти<a>');
}