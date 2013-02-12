<?php 
	ob_start(); $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php"); require_once(INC."eh_funcs.php");

	$result	= eh_get_drive_info($_GET['id']);
	echo $result['imaging'];
?>