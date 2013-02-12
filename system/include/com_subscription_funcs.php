<?php 
function getFields($list){
	$subscription = array("ID"=>"manage_cloud_id", "Admin Freindly Name"=>"admin_friendly_name", "Created on"=>"creation_date", "Last Update"=>"last_modified", "Status"=>"status", "Action"=>"");
	$manage_cloud_trans = array("ID"=>"id", "Title"=>"title", "Language"=>"language", "Details"=>"");
	$manage_cloud_price = array("ID"=>"id", "Price"=>"price", "Server Range From (GB)"=>"server_range_from", "Server Range To (GB)"=>"server_range_to", "Currency"=>"currency", "Details"=>"");
	$manage_cloud_detail = array("ID"=>"id", "Title"=>"title", "Description"=>"description", "Language"=>"language", "Order"=>"record_order", "Details"=>"");
	
	$apps		= array("ID"=>"click_app_id", "Admin Freindly Name"=>"admin_friendly_name", "Created on"=>"creation_date", "Last Update"=>"last_modified", "Manage Status"=>"manage_status", "Action"=>"");
	$app_types	= array("ID"=>"id_type", "Type Name"=>"type_name", "Action"=>"");
	
	$feature	= array("ID"=>"feature_id", "Admin Freindly Name"=>"admin_freindly_name", "Status"=>"status", "Order"=>"record_order", "Action"=>"");
	$clickgo_feature_trans = array("ID"=>"id", "Title"=>"feature_title", "Language"=>"language", "Details"=>"");
	
	$price_cat	= array("ID"=>"price_cat_id", "Admin Freindly Name"=>"admin_friendly_name", "Status"=>"status", "Action"=>"");
	$price_cat_trans = array("ID"=>"id", "Title"=>"price_cat_title", "Language"=>"language", "Details"=>"");
	$price_cat_price = array("ID"=>"id", "Price"=>"price", "Currency"=>"currency", "Details"=>"");
	$price_cat_detail = array("ID"=>"id", "Title"=>"title", "Description"=>"description", "Language"=>"language", "Order"=>"record_order", "Details"=>"");
	
	$message		= array("ID"=>"id_message", "Admin Freindly Name"=>"admin_friendly_name", "Status"=>"status", "Action"=>"");
	$message_trans	= array("ID"=>"id", "Text"=>"message_text", "Language"=>"language", "Details"=>"");
	
	$vandor			= array("ID"=>"id_vandor", "Admin Freindly Name"=>"admin_friendly_name", "Status"=>"status", "Action"=>"");
	$vandor_trans	= array("ID"=>"id", "Vandor Name"=>"vandor_name", "Language"=>"language", "Details"=>"");
	$vandor_detail = array("ID"=>"id", "Memory"=>"memory_size", "Processor"=>"processor", "HD Space"=>"hd_size", "Price"=>"price", "Order"=>"record_order", "Details"=>"");
	$vandor_bandwidth = array("ID"=>"id", "Bandwidth"=>"bandwidth", "Price"=>"price", "Order"=>"record_order", "Details"=>"");
	$vandor_datacenter = array("ID"=>"id", "Name"=>"name", "Order"=>"record_order", "Details"=>"");
	
	$services		= array("ID"=>"s.service_id", "Service Name"=>"s.service_name", "User Name"=>"u.name", "Created on"=>"s.created_on", "Creation Date"=>"s.charge_date", "Amount"=>"s.amount", "Status"=>"s.status", "Action"=>"");
	
	$page				= array("ID"=>"id_page", "Page Name"=>"page_name", "Page Link"=>"page_link", "Action"=>"");
	$request			= array("ID"=>"r.id_request", "User Name"=>"u.name", "Date"=>"r.date", "Action"=>"");
	
	$server_comp		= array("ID"=>"id_server_quotation_component", "Component Name"=>"component_name", "Sort Order"=>"sort", "Status"=>"status", "Action"=>"");
	$server_comp_value	= array("ID"=>"id_server_quotation_component_value", "Value Name"=>"name", "Amount"=>"amount", "Sort Order"=>"sort", "Status"=>"status", "Action"=>"");
	$server_quote		= array("ID"=>"q.id_server_quotation", "Admin Name"=>"a.username", "Generated On"=>"q.generated_on", "Updated On"=>"q.updated_on", "Total Amount"=>"q.total_amount", "Action"=>"");
	
	$domain			= array("ID"=>"id_domain", "Domain Name"=>"domain_name", "Action"=>"");
	
	$compensation	= array("ID"=>"c.id_compensation", "Name"=>"u.name", "Hours"=>"c.hours", "Month"=>"c.month", "Status"=>"c.status", "Action"=>"");
	
	$feng_report	= array("Date"=>"date", "Title"=>"title", "Workspace"=>"workspace", "User"=>"user", "Time"=>"time", "Time In Minutes"=>"time_in_minutes");

	$sortList = array(
						'subscription'=>$subscription, 
						'manage_cloud_trans'=>$manage_cloud_trans, 
						'manage_cloud_price'=>$manage_cloud_price,
						'manage_cloud_detail'=>$manage_cloud_detail,
						'apps'=>$apps,
						'app_types'=>$app_types,
						'feature'=>$feature,
						'clickgo_feature_trans'=>$clickgo_feature_trans,
						'price_cat'=>$price_cat,
						'price_cat_trans'=>$price_cat_trans,
						'price_cat_price'=>$price_cat_price,
						'price_cat_detail'=>$price_cat_detail,
						'message'=>$message,
						'message_trans'=>$message_trans,
						'vandor'=>$vandor,
						'vandor_trans'=>$vandor_trans,
						'vandor_detail'=>$vandor_detail,
						'vandor_bandwidth'=>$vandor_bandwidth,
						'vandor_datacenter'=>$vandor_datacenter,
						'services'=>$services,
						'page'=>$page,
						'request'=>$request,
						'server_comp'=>$server_comp,
						'server_comp_value'=>$server_comp_value,
						'server_quote'=>$server_quote,
						'domain'=>$domain,
						'compensation'=>$compensation,
						'feng_report'=>$feng_report
					);
	
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
		
		case "sub_del": $act = "DELETE FROM manage_cloud WHERE manage_cloud_id='$id'"; break;
		case "sub_0": case "sub_1": if($act=='sub_0'){$act=0;}else $act=1; $act = "UPDATE manage_cloud SET status='$act' WHERE manage_cloud_id='$id'"; break;
		case "sub_trans_del": $act = "DELETE FROM manage_cloud_trans WHERE id='$id'"; break;
		case "sub_price_del": $act = "DELETE FROM manage_cloud_price WHERE id='$id'"; break;
		case "sub_detail_del": $act = "DELETE FROM manage_cloud_feat WHERE id='$id'"; break;
		
		case "app_del": $act = "DELETE FROM click_go_apps WHERE click_app_id='$id'"; break;
		case "app_0": $act = "UPDATE click_go_apps SET manage_status='0' WHERE click_app_id='$id'"; break;
		case "app_1": $act = "UPDATE click_go_apps SET manage_status='1' WHERE click_app_id='$id'"; break;
		case "app_2": $act = "UPDATE click_go_apps SET manage_status='2' WHERE click_app_id='$id'"; break;
		case "app_3": $act = "UPDATE click_go_apps SET manage_status='3' WHERE click_app_id='$id'"; break;
		case "app_trans_del": $act = "DELETE FROM click_go_apps_trans WHERE id='$id'"; break;
		case "app_types_del": $act = "DELETE FROM click_go_apps_type WHERE id_type='$id'"; break;
		
		case "fea_del": $act = "DELETE FROM click_go_features WHERE feature_id='$id'"; break;
		case "fea_0": case "fea_1": if($act=='fea_0'){$act=0;}else $act=1; $act = "UPDATE click_go_features SET status='$act' WHERE feature_id='$id'"; break;
		case "fea_trans_del": $act = "DELETE FROM click_go_features_text WHERE id='$id'"; break;
		
		case "pri_cat_del": $act = "DELETE FROM click_go_price_cat WHERE price_cat_id='$id'"; break;
		case "pri_cat_0": case "pri_cat_1": if($act=='pri_cat_0'){$act=0;}else $act=1; $act = "UPDATE click_go_price_cat SET status='$act' WHERE price_cat_id='$id'"; break;
		case "pri_cat_trans_del": $act = "DELETE FROM click_go_price_cat_trans WHERE id='$id'"; break;
		case "pri_cat_price_del": $act = "DELETE FROM click_go_price_cat_price WHERE id='$id'"; break;
		case "pri_cat_detail_del": $act = "DELETE FROM click_go_price_detail WHERE id='$id'"; break;
		
		case "msg_del": $act = "DELETE FROM member_message WHERE id_message='$id'"; break;
		case "msg_0": $act = "UPDATE member_message SET status='0' WHERE id_message='$id'"; break;
		case "msg_1": $act = "UPDATE member_message SET status='1' WHERE id_message='$id'"; break;
		case "msg_trans_del": $act = "DELETE FROM member_message_trans WHERE id='$id'"; break;
		
		case "vandor_del": $act = "DELETE FROM pricing_vandor WHERE id_vandor='$id'"; break;
		case "vandor_0": $act = "UPDATE pricing_vandor SET status='0' WHERE id_vandor='$id'"; break;
		case "vandor_1": $act = "UPDATE pricing_vandor SET status='1' WHERE id_vandor='$id'"; break;
		case "vandor_trans_del": $act = "DELETE FROM pricing_vandor_trans WHERE id='$id'"; break;
		case "vandor_detail_del": $act = "DELETE FROM pricing_vandor_detail WHERE id='$id'"; break;
		case "vandor_bandwidth_del": $act = "DELETE FROM pricing_vandor_bandwidth WHERE id='$id'"; break;
		case "vandor_datacenter_del": $act = "DELETE FROM pricing_vandor_datacenter WHERE id='$id'"; break;
		
		case "service_del": $act = "DELETE FROM service WHERE service_id='$id'"; break;
		case "service_0": $act = "UPDATE service SET status='0' WHERE service_id='$id'"; break;
		case "service_1": $act = "UPDATE service SET status='1' WHERE service_id='$id'"; break;
		
		case "page_del": $act = "DELETE FROM affiliate_pages WHERE id_page='$id'"; break;
		
		case "comp_del": $act = "DELETE FROM server_quotation_component WHERE id_server_quotation_component='$id'"; break;
		case "comp_0": $act = "UPDATE server_quotation_component SET status='0' WHERE id_server_quotation_component='$id'"; break;
		case "comp_1": $act = "UPDATE server_quotation_component SET status='1' WHERE id_server_quotation_component='$id'"; break;
		
		case "comp_val_del": $act = "DELETE FROM server_quotation_component_value WHERE id_server_quotation_component_value='$id'"; break;
		case "comp_val_0": $act = "UPDATE server_quotation_component_value SET status='0' WHERE id_server_quotation_component_value='$id'"; break;
		case "comp_val_1": $act = "UPDATE server_quotation_component_value SET status='1' WHERE id_server_quotation_component_value='$id'"; break;
		
		case "serv_quote_del": $act = "DELETE FROM server_quotation WHERE id_server_quotation='$id'"; break;
		
		case "domain_del": $act = "DELETE FROM blocked_email_domains WHERE id_domain='$id'"; break;
		
		case "inv_comp_del": $act = "DELETE FROM invoice_compensation WHERE id_compensation='$id'"; break;
		case "inv_comp_0": $act = "UPDATE invoice_compensation SET status='0' WHERE id_compensation='$id'"; break;
		case "inv_comp_1": $act = "UPDATE invoice_compensation SET status='1' WHERE id_compensation='$id'"; break;
		
		default: $act = $act; break;
	}
	
	return $act;
}


