<?php 
function getFields($list){
	$lang			= array('ID'=>'id_lang', "Language"=>"screen_name", "Code"=>"code", "Priority"=>"priority", "Status"=>"status", "Flag"=>"flag_code", "Details"=>"");
	$currency		= array('ID'=>'id', "Title"=>"name", "Symbol"=>"symbol", "Country code"=>"country_code", "Currency code"=>"currency_code", "Status"=>"status", "Details"=>"");
	
	$eh_region		= array("ID"=>"id_region", "Region Name"=>"region_name", "Region Code"=>"region_code", "Server Region"=>"server_region", "Action"=>"");
	$eh_image		= array("ID"=>"i.id_image", "Image Name"=>'i.image_name', "Image Uuid"=>'i.image_uid', "Region Name"=>"r.region_name", "Status"=>'i.is_active', "Action"=>"");
	$eh_model		= array("ID"=>"id_model", "Model"=>"model_name", "Action"=>"");
	$eh_drive		= array("Drive Name"=>"", "Drive Uuid"=>"", "Size"=>"", "Tier"=>"", "Status"=>"", "Encryption"=>"", "Action"=>"");
	$eh_server		= array("Server Name"=>"", "CPU"=>"", "Memory"=>"", "Status"=>"", "VNC Password"=>"", "Action"=>"");
	$eh_server_role	= array("ID"=>"id_role", "Role Name"=>"role_name", "Description"=>"description", "Action"=>"");
	$eh_ip			= array("Name"=>"", "IP"=>"", "Gateway"=>"", "Netmask"=>"", "Action"=>"");
	$eh_vlan		= array("Name"=>"", "Resource"=>"", "Action"=>"");
	
	$aws_zone		= array("ID"=>"id_zone", "Zone Name"=>"zone_name", "Zone Code"=>"zone_code", "Action"=>"");
	$aws_region		= array("ID"=>"id_region", "Region Name"=>"region_name", "Region Code"=>"region_code", "Action"=>"");
	$aws_image		= array("ID"=>"i.id_image", "Arch"=>"i.arch", "Image Name"=>'i.image_name', "AMI ID"=>'i.ami_id', "Region Name"=>"i.region_name", "Version"=>"i.version", "Disk"=>"i.disk", "Size"=>"i.size", "Status"=>'i.is_active', "Action"=>"");
	$aws_ins_type	= array("ID"=>"id_instance_type", "Type Name"=>"type_name", "Action"=>"");
	$aws_port		= array("ID"=>"id_port", "IP Protocol"=>"ip_protocol", "Port"=>"port", "Action"=>"");
	$aws_vpc		= array("ID"=>"", "CIDR Block"=>"", "DHCP Options ID"=>"", "State"=>"", "Tenancy"=>"");
	$aws_instance	= array("ID"=>"", "Server Name"=>"", "Instance Type"=>"", "State"=>"", "Private IP"=>"", "IP"=>"", "VPC ID"=>"", "Network Interface ID"=>"", "Action"=>"");
	
	$sortList		= array('languages'=>$lang, 'currency'=>$currency, 'eh_region'=>$eh_region, 'eh_image'=>$eh_image, 'eh_model'=>$eh_model, 'eh_drive'=>$eh_drive, 'eh_server'=>$eh_server, 'eh_ip'=>$eh_ip, 'eh_vlan'=>$eh_vlan, 'eh_server_role'=>$eh_server_role, 'aws_zone'=>$aws_zone, 'aws_region'=>$aws_region, 'aws_image'=>$aws_image, 'aws_ins_type'=>$aws_ins_type, 'aws_vpc'=>$aws_vpc, 'aws_port'=>$aws_port, 'aws_instance'=>$aws_instance);
	
	return $sortList[$list];
}

function getQueryParm($parm){
	switch($parm){
		case "seract_1": $parm=1; break;
	
		default: $parm=$parm; break;
	}
	return $parm;
}

