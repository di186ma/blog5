<?php
namespace App\Controllers;

use App\Models\MatchModel;
use App\Models\PostsModel;
use Framework\Container;
use Framework\Controller;
use Framework\Request;

class PostsController extends Controller
{
    public function index(Request $request){
        return $this->view('posts.php', ['users' =>  $request->getUser(), 'message' => $request->getSession()['msg'], 'posts' => PostsModel::all()]);

    }


}