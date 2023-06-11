<?php
namespace Framework;
require_once 'Framework/Route.php';

class Request
{
    private $path;
    private $get_params;
    private $post_params;
    private $type;

    public function __construct()
    {
        $this->path = $_SERVER['REQUEST_URI'];
        $this->get_params = $_GET;
        unset($this->get_params['path']);
        $this->post_params = $_POST;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $this->type = Route::METHOD_POST;
        if ($_SERVER['REQUEST_METHOD'] === 'GET') $this->type = Route::METHOD_GET;
    }

    /**
     * @return mixed
     */

    public function getPath()
    {
        if (isset($this->path) && !empty($this->path)) {
            return $this->path;
        } else {
            echo "Путь не определен";
        }
    }
    /**
     * @return mixed
     */
    public function getGetParams()
    {
        return $this->get_params;
    }

    /**
     * @return mixed
     */
    public function getPostParams()
    {
        return $this->post_params;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

}