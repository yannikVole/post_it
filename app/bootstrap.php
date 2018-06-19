<?php
//config file
require_once "config/config.php";

require_once "helpers/url_helper.php";
require_once "helpers/session_helper.php";

//Autoload setup for libs
spl_autoload_register(function($classname){
    require_once "libraries/".$classname.".php";
});
