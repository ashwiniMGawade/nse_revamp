<?php

require "application/controllers/BaseController.class.php";

class IndexController extends BaseController{

   
    public function loginAction(){

        include CURR_VIEW_PATH."login.php";

    }

    public function authenticateAction() {
        if(isset($_POST['username']) && isset($_POST['password'])){
            $adServer = $GLOBALS['config']['ldap']['url'];
			ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
			$ret = ldap_set_option(null, LDAP_OPT_X_TLS_CACERTFILE, 'c:/openldap/sysconf/webcert.pem');
			$ret=ldap_set_option(null,LDAP_OPT_X_TLS_CACERTDIR,"c:/openldap/sysconf/");	
			        
            $ldap = ldap_connect($adServer);
				// Set the debug flag
			$debug = true;
			// Set debugging
			if ($debug) {
			  ldap_set_option($ldap, LDAP_OPT_DEBUG_LEVEL, 7);
			}
			
            $username = $_POST['username'];
            $password = $_POST['password'];
        
            $ldaprdn = "nseroot\\" . $_POST['username'];
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
			$ret = ldap_set_option($ldap, LDAP_OPT_X_TLS_CACERTFILE, 'c:/openldap/sysconf/webcert.pem');
			$ret=ldap_set_option($ldap,LDAP_OPT_X_TLS_CACERTDIR,"c:/openldap/sysconf/");
			ldap_set_option($ldap, LDAP_OPT_X_TLS_REQUIRE_CERT, 1);
			
             $bind = @ldap_bind($ldap,   $ldaprdn, $password);

			// if (!$bind) {
			// 	echo "Unable to bind to server $adServer\n";
			// 	echo "OpenLdap error message: " . ldap_error($ldap) . "\n";
			// 	exit;
			// }
		
        
            if ($bind) {
                $filter="(".$GLOBALS['config']['ldap']['searchFilterAttr']."=".$username.")";	
                $result_grp = ldap_search($ldap,$GLOBALS['config']['ldap']['searchBase'],$filter, array("memberof",'primarygroupid'));
                $info_grp = ldap_get_entries($ldap, $result_grp);
				$uesrIsMember = false;
				
				for ($i=0; $i<$info_grp[0]['memberof']['count']; $i++)
				{
					if($info_grp[0]['memberof'][$i] ==  $GLOBALS['config']['ldap']['securityGroup']) {
						$uesrIsMember = true;;
						break;
					}
				}
                    

                if ($uesrIsMember) {
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
                    $msg = "Unauthorized user!";
                    header("Location:".$_SERVER['PHP_SELF']."?p=auth&a=login&msg=".urlencode($msg));
                }               
               
            } else {
                $msg = "Invalid email address / password!";
                header("Location:".$_SERVER['PHP_SELF']."?p=auth&a=login&msg=".urlencode($msg));
            }
        
        }
    }


    public function signoutAction(){

        session_destroy();
        unset($_SESSION['user']);
        $_SESSION = [];
        header("Location:".$_SERVER['PHP_SELF']."?p=auth&a=login");

    }

    public function dragAction(){

        include CURR_VIEW_PATH . "drag.html";

    }

    public function topAction(){

        include CURR_VIEW_PATH . "top.html";

    }

}