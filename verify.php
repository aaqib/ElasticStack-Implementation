<?php 
ob_start();
require_once("system/include/config.php");
require_once(INC."util_func.php");

if($_GET['code']==base64_encode('logout')){
	setAdminStatus($_SESSION['usrId'], 0);
	unset($_SESSION['usrId']);
	unset($_SESSION['access_priv']);
	unset($_SESSION['child_priv']);
	unset($_SESSION['aws_credentials']);
	unset($_SESSION['eh_credentials']);
	header("location:index.php?err=Logout Successfully.");
}else{
	extract($_POST);
	$pass = md5($password);
	
	$q		= "select id, type, status from admins where username='$username' AND password='$pass'";
	$sql	= mysql_query($q);
	$rows	= mysql_num_rows($sql);
	$rw		= mysql_fetch_array($sql);
	
	if($rows == '0'){
		header("location:index.php?err=User Name/Password is incorrect.");
	}
	else if($rw['status'] == '0')
	{
		header("location:index.php?err=Your account has been INACTIVE. Please contact System Administrator for assistance.");
	}
	else{
		//$rw = mysql_fetch_array($sql);
		$_SESSION['usrId']	= $rw['id'];
		$_SESSION['type']	= $rw['type'];
		
		$arr = array("type"=>"login", "activity"=>strtoupper($username)." | Login in Admin Panel User ID - $_SESSION[usrId]", 'c_type'=>0, "id"=>$_SESSION['usrId'], "client"=>$_SESSION['usrId']); addActivity($arr);
		setAdminStatus($_SESSION['usrId'], 1);	header("location:home.php");
	}
}
?>