function getActionQuery($act,$id){
	$activity = getActivity($act, $id);

	foreach($activity as $k=>$v){
		$arr = array("type"=>$k, "activity"=>$v, "id"=>$id, 'c_type'=>0, "client"=>$_SESSION['usrId']);
		addActivity($arr);
	}
	
	switch($act){
		
		case "lang_del":			$act = "DELETE FROM languages WHERE id_lang='$id'"; break;
		case "lang_0":
		case "lang_1": 
		if($act=='lang_0'){$act=0;}else $act=1; $act = "UPDATE languages SET status='$act' WHERE id_lang='$id'"; break;

		case "eh_region_del":				$act = "DELETE FROM eh_region WHERE id_region='$id'"; break;
		case "eh_image_del":				$act = "DELETE FROM eh_image WHERE id_image='$id'"; break;
		case "eh_image_0":					$act = "UPDATE eh_image SET is_active='0' WHERE id_image='$id'"; break;
		case "eh_image_1":					$act = "UPDATE eh_image SET is_active='1' WHERE id_image='$id'"; break;
		case "eh_model_del":				$act = "DELETE FROM eh_model WHERE id_model='$id'"; break;
		case "eh_drive_del":				$act = eh_destroy_drive($id); break;
		
		case "eh_server_del":				$act = eh_server_action($id, 'destroy'); break;
		case "eh_server_start":				$act = eh_server_action($id, 'start'); break;
		case "eh_server_stop":				$act = eh_server_action($id, 'stop'); break;
		case "eh_server_shut":				$act = eh_server_action($id, 'shutdown'); break;
		case "eh_server_reset": 			$act = eh_server_action($id, 'reset'); break;
		
		case "eh_server_role_del":			$act = "DELETE FROM eh_server_role WHERE id_role='$id'"; break;
		
		case "eh_ip_del":					$act = eh_destroy_resource('ip', $id); break;
		case "eh_vlan_del":					$act = eh_destroy_resource('vlan', $id); break;
		
		case "aws_zone_del":				$act = "DELETE FROM aws_zone WHERE id_zone='$id'"; break;
		case "aws_region_del":				$act = "DELETE FROM aws_region WHERE id_region='$id'"; break;
		case "aws_image_del":				$act = "DELETE FROM aws_image WHERE id_image='$id'"; break;
		case "aws_image_0":					$act = "UPDATE aws_image SET is_active='0' WHERE id_image='$id'"; break;
		case "aws_image_1":					$act = "UPDATE aws_image SET is_active='1' WHERE id_image='$id'"; break;
		
		case "aws_ins_type_del":			$act = "DELETE FROM aws_instance_type WHERE id_instance_type='$id'"; break;
		case "aws_port_del":				$act = "DELETE FROM aws_securitygroup_port WHERE id_port='$id'"; break;
		case "aws_vpc_del":					$act = aws_destroy_vpc($id); break;
		
		case "aws_instance_terminate":		$act = aws_instance_action($id, 'terminate'); break;
		case "aws_instance_start":			$act = aws_instance_action($id, 'start'); break;
		case "aws_instance_stop":			$act = aws_instance_action($id, 'stop'); break;
		case "aws_instance_reboot":			$act = aws_instance_action($id, 'reboot'); break;
		
		default: $act = $act; break;
	}
	
	return $act;
}


function getActionLinks($list){
	$lang			= array("lang_del"=>"DELETE", "lang_1"=>"ACTIVE", "lang_0"=>"INACTIVE");
	$currency		= array("currency_1"=>"ACTIVE", "currency_0"=>"INACTIVE");
	
	$eh_region		= array("eh_region_del"=>"DELETE");
	$eh_image		= array("eh_image_del"=>"DELETE", "eh_image_1"=>"ACTIVE", "eh_image_0"=>"INACTIVE");
	$eh_model		= array("eh_model_del"=>"DELETE");
	$eh_drive		= array("eh_drive_del"=>"DELETE");
	$eh_server		= array("eh_server_del"=>"DELETE", "eh_server_start"=>"START", "eh_server_stop"=>"STOP", "eh_server_shut"=>"SHUT DOWN", "eh_server_reset"=>"RESET");
	$eh_server_role	= array("eh_server_role_del"=>"DELETE");
	$eh_ip			= array("eh_ip_del"=>"DELETE");
	$eh_vlan		= array("eh_vlan_del"=>"DELETE");
	
	$aws_zone		= array("aws_zone_del"=>"DELETE");
	$aws_region		= array("aws_region_del"=>"DELETE");
	$aws_image		= array("aws_image_del"=>"DELETE", "aws_image_1"=>"ACTIVE", "aws_image_0"=>"INACTIVE");
	$aws_ins_type	= array("aws_ins_type_del"=>"DELETE");
	$aws_port		= array("aws_port_del"=>"DELETE");
	$aws_vpc		= array("aws_vpc_del"=>"DELETE");
	$aws_instance	= array("aws_instance_start"=>"START", "aws_instance_stop"=>"STOP", "aws_instance_reboot"=>"REBOOT");
	
	$arrList = array('languages'=>$lang, 'currency'=>$currency, 'eh_region'=>$eh_region, 'eh_image'=>$eh_image, 'eh_model'=>$eh_model, 'eh_drive'=>$eh_drive, 'eh_server'=>$eh_server, 'eh_ip'=>$eh_ip, 'eh_vlan'=>$eh_vlan, 'eh_server_role'=>$eh_server_role, 'aws_zone'=>$aws_zone, 'aws_region'=>$aws_region, 'aws_image'=>$aws_image, 'aws_ins_type'=>$aws_ins_type, 'aws_vpc'=>$aws_vpc, 'aws_port'=>$aws_port, 'aws_instance'=>$aws_instance);
	
	return $arrList[$list];
	//checking for rights
	/*global $access_rights;
	if($access_rights[1] == '1')
	{
		return $arrList[$list];
	}
	else
	{
		return array("access-denied"=>"ACCESS DENIED");
	}*/	
}