function getActionLinks($list){
	$subscription = array("sub_1"=>"ACTIVE", "sub_0"=>"INACTIVE");
	$sub_trans = array("sub_trans_del"=>"DELETE");
	$sub_price = array("sub_price_del"=>"DELETE");
	$sub_detail = array("sub_detail_del"=>"DELETE");
	
	$app = array("app_del"=>"DELETE", "app_0"=>"Off", "app_1"=>"Click Go", "app_2"=>"Manage Cloud", "app_3"=>"Power Cloud");
	$app_trans = array("app_trans_del"=>"DELETE");
	$app_types = array("app_types_del"=>"DELETE");
	
	$feature = array("fea_del"=>"DELETE", "fea_1"=>"ACTIVE", "fea_0"=>"INACTIVE");
	$fea_trans = array("fea_trans_del"=>"DELETE");
	
	$price_cat = array("pri_cat_del"=>"DELETE", "pri_cat_1"=>"ACTIVE", "pri_cat_0"=>"INACTIVE");
	$price_cat_trans = array("pri_cat_trans_del"=>"DELETE");
	$price_cat_price = array("pri_cat_price_del"=>"DELETE");
	$price_cat_detail = array("pri_cat_detail_del"=>"DELETE");
	
	$message = array("msg_del"=>"DELETE", "msg_1"=>"ACTIVE", "msg_0"=>"INACTIVE");
	$message_trans = array("message_trans_del"=>"DELETE");
	
	$vandor = array("vandor_del"=>"DELETE", "vandor_1"=>"ACTIVE", "vandor_0"=>"INACTIVE");
	$vandor_trans = array("vandor_trans_del"=>"DELETE");
	$vandor_detail = array("vandor_detail_del"=>"DELETE");
	$vandor_bandwidth = array("vandor_bandwidth_del"=>"DELETE");
	$vandor_datacenter = array("vandor_datacenter_del"=>"DELETE");
	
	$services = array("service_del"=>"DELETE", "service_1"=>"ACTIVE", "service_0"=>"INACTIVE");
	
	$page = array("page_del"=>"DELETE");
	
	$server_comp = array("comp_1"=>"ACTIVE", "comp_0"=>"INACTIVE");
	$server_comp_value = array("comp_val_1"=>"ACTIVE", "comp_val_0"=>"INACTIVE");
	$server_quote = array("serv_quote_del"=>"DELETE");
	
	$domain = array("domain_del"=>"DELETE");
	
	$compensation = array("inv_comp_del"=>"DELETE", "inv_comp_1"=>"COMPENSATED", "inv_comp_0"=>"PENDING");
	
	$arrList = array("subscription"=>$subscription, "sub_trans"=>$sub_trans, "sub_price"=>$sub_price, "sub_detail"=>$sub_detail, "app"=>$app, "app_trans"=>$app_trans, "app_types"=>$app_types, 'feature'=>$feature, 'fea_trans'=>$fea_trans, "price_cat"=>$price_cat, "price_cat_trans"=>$price_cat_trans, "price_cat_price"=>$price_cat_price, "price_cat_detail"=>$price_cat_detail, "message"=>$message, "message_trans"=>$message_trans, "vandor"=>$vandor, "vandor_trans"=>$vandor_trans, "vandor_detail"=>$vandor_detail, "services"=>$services, 'vandor_bandwidth'=>$vandor_bandwidth, 'page'=>$page, 'server_comp'=>$server_comp, 'server_comp_value'=>$server_comp_value, 'server_quote'=>$server_quote, 'domain'=>$domain, 'compensation'=>$compensation, 'vandor_datacenter'=>$vandor_datacenter);
	
	//checking for rights
	global $access_rights;
	if($access_rights[1] == '1')
	{
		return $arrList[$list];
	}
	else
	{
		return array("access-denied"=>"ACCESS DENIED");
	}	
}

