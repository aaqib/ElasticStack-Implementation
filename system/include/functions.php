<?php 
/************************************************************************************************
	Developer: Muhammad Akram
	Company: Gaditek Solution
	Date: 06 April 2010
************************************************************************************************/

function getFields($list)
{
	$inv = array('ID'=>'i.id_invoice', 'Client'=>'u.name', 'Date'=>'i.date', 'Due Date'=>'', 'Payment Method'=>'i.payment_method', 'Type'=>'i.id_invoice_parent', 'Amount'=>'i.amount', 'Status'=>'i.status');
	//$customers = array('ID'=>'u.id_users', 'Email'=>'u.email', 'Name'=>'u.name', 'Managed Type'=>'u.is_managed', 'Status'=>'u.is_active', 'VAT Apply'=>'u.vat_applied', 'Language'=>'lang.screen_name', "User Services"=>"", 'Details'=>'');
	$customers = array('ID'=>'u.id_users', 'Email'=>'u.email', 'Name'=>'u.name', 'Date'=>'u.date', 'User Type'=>'u.is_managed', 'Status'=>'u.is_active', 'VAT Apply'=>'u.vat_applied', 'Verified'=>'u.manual_verified', 'Blocked(UnAuth)'=>'u.is_blocked', 'Details'=>'');
	$team = array('ID'=>'t.id_users_sec', 'Email'=>'t.email', 'Name'=>'t.name', 'Create By'=>'', 'Date'=>'t.added_on', 'Status'=>'t.status');
	$fund_hist = array("ID"=>"fund.id_transaction", "Discription"=>"fund.service_id", "Date"=>"fund.fund_date", "Ammount"=>"fund.amount");	
	$inv_hist = array("ID"=>"inv.id_invoice", "Date"=>"inv.creation_date", "Invoice Type"=>"inv.invoice_type", "Payment Status"=>"inv.payment_status", "Ammount (User)"=>"inv.grand_total_user", "Ammount (CW)"=>"inv.grand_total_cw");
	$servicesArr = array("ID"=>"ser.service_id", "Config Name"=>"conf.admin_friendly_name", "Activate On"=>"ser.activated_on", "Provider"=>"pro.provider", "Status"=>"ser.service_status", "Funds"=>"u.currency", "Hours"=>"", "Action"=>"");
	$servicesView = array("ID"=>"ser.service_id", "Config Name"=>"conf.admin_friendly_name", "User Name"=>"u.name", "Viewed On"=>"ser.created_on", "Provider"=>"pro.provider", "Platform"=>"plat.platform");
	$client_cancel_req = array("ID"=>"req.id_c_requests", "Service ID"=>"req.service_id", "User Name"=>"u.name", "Reason"=>"req.reason", "Status"=>"req.status", "Remove Credential"=>"req.credential", "Date"=>"req.date");
	$servicesLog = array("ID"=>"id", "Service ID"=>"service_id", "Activity Code"=>"activity", "Description"=>"note", "Date and Time"=>"date_time", "Type"=>"status");
	$tick = array('ID'=>"t.ticket_id", 'Client'=>"u.name", 'Date'=>"t.date", 'Categoy'=>"cat.cat_name", 'Subject'=>"t.ticket_subject", 'Status'=>"st.type_name", 'Urgency'=>"t.ticket_urgency");
	$tick_dept = array("ID"=>"dept.section_id", "Department"=>"dept.sec_name", "E-Mail"=>"dept.email", "Language"=>"lang.screen_name", "Status"=>"dept.is_active", "Priority"=>"dept.sec_priority", "Details"=>"");
	$tick_cat = array("ID"=>"cat.category_id", "Title"=>"cat.cat_name", "Description"=>"cat.cat_desc", "Department"=>"sec.sec_name", "Status"=>"cat.is_active", "Details"=>"");
	$client_fund_hist = array("ID"=>"pre.id_transaction", "Description"=>"pre.id_invoice", "Prepaid Amount"=>"pre.type", "Date"=>"pre.date", "Amount"=>"pre.amount");
	$client_com_hist = array("ID"=>"com.id_affiliates_balance", "Description"=>"com.id_invoice", "Prepaid Amount"=>"", "Date"=>"com.date", "Amount"=>"com.amount");
	$affiliates = array("ID"=>"a.id", "User Name"=>"u.name", "Payout Percentage"=>"plan.percentage", "Limit"=>"plan.payout_limit", "Date"=>"a.date", "Status"=>"a.status");
	$payout_req = array("ID"=>"req.id", "User Name"=>"u.name", "User E-mail"=>"u.email", "Amount"=>"req.amount", "Payment Method"=>"req.method", "Details"=>"");
	$activity = array("ID"=>"act.activity_id", "User Name"=>"ad.username", "Description"=>"act.activity", "Date"=>"act.act_date"	);
	$servers = array("ID"=>"s.id", "Server Name"=>"s.name", "Location"=>"cnt.printable_name", "Discription"=>"s.features", "Display"=>"s.display", "Status"=>"s.status", "Details"=>"");
	$bane_list = array("ID"=>"id_ban_list", "E-mail"=>"item");
	$notifications = array("ID"=>"nt.id", "Event"=>"nt.event", "Subject"=>"nt.subject", "E-mail Message"=>"nt.message", "Language"=>"lang.screen_name", "Details"=>"");
	$tex_report = array("ID"=>"fund.id_transaction", "Service ID"=>"fund.service_id", "User Name"=>"u.name", "Amount"=>"", "Tax"=>"", "Currency"=>"fund.currency", "Date and Time"=>"fund.fund_date");
	$pro_cats = array("ID"=>"cat_id", "Title"=>"cat_name", "Description"=>"description", "Status"=>"status", "Details"=>"");
	$pro_cat_trans = array("ID"=>"trans_id", "Category"=>"cat_name", "Description"=>"cat_desc", "Language"=>"language", "Details"=>"");
	$plan_all = array("ID"=>"c.id_config", "Admin Friendly Name"=>"c.admin_friendly_name", "Amazon Configuration"=>"", "Elastic Host Configuration"=>"", "Action"=>"");
	$pro_cur_all = array("ID"=>"c.id", "Currency"=>"c.currency_code", "Price"=>"c.price", "Setup Fee"=>"c.setup", "Details"=>"");
	$plan_trans_all = array("ID"=>"id", "User Friendly Name"=>"user_friendly_name", "Language"=>"language", "Details"=>"");
	
	$pro_servers_all = array("Server Title"=>"s.name", "Server Code"=>"conf.server_code", "IP-Address"=>"conf.ip", "Status"=>"conf.status", "Flag"=>"conf.flag");
	$apps = array("ID"=>"a.id_application", "Keyword"=>"a.keyword", "language"=>"lang.screen_name", "Actions"=>"");
	$chars = array("ID"=>"a.id_characteristics", "Keyword"=>"a.keyword", "language"=>"lang.screen_name", "Actions"=>"");
	$alert_message = array("ID"=>"alert.id", "Event"=>"alert.event", "Message"=>"alert.message", "Language"=>"lang.screen_name", "Details"=>"");
	$service_search = array("ID"=>"search_id", "Admin Friendly Name"=>"admin_friendly_name", "Windows Configuration"=>"", "Linux Configuration"=>"", "Status"=>"status", "Action"=>"");
	
	$service_search_category = array("ID"=>"search_category_id", "Admin Friendly Name"=>"admin_friendly_name", "Status"=>"status", "Action"=>"");	
	$service_search_category_trans = array("ID"=>"id", "Title"=>"title", "Language"=>"language", "Details"=>"");
	$service_search_category_framework = array("ID"=>"data.id", "Framework Title"=>"", "Category Title"=>"");
	$service_search_framework = array("ID"=>"search_framework_id", "Admin Friendly Name"=>"admin_friendly_name", "Basic Plan"=>"search_basic", "Professional Plan"=>"search_profesional", "Enterprise Plan"=>"search_enterprise", "Status"=>"status", "Details"=>"");
	$service_search_framework_trans = array("ID"=>"id", "Title"=>"title", "Language"=>"language", "Details"=>"");
	$service_search_trans_all = array("ID"=>"id", "Title"=>"title", "Language"=>"language", "Details"=>"");
	
	$cron_log = array("ID"=>"id", "Type"=>"cron_type", "Executed On"=>"run_on", "Invoice IDs"=>"id_invoices");
	$email_log = array("ID"=>"l.id", "Name"=>"u.name", "Email"=>"u.email", "Subject"=>'l.subject', "Date"=>"l.sent_on", "Details"=>"");
	$adyen_log = array("ID"=>"ad.id", "Name"=>"u.name", "Email"=>"u.email", "IP"=>'ad.ip', "Action"=>"ad.action", "Result"=>"ad.result", "Date"=>"logged_on");
	$sc_log = array("ID"=>"api.id_status", "Name"=>"api.name", "Email"=>"u.email", "IP"=>'api.user_ip', "Date"=>"api.access_on", "Details"=>"");
	$login_log = array("ID"=>"id_history", "Name"=>"", "Email"=>"", "IP"=>'user_ip', "Access Type"=>"type", "User Type"=>"user_type", "Date"=>"history_date");
	$comm_hist = array("ID"=>"comm.id_aff_comm", "Date"=>"comm.date", "Type"=>"comm.type", "Status"=>"comm.status", "Ammount"=>"comm.amount_affiliate");
	$affiliates = array('ID'=>'u.id_users', 'Email'=>'u.email', 'Name'=>'u.name', 'Total Visits'=>'', 'Total Signups'=>'', "Details"=>"");
	$verify_cus = array('ID'=>'u.id_users', 'Email'=>'u.email', 'Name'=>'u.name', 'User Type'=>'u.type', 'Authorization Date'=>'u.auth_date');
	
	$invoice_summary = array("ID"=>"id_summary", "Date"=>"date", "SC Amount"=>"total_sc_amount", "Managed Service Amount"=>"total_cw_amount", "VAT/Markup"=>"total_tax_amount", "Company User Amount"=>"total_company_amount", "Action"=>"");

	$sortList = array(
	'alert_message'=>$alert_message, 
	'servicesLog'=>$servicesLog, 
	'invoices'=>$inv, 
	'fund_hist'=>$fund_hist, 
	'inv_hist'=>$inv_hist,
	'customers'=>$customers, 
	'team'=>$team,
	'tickets'=>$tick, 
	"services"=>$servicesArr, 
	"servicesView"=>$servicesView, 
	"ticket_sec"=>$tick_dept, 
	"ticket_cat"=>$tick_cat, 
	"client_cancel_req"=>$client_cancel_req, 
	"client_fund_hist"=>$client_fund_hist, 
	"client_com_hist"=>$client_com_hist, 
	"affiliates"=>$affiliates, 
	"payout_req"=>$payout_req, 
	"activity"=>$activity, 
	"servers"=>$servers, 
	"bane_list"=>$bane_list, 
	"notifications"=>$notifications, 
	"tex_report"=>$tex_report, 
	"pro_cats"=>$pro_cats, 
	"plan_all"=>$plan_all, 
	"plan_trans_all"=>$plan_trans_all, 
	"pro_servers_all"=>$pro_servers_all, 
	"pro_cat_trans"=>$pro_cat_trans, 
	"pro_cur_all"=>$pro_cur_all, 
	'apps'=>$apps, 
	'chars'=>$chars, 
	'service_search'=>$service_search,
	'service_search_trans_all'=>$service_search_trans_all,
	'service_search_category'=>$service_search_category,
	'service_search_category_trans'=>$service_search_category_trans,
	'service_search_category_framework'=>$service_search_category_framework,
	'service_search_framework'=>$service_search_framework,
	'service_search_framework_trans'=>$service_search_framework_trans,
	'cron_log'=>$cron_log,
	'email_log'=>$email_log,
	'adyen_log'=>$adyen_log,
	'sc_log'=>$sc_log,
	'login_log'=>$login_log,
	'comm_hist'=>$comm_hist,
	'affiliates'=>$affiliates,
	'verify_cus'=>$verify_cus,
	'invoice_summary'=>$invoice_summary
	);
	return $sortList[$list];
}

