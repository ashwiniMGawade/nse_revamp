<?php

// application/controllers/home/IndexController.class.php

require "application/controllers/BaseController.class.php";
require "framework/helpers/paginate.php";

class IndexController extends BaseController{

    public function mainAction(){

        include CURR_VIEW_PATH . "main.html";

        // Load Captcha class

        $this->loader->library("Captcha");

        $captcha = new Captcha;

        $captcha->hello();

    }

    public function indexAction(){

        // Load View template
        $isMain = true;
        $hideSideBar = true;
        $breadcrumbs = array();
        $breadcrumbs[] =  (object) [
            'title' => '<i class="fa fa-home"></i> Home',
            'link' =>  "index.php",
            "isActive" => "true"
          ];
        $lnavElement = array("element" =>'<i class="fa fa-home"></i> Home', "link"=> "index.php");

        $pageContent = CURR_VIEW_PATH . "index.php";

        include VIEW_PATH."template.php";

    }

    public function notFoundAction(){

        // Load View template
        $isMain = true;
        $breadcrumbs = array();
        $breadcrumbs[] =  (object) [
            'title' => 'Home',
            'link' =>  "index.php",
            "isActive" => "true"
          ];
        $lnavElement = array("element" => "Home", "link"=> "index.php");

        $pageContent = VIEW_PATH . "404.php";

        include VIEW_PATH."template.php";

    }


    public function menuAction(){

        include CURR_VIEW_PATH . "menu.html";

    }

    public function dragAction(){

        include CURR_VIEW_PATH . "drag.html";

    }

    public function topAction(){

        include CURR_VIEW_PATH . "top.html";

    }

}