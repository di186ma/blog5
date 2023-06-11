<?php
namespace App\Controllers;

use App\Models\UserModel;
use Framework\Container;
use Framework\Controller;
use Framework\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->getPostParams()['email'];
        $PASSWORD = $request->getPostParams()['PASSWORD'];
//        echo ($login.' '.$password);
        if (isset($email) and $email != '') {
            $user = UserModel::getWhere('email', '=', $login)[0];
            if ($user){
                if (MD5($PASSWORD) == $user->md5password){
                    $_SESSION['email'] = $user->email;
                    $_SESSION['PASSWORD'] = $user->PASSWORD;
                    $_SESSION['id'] = $user->id;

                    $_SESSION['msg'] = "Вы успешно вошли в систему";
                }
                else $_SESSION['msg'] = "Неправильный пароль";
            }
            else $_SESSION['msg'] = "Неправильный логин";
        }
        header('Location: /page/hello');
        exit();
    }
    public function logout(Request $request){
        $_SESSION = null;
        $_SESSION['msg'] =  "Вы успешно вышли из системы";
        header('Location: /page/hello');
        exit();
    }
}
