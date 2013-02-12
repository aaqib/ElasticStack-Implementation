<?php 
	ob_start(); $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php");

	echo (test_port($_GET['id'], $port=22, $timeout=20)) ? '1' : '0'; //checking if 22 port enabled
?>