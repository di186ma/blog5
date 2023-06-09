<?php
namespace Framework;

class Request
{

    private $get_params;
    private $post_params;
    private $type;

    public function __construct()
    {
        $this->get_params = $_GET;

        $this->post_params = $_POST;
        if($_SERVER['REQUEST_METHOD'] === 'POST') $this->type = Route::METHOD_POST;
        if($_SERVER['REQUEST_METHOD'] === 'GET') $this->type = Route::METHOD_GET;
    }

    /**
     * @return mixed
     */


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