function getStatus($status){
	switch($status){
		case 'sub_0': $status = "<b class='inr-hltxt4'>InActive</b>"; break;
		case 'sub_1': $status = "<b class='inr-hltxt2'>Active</b>"; break;
		
		case 'app_0': $status = "<b class='inr-hltxt4'>Off</b>"; break;
		case 'app_1': $status = "<b class='inr-hltxt2'>Click Go</b>"; break;
		case 'app_2': $status = "<b class='inr-hltxt2'>Manage Cloud</b>"; break;
		case 'app_3': $status = "<b class='inr-hltxt2'>Power Cloud</b>"; break;
		
		case 'fea_0': $status = "<b class='inr-hltxt4'>InActive</b>"; break;
		case 'fea_1': $status = "<b class='inr-hltxt2'>Active</b>"; break;
		
		case 'pri_cat_0': $status = "<b class='inr-hltxt4'>InActive</b>"; break;
		case 'pri_cat_1': $status = "<b class='inr-hltxt2'>Active</b>"; break;
		
		case 'msg_0': $status = "<b class='inr-hltxt4'>InActive</b>"; break;
		case 'msg_1': $status = "<b class='inr-hltxt1'>Active</b>"; break;
		
		case 'vandor_0': $status = "<b class='inr-hltxt4'>InActive</b>"; break;
		case 'vandor_1': $status = "<b class='inr-hltxt1'>Active</b>"; break;
		
		case 'service_0': $status = "<b class='inr-hltxt4'>InActive</b>"; break;
		case 'service_1': $status = "<b class='inr-hltxt1'>Active</b>"; break;
		
		case 'inv_comp_0': $status = "<b class='inr-hltxt4'>Pending</b>"; break;
		case 'inv_comp_1': $status = "<b class='inr-hltxt1'>Compensated</b>"; break;

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