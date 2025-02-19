<?php
class HomeController {
    public $model;
    public $config;

    /*
        Type : View.
        Action : Show view layer.
    */
    public function indexAction(){
        // $items = $this->model->getItemData();
       return require_once('../views/dashboard.php');
    }


}
