<?php 
//session_start();
//ob_start();

$url = $_SERVER['PHP_SELF'];
$url = explode('/', $url);

$url = $url[(count($url)-1)];

if(!isset($_SESSION['usrId']) && $url != "verify.php"){
	if(!isset($_SESSION['usrId']) && $url != "home.php"){
		header("Location:../../index.php?err=Direct Access is Denied.");exit;
	}else{
		header("Location:index.php?err=Direct Access is Denied.");exit;
	}
}
?>