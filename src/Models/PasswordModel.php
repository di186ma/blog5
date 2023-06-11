<?php
namespace App\Models;

use Framework\Model;
use Framework\MysqlModel;

class PasswordModel extends MysqlModel
{
    protected $table="users";
//    public function index()
//
//    {
//        $user = new UserModel();
//        $user->create(["username" => "monster"]);
//        return $this->view('index.php',['users'=>$usermodel->all()]);
//    }

//    public function getWhere($conditions)
//    {
//        // TODO: Implement getWhere() method.
//    }

    public function deleteWhere($conditions)
    {
        // TODO: Implement deleteWhere() method.
    }

    public function updateWhere($conditions)
    {
        // TODO: Implement updateWhere() method.
    }

    public function create($fields)
    {
        // TODO: Implement create() method.
    }
}