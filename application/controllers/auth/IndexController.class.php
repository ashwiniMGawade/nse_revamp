<?php

require "application/controllers/BaseController.class.php";

class IndexController extends BaseController{

   
    public function loginAction(){

        include CURR_VIEW_PATH."login.php";

    }

    public function authenticateAction() {
        if(isset($_POST['username']) && isset($_POST['password'])){
            $adServer = $GLOBALS['config']['ldap']['url'];
        
            $ldap = ldap_connect($adServer);
            $username = $_POST['username'];
            $password = $_POST['password'];
        
            $ldaprdn = $_POST['username']; 
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        
            $bind = @ldap_bind($ldap, $ldaprdn, $password);   
        
            if ($bind) {
                $filter="(".$GLOBALS['config']['ldap']['searchFilterAttr']."=".$username.")";
                $result = ldap_search($ldap,$GLOBALS['config']['ldap']['searchBase'],$filter);

                $info = ldap_get_entries($ldap, $result);
                for ($i=0; $i<$info["count"]; $i++)
                {
                    if($info['count'] > 1)
                        break;
                  
                    $userDn = $info[$i]["cn"][0]; 
                    $_SESSION['user'] = $userDn;
                    @ldap_close($ldap);
                    header("Location:".$_SERVER['PHP_SELF']);                   
                }
               
            } else {
                $msg = "Invalid email address / password";
                header("Location:".$_SERVER['PHP_SELF']."?p=auth&a=login&msg=".urlencode($msg));
            }
        
        }
    }


    public function signoutAction(){

        session_destroy();
        header("Location:".$_SERVER['PHP_SELF']."?p=auth&a=login");

    }

    public function dragAction(){

        include CURR_VIEW_PATH . "drag.html";

    }

    public function topAction(){

        include CURR_VIEW_PATH . "top.html";

    }

}