<?php

// framework/core/Framework.class.php
class Framework {

    public static function run() {

        self::runConfiguration();

        self::init();

        self::autoload();

        self::dispatch();

    }

    public static function runConfiguration() {
        // toggle this to change the setting
        define('DEBUG', true); 
        // you want all errors to be triggered
        error_reporting(E_ALL); 

        if(DEBUG == true)
        {
            // you're developing, so you want all errors to be shown
            ini_set('display_errors', 'On');
            // logging is usually overkill during dev
            ini_set('log_errors', 'Off');
        }
        else
        {
            // you don't want to display errors on a prod environment
            ini_set('display_errors', 'Off'); 
            // you definitely wanna log any occurring
            ini_set('log_errors', 'On');
        }
    }

    // Initialization
    private static function init() {
        // Define path constants
        // echo "init callad";
        
        define("DS", DIRECTORY_SEPARATOR);

        define("ROOT", getcwd() . DS);

        define("APP_PATH", ROOT . 'application' . DS);

        define("FRAMEWORK_PATH", ROOT . "framework" . DS);

        define("PUBLIC_PATH", ROOT . "public" . DS);


        define("CONFIG_PATH", APP_PATH . "config" . DS);

        define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);

        define("MODEL_PATH", APP_PATH . "models" . DS);

        define("VIEW_PATH", APP_PATH . "views" . DS);


        define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);

        define('DB_PATH', FRAMEWORK_PATH . "database" . DS);

        define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);

        define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);

        define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DS);


        // Define platform, controller, action, for example:

        // index.php?p=admin&c=Goods&a=add

        define("PLATFORM", isset($_REQUEST['p']) ? $_REQUEST['p'] : 'home');

        define("CONTROLLER", isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Index');

        define("ACTION", isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');


        define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);

        define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);


        // Load core classes

        require CORE_PATH . "Controller.class.php";

        require CORE_PATH . "Loader.class.php";

        require DB_PATH . "Mysql.class.php";

        require CORE_PATH . "Model.class.php";


        // Load configuration file

        $GLOBALS['config'] = include CONFIG_PATH . "config.php";


        // Start session

        session_start();

    }
 
 
    private static function autoload() {
        spl_autoload_register(array(__CLASS__,'load')); 
    }

    // Define a custom load method

    private static function load($classname){


        // Here simply autoload app’s controller and model classes

        if (substr($classname, -10) == "Controller"){

            // Controller

            require_once CURR_CONTROLLER_PATH . "$classname.class.php";

        } elseif (substr($classname, -5) == "Model"){

            // Model

            require_once  MODEL_PATH . "$classname.class.php";

        }

    }
 
    // Routing and dispatching

    private static function dispatch() {
        // Instantiate the controller class and call its action method

        $controller_name = CONTROLLER . "Controller";

        $action_name = ACTION . "Action";

        $controller = new $controller_name;

        //check if the action exists inside the class
        $methodExists = method_exists($controller, $action_name);

        if (!$methodExists) {
            //show 404 page
            $controller = new IndexController;
            $controller->notFoundAction();
        } else {
            $controller->$action_name();
        }
 
    }
}