<?php

// application/controllers/admin/IndexController.class.php

require "application/controllers/BaseController.class.php";


class IndexController extends BaseController{

    public function mainAction(){

        include CURR_VIEW_PATH . "main.html";

        // Load Captcha class

        $this->loader->library("Captcha");

        $captcha = new Captcha;

        $captcha->hello();

    }

    public function indexAction(){

        $breadcrumb = [
            {"tilte": "Home", "link": "#", "isActive": "true" }
        ]
       
        $pageContent = CURR_VIEW_PATH . "index.php";

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