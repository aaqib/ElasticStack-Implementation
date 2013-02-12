<?php 
//getting menu item with specific rights
function getMenuItem($type, $id_admin, $top_menu, $id_parent='-1')
{
	if($type == '1') //for super admin
	{
		$query		= "* FROM admin_menu where id_parent='". $id_parent ."' and status='1' and top_menu = '". $top_menu ."' order by sort";
	}
	else //for sub admins
	{
		$query		= "* FROM admin_menu as AM, admin_access as AC where AM.id_menu = AC.id_menu and AM.id_parent='". $id_parent ."' and AM.status='1' and top_menu = '". $top_menu ."' ";
		if($type != '1')
			$query	.= "and AC.id_admin = '". $id_admin ."' ";
		$query		.= "order by sort";	
	}
	return getLoopData($query);
}

//if admin has rights to that perticular file
function getAdminRights($type, $id_admin, $menu_path, $current_file)
{
	$current_file	= '|'. $current_file .'|';
	if($type == '1')
	{
		return array(true, '1');
	}
	else
	{
		$query	= "* FROM admin_menu as AM, admin_access as AC where AM.id_menu = AC.id_menu and AM.status='1' and AC.id_admin = '". $id_admin ."' and AM.menu_path like '". $menu_path ."%' and (AM.view_files like '%". $current_file ."%' or AM.edit_files like '%". $current_file ."%') order by AM.id_menu limit 1 ";
		$data	= getLoopData($query);
		
		if(isset($data) && count($data) > 0) //if admin access exist
		{
			$data	= $data[0];
			//var_dump($data);
			//exit;
			
			//checking if admin has access
			if($data['allow_edit'] == '1')
			{
				return array(true, $data['allow_edit']);
			}
			else if($data['allow_edit'] == '0' && (strrpos($data['view_files'], $current_file) !== false))
			{
				return array(true, $data['allow_edit']);
			}
			else
			{
				return array(false, $data['allow_edit']);
			}
		}
		else
		{
			return array(false, $data['allow_edit']);
		}
	}
}

function isAccessPriv($priv){
	return true; //added by sarfraz
	$priv_list = array('home'=>'addons/currency/index.php', 'addons'=>'../../modules/account/invi_all.php', 'invoices'=>'../../modules/cms/faq_add.php',
						'cms'=>'../customer/client_all.php', 'customers'=>'../order/order_all.php', 'orders'=>'../support/tick_all.php',
						'support'=>'../product/pro_add.php', 'setup'=>'../bandwidth/index.php', 'util'=>'../../home.php');
						
	$privs = split(',', $_SESSION['access_priv']);
	
	if(in_array('all', $privs)){
		return true;
	}else if(in_array($priv, $privs)){
		return true;
	}

	//echo $priv;
	if($priv_list[$priv] == "" || $privs == ""){
		//echo 'dddddddd='.$priv_list[$priv];
		header("location:".URL."modules/error/index.php");exit;
	}else if($priv_list[$priv] != "" && in_array(next($privs), $privs)){
	//echo 'hhhhhh='.$priv_list[$priv];
		header("location:".$priv_list[$priv]."");exit;
	}else{
		if(count($priv)>1){$priv = next($privs );}
	echo $priv.'nnn='.$priv_list[$priv];
	//	header("location:".$priv_list[$priv]."");exit;
	}
	
}

