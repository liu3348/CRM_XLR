<?php
ini_set('display_errors',true);
error_reporting(7);
//开启调试模式
define('APP_DEBUG',true);
define ('APP_NAME','App');
define ('APP_PATH','./App/');
define ('UPLOAD_PATH','./Uploads/');
require APP_PATH."/Conf/app_debug.php";
require 'Base/ThinkPHP.php';