function getStatus($status){
	switch($status){
		case 'act_0': $status = "<b class='inr-hltxt4'>InActive</b>"; break;
		case 'act_1': $status = "<b class='inr-hltxt2'>Active</b>"; break;
		
		case 'aws_terminated': $status = "<b class='inr-hltxt4'>Terminated</b>"; break;
		case 'aws_stopped': $status = "<b class='inr-hltxt4'>Stopped</b>"; break;
		case 'aws_running': $status = "<b class='inr-hltxt2'>Running</b>"; break;
		case 'aws_stopping': $status = "<b class='inr-hltxt3'>Stopping</b>"; break;
		case 'aws_starting': $status = "<b class='inr-hltxt2'>Starting</b>"; break;
		case 'aws_pending': $status = "<b class='inr-hltxt3'>Pending</b>"; break;

		default: $status = $status; break;
	}
	return $status;
}

function getTicketUser($id){
	$q="SELECT u.name, u.email FROM users u INNER JOIN tickets USING(id_users) WHERE ticket_id='$id'";
	$sql=mysql_query($q);	
	$row=mysql_fetch_array($sql);
	return $row;
}

function getCurrServerPrice($uid, $pid, $server, $currency){
	$q = "SELECT price FROM currency_servers WHERE id_users='$uid' and product_id='$pid' and name='$server' AND currency_code='$currency'";
	$sql = mysql_query($q);	$rws = mysql_num_rows($sql);
	
	if($rws > 0){
		$rw = mysql_fetch_array($sql);
		return $rw['price'];
	}
	return;
}

function getPrice($id, $pid){
	$q = "SELECT price FROM pre_plan_rates WHERE product_id = '$pid' and id_users='$id'";
	$sq1 = mysql_query($q);
	$rws = mysql_num_rows($sq1);
	
	if($rws > 0){
		$price_r = mysql_fetch_array($sq1);
		return $price_r['price'];
	}
	return false;		
}
function getPreplaneProducts(){
	$q = "SELECT inv.product_id, inv.name FROM inventory inv INNER JOIN inventory_categories cat USING(cat_id) WHERE cat.attributed != '1'";
	$sq = mysql_query($q);
	$arr = array();
	
	while($rw = mysql_fetch_array($sq)){
		$arr[$rw['product_id']]= $rw['name'];
	}
	return $arr;
}
function getAllProducts(){
	$q = "SELECT product_id, name FROM inventory";
	$sq = mysql_query($q);
	$arr = array();
	
	while($rw = mysql_fetch_array($sq)){
		$arr[$rw['product_id']]= $rw['name'];
	}
	return $arr;
}
function getCustomizeProducts(){
	$q = "SELECT inv.product_id, inv.name FROM inventory inv INNER JOIN inventory_categories cat USING(cat_id) WHERE cat.attributed = '1'";
	$sq = mysql_query($q);
	$arr = array();
	
	while($rw = mysql_fetch_array($sq)){
		$arr[$rw['product_id']]= $rw['name'];
	}
	return $arr;
}
function getUserServers($id){
	$q = "SELECT name FROM inventory_servers WHERE id_users='$id'  GROUP BY name";
	$sql = mysql_query($q);
	$arr = array();

	while($rw = mysql_fetch_array($sql)){
		$arr[] = $rw['name'];
	}
	return $arr;
}
function unSetValue($arr, $v1){
	if($arr != ""){
		foreach($arr as $k=>$v){
			if($v == $v1){
				unset($arr[$k]);
			}
		}
	}
	return $arr;
}
function getProductName($id){
	$q="SELECT name FROM inventory where product_id='$id'";
	$sql=mysql_query($q);
	$row=mysql_fetch_array($sql);
	
	return $row['name'];
}

function getFAQCats(){
	$q = "select * from faq_cat"; $sq = mysql_query($q);$arr = array();
	while($cn = mysql_fetch_array($sq)){ $arr[$cn['cat_id']]=$cn['cat_name'];}
	return $arr;
}

function getFAQCatsAjax($cat_lang){
	$q = "select * from faq_cat WHERE language='$cat_lang'"; $sq = mysql_query($q);$arr = array();
	while($cn = mysql_fetch_array($sq)){ $arr[$cn['cat_id']]=$cn['cat_name'];}
	return $arr;
}
?>