function isChildPriv($priv){
	return true; //added by sarfraz
	$priv_list = array('currency'=>'../forum/forum_all.php', 'forums'=>'../site_admin/index.php', 'admins'=>'../language/lang_all.php', 
						'language'=>'../reseller/res_cntall.php', "reseller"=>'../../modules/account/invi_all.php',
						
						'faqs'=>'../cms/about_all.php','front_end'=>'../cms/tut_add.php', 'tutorials'=>'../cms/promo_add.php',
						'pcodes'=>'../customer/client_all.php',
						
						'clients'=>'../customer/affil_plan.php', 'affiliate'=>'../order/order_all.php',
						
						'tickets'=>'../support/dep_all.php',	'tick_settings'=>'../setup/product_add.php', 
						
						'products'=>'../setup/server_all.php',	'servers'=>'../setup/conf_credit.php', 
						'site_config'=>'../setup/2checkout.php',	'payment_modules'=>'../utilities/acnt_profdet.php', 
						
						"bandwidth"=>"../utilities/acnt_logindet.php", 'my_account'=>'modules/utilities/web_admin.php',	'web_act'=>'home.php');

	$access_privs = split(',', $_SESSION['access_priv']);
	$privs = split(',', $_SESSION['child_priv']);
	
	if(in_array('all', $access_privs)){
		return true;
	}else if(in_array($priv, $privs)){
		return true;
	}
	
	
	if($priv_list[$priv] == "" || $privs == ""){
		//echo 'dddddddd='.$priv_list[$priv];
		header("location:".URL."modules/error/index.php");exit;
	}else if($priv_list[$priv] != "" && in_array(next($privs), $privs)){
		header("location:".$priv_list[$priv]."");exit;
	}else{
		$priv = next($privs );
		header("location:'".$priv_list[$priv]."'");exit;
	}
}
function getPrivChecked($v, $arr){
	if($arr !=""){
		if(in_array($v, $arr) || in_array('all', $arr)){
			return "checked='checked'";
		}
	}
	return "";
}

function getChildChecked($v, $arr, $privs){
	if($arr !=""){
		if(in_array($v, $arr) || !empty($privs) && in_array('all', $privs)){
			return "checked='checked'";
		}
	}
	return "";
}

function isChecked($v, $arr){
	return true; //added by sarfraz
	if($arr !=""){
		if(in_array($v, $arr)){
			return true;
		}
	}
	return false;
}
function getAccessLevels($id){
	$q = "SELECT access_id, type FROM access_levels WHERE id_users='$id'"; $sql = mysql_query($q); $arr = array();
	while($row = mysql_fetch_array($sql)){ $arr[$row['access_id']] = $row['type'];}return $arr;
}
function getAccessChilds($id, $arr){
	$q = "SELECT id, type FROM access_childs WHERE access_id='$id'"; $sql = mysql_query($q);
	while($row = mysql_fetch_array($sql)){  $arr[$row['id']] = $row['type'];}return $arr;
}
function getChildPrivs($id, $arr){
	$q = "SELECT id, type FROM access_childs WHERE access_id='$id'"; $sql = mysql_query($q);
	while($row = mysql_fetch_array($sql)){  $arr[$row['type']] = $row['id'];}return $arr;
}

function insertAccessPriv($user, $type){
	if($act=""){$act="Add";}
	$q = "SELECT access_id FROM access_levels WHERE id_users=$user AND type='$type' LIMIT 1"; $sql = mysql_query($q); $rws = mysql_num_rows($sql);

	if($rws == 0){
		$q = "INSERT INTO access_levels SET id_users='$user', type='$type'";
		if($sql = mysql_query($q)){ $id = mysql_insert_id();
			//arr = array("type"=>"access_levels", "activity"=>"Privilage $type Add# $id", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
		}
	}else{$rw = mysql_fetch_array($sql); $id = $rw['access_id'];}
	return $id;
}
function insertChildPriv($priv, $type){
	$q = "SELECT access_id FROM access_childs WHERE access_id='$priv' AND type='$type' LIMIT 1"; $sql = mysql_query($q); $rws = mysql_num_rows($sql);
	
	if($rws == 0){
		$q = "INSERT INTO access_childs SET access_id='$priv', type='$type'";
		if($sql = mysql_query($q)){ $id = mysql_insert_id();
	//		$arr = array("type"=>"child_levels", "activity"=>"Privilage $type Add# $id", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
		}
	}
}
function removePrivs($id, $type=""){
	if($type!=""){ $type = " AND type='$type'"; 
		$q = "SELECT access_id FROM access_levels WHERE id_users=$id $type"; $sql = mysql_query($q); $rw = mysql_fetch_array($sql);
	}
	
	 $q = "DELETE FROM access_levels WHERE id_users=$id $type";

	if($sql = mysql_query($q)){
		if($rw['access_id'] != ""){
			$q = "DELETE FROM access_childs WHERE access_id='".$rw['access_id']."'"; mysql_query($q);
		}
		//$arr = array("type"=>$table, "activity"=>"DELETE Privilage# $id", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
	}
}
function removePriv($table, $field, $id, $type){
	$q = "DELETE FROM $table WHERE $field=$id";
	if($sql = mysql_query($q)){	$arr = array("type"=>$table, "activity"=>"REMOVE $type Privilage# $id", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);	}
}
?>