function getQuery($table, $parm)
{
	$arr = array("invoices"=>" , i.symbol FROM invoice i INNER JOIN users u USING(id_users) WHERE u.name LIKE '%$parm%' OR u.email LIKE '%$parm%'",
				 "customers"=>"FROM users u INNER JOIN languages lang ON lang.code = u.language WHERE name LIKE '%$parm%' OR email LIKE '%$parm%'",
				 "tickets"=>", st.ticket_status_id FROM tickets t INNER JOIN ticket_categories cat USING(category_id) INNER JOIN ticket_status_type st USING(ticket_status_id) INNER JOIN users u USING(id_users) WHERE u.name LIKE '%$parm%' OR u.id_users LIKE '%$parm%' OR st.type_name LIKE '%$parm%'",
				 "services"=>", ser.id_users, ser.id_cloud, curr.symbol FROM service ser INNER JOIN configurations conf USING(id_config) INNER JOIN cloud_provider pro USING(id_provider) INNER JOIN platforms plat USING(id_platform) INNER JOIN users u USING(id_users) INNER JOIN currency curr ON curr.currency_code = u.currency WHERE ser.status='0' AND u.name LIKE '%$parm%' OR ser.service_id LIKE '%$parm%' OR pro.provider LIKE '%$parm%' OR plat.platform LIKE '%$parm%'");
	return $arr[$table];
}

function getTicketUser($id){
	$q="SELECT u.name, u.email, u.language AS lang FROM users u INNER JOIN tickets USING(id_users) WHERE ticket_id='$id'";
	$sql=mysql_query($q);
	$row=mysql_fetch_array($sql);
	return $row;
}

function getQueryParm($parm){
	switch($parm){
		case "seract_1": $parm=1; break;
		case "seract_C": $parm="C"; break;
		case "seract_F": $parm="F"; break;
		case "seract_E": $parm="E"; break;
		default: $parm=$parm; break;
	}
	return $parm;
}

function getActionQuery($act,$id){
	$activity = getActivity($act, str_replace("_../", " ",$id));
	foreach($activity as $k=>$v){
		$arr = array("type"=>$k, "activity"=>$v, 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']);
		addActivity($arr);
	}
	switch($act){
		case "Paid": 
			$act2= "UPDATE invoice SET status='$act' WHERE id_invoice='$id' AND status!='Cancelled'";  $sql = mysql_query($act2);
			$rws=mysql_affected_rows(); 
			if($rws>0){
				$act2 = "UPDATE invoice_details SET paid='1', last_updated=now() WHERE id_invoice='$id' AND status!='C'"; mysql_query($act2);
				$act1 = "UPDATE invoice SET last_updated=now() WHERE id_invoice='$id' AND status!='Cancelled'";  $sql = mysql_query($act1);
				$q = "SELECT i.*, u.name, u.email, u.language FROM invoice i INNER JOIN users u USING(id_users) WHERE i.id_invoice='$id'";

				$sql=mysql_query($q); $rw = mysql_fetch_array($sql);

				$newdate = getDueDate($rw['date']);

				$arr = array('name'=>$rw['name'], 'email'=>$rw['email'], "lang"=>$rw['language'],'id_invoice'=>$rw['id_invoice'],

				'amount'=>$rw['amount'], 'date'=>$rw['date'], 'newdate'=>$newdate, "symbol"=>$rw['symbol'], "currency"=>$rw['currency']);

					genrateOrRenewInvoice($id,"../../../../", "manual");

			} break;

		
		case "Unpaid": 

			$act2= "UPDATE invoice SET status='$act' WHERE id_invoice='$id' AND status!='Cancelled'";  $sql = mysql_query($act2);

			$rws=mysql_affected_rows(); 

			if($rws>0){

 				$act2 = "UPDATE invoice_details SET paid='0', last_updated=now() WHERE id_invoice='$id' AND status!='C'"; mysql_query($act2);

				$act1 = "UPDATE invoice SET last_updated=now() WHERE id_invoice='$id' AND status!='Cancelled'";  $sql = mysql_query($act1);

  				$act1 = "DELETE FROM affiliates_balance WHERE id_invoice='$id'";  $sql = mysql_query($act1);
 				$q = "SELECT i.*, u.name, u.email, u.language FROM invoice i INNER JOIN users u USING(id_users) WHERE i.id_invoice='$id'";
 
 				$sql=mysql_query($q); $rw = mysql_fetch_array($sql);
 
 				$newdate = getDueDate($rw['date']);
 
 				$arr = array('name'=>$rw['name'], 'email'=>$rw['email'], "lang"=>$rw['language'],'id_invoice'=>$rw['id_invoice'],
 
 				'amount'=>$rw['amount'], 'date'=>$rw['date'], 'newdate'=>$newdate, "symbol"=>$rw['symbol'], "currency"=>$rw['currency']);
 
 				 //sendMail("nu", $arr);
 
			} break;



		case "Cancelled":
			
			$act1 = "UPDATE invoice SET status='$act', last_updated=now() WHERE id_invoice='$id' AND status!='Cancelled'";
			$sql = mysql_query($act1); break;

		case "inv_del": $act = "DELETE FROM invoice WHERE id_invoice='$id'"; break;

		case "2": case "4": case "5": case "6":  $act = "UPDATE tickets SET ticket_status_id='$act', last_updated=now() WHERE ticket_id='$id'"; break;

		case "seract_C": 
			$parm = getQueryParm($act); 
			$act = "UPDATE service SET service_status='$parm', last_updated=NOW() WHERE service_id='$id' AND service_status!='C'"; 
			//changeServiceStatus($id,"cancel_", "C"); | Not use Here			

			//Updating Alert Message
			mem_alert_act($id, "status='0'");
		break;

		case "seract_E": 
			$parm = getQueryParm($act); 
			$act = "UPDATE service SET service_status='$parm', last_updated=NOW() WHERE service_id='$id' AND service_status!='C'"; 

			//Updating Alert Message
			mem_alert_act($id, "code='exp', status='1'");
		break;

		case "seract_F": 
			$parm = getQueryParm($act); 
			$act = "UPDATE service SET service_status='$parm', last_updated=NOW() WHERE service_id='$id' AND service_status!='C'"; 
			//changeServiceStatus($id,"fraud_", "F"); | Not use Here 

			//Updating Alert Message
			mem_alert_act($id, "status='0'");
		break;
		
		case "seract_1": 
			$tmp = explode("_", $id); $path=$tmp[1]; $id=$tmp[0]; mark_service_active($id); 
		break;

		case "ser_2": markServiceRefund($id, "../../../"); break;

		case "serpaid_1": case "serpaid_0": if($act=="serpaid_1"){$act=1;}else{ $act=0;} $act="UPDATE invoice_details SET paid='$act', last_updated=now() WHERE id_invoice_details='$id' AND status!='C'"; break;	
		case "seract_del": $act = "DELETE FROM invoice_details WHERE id_invoice_details='$id'"; mysql_query("DELETE FROM vpn_accounts WHERE id_invoice_details='$id'"); break;

		case "tick_sec_0": case "tick_sec_1": if($act == "tick_sec_0"){ $act=0;}else{$act=1;} $act = "UPDATE ticket_sections SET is_active='$act' WHERE section_id='$id'"; break;

		case "tick_sec_del": $act = "DELETE FROM ticket_sections WHERE section_id='$id'"; break;

		case "tick_cat_0": case "tick_cat_1": if($act == "tick_cat_0"){ $act=0;}else{$act=1;} $act = "UPDATE ticket_categories SET is_active='$act' WHERE category_id='$id'"; break;

		case "tick_cat_del": $act = "DELETE FROM ticket_categories WHERE category_id='$id'"; break;

		case "client_cancel_req": cancelService($id); $act = "UPDATE c_requests SET status='1' WHERE id_c_requests ='$id'"; break;

		case "client_fund_del": $act = "DELETE FROM pre_paid_funds WHERE id_transaction='$id'"; break;

		case "client_com_del": $act = "DELETE FROM affiliates_balance WHERE id_affiliates_balance='$id'"; break;

		case "affiliate_0": case "affiliate_1": case "affiliate_2": 

			$tmp = explode("_", $act); $act = $tmp[1]; $act = "UPDATE affiliates SET status='$act' WHERE id='$id'"; break;

		case "payout.req_0": case "payout.req_1": case "payout.req_2":

			$qq = "SELECT u.id_users, u.name, u.email, u.language, req.amount, req.method, req.currency, req.is_approved FROM users u LEFT JOIN affiliate_payout_requests req ON u.id_users = req.id_users WHERE req.id='$id'"; $sql = mysql_query($qq); $rw = mysql_fetch_array($sql);

		
			if($act=="payout.req_1"){ 

				if($rw['is_approved']!=1){

					$q="INSERT INTO affiliates_balance SET amount='-$rw[amount]', date=now(), id_affiliate='$rw[id_users]', status='1', currency='$rw[currency]', id_invoice='-111'";

					mysql_query($q);

							
					$arr = array('name'=>$rw['name'], 'email'=>$rw['email'], 'date'=>$date, 'amount'=> $rw['amount'], 'payment_method'=>$rw['method'], 'lang'=>$rw['language']); sendMail('pr', $arr);

			   }

			}

			if($rw['is_approved']!=1){ $tmp = explode("_", $act); $act = $tmp[1]; $act = "UPDATE affiliate_payout_requests SET is_approved='$act' WHERE id='$id'";} break;



		case "server_0": case "server_1": case "server_2": 

			$tmp = explode("_", $act); $act = $tmp[1]; $act = "UPDATE servers SET status='$act' WHERE id='$id'"; break;	
		case "bane_list_del":  $act = "DELETE FROM ban_list WHERE id_ban_list='$id'"; break;

		case "notification_del": $act = "DELETE FROM notifications WHERE id='$id'"; break;
		case "alert_del": $act = "DELETE FROM member_alert WHERE id='$id'"; break;
		
		case "plan_am_win_0": case "plan_am_win_1": 
			 $plan_stat = explode("_",$act);
			 $act="UPDATE cloud_cofigurations SET status='".$plan_stat[3]."' WHERE id_config='$id' AND id_provider='1' AND id_platform='1' LIMIT 1"; 
		break;

		case "plan_am_linux_0": case "plan_am_linux_1": 
			 $plan_stat = explode("_",$act);
			 $act="UPDATE cloud_cofigurations SET status='".$plan_stat[3]."' WHERE id_config='$id' AND id_provider='1' AND id_platform='2' LIMIT 1"; 
		break;

		case "plan_el_win_0": case "plan_el_win_1": 
			 $plan_stat = explode("_",$act);
			 $act="UPDATE cloud_cofigurations SET status='".$plan_stat[3]."' WHERE id_config='$id' AND id_provider='2' AND id_platform='1' LIMIT 1"; 
		break;

		case "plan_el_linux_0": case "plan_el_linux_1": 
			 $plan_stat = explode("_",$act);
			 $act="UPDATE cloud_cofigurations SET status='".$plan_stat[3]."' WHERE id_config='$id' AND id_provider='2' AND id_platform='2' LIMIT 1"; 
		break;
		
		case "product_ser_0": case "product_ser_1": if($act=="product_ser_1"){$act=1;}else{ $act=0;} $act="UPDATE inv_server_config SET status='$act' WHERE name='$id'"; break;
		case "pro_cat_trans_del": $act = "DELETE FROM translation_inv_cats WHERE trans_id='$id'"; break;
		case "pro_cur_del": 
			$q = "SELECT product_id, currency_code FROM currency_services WHERE id='$id'";$sql=mysql_query($q);$rw=mysql_fetch_array($sql);
			$act = "DELETE FROM currency_servers WHERE product_id='".$rw['product_id']."' AND currency_code='".$rw['currency_code']."'"; mysql_query($act);
			$act = "DELETE FROM currency_services WHERE product_id='".$rw['product_id']."' AND currency_code='".$rw['currency_code']."'";break;
		case "pro_cat_0": case "pro_cat_1": if($act == "pro_cat_0"){ $act=0;}else{$act=1;} $act = "UPDATE inventory_categories SET status='$act' WHERE cat_id='$id'"; break;
		case "pro_cat_del": $act = "DELETE FROM translation_inv_cats WHERE cat_id='$id'"; mysql_query($act);
			$q = "SELECT product_id FROM inventory WHERE cat_id='$id'"; $sql = mysql_query($q); 
			while($rw = mysql_fetch_array($sql)){ $act = "DELETE FROM translation_services WHERE product_id='".$rw['product_id']."'"; mysql_query($act); }
			$act = "DELETE FROM inventory WHERE cat_id='$id'"; mysql_query($act); $act = "DELETE FROM inventory_categories WHERE cat_id='$id'"; break;
		case "pro_trans_del": $act = "DELETE FROM translation_services WHERE id_ser_trans='$id'"; break;
		case "app_del": $act = "DELETE FROM search_applications WHERE id_application='$id'"; 	break;
		case "char_del": $act = "DELETE FROM search_config_characteristics WHERE id_characteristics='$id'"; break;
		case "service_search_0": case "service_search_1": $ser_disp = array("service_search_0"=>"0", "service_search_1"=>"1"); $act="UPDATE config_search SET status='".$ser_disp[$act]."' WHERE search_id='$id'"; break;
		case "service_search_trans_del": $act = "DELETE FROM config_search_trans WHERE id='$id'"; break;

		case "service_search_category_0": case "service_search_category_1": $ser_status = array("service_search_category_0"=>"0", "service_search_category_1"=>"1"); $act="UPDATE config_search_category SET status='".$ser_status[$act]."' WHERE search_category_id='$id'"; break;
		case "service_search_category_trans_del": $act = "DELETE FROM config_search_category_trans WHERE id='$id'"; break;
		case "service_search_category_framework_del": $act = "DELETE FROM config_search_category_data WHERE id='$id'"; break;
		case "service_search_framework_0": case "service_search_framework_1": $ser_status = array("service_search_framework_0"=>"0", "service_search_framework_1"=>"1"); $act="UPDATE config_search_framework SET status='".$ser_status[$act]."' WHERE search_framework_id='$id'"; break;
		case "service_search_framework_trans_del": $act = "DELETE FROM config_search_framework_trans WHERE id='$id'"; break;

		case "client_del": 
			mysql_query("DELETE FROM invoice WHERE id_users='$id'"); mysql_query("DELETE FROM invoice_details WHERE id_users='$id'");
			$act = "DELETE FROM users WHERE id_users='$id'"; 
			break;
			
		case "client_act_0": $q = "UPDATE users SET is_active='0' WHERE id_users='$id'";  $sql = mysql_query($q); break;
		case "client_act_1": $q = "UPDATE users SET is_active='1' WHERE id_users='$id'"; $sql = mysql_query($q); break;
		
		case "team_del": mysql_query("DELETE FROM users_secondary WHERE id_users_sec='$id'"); break;
		case "team_act_0": $q = "UPDATE users_secondary SET status='0' WHERE id_users_sec='$id'";  $sql = mysql_query($q); break;
		case "team_act_1": $q = "UPDATE users_secondary SET status='1' WHERE id_users_sec='$id'"; $sql = mysql_query($q); break;
		
		case "client_vat_1": $q = "UPDATE users SET vat_applied='1' WHERE id_users='$id'"; $sql = mysql_query($q); break;
		case "client_vat_0": $q = "UPDATE users SET vat_applied='0' WHERE id_users='$id'"; $sql = mysql_query($q); break;
		case "client_verify_1": $q = "UPDATE users SET manual_verified='1' WHERE id_users='$id'"; $sql = mysql_query($q); break;
		case "client_verify_0": $q = "UPDATE users SET manual_verified='0' WHERE id_users='$id'"; $sql = mysql_query($q); break;
		
		case "aff_comm_0": $act = "UPDATE affiliate_commission_history SET status='0' WHERE id_aff_comm='$id'"; break;
		case "aff_comm_1": $act = "UPDATE affiliate_commission_history SET status='1' WHERE id_aff_comm='$id'"; break;
		case "aff_comm_2": $act = "UPDATE affiliate_commission_history SET status='2' WHERE id_aff_comm='$id'"; break;
		
		case "verify_cus_0": $q = "UPDATE users SET is_blocked='1' WHERE id_users='$id'";  $sql = mysql_query($q); break;
		case "verify_cus_1": $q = "UPDATE users SET manual_verified='1' WHERE id_users='$id'"; $sql = mysql_query($q); break;
		
		default: $act = $act; break;
	}
	return $act;
}

function getActionLinks($list){
	$inv = array("Paid"=>"MARK PAID", "Unpaid"=>"MARK UNPAID", "Cancelled"=>"MARK CANCELLED");
	$cus = array("client_del"=>"DELETE", "client_act_1"=>"ENABLE", "client_act_0"=>"DISABLE", "client_vat_1"=>"VAT: YES", "client_vat_0"=>"VAT: NO", "client_verify_1"=>"Verify: YES", "client_verify_0"=>"Verify: NO");
	$team = array("team_del"=>"DELETE", "team_act_1"=>"ENABLE", "team_act_0"=>"DISABLE");
	$tickets = array("2"=>"ANSWERED", "4"=>"ON-HOLD", "6"=>"CLOSED", "5"=>"IN-PROGRESS");
	$serv = array("seract_1"=>"ACTIVE", "seract_E"=>"EXPIRED", "seract_C"=>"CANCELLED", "seract_F"=>"FRAUD");
	$tick_det = array("tick_sec_del"=>"DELETE", "tick_sec_1"=>"ENABLE", "tick_sec_0"=>"DISABLE");
	$tick_cat = array("tick_cat_del"=>"DELETE", "tick_cat_1"=>"ENABLE", "tick_cat_0"=>"DISABLE");
	$app_all = array("app_del"=>"DELETE");
	$char_all = array("char_del"=>"DELETE");
	$client_cancel_req = array("client_cancel_req"=>"APPROVE REQUEST");
	$client_fund_hist= array("client_fund_del"=>"DELETE");
	$client_com_hist= array("client_com_del"=>"DELETE");
	$affiliates = array("affiliate_0"=>"UNAPPROVE", "affiliate_1"=>"APPROVE", "affiliate_2"=>"REJECT");
	$payout_req = array("payout.req_0"=>"PENDING", "payout.req_1"=>"APPROVE", "payout.req_2"=>"REJECT");
	$servers = array("server_0"=>"MAINTENANCE", "server_1"=>"ACTIVE", "server_2"=>"DOWN");
	$bane_list = array("bane_list_del"=>"DELETE");
	$notification = array("notification_del"=>"DELETE");
	$alert_message = array("alert_del"=>"DELETE");	
	$plan_trans_all = array("pro_trans_del"=>"DELETE");
	$service_search = array("service_search_0"=>"DISABLE", "service_search_1"=>"ENABLE");
	$service_search_trans_all = array("service_search_trans_del"=>"DELETE");

	$service_search_category = array("service_search_category_0"=>"DISABLE", "service_search_category_1"=>"ENABLE");	
	$service_search_category_trans = array("service_search_category_trans_del"=>"DELETE");
	$service_search_category_framework = array("service_search_category_framework_del"=>"DELETE");
	$service_search_framework = array("service_search_framework_0"=>"DISABLE", "service_search_framework_1"=>"ENABLE");	
	$service_search_framework_trans = array("service_search_framework_trans_del"=>"DELETE");
	
	$pro_servers_all = array("product_ser_1"=>"ENABLE", "product_ser_0"=>"DISABLE");
	$pro_cat_trans = array("pro_cat_trans_del"=>"DELETE");
	$pro_cat = array("pro_cat_1"=>"ENABLE", "pro_cat_0"=>"DISABLE"); //$pro_cat = array("pro_cat_del"=>"DELETE", "pro_cat_1"=>"ENABLE", "pro_cat_0"=>"DISABLE");
	$pro_cur_all = array("pro_cur_del"=>"DELETE");
	
	$aff_comm = array("aff_comm_1"=>"APPROVE", "aff_comm_2"=>"HOLD", "aff_comm_0"=>"CANCEL");
	
	$verify_cus = array("verify_cus_1"=>"VERIFY", "verify_cus_0"=>"BLOCK");
	

	$arrList = array("alert_message"=>$alert_message, "invoices"=>$inv, "customers"=>$cus, "tickets"=>$tickets, "services"=>$serv, "ticket_sec"=>$tick_det, "ticket_cat"=>$tick_cat, "client_cancel_req"=>$client_cancel_req, "client_fund_hist"=>$client_fund_hist, "client_com_hist"=>$client_com_hist, "affiliates"=>$affiliates, "payout_req"=>$payout_req, "servers"=>$servers, "bane_list"=>$bane_list, "notification"=>$notification, "plan_trans_all"=>$plan_trans_all, "pro_servers_all"=>$pro_servers_all, "pro_cat_trans"=>$pro_cat_trans, "pro_cur_all"=>$pro_cur_all, "pro_cat"=>$pro_cat, "app_all"=>$app_all, "char_all"=>$char_all, "service_search"=>$service_search, "service_search_trans_all"=>$service_search_trans_all, "service_search_category"=>$service_search_category, "service_search_category_trans"=>$service_search_category_trans, "service_search_category_framework"=>$service_search_category_framework, "service_search_framework"=>$service_search_framework, "service_search_framework_trans"=>$service_search_framework_trans, "aff_comm"=>$aff_comm, 'verify_cus'=>$verify_cus, 'team'=>$team);
	
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

function getGateway($type){

	$methods = array('2co'=>"2Checkout", 'mb'=>"Money Bookers", 'au'=>"Authorize.net", 'uk'=>"UKash", 'pp'=>"Paypal", 'gc'=>'Google Checkout', 'ad'=>"Admin", "pa1"=>"Payout processed", "lr"=>"Liberty Reserve");

	return $methods[$type];

}

function getStatus($status)
{
	switch($status)
	{
		case "Paid": case "ser_1": $status = "<b class='srch-hltxt1'>Paid</b>"; break;
		case "Unpaid": case "ser_0": case "ser_": $status = "<b class='srch-hltxt2'>Unpaid</b>";break;
		case "Cancelled": case "seract_C": $status = "<b class='srch-hltxt4'>Cancelled</b>";  break;
		case 'ser_2': $status = "<b class='srch-hltxt6'>Refund</b>"; break;
		case 'seract_1': $status = "<b class='srch-hltxt3'>Active</b>"; break;
		case 'seract_F': $status = "<b class='srch-hltxt5'>Fraud</b>"; break;
		case 'seract_E': $status = "<b class='srch-hltxt4'>Expired</b>"; break;
		case 'seract_0': $status = "<b class='srch-hltxt2'>Pending</b>"; break;
		case 'seract_V': $status = "<b class='srch-hltxt1'>Viewed</b>"; break;
		case '1': $status = "<b class='srch-hltxt5'>Open</b>"; break;
		case '2': $status = "<b class='srch-hltxt3'>Answered</b>"; break;
		case '3': $status = "<b class='srch-hltxt6'>Customer Reply</b>"; break;
		case '4': $status = "<b class='srch-hltxt1'>On-hold</b>"; break;
		case '5': $status = "<b class='srch-hltxt4'>In-Progress</b>"; break;
		case '6': $status = "<b class='srch-hltxt2'>Closed</b>";break;
		case 'tick_sec_1': $status = "<b class='srch-hltxt1'>Enabled</b>"; break;
		case 'tick_sec_0': $status = "<b class='srch-hltxt2'>Disabled</b>"; break;
		case 'client_bal_1': $status = "<b class='srch-hltxt1'>Debit</b>"; break;
		case 'client_bal_0': $status = "<b class='srch-hltxt2'>Credit</b>"; break;
		case 'affiliate_0': $status = "<b class='inr-tablnk4'>Unapprove</b>"; break;
		case 'affiliate_1': $status = "<b class='inr-tablnk1'>Approve</b>"; break;
		case 'affiliate_2': $status = "<b class='inr-tablnk4'>Reject</b>"; break;
		case 'server_0': $status = "<b class='inr-hltxt3'>Maintenance</b>"; break;
		case 'server_1': $status = "<b class='inr-hltxt2'>Active</b>"; break;
		case 'server_2': $status = "<b class='inr-tablnk4'>Down</b>"; break;
		case 'pro_cat_0': $status = "<b class='inr-hltxt3'>Preplane</b>"; break;
		case 'pro_cat_1': $status = "<b class='inr-hltxt2'>Customized</b>"; break;
		case 'log_0': $status = "<b class='srch-hltxt5'>Old</b>"; break;
		case 'log_1': $status = "<b class='srch-hltxt3'>New</b>"; break;
		case 'credent_0': $status = "<b class='inr-tablnk1'>No</b>"; break;
		case 'credent_1': $status = "<b class='inr-tablnk4'>Yes</b>"; break;
		case 'charge_0': $status = "<b class='inr-hltxt1'>Hourly</b>"; break;
		case 'charge_1': $status = "<b class='inr-hltxt1'>Fixed</b>"; break;
		case 'invoice_0': $status = "<b class='inr-hltxt4'>NO</b>"; break;
		case 'invoice_1': $status = "<b class='inr-hltxt1'>YES</b>"; break;
		case 'usertype_c': $status = "<b class='srch-hltxt2'>Custom</b>"; break;
		case 'usertype_1': $status = "<b class='srch-hltxt3'>Clickgo</b>"; break;
		case 'usertype_2': $status = "<b class='srch-hltxt1'>Power Cloud</b>"; break;
		case 'managedtype_0': $status = "<b class='srch-hltxt2'>Self</b>"; break;
		case 'managedtype_1': $status = "<b class='srch-hltxt3'>Full</b>"; break;
		case 'managedtype_2': $status = "<b class='srch-hltxt1'>Essential</b>"; break;
		case 'it_monthly': $status = "<b class='inr-hltxt1'>Monthly</b>"; break;
		case 'it_custom': $status = "<b class='inr-hltxt2'>Custom</b>"; break;
		case 'it_custom_recurring': $status = "<b class='inr-hltxt3'>Custom Recurring</b>"; break;
		case 'businesstype_0': $status = "<b class='inr-hltxt2'>Individual</b>"; break;
		case 'businesstype_1': $status = "<b class='inr-hltxt1'>Business</b>"; break;
		case 'useract_0': $status = "<b class='inr-hltxt4'>DISABLE</b>"; break;
		case 'useract_1': $status = "<b class='inr-hltxt2'>ENABLE</b>"; break;
		case 'userblock_1': $status = "<b class='inr-hltxt4'>YES</b>"; break;
		case 'userblock_0': $status = "<b class='inr-hltxt2'>NO</b>"; break;
		case 'uservat_1': $status = "<b class='inr-hltxt2'>YES</b>"; break;
		case 'uservat_0': $status = "<b class='inr-hltxt4'>NO</b>"; break;
		case 'service_cron': $status = "<b class='inr-hltxt1'>Service Cronjob</b>"; break;
		case 'affiliate_bonus_cron': $status = "<b class='inr-hltxt1'>Affiliate Bonus Cronjob</b>"; break;
		case 'invoice_reminder_cron': $status = "<b class='inr-hltxt1'>Invoice Reminder Cronjob</b>"; break;
		case 'invoice_charge_cron': $status = "<b class='inr-hltxt1'>Invoice Charge Cronjob</b>"; break;
		case 'aff_comm_0': $status = "<b class='inr-hltxt4'>Cancel</b>"; break;
		case 'aff_comm_1': $status = "<b class='inr-hltxt2'>Approved</b>"; break;
		case 'aff_comm_2': $status = "<b class='inr-hltxt1'>Hold</b>"; break;
		
		case 'inv_0': $status = "<b class='inr-hltxt4'>Unpaid</b>"; break;
		case 'inv_1': $status = "<b class='inr-hltxt2'>Paid</b>"; break;
		case 'inv_c': $status = "<b class='inr-hltxt3'>Cancel</b>"; break;
		
		default: $status = $status; break;
	}
	return $status;
}



function markServiceRefund($id,$path){

	$q="SELECT * FROM invoice_details WHERE id_invoice_details='$id'";

	$sql=mysql_query($q); $row=mysql_fetch_array($sql);

	$pid=$row['product_id']; $qty = $row['quantity']; $price=($row['price']*$qty); $dis=$row['discount']; $inv=$row['id_invoice']; $detid=$row['id_invoice_details'];

	$id_users=$row['id_users'];	$price = ($price-$dis); $paid=$row['paid']; $status = $row['status'];

	$q="UPDATE invoice_details SET paid='2', status='C' WHERE id_invoice_details='$detid' AND paid!='0'";

	$sql = mysql_query($q); $rws = mysql_affected_rows(); //echo $rws ."dddd".'1';



	if($rws > 0 && $paid=='1'){

		$q = "UPDATE invoice SET amount=amount-$price, last_updated=now() WHERE id_invoice='$inv'"; mysql_query($q);

		$q="UPDATE invoice_details SET last_updated=now() WHERE id_invoice_details='$detid' AND paid!='0'";	$sql = mysql_query($q);



		if($status=='1'){

			$q = "SELECT name, email, language FROM users WHERE id_users='$id_users'"; $sql=mysql_query($q); $row=mysql_fetch_array($sql);

			$newdate = date("d/m/Y");

			$arr = array("id_users"=>$id_users, "name"=>$row['name'], "email"=>$row['email'], "lang"=>$row['language'], "id_inv_det_parent"=>$detid, 

						 "qty"=>$qty, "path"=>"../../../../", "date"=>$newdate, "act"=>"cancel_"); $users = renewService($arr, $users);

			if($users !=""){ foreach($users as $k=>$v){	sendMail("sc", $v);	} }

		}

	}

}



//--------------------------Mark Fraud a Service and Generate File----------------------------------------------------------

function changeServiceStatus($id, $act, $st)
{
	$q="SELECT status, id_users, quantity FROM invoice_details WHERE id_invoice_details='$id'"; 
	$sql=mysql_query($q); 
	$row=mysql_fetch_array($sql); 
	$qty = $row['quantity'];

	$q = "UPDATE invoice_details SET status='$st' WHERE id_invoice_details='$id' AND status!='C'";
    $sql=mysql_query($q); 
	$rws=mysql_affected_rows();

    if($rws>0 && $row['status']==1)
	{
		//$q = "SELECT name, email, language FROM users WHERE id_users='$row[id_users]'"; $sql=mysql_query($q); $row=mysql_fetch_array($sql);
		$newdate = date("d/m/Y");
		//$arr = array("id_users"=>$id_users, "name"=>$row['name'], "email"=>$row['email'], "lang"=>$row['language'], "qty"=>$qty,
		$arr = array("id_users"=>$row['id_users'], "qty"=>$qty, "id_inv_det_parent"=>$id, "path"=>"../../../../",
					 "date"=>$newdate, "act"=>$act); 
					  //print_r($arr);
					 $users = renewService($arr, $users);
					 //print_r($arr);
		$act = "UPDATE invoice_details SET last_updated=now() WHERE id_invoice_details='$id' AND status!='C'"; 
	}
}

//--------------------------End Mark Fraud a Service and Generate File----------------------------------------------------------



//--------------------------Cancel Service and Generate File----------------------------------------------------------

function cancelService($id)
{
	$q_1="SELECT can.service_id, can.id_users, can.date, can.credential, can.reason, u.name, u.email, u.language, conf.user_friendly_name FROM c_requests can INNER JOIN users u USING(id_users) INNER JOIN service ser USING(service_id) INNER JOIN config_translations conf USING(id_config) WHERE can.id_c_requests='$id' AND can.status='0' AND u.language = conf.language LIMIT 1";
	$sql_1=mysql_query($q_1); 
	$num_row = mysql_num_rows($sql_1);

	if($num_row>0)
	{
		$row_1=mysql_fetch_array($sql_1);
		if($row_1['credential'] == 1)
		{
			require_once(INC."test_asd_123.php");	
			$test_n = test_asd_123();
			$param = "credentials_user=AES_ENCRYPT('empty','$test_n'), credentials_pass=AES_ENCRYPT('empty','$test_n'), ";
		}
		
		//Updating Service Detail	
		$q_2 = "UPDATE service SET $param service_status='C' WHERE service_id='".$row_1['service_id']."' AND id_users='".$row_1['id_users']."' AND service_status!='C' LIMIT 1";
		$sql=mysql_query($q_2); 
		$rws=mysql_affected_rows();
		
		//Sending Confirmation Email
		if($rws>0)
		{
			$rem_cre = array('No','Yes');
			$arr = array('email'=>$row_1['email'], 'lang'=>$row_1['language'], 'name'=>$row_1['name'], 'service_name'=>$row_1['user_friendly_name'],'service_id'=>$row_1['service_id'],'credential'=>$rem_cre[$row_1['credential']], 'date'=>date('D, F, Y', strtotime($row_1['date'])), 'cancel_reason'=>$row_1['reason']);
			sendMail("cr", $arr); 
		}
		
		//Old Data 
		/*$detid=$row['id_invoice_details']; $qty = $row['quantity']; $price=($row['price']*$qty); $id_users=$row['id_users']; $pid=$row['product_id'];
		$dis=$row['discount']; $inv_status=$row['inv_status']; $price = ($price-$dis); $inv=$row['id_invoice']; $status=$row['status'];
		$q="UPDATE invoice_details SET status='C' WHERE id_invoice_details='$detid'"; $sql=mysql_query($q); $rws=mysql_affected_rows();
	
		if($rws>0 && $inv_status=='Unpaid')
		{
	
			$q = "UPDATE invoice SET amount=amount-$price WHERE id_invoice='$inv'"; mysql_query($q);
	
			$q="UPDATE invoice_details SET last_updated=now() WHERE id_invoice_details='$detid'"; $sql=mysql_query($q);
	
		}else if($rws>0 && $inv_status=='Paid'){
	
			if($status=='1'){
	
				$q="UPDATE invoice_details SET last_updated=now() WHERE id_invoice_details='$detid'"; $sql=mysql_query($q);
	
				$q = "SELECT name, email, language FROM users WHERE id_users='$id_users'"; $sql=mysql_query($q); $row=mysql_fetch_array($sql);
	
				$newdate = date("d/m/Y");
	
				$arr = array("id_users"=>$id_users, "name"=>$row['name'], "email"=>$row['email'], "lang"=>$row['language'], "id_inv_det_parent"=>$detid, 
	
							 "qty"=>$qty, "path"=>"../../../../", "date"=>$newdate, "act"=>"cancel_"); $users = renewService($arr, $users);
	
				if($users !=""){ 
	
					foreach($users as $k=>$v){
	
					  $q="SELECT name FROM translation_services WHERE product_id='$pid' AND language='$v[lang]'"; $sql=mysql_query($q);
	
					  $rw=mysql_fetch_array($sql); $v['date']=date("Y-m-d"); $v['service_id']=$detid; $v['service_name']=$rw['name']; sendMail("cr", $v); 
	
					  //print_r($v);				 
	
					} 
	
				}
	
			}
	
		}*/
	}
}

//---------------------------End Cancel Service--------------------------------------------------------------------------------
function getServices($id, $stat_1, $stat_2)
{
	return;
  	$q = "SELECT service_id FROM service WHERE $stat_1 status='$stat_2' AND id_users='$id'";
	$sql = mysql_query($q);
	$rw = mysql_num_rows($sql);
	return $rw;
}


function getExpDate($id,$date){

	$sql=mysql_query("select duration from inventory where product_id='$id'");

	$rws = mysql_num_rows($sql);

	if($rws > 0){

		$row=mysql_fetch_array($sql);

		$duration=$row['duration'];

		$newdate = strtotime ( '+'.$duration.' month' , strtotime ( $date ) ) ;

		$newdate = date ( 'Y-m-d' , $newdate );

	}else $newdate= "";

	if($date == NULL) { $newdate= ""; }

	return $newdate;

}



function mark_service_active($service,$path="")
{
	//All Error Messages Save Here
	global $ser_err;
	
	//Fetching Service Data | Config COST | Config CMS | User Detail 
	$ser_data = getFieldsData('service ser INNER JOIN users u USING(id_users) INNER JOIN config_management_cost cost ON cost.id = ser.id_cloud AND cost.package_id = ser.package_id AND cost.currency = u.currency INNER JOIN config_translations conf ON ser.id_config = conf.id_config AND conf.language = u.language', 'ser.id_users, ser.id_cloud, ser.service_status, ser.activated_on, u.currency, u.name, u.email, u.language, cost.price, cost.setup_fee, conf.user_friendly_name', "ser.service_id='$service'");

	//Saving Required
	$req_cost = $ser_data['price'];
	
	//Adding Setup || *if setup fee required or service status is pending for one time
	if(($ser_data['service_status'] == 0) && ($ser_data['setup_fee'] != 0))
	{
		$req_cost = $req_cost+$ser_data['setup_fee'];	
	}
	
	//Fetching User Funds
	$user_fund = getTotalSum2('pre_paid_funds', 'amount', "status='1' AND id_users='".$ser_data['id_users']."' AND service_id='".$service."' AND deduct_type='1'");
	
	//Comparing User or Config Fund
	if($user_fund >= $req_cost)
	{
		//Service Update Checks
		$upd_ser = 1;
		$upd_act = ", activated_on=NOW()";
		
		//Checking Expired Serivce 
		if($ser_data['service_status'] == 'E')
		{
			$curr_time = date("g-i-Y-m-d");
			$act_time_1 = date("g-i-Y-m-d", strtotime($ser_data['activated_on']));
			$act_time_2 = date("g-i-Y-m-d", strtotime($ser_data['activated_on']."+ 1 hour"));
			
			//Comparing Activation or Current Time
			if(($curr_time >= $act_time_1) && ($curr_time <= $act_time_2)){     $upd_ser = 0; $upd_act = "";    }
		}
		
		//Updating Service Status
		$q = "UPDATE service SET service_status='1', last_updated=NOW() $upd_act WHERE service_id='$service' AND service_status!='C' AND service_status!='1' AND status='0'"; 
		$sql = mysql_query($q);
		
		if(mysql_affected_rows() == 1)
		{
			if($upd_ser == 1)
			{
				//Deducting Setup Fee only for one Time Pending Service
				if(($ser_data['service_status'] == 0) && ($ser_data['setup_fee'] != 0))
				{
					$setup_cost =-($ser_data['setup_fee']); //setup_cost ===> SETUP FEE DEDUCT COST
					$q_1 = "INSERT INTO pre_paid_funds SET service_id='$service', id_users='".$ser_data['id_users']."', amount='$setup_cost', type='4', fund_date=now(), status='1', currency='".$ser_data['currency']."', timzone='".TIME_ZONE."'";
					$sql_1 = mysql_query($q_1) or die(mysql_error());
				}
				
				//Deducting Hourly Cost
				$hd_cost =-($ser_data['price']); //hd_cost ===> HOURLY DEDUCT COST
				$q_2 = "INSERT INTO pre_paid_funds SET service_id='$service', id_users='".$ser_data['id_users']."', amount='$hd_cost', type='hd', fund_date=now(), status='1', currency='".$ser_data['currency']."', timzone='".TIME_ZONE."'";
				$sql_2 = mysql_query($q_2) or die(mysql_error());
				
				//Sending User Email
				$arr = array("name"=>$ser_data['name'], "service"=>$ser_data['user_friendly_name'], "id"=>$service, "email"=>$ser_data['email'], "lang"=>$ser_data['language']);
				sendMail("sa", $arr);
			}
			
			//Updating Service Activities Report
			$q_3 = "UPDATE service_logs SET status='0' WHERE service_id='$service'";
			$sql_3 = mysql_query($q_3) or die(mysql_error());
			
			//Updating Alert Message
			mem_alert_act($service, "status='0'");
		
			//generate unique user
			/*if($id_invoice_parent<1)
			{
				$q = "SELECT * FROM vpn_accounts WHERE id_invoice_details='$service_id' ORDER BY id_vpn_accounts DESC LIMIT $qty"; 
				$sql=mysql_query($q); $rws=mysql_num_rows($sql);
				
				if($rws==0){
					for($x=1;$x<=$qty;$x++) {
						for($i=0;$i<15;$i++){
							$user_name=WHITE_BRAND."_".createRandomPassword();
							$q = "SELECT id_vpn_user FROM vpn_accounts WHERE id_vpn_user='$user_name'"; $sql=mysql_query($q); $rws=mysql_num_rows($sql);
							if($rws>0){	continue;	}else{ break;}
						}
						
						$password=createRandomPassword(); $file_name="create_".$user_name;  $passchk = 1;
						$server_list=""; $server_codes=""; $arr_list = getServersList($service_id,$pid);
						foreach($arr_list as $k=>$v){ $server_codes.=$v['code']." "; $server_list.=$v['name'].": ".$v['ip']."<br/>"; }
						$server_codes = substr($server_codes, 0, (strlen($server_codes)-1));
						$users[] = array("id"=>$id_users, "name"=>$name, "account"=>$user_name, "password"=>$password, "email"=>$email, "lang"=>$lang, "server_list"=>$server_list);
						//echo $user_name."=".$password;
						$q = "INSERT INTO vpn_accounts SET id_vpn_user='$user_name', id_users='$id_users', pass_vpn='".md5($password)."', id_invoice_details='$service_id'";	mysql_query($q);
						//end generate unique user
						$arr = array("file"=>$file_name, "name"=>$user_name, "pass"=>$password, "servers_list"=>$server_codes, "email"=>$email, "date"=>$newdate, "path"=>$path);
						generateFile($arr,$passchk);
					}
				}
				else
				{
					while($row=mysql_fetch_array($sql)) {
						$user_name=$row['id_vpn_user'];	$password=createRandomPassword(); $file_name="create_".$user_name;  $passchk=1;
						$server_list=""; $server_codes=""; $arr_list = getServersList($service_id,$pid);
						foreach($arr_list as $k=>$v){ $server_codes.=$v['code']." "; $server_list.=$v['name'].": ".$v['ip']."<br/>"; }
						$server_codes = substr($server_codes, 0, (strlen($server_codes)-1));
						$users[] = array("id"=>$id_users, "name"=>$name, "account"=>$user_name, "password"=>$password, "email"=>$email, "lang"=>$lang, "server_list"=>$server_list);
		
						$q="UPDATE vpn_accounts SET pass_vpn='".md5($password)."' WHERE id_vpn_user='$user_name' id_invoice_details='$service_id'";
						mysql_query($q);
		
						$arr = array("file"=>$file_name, "name"=>$user_name, "pass"=>$password, "servers_list"=>$server_codes, "email"=>$email, "date"=>$newdate, "path"=>$path);
						generateFile($arr,$passchk);
					}
				}
			}
			else
			{ 
				//get vpn id for renewal accounts 
				$parent_act_date=getParentActDate($id_inv_det_parent); $date=date("Y-m-d"); $actdate=getExpDate($pid,$parent_act_date);
				if($date>$actdate){	$actdate=$date;	} $newdate=getExpDateOnActive($pid, $actdate);
				
		
				$server_list=""; $server_codes=""; $arr_list = getServersList($id_inv_det_parent,$pid);
				foreach($arr_list as $k=>$v){ $server_codes.=$v['code']." "; $server_list.=$v['name'].": ".$v['ip']."<br/>"; }
				$server_codes = substr($server_codes, 0, (strlen($server_codes)-1));
				$arr = array("id_users"=>$id_users, "name"=>$name, "email"=>$email, "lang"=>$lang, "servers_list"=>$server_codes, "id_inv_det_parent"=>$id_inv_det_parent,
							 "service_id"=>$service_id, "qty"=>$qty, "path"=>$path, "date"=>$newdate, "act"=>"renew_"); renewService($arr, $users);
				mysql_query("UPDATE invoice_details SET date_activation='$actdate' WHERE id_invoice_details='$service_id'");
			}*/
		}
		
		// End create and ftp user file
		/*if($users !="")
		{
			foreach($users as $k=>$v)
			{
				if($id_invoice_parent<1)
				{
					//Send Activation mail;
					sendMail("sc", $v);
				}
				//end send confirmation email
			}
		}*/
	}
	else
	{
		$ser_error_text .= '<b>&bull;</b> Service ID# <strong>'.$service.'</strong> - <span>Minimum Balance Required: <strong>'.$req_cost.' '.$ser_data['currency'].'</strong>';
		$ser_error_text .= ' | <strong>'.$ser_data['price'].' '.$ser_data['currency'].'</strong> for Hourly Deduction</span>';

		if(($ser_data['service_status'] == 0) && ($ser_data['setup_fee'] != 0))
		{
			$ser_error_text .= '<span> | <strong>'.$ser_data['setup_fee'].' '.$ser_data['currency'].'</strong> for One Time Setup Fee</span>';
		}
		
		$ser_error_text .= '<br />';
		$ser_err[] = $ser_error_text;
	}
}

function sendActivationMail($arr,$chk)
{
	if($chk == true)
	{
		$j=0;
		foreach($arr["array"] as $value)
		{
			//echo $j;

			//echo $u[$j];

			//echo $p[$j];

			//echo "<p>";

//			if($parent_check==0) {			 

				sendMail("sc", $arr);

			//}

			$j++;

			//end send confirmation email

	    }

	}
}
function GetRoundData($am1, $am2)
{
	$amount = $am1/$am2;
	$amount = floor($amount);
	return $amount;
}
?>