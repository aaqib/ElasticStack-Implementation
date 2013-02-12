<?php 
/************************************************************************************************************************
 Author: Muhammad Akram (akram_kamboh@hotmail.com)
 Designation: Software Engineer
 Company: Gaditek Solutions
 Date Creation: 15 April 2010 
 Last Updated : 07 July 2010
 
*************************************************************************************************************************/
function getTitle($page)
{
	$arr = array('0'=>"All", '1'=>"Open", '2'=>"Answered", '3'=>"Customer Replied", '4'=>"On-Hold", '5'=>"In-Progress", '6'=>"Closed",
				 'order_all'=>"All", 'order_0'=>"Pending", 'order_'=>"All", 'order_1'=>"Active", 'order_C'=>"Canceled", 'order_E'=>"Expired", 'order_F'=>"Fraud",
				 'payout_0'=>'Pending', "payout_1"=>"Approve", "payout_2"=>"Reject");

	return $arr[$page];
}

function addActivity($arr){
	$q = "INSERT INTO web_activities SET act_type='".$arr['type']."', activity='".$arr['activity']."', web_act_id='".$arr['id']."', client_type='".$arr['c_type']."', client='".$arr['client']."',act_date=NOW()";
	$sql = mysql_query($q);
}

function getActivity($chk, $id){
	$act = array();

	switch($chk){
		case "eh_region_del":				$act['eh_region_delete']	= "Delete Elastichosts Region <b>ID-$id</b>"; break;
		
		case "eh_image_0":					$act['eh_image_inactivated']	= "Change Elastichosts Image Status to <b>InActive</b> ID-$id"; break;		
		case "eh_image_1":					$act['eh_image_activated']	= "Change Elastichosts Image Status to <b>Active</b> ID-$id"; break;
		case "eh_image_del":				$act['eh_image_delete']	= "Delete Elastichosts Image <b>ID-$id</b>"; break;
		
		case "eh_model_del":				$act['eh_model_delete']	= "Delete Elastichosts Model <b>ID-$id</b>"; break;
		
		case "eh_drive_del":				$act['eh_drive_delete']	= "Delete Elastichosts Drive <b>ID-$id</b>"; break;
		
		case "eh_server_del":				$act['eh_server_delete']	= "Delete Elastichosts Server <b>ID-$id</b>"; break;
		case "eh_server_start":				$act['eh_server_start']		= "Change Elastichosts Server Status to <b>Start</b> ID-$id"; break;
		case "eh_server_stop":				$act['eh_server_stop']		= "Change Elastichosts Server Status to <b>Stop</b> ID-$id"; break;
		case "eh_server_shut":				$act['eh_server_shut']		= "Change Elastichosts Server Status to <b>Shutdown</b> ID-$id"; break;
		case "eh_server_reset":				$act['eh_server_reset']		= "Change Elastichosts Server Status to <b>Reset</b> ID-$id"; break;
		
		case "eh_ip_del":					$act['eh_ip_delete']		= "Delete Elastichosts IP <b>ID-$id</b>"; break;
		case "eh_vlan_del":					$act['eh_vlan_delete']		= "Delete Elastichosts VLAN <b>ID-$id</b>"; break;
		
		case "eh_server_role_del":			$act['eh_server_role_delete']		= "Delete Elastichosts Server Role <b>ID-$id</b>"; break;
		
		case "aws_zone_del":				$act['aws_zone_delete']				= "Delete AWS Zone <b>ID-$id</b>"; break;
		case "aws_region_del":				$act['aws_region_delete']			= "Delete AWS Region <b>ID-$id</b>"; break;
		
		case "aws_image_0":					$act['aws_image_inactivated']		= "Change AWS Image Status to <b>InActive</b> ID-$id"; break;		
		case "aws_image_1":					$act['aws_image_activated']			= "Change AWS Image Status to <b>Active</b> ID-$id"; break;
		case "aws_image_del":				$act['aws_image_delete']			= "Delete AWS Image <b>ID-$id</b>"; break;
		
		case "aws_ins_type_del":			$act['aws_instance_type_delete']	= "Delete AWS Instance Type <b>ID-$id</b>"; break;
		
		case "aws_port_del":				$act['aws_port_delete']				= "Delete AWS Security Group Port <b>ID-$id</b>"; break;
		
		case "aws_vpc_del":					$act['aws_vpc_delete']				= "Delete AWS VPC <b>ID-$id</b>"; break;
		
		case "aws_instance_terminate":		$act['aws_instance_terminate']		= "Terminate AWS Instance <b>ID-$id</b>"; break;
		case "aws_instance_start":			$act['aws_instance_start']			= "Change AWS Instance Status to <b>Start</b> ID-$id"; break;
		case "aws_instance_stop":			$act['aws_instance_stop']			= "Change AWS Instance Status to <b>Stop</b> ID-$id"; break;
		case "aws_instance_reboot":			$act['aws_instance_reboot']			= "Change AWS Instance Status to <b>Reboot</b> ID-$id"; break;
		
		case "access-denied":		$act['access-denied']	= "ACCESS DENIED"; break;
		
		default: $act = $chk; break;
	}
	return $act;
}

function getTableNameAndId($act){
	$arr = array();

	switch($act){
		case "inv": $arr['invoice'] = "id_invoice"; break;
		case "tickets": $arr['tickets'] = "ticket_id"; break;
		case "service": $arr['invoice_details'] = "id_invoice_details"; break;
		case "client": $arr['users'] = "id_users"; break;
		case "client_bal": $arr['affiliates_balance'] = "id_affiliates_balance"; break;
		case "affiliate": $arr['affiliates'] = "id"; break;
		case "payout_req": $arr['affiliate_payout_requests'] = "id"; break;

		default: $arr['admin'] = 0; break;
	}
	return $arr;
}

function isActDelete($act){
	$tmp = explode("_", $act);
	$len = count($tmp);

	if($len > 0){
		if($tmp[$len-1] == "del") return true; else return false;
	}else
		return false;
}

function downloadFile($file, $path){
	$filename = $path.$file;
	$filename = realpath($filename); //server specific
	$file_extension = strtolower(substr(strrchr($filename,"."),1));
	if (!file_exists( $filename)){  die("NO File Found");  }

	switch( $file_extension ){
		case "pdf": $ctype="application/pdf"; break;
		case "exe": $ctype="application/octet-stream"; break;
		case "zip": $ctype="application/zip"; break;
		case "doc": $ctype="application/msword"; break;
		case "xls": $ctype="application/vnd.ms-excel"; break;
		case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
		case "gif": $ctype="image/gif"; break;
		case "png": $ctype="image/png"; break;
		case "jpe": case "jpeg": case "jpg": $ctype="image/jpg"; break;
		default: $ctype="application/force-download";
	}

	header("Pragma: public"); // required
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); // required for certain browsers
	header("Content-Type: $ctype");
	header("Content-Disposition: attachment; filename=".basename($filename).";" );
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".@filesize($filename));
	@readfile("$filename") or die("file not found.");
	exit(); 
}

function getDueDate($date){
	$newdate = strtotime ( '+3 day' , strtotime ( $date ) ) ;
	$newdate = date ( 'Y-m-d' , $newdate );
	return $newdate;
}

//downloadFile() End;

function getLanguage($lang){
	$q="SELECT screen_name as lang FROM languages WHERE code='$lang'";$sql=mysql_query($q);	$row=mysql_fetch_array($sql);
	return $row['lang'];
}
	
function getPageLimitList(){
	$limitList = array('5'=>'Record Limit', '10'=>'10 Records', '20'=>'20 Records', '30'=>'30 Records', '40'=>'40 Records');
	return $limitList;
}

function getTotalRec($table, $field, $value=""){
	if($value == ""){
		$q = "SELECT $field FROM $table";
	}else{
		$q = "SELECT $field FROM $table WHERE $field=$value";
	}
	$sql = mysql_query($q);
	$rws = mysql_num_rows($sql);
	return $rws;
}

////////////////Home Page Functions//////////////////////////////////////

function getTotalRecords($table, $field, $value=""){
	if($value == ""){
		$q = "SELECT $field FROM $table";
	}else{
		$q = "SELECT $field FROM $table WHERE $value";
	}
	$sql = mysql_query($q) or die("MYSQL Error: ".mysql_error());
	$rws = mysql_num_rows($sql);
	return $rws;
}

function getTotalRec2($table, $table1, $field, $value=""){
	if($value == ""){
		$q = "SELECT $field FROM $table INNER JOIN $table1 USING($field)";
	}else{
		$q = "SELECT $field FROM $table INNER JOIN $table1 USING($field) WHERE $value";
	}
	$sql = mysql_query($q);
	$rws = mysql_num_rows($sql);
	return $rws;
}

/////////---------------End Function--------------------//////////////

function getTotalSum($table, $field, $chk="", $value=""){
	if($value == "" || $chk==""){
		$q = "SELECT SUM($field) as total FROM $table";
	}else{
		$q = "SELECT SUM($field) as total FROM $table WHERE $chk=$value";
	}
	//echo $q;
	$sql = mysql_query($q);
	$row = mysql_fetch_array($sql);
	return $row['total'];
}

function getLanguages(){
	$q = "SELECT code, screen_name FROM languages";
	$sql = mysql_query($q);
	$arr = array();

	while($rw = mysql_fetch_array($sql)){
		$arr[$rw['code']] = $rw['screen_name'];
	}
	return $arr;
}

function getServiceCategory(){
	$q = "SELECT search_category_id, admin_friendly_name FROM config_search_category";
	$sql = mysql_query($q);
	$arr = array();

	while($rw = mysql_fetch_array($sql)){
		$arr[$rw['search_category_id']] = $rw['admin_friendly_name'];
	}
	return $arr;
}

function getTemplates(){
	$q = "SELECT template_id, admin_friendly_name FROM landing_template";
	$sql = mysql_query($q);
	$arr = array();

	while($rw = mysql_fetch_array($sql)){
		$arr[$rw['template_id']] = $rw['admin_friendly_name'];
	}
	return $arr;
}


function setDefaultLanguage($site_url, $rep_url="")
{
	//Checking Browser Language
	$br_lang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
	$br_default = $br_lang[0].$br_lang[1];
	
	$br_q = mysql_query("SELECT code FROM languages WHERE code='$br_default' AND status='1'");
	$br_cnt = mysql_num_rows($br_q);
	
	if($br_cnt=='1')
	{
		$br_rw = mysql_fetch_array($br_q);
		$_SESSION['language'] = $br_rw['code'];
	}
	else
	{
		$def_q = mysql_query("SELECT code FROM languages WHERE default_lang='1' AND status='1' LIMIT 1");
		$def_rw = mysql_fetch_array($def_q);
		$_SESSION['language'] = $def_rw['code'];
	}
	
	$red_url = $_SESSION['language'].$_SERVER['REQUEST_URI'];
	if($rep_url != ""){  $red_url = str_replace($rep_url, $rep_url.$_SESSION['language']."/", $_SERVER['REQUEST_URI']);  }
	header("Location:".$site_url.$red_url);
}

function setSelectedLanguage($selected_lang, $site_url, $rep_url="")
{
	//Rederict URL Define Here
	$red_url = $_SESSION['language'].$_SERVER['REQUEST_URI'];
	if($rep_url != ""){  $red_url = str_replace($rep_url, $rep_url.$_SESSION['language']."/", $_SERVER['REQUEST_URI']);  }

	//Checking Selected Language in Array Key
	if($selected_lang != "")
	{
		//Getting System all Languages
		$system_lang = getLanguages();
	
		//Comparing Selected or Getting Language
		if(array_key_exists($selected_lang, $system_lang))
		{
			$_SESSION['language'] = $selected_lang;
		}
		else
		{
			header("Location:".$site_url.$_SESSION['language']."/index.php");
		}
	}
	else
	{
		header("Location:".$site_url.$red_url);
	}
}

function getLanguages2(){
	$q = "SELECT code, screen_name FROM languages WHERE status='1'";
	$sql = mysql_query($q);
	$arr = array();

	while($rw = mysql_fetch_array($sql)){
		$arr[$rw['code']] = $rw['screen_name'];
	}
	return $arr;
}

function getCurrencies(){
	$q = "SELECT name, currency_code FROM currency where status='1'";
	$sql = mysql_query($q);
	$arr = array();

	while($rw = mysql_fetch_array($sql)){
		$arr[$rw['currency_code']] = $rw['name'];
	}
	return $arr;
}

function getCurrencySign(){
	$q = "SELECT symbol, currency_code FROM currency";
	$sql = mysql_query($q);
	$sym = array();
	$code = array();

	while($rw = mysql_fetch_array($sql)){
		$sym[] = $rw['symbol'];
		$code[$rw['symbol']] = $rw['currency_code'];
	}
	
	$data = array($sym,$code);
	return $data;
}

function getAllInventoryCats(){
	$q = "SELECT cat_id, cat_name FROM inventory";
	$sq = mysql_query($q);
	$arr = array();

	while($rw = mysql_fetch_array($sq)){
		$arr[$rw['cat_id']]= $rw['cat_name'];
	}
	return $arr;
}

function getUserName($id, $type){
	$q = "SELECT name FROM users WHERE type='$type' and id_users='$id'";
	$sql = mysql_query($q);
	$row = mysql_fetch_array($sql);
	return $row['name'];
}

function getCountries($field){
	$q = "select $field , printable_name from country";$sq = mysql_query($q);$arr = array();
	while($cn = mysql_fetch_array($sq)){ $arr[$cn[$field]]=$cn['printable_name'];}
	return $arr;
}

function getProductCats(){
	$q = "select cat_id, cat_name from inventory_categories";$sq = mysql_query($q);$arr = array();
	while($cn = mysql_fetch_array($sq)){ $arr[$cn['cat_id']]=$cn['cat_name'];}
	return $arr;
}

function getTutSections(){
	$q = "SELECT sec_id, sec_name FROM tutorial_sections";
	$sql = mysql_query($q);
	$arr = array();

	while($rw = mysql_fetch_array($sql)){
		$arr[$rw['sec_id']] = $rw['sec_name'];
	}
	return $arr;
}

function getTutFields($id, $fields){
	$q = "SELECT $fields FROM tutorials WHERE tutorial_id='$id'";
	$sql = mysql_query($q);
	$rw = mysql_fetch_array($sql);
	return $rw;	
}

function getFieldsData($table, $fields, $chk){
	$q = "SELECT $fields FROM $table WHERE $chk";
	//echo $q.'<br /><br />';
	$sql = mysql_query($q) or die('Query failed: ' . mysql_error());
	$rw = mysql_fetch_array($sql);
	return $rw;	
}

function getLoopData($query)
{
	$q = "SELECT $query";
	$sql = mysql_query($q) or die('Query failed: ' . mysql_error());
	while($row=mysql_fetch_array($sql))
	{
		$arr[] = $row;
	}
	return $arr;
}

function getMetaDet($page){
	$q = "SELECT * FROM meta_details WHERE page='$page' AND language='$_SESSION[language]'";
	$sql = mysql_query($q) or die('Query failed: ' . mysql_error());
	$rw = mysql_fetch_array($sql);
	return $rw;	
}

function UnSetByVal($val, $arr){
	if(!empty($arr)){
		foreach($arr as $k=>$v){
			if($val == $v){ unset($arr[$k]); }
		}		
	}
	return $arr;
}

function getUrgency($u){
	$arr = array("l"=>"<b>Low</b>", "m"=>"<b>Medium</b>", "h"=>"<b>High</b>");	
	return $arr[$u];
}

function getProductServers($pid){
	$q = "SELECT inv.id_server, inv.name, inv.price, cfg.flag FROM inventory_servers inv INNER JOIN  inv_server_config cfg USING(name) WHERE inv.product_id='$pid' AND inv.id_users='0' AND cfg.status='1'";
	$sql = mysql_query($q);
	$servers =array();
	
	while($rw = mysql_fetch_array($sql)){ 
		$servers[$rw['name']] = array("id"=>$rw['id_server'], "price"=>$rw['price'], "flag"=>$rw['flag']);
	}
	return $servers;
}

function getProductCurServers($pid,$currency){
	$q = "SELECT cs.id, cs.name, cs.price, cfg.flag FROM currency_servers cs INNER JOIN inv_server_config cfg USING(NAME) WHERE cs.product_id='$pid' AND cs.currency_code='$currency' AND cs.id_users='0' AND cfg.status='1'";
	$sql = mysql_query($q);
	$servers =array();

	while($rw = mysql_fetch_array($sql)){ 
		$servers[$rw['name']] = array("id"=>$rw['id'], "price"=>$rw['price'], "flag"=>$rw['flag']);
	}
	return $servers;
}

function isCheckedBox($v, $arr){
	if($arr !=""){
		if(in_array($v, $arr) || in_array('all', $arr)){
			return "checked='checked'";
		}
	}
	return "";
}

function getServerNames(){
	$q = "SELECT name FROM inventory_servers GROUP BY name ORDER BY name";
	$sql = mysql_query($q);
	$servers =array();

	while($rw = mysql_fetch_array($sql)){ 
		$servers[] = $rw['name'];
	}
	return $servers;
}

function getServer($uid, $pid, $server, $ret='---'){
	$q = "SELECT price FROM inventory_servers WHERE id_users='$uid' and product_id='$pid' and name='$server'";
	$sql = mysql_query($q);
	$rws = mysql_num_rows($sql);

	if($rws > 0){
		$rw = mysql_fetch_array($sql);
		return $rw['price'];
	}
	return $ret;
}

function getTotalSum2($table, $field, $value=""){
	if($value == ""){
		$q = "SELECT SUM($field) as total FROM $table";
	}else{
		$q = "SELECT SUM($field) as total FROM $table WHERE $value";
	}
	//echo $q;
	$sql = mysql_query($q);
	$row = mysql_fetch_array($sql);
	return $row['total'];
}

function getUserFriendlyURL($url){
	$url=str_replace("?","",$url); $url=str_replace(".","",$url); $url=str_replace(" ","_",$url);
	$url= str_replace("+","",$url); $url=str_replace("=","",$url); $url=str_replace("/","-",$url); 
	$url=strip_tags($url); $url = htmlentities($url, ENT_COMPAT, "utf-8");	$url = strtolower($url);
	return $url;
}

function setHtmlCharacter($para)
{
	//All Replace Characters Define Here
	$rep_char = array(
		'"'=>"&quot;", "& "=>"&amp; ", "€"=>"&euro;", "'"=>"&acute;", "´"=>"&acute;", "¦"=>"&brvbar;",
		","=>"&cedil;", "©"=>"&copy;", "£"=>"&pound;", "®"=>"&reg;", "•"=>"&bull;", "™"=>"&trade;"
	);
	
	//Replacing Characters
	foreach($rep_char as $k=>$v)
	{
		$para = str_replace("".$k."","".$v."",$para);
		//echo $para.'<br />';
	}
	return $para;
}

function setTemplateFolder($name)
{
	//All Replace Characters Define Here
	$rep_char = array(
		'"'=>"", "& "=>"", "?"=>"", "'"=>"", "´"=>"", "¦"=>"", "("=>"", ")"=>"", ":"=>"", ";"=>"", "<"=>"", ">"=>"", 
		","=>"", "."=>"", "/"=>"", "{"=>"", "}"=>"", "["=>"", "]"=>"", "-"=>"_", "="=>"", "+"=>"", "|"=>"", " "=>"_"
	);
	
	//Set Lower Case
	$name = strtolower($name);

	//Replacing Characters
	foreach($rep_char as $k=>$v)
	{
		$name = str_replace("".$k."","".$v."",$name);
		//echo $name.'<br />';
	}
	return $name;
}



function getLanguageCode(){
	$lang_code = array('ab'=>'Abkhazian - ab', 'aa'=>'Afar - aa', 'af'=>'Afrikaans - af', 'sq'=>'Albanian - sq', 'am'=>'Amharic - am', 'ar'=>'Arabic - ar', 'hy'=>'Armenian - hy', 'as'=>'Assamese - as', 'ay'=>'Aymara - ay', 'az'=>'Azerbaijani - az', 'ba'=>'Bashkir - ba', 'eu'=>'Basque - eu', 'bn'=>'Bengali (Bangla) - bn', 'dz'=>'Bhutani - dz', 'bh'=>'Bihari - bh', 'bi'=>'Bislama - bi', 'br'=>'Breton - br', 'bg'=>'Bulgarian - bg','my'=>'Burmese - my','be'=>'Byelorussian (Belarusian) - be','km'=>'Cambodian - km','ca'=>'Catalan - ca','zh'=>'Chinese - zh','co'=>'Corsican - co','hr'=>'Croatian - hr','cs'=>'Czech - cs','da'=>'Danish - da','nl'=>'Dutch - nl','en'=>'English - en','eo'=>'Esperanto - eo','et'=>'Estonian - et','fo'=>'Faeroese - fo','fa'=>'Farsi - fa','fj'=>'Fiji - fj','fi'=>'Finnish - fi','fr'=>'French - fr','fy'=>'Frisian - fy','gl'=>'Galician - gl','gd'=>'Gaelic (Scottish) - gd','gv'=>'Gaelic (Manx) - gv','ka'=>'Georgian - ka','de'=>'German - de','el'=>'Greek - el','kl'=>'Greenlandic - kl','gn'=>'Guarani - gn','gu'=>'Gujarati - gu','ha'=>'Hausa - ha','he'=>'Hebrew - he','hi'=>'Hindi - hi','hu'=>'Hungarian - hu','is'=>'Icelandic - is','id'=>'Indonesian - id','ia'=>'Interlingua - ia','ie'=>'Interlingue - ie','iu'=>'Inuktitut - iu','ik'=>'Inupiak - ik','ga'=>'Irish - ga','it'=>'Italian - it','ja'=>'Japanese - ja','jv'=>'Javanese - jv','kn'=>'Kannada - kn','ks'=>'Kashmiri - ks','kk'=>'Kazakh - kk','rw'=>'Kinyarwanda (Ruanda) - rw','ky'=>'Kirghiz - ky','rn'=>'Kirundi (Rundi) - rn','ko'=>'Korean - ko','ku'=>'Kurdish - ku','lo'=>'Laothian - lo','la'=>'Latin - la','lv'=>'Latvian (Lettish) - lv','li'=>'Limburgish ( Limburger) - li','ln'=>'Lingala - ln','lt'=>'Lithuanian - lt','mk'=>'Macedonian - mk','mg'=>'Malagasy - mg','ms'=>'Malay - ms','ml'=>'Malayalam - ml','mt'=>'Maltese - mt','mi'=>'Maori - mi','mr'=>'Marathi - mr','mo'=>'Moldavian - mo','mn'=>'Mongolian - mn','na'=>'Nauru - na','ne'=>'Nepali - ne','no'=>'Norwegian - no','oc'=>'Occitan - oc','or'=>'Oriya - or','om'=>'Oromo (Afan, Galla) - om','ps'=>'Pashto (Pushto) - ps','pl'=>'Polish - pl','pt'=>'Portuguese - pt','pa'=>'Punjabi - pa','qu'=>'Quechua - qu','rm'=>'Rhaeto-Romance - rm','ro'=>'Romanian - ro','ru'=>'Russian - ru','sm'=>'Samoan - sm','sg'=>'Sangro - sg','sa'=>'Sanskrit - sa','sr'=>'Serbian - sr','sh'=>'Serbo-Croatian - sh','st'=>'Sesotho - st','tn'=>'Setswana - tn','sn'=>'Shona - sn','sd'=>'Sindhi - sd','si'=>'Sinhalese - si','ss'=>'Siswati - ss','sk'=>'Slovak - sk','sl'=>'Slovenian - sl','so'=>'Somali - so','es'=>'Spanish - es','su'=>'Sundanese - su','sw'=>'Swahili (Kiswahili) - sw','sv'=>'Swedish - sv','tl'=>'Tagalog - tl','tg'=>'Tajik - tg','ta'=>'Tamil - ta','tt'=>'Tatar - tt','te'=>'Telugu - te','th'=>'Thai - th','bo'=>'Tibetan - bo','ti'=>'Tigrinya - ti','to'=>'Tonga - to','ts'=>'Tsonga - ts','tr'=>'Turkish - tr','tk'=>'Turkmen - tk','tw'=>'Twi - tw','ug'=>'Uighur - ug','uk'=>'Ukrainian - uk','ur'=>'Urdu - ur','uz'=>'Uzbek - uz','vi'=>'Vietnamese - vi','vo'=>'Volapuk - vo','cy'=>'Welsh - cy','wo'=>'Wolof - wo','xh'=>'Xhosa - xh','yi'=>'Yiddish - yi','yo'=>'Yoruba - yo','zu'=>'Zulu - zu');

	return $lang_code;
}

function getCurrencyCode(){
	$cur_code = array('ADF'=>'ADF -- Andorran Franc','ADP'=>'ADP -- Andorran Peseta','AED'=>'AED -- United Arab Emirates Dirham','AFN'=>'AFN -- Afghanistan Afghani','ALL'=>'ALL -- Albanian Lek','AMD'=>'AMD -- Armenian Dram','ANG'=>'ANG -- Netherlands Antillian Guilder','AOA'=>'AOA -- Angolan Kwanza','ARS'=>'ARS -- Argentine Peso','ATS'=>'ATS -- Austrian Schilling ','AUD'=>'AUD -- Australian Dollar','AWG'=>'AWG -- Aruban Florin ','AZN'=>'AZN -- Azerbaijani Manat','BAM'=>'BAM -- Bosnia and Herzegovina Convertible Mark','BBD'=>'BBD -- Barbados Dollar','BDT'=>'BDT -- Bangladeshi Taka','BEF'=>'BEF -- Belgian Franc ','BGN'=>'BGN -- Bulgarian Lev','BHD'=>'BHD -- Bahraini Dinar','BIF'=>'BIF -- Burundi Franc','BMD'=>'BMD -- Bermudian Dollar','BND'=>'BND -- Brunei Dollar','BOB'=>'BOB -- Bolivian Boliviano','BRL'=>'BRL -- Brazilian Real','BSD'=>'BSD -- Bahamian Dollar','BTN'=>'BTN -- Bhutan Ngultrum','BWP'=>'BWP -- Botswana Pula','BYR'=>'BYR -- Belarusian Ruble','BZD'=>'BZD -- Belize Dollar','CAD'=>'CAD -- Canadian Dollar','CDF'=>'CDF -- Congolese Franc','CHF'=>'CHF -- Swiss Franc','CLP'=>'CLP -- Chilean Peso','CNY'=>'CNY -- Chinese Yuan Renminbi','COP'=>'COP -- Colombian Peso','CRC'=>'CRC -- Costa Rican Colon','CZK'=>'CZK -- Czech Koruna','CUP'=>'CUP -- Cuban Peso','CVE'=>'CVE -- Cape Verde Escudo','CYP'=>'CYP -- Cyprus Pound','DEM'=>'DEM -- German Mark ','DJF'=>'DJF -- Djibouti Franc','DKK'=>'DKK -- Danish Krone','DOP'=>'DOP -- Dominican Peso','DZD'=>'DZD -- Algerian Dinar','ECS'=>'ECS -- Ecuador Sucre','EEK'=>'EEK -- Estonian Kroon','EGP'=>'EGP -- Egyptian Pound','ESP'=>'ESP -- Spanish Peseta','ETB'=>'ETB -- Ethiopian Birr','EUR'=>'EUR -- Euro','FIM'=>'FIM -- Finnish Markka','FJD'=>'FJD -- Fiji Dollar','FKP'=>'FKP -- Falkland Islands Pound','FRF'=>'FRF -- French Franc ','GBP'=>'GBP -- British Pound','GEL'=>'GEL -- Georgian Lari','GHC'=>'GHC -- Ghanaian Cedi','GHS'=>'GHS -- Ghanaian Cedi','GIP'=>'GIP -- Gibraltar Pound','GMD'=>'GMD -- Gambian Dalasi','GNF'=>'GNF -- Guinea Franc','GRD'=>'GRD -- Greek Drachma','GTQ'=>'GTQ -- Guatemalan Quetzal','GYD'=>'GYD -- Guyanan Dollar','HKD'=>'HKD -- Hong Kong Dollar','HNL'=>'HNL -- Honduran Lempira','HRK'=>'HRK -- Croatian Kuna','HTG'=>'HTG -- Haitian Gourde','HUF'=>'HUF -- Hungarian Forint','IDR'=>'IDR -- Indonesian Rupiah','IEP'=>'IEP -- Irish Punt ','ILS'=>'ILS -- Israeli New Shekel','INR'=>'INR -- Indian Rupee','IQD'=>'IQD -- Iraqi Dinar','IRR'=>'IRR -- Iranian Rial','ISK'=>'ISK -- Iceland Krona','ITL'=>'ITL -- Italian Lira','JMD'=>'JMD -- Jamaican Dollar','JOD'=>'JOD -- Jordanian Dinar','JPY'=>'JPY -- Japanese Yen','KES'=>'KES -- Kenyan Schilling','KGS'=>'KGS -- Kyrgyzstanian Som','KHR'=>'KHR -- Kampuchean ','KMF'=>'KMF -- Comoros Franc','KPW'=>'KPW -- North Korean Won',''=>'KRW -- Korean Won','KWD'=>'KWD -- Kuwaiti Dinar','KYD'=>'KYD -- Cayman Islands Dollar','KZT'=>'KZT -- Kazakhstan Tenge','LAK'=>'LAK -- Lao Kip','LBP'=>'LBP -- Lebanese Pound','LKR'=>'LKR -- Sri Lanka Rupee','LRD'=>'LRD -- Liberian Dollar','LSL'=>'LSL -- Lesotho Loti','LTL'=>'LTL -- Lithuanian Litas','LUF'=>'LUF -- Luxembourg Franc','LVL'=>'LVL -- Latvian Lats','LYD'=>'LYD -- Libyan Dinar','MAD'=>'MAD -- Moroccan Dirham','MDL'=>'MDL -- Moldavan Leu','MGA'=>'MGA -- Malagasy Ariary','MGF'=>'MGF -- Malagasy Franc','MKD'=>'MKD -- Macedonian Denar','MMK'=>'MMK -- Myanmar Kyat','MNT'=>'MNT -- Mongolian Tugrik','MOP'=>'MOP -- Macau Pataca','MRO'=>'MRO -- Mauritanian Ouguiya','MTL'=>'MTL -- Maltese Lira','MUR'=>'MUR -- Mauritius Rupee','MVR'=>'MVR -- Maldive Rufiyaa','MWK'=>'MWK -- Malawi Kwacha','MXN'=>'MXN -- Mexican Peso','MXP'=>'MXP -- Mexican Peso','MYR'=>'MYR -- Malaysian Ringgit','MZM'=>'MZM -- Mozambique Metical','MZN'=>'MZN -- Mozambique New Metical','NAD'=>'NAD -- Namibian Dollar','NGN'=>'NGN -- Nigerian Naira','NIO'=>'NIO -- Nicaraguan Cordoba Oro','NLG'=>'NLG -- Dutch Guilder ','NOK'=>'NOK -- Norwegian Kroner','NPR'=>'NPR -- Nepalese Rupee','NZD'=>'NZD -- New Zealand Dollar','OMR'=>'OMR -- Omani Rial','PAB'=>'PAB -- Panamanian Balboa','PEN'=>'PEN -- Peruvian Nuevo Sol','PGK'=>'PGK -- Papua New Guinea Kina','PHP'=>'PHP -- Philippine Peso','PKR'=>'PKR -- Pakistan Rupee','PLN'=>'PLN -- Polish Zloty','PTE'=>'PTE -- Portuguese Escudo','PYG'=>'PYG -- Paraguay Guarani','QAR'=>'QAR -- Qatari Rial','RON'=>'RON -- Romanian Leu','RSD'=>'RSD -- Serbian Dinar','RUB'=>'RUB -- Russian Rouble','RWF'=>'RWF -- Rwandan Franc','SAR'=>'SAR -- Saudi Riyal','SBD'=>'SBD -- Solomon Islands Dollar','SCR'=>'SCR -- Seychelles Rupee','SDD'=>'SDD -- Sudanese Dinar','SDG'=>'SDG -- Sudanese Pound','SDP'=>'SDP -- Sudanese Pound','SEK'=>'SEK -- Swedish Krona','SGD'=>'SGD -- Singapore Dollar','SHP'=>'SHP -- St. Helena Pound','SIT'=>'SIT -- Slovenian Tolar','SKK'=>'SKK -- Slovak Koruna','SLL'=>'SLL -- Sierra Leone Leone','SOS'=>'SOS -- Somali Schilling','SRD'=>'SRD -- Suriname Dollar','SRG'=>'SRG -- Suriname Guilder','STD'=>'STD -- Sao Tome and Principe Dobra','SVC'=>'SVC -- El Salvador Colon','SYP'=>'SYP -- Syrian Pound','SZL'=>'SZL -- Swaziland Lilangeni','THB'=>'THB -- Thai Baht','TJS'=>'TJS -- Tajikistani Somoni','TMM'=>'TMM -- Turkmenistan Manat','TND'=>'TND -- Tunisian Dinar','TOP'=>'TOP -- Tongan Paanga','TRY'=>'TRY -- Turkish Lira','TTD'=>'TTD -- Trinidad and Tobago Dollar','TWD'=>'TWD -- Taiwan Dollar','TZS'=>'TZS -- Tanzanian Schilling','UAG'=>'UAG -- Ukraine Hryvnia ','UAH'=>'UAH -- Ukraine Hryvnia','UAK'=>'UAK -- Ukraine Karbovanets','UGS'=>'UGS -- Uganda Shilling','UGX'=>'UGX -- Uganda Shilling','USD'=>'USD -- US Dollar','UYP'=>'UYP -- Uruguayan Peso','UYU'=>'UYU -- Uruguayan Peso','UZS'=>'UZS -- Uzbekistan Som','VEF'=>'VEF -- Venezuelan Bolivar Fuerte','VND'=>'VND -- Vietnamese Dong','VUV'=>'VUV -- Vanuatu Vatu','WST'=>'WST -- Samoan TalaXAF','XAF'=>'XAF -- CFA Franc BEAC','XAG'=>'XAG -- Silver','XAU'=>'XAU -- Gold','EUR'=>'EUR -- Euro','XOF'=>'XOF -- CFA Franc BCEAO','XPD'=>'XPD -- Palladium','XPT'=>'XPT -- Platinum','YUN'=>'YUN -- Yugoslav Dinar','ZAR'=>'ZAR -- South African Rand','ZMK'=>'ZMK -- Zambian Kwacha','ZWD'=>'ZWD -- Zimbabwe Dollar');

	return $cur_code;
}

//currency from, currency to
function convertCurrency($curr, $tocurr)
{
	if($curr!=$tocurr)
	{
		$q="SELECT rate FROM currency_coversions WHERE currency_code='$curr' AND currency_to='$tocurr'";
		$sql=mysql_query($q); $rws=mysql_num_rows($sql);

		if($rws>0)
		{
			$rw = mysql_fetch_array($sql);
			if($rw['rate']==""){ return -1;	}
			else{ return $rw['rate'];}
		}else return -1;
	}
	return 1;
}

function checkSubmit($chk,$btn, $currency){
	if($chk==-1){ echo "ERROR: ".$currency." Currency Coversion rates missing.";}
	else{ echo $btn; }
}

function insertCommission($inv, $user){	
	//echo "SELECT a.affiliate_id, u.currency FROM affiliate_refrer a INNER JOIN users u USING(id_users) WHERE a.id_users='$user' AND a.affiliate_id !='0'";
	$sql = mysql_query("SELECT a.affiliate_id, u.currency FROM affiliate_refrer a INNER JOIN users u USING(id_users) WHERE a.id_users='$user' AND a.affiliate_id !='0'");	
	$row = mysql_fetch_array($sql);
			
	if($row['affiliate_id'] > 0){
		$id_affiliate = $row['affiliate_id'];		
		$q="SELECT percentage, plan_type, currency FROM users WHERE id_users='$id_affiliate'"; $sq=mysql_query($q); $rw=mysql_fetch_array($sq);
		$q=mysql_query("SELECT amount, id_invoice_parent, VAT, currency FROM invoice WHERE id_invoice='$inv'"); $rs=mysql_fetch_array($q);
		
		$curr_affi = $rw['currency']; $curr_user = $rs['currency'];
		
		
		$amount=($rs['amount']-$rs['VAT']); $percentage=$rw['percentage'];	$commission=($amount/100)*$percentage;
		$changerate = convertCurrency($curr_user, $curr_affi);
		if($changerate!=-1){$commission=($commission*$changerate); }else{ $curr_affi=$curr_user; }
	//	echo $commission;
		if($rw['plan_type']==0) {
			if($rs['id_invoice_parent']==NULL || $rs['id_invoice_parent']==0){
				$q="INSERT INTO affiliates_balance SET amount='$commission', id_users='$user', id_invoice='$inv', id_affiliate='$id_affiliate', date=now(), status=1, currency='$curr_affi'"; 
				mysql_query($q);
			}			
		}else{
			$q="INSERT INTO affiliates_balance SET amount='$commission', id_users='$user', id_invoice='$inv', id_affiliate='$id_affiliate', date=now(), status=1, currency='$curr_affi'";
			mysql_query($q);
		}
	}	
}

function genrateOrRenewInvoice($id,$path="", $admin=""){
	$mode = getAccCreationMode();
	$q="SELECT i.id_invoice_parent, i.id_users, i.amount, i.currency, i.symbol, u.name, u.email, u.language, u.use_credit FROM invoice i INNER JOIN users u USING(id_users) WHERE i.id_invoice='$id'"; $sql=mysql_query($q); $row=mysql_fetch_array($sql); insertCommission($id, $row['id_users']);
	$em_arr=array("name"=>$row['name'], "email"=>$row['email'], "currency"=>$row['currency'], "lang"=>$row['language'], "amount"=>$row['amount'], "id_invoice"=>$id); sendMail('pi', $em_arr);
	
	if($mode['id']==1 || $mode['id']==3 || $admin=="manual"){ //if($mode['type']=="Automatic" || $mode['type']=="Semi_Automatic"){
		$parent=$row['id_invoice_parent']; $symbol=$row['symbol']; $currency=$row['currency'];$date = date("Y-m-d");
		$q="SELECT * FROM invoice_details WHERE id_invoice='$id'"; $sq=mysql_query($q); 

		while($rw=mysql_fetch_array($sq)){
			$id_users=$rw['id_users']; $name=$row['name']; $email=$row['email']; $qty=$rw['quantity']; $pid=$rw['product_id'];
			$lang=$row['language']; $serv_id=$rw['id_invoice_details'];

			if($parent>0){
				$parent_act_date=getParentActDate($rw['id_invoice_details_parent']); $actdate=getExpDate($pid,$parent_act_date); $date=date("Y-m-d");
				if($date>$actdate){	$actdate=$date;	} $newdate=getExpDateOnActive($pid, $actdate);
				
				$server_list=""; $server_codes=""; $arr_list = getServersList($rw['id_invoice_details_parent'],$pid);
				foreach($arr_list as $k=>$v){ $server_codes.=$v['code']." "; $server_list.=$v['name'].": ".$v['ip']."<br/>"; }
				$server_codes = substr($server_codes, 0, (strlen($server_codes)-1));

				$arr = array("id_users"=>$id_users, "name"=>$name, "email"=>$email, "id_inv_det_parent"=>$rw['id_invoice_details_parent'], 
							 "service_id"=>$serv_id, "qty"=>$qty, "path"=>$path, "servers_list"=>$server_codes, "date"=>$newdate, "act"=>"renew_"); renewService($arr, $users);
			    $users[] = array("id"=>$id_users, "name"=>$name, "account"=>$user_name, "password"=>$password, "server_list"=>$server_list, "email"=>$email, "lang"=>$lang);
				
				mysql_query("UPDATE invoice_details SET date_activation='$actdate', status='1' WHERE id_invoice_details='$serv_id'");
				//if($users!=""){	foreach($users as $k=>$v){ sendMail("sc", $v); }}
			}else if($mode['id']==1 || $admin=="manual"){
				$newdate=getExpDateOnActive($pid);
				
				$q = "SELECT * FROM vpn_accounts WHERE id_invoice_details='$serv_id' ORDER BY id_vpn_accounts DESC LIMIT $qty"; 
				$sql=mysql_query($q); $rws=mysql_num_rows($sql);
				
				if($rws==0){
					for($i=1; $i<=$qty; $i++){
						for($j=0;$j<15;$j++){
							$user_name=WHITE_BRAND."_".createRandomPassword();
							$q = "SELECT id_vpn_user FROM vpn_accounts WHERE id_vpn_user='$user_name'"; $sql=mysql_query($q); $rws=mysql_num_rows($sql);
							if($rws>0){	continue;	}else{ break;}
						}	
						$password=createRandomPassword(); $file_name="create_".$user_name;
	
						$server_list=""; $server_codes=""; $arr_list = getServersList($serv_id,$pid);
						foreach($arr_list as $k=>$v){ $server_codes.=$v['code']." "; $server_list.=$v['name'].": ".$v['ip']."<br/>"; }
						$server_codes = substr($server_codes, 0, (strlen($server_codes)-1));
						$user = array("id"=>$id_users, "name"=>$name, "account"=>$user_name, "password"=>$password, "email"=>$email, "lang"=>$lang, "server_list"=>$server_list); $users[] = $user;
					
						$q="INSERT INTO vpn_accounts SET id_vpn_user='$user_name', id_users='$id_users', pass_vpn='".md5($password)."', id_invoice_details='".$rw['id_invoice_details']."'";
						mysql_query($q); $newdate=str_replace("/","-", $newdate);
						$newdate = strtotime('+1 day' , strtotime($newdate)); $newdate=date('d/m/Y', $newdate);
						//end generate unique user
						$arr = array("file"=>$file_name, "name"=>$user_name, "pass"=>$password, "email"=>$email, "servers_list"=>$server_codes, "date"=>$newdate, "path"=>$path); generateFile($arr,1);	sendMail('sc', $user);
					}
				}else{
					while($row=mysql_fetch_array($sql)) {
						$user_name=$row['id_vpn_user'];	$password=createRandomPassword(); $file_name="create_".$user_name;
	
						$server_list=""; $server_codes=""; $arr_list = getServersList($serv_id,$pid);
						foreach($arr_list as $k=>$v){ $server_codes.=$v['code']." "; $server_list.=$v['name'].": ".$v['ip']."<br/>"; }
						$server_codes = substr($server_codes, 0, (strlen($server_codes)-1));
						$user = array("id"=>$id_users, "name"=>$name, "account"=>$user_name, "password"=>$password, "email"=>$email, "lang"=>$lang, "server_list"=>$server_list); $users[] = $user;
								
						$q="UPDATE vpn_accounts SET pass_vpn='".md5($password)."' WHERE id_vpn_user='$user_name' id_invoice_details='$serv_id'";
						
						mysql_query($q); $newdate=str_replace("/","-", $newdate);
						$newdate = strtotime('+1 day' , strtotime($newdate)); $newdate=date('d/m/Y', $newdate);
						//end generate unique user
						$arr = array("file"=>$file_name, "name"=>$user_name, "pass"=>$password, "email"=>$email, "servers_list"=>$server_codes, "date"=>$newdate, "path"=>$path); generateFile($arr,1);	sendMail('sc', $user);
					}
				}
					
					
				$q="UPDATE invoice_details SET status='1', paid='1', date_activation=now() WHERE id_invoice_details='$rw[id_invoice_details]'"; mysql_query($q);
			}else{ $q="UPDATE invoice_details SET paid='1' WHERE id_invoice_details='$rw[id_invoice_details]'"; mysql_query($q);}
		}	
	}else{ $q="UPDATE invoice_details SET paid='1' WHERE id_invoice='$id'"; mysql_query($q);}
	return $users;
}

function getInvDetServers($id,$currency, $pid=""){

	$q="SELECT invs.name, s.id_server, cs.price FROM invoice_details_servers s INNER JOIN inventory_servers invs USING(id_server) INNER JOIN currency_servers cs ON invs.name=cs.name WHERE cs.product_id='$pid' AND currency_code='$currency' AND s.id_invoice_details='$id' AND invs.id_users='0' GROUP BY invs.name";
	$sql=mysql_query($q); $servers=array();

	while($row=mysql_fetch_array($sql)){
		$servers[]=array('id'=>$row['id_server'], "name"=>$row['name'], 'price'=>$row['price']);
	}
	return $servers;
}

function getPrepInvDetServer($id){
	$q="SELECT name FROM inventory_servers WHERE product_id='$id' AND id_users='0' GROUP BY name";
	$sql=mysql_query($q); $servers=array();

	while($row=mysql_fetch_array($sql)){
		$servers[]=$row['name'];
	}
	return $servers;
}

function getNotification($legend){
	$ru = array('Full Name'=>'[ $name ]', 'E-mail Address'=>'[ $email ]', 'Password'=>'[ $password ]', 'Link'=>'[ $link ]');
	$fp = array('Full Name'=>'[ $name ]', 'Password Reset URL'=>'[ $link ]');
	$fpa = array('Full Name'=>'[ $name ]', 'Password'=>'[ $pass ]');
	$pi = array('Full Name'=>'[ $name ]', 'Total Ammount'=>'[ $total_amount ]');
	$sa = array('Full Name'=>'[ $name ]', 'Service Name'=>'[ $service ]', 'Service ID'=>'[ $id ]');
	$ar = array('Full Name'=>'[ $name ]', 'Refferall URL'=>'[ $link ]');
	$aa = array('Full Name'=>'[ $name ]', 'Date'=>'[ $date ]', 'E-mail Address'=>'[ $email ]', 'Affiliate Type'=>'[ $type ]', 'Commission Percentage'=>'[ $percentage ]', 'Payment Limit'=>'[ $limit ]');
	$pa = array('Full Name'=>'[ $name ]', 'Date'=>'[ $date ]', 'E-mail Address'=>'[ $email ]');
	$pr = array('Full Name'=>'[ $name ]');
	$ac = array('Full Name'=>'[ $name ]', 'Invoice ID'=>'[ $id_invoice ]', 'Date'=>'[ $date ]', 'Price'=>'[ $price ]', 'New Date'=>'[ $newdate ]');
	$ta = array('Ticket ID'=>'[ $ticket_id ]', 'Reply Text'=>'[ $request_text ]');
	$tc = array('Ticket ID'=>'[ $ticket_id ]');
	$ra = array('Ticket ID'=>'[ $ticket_id ]', 'Reply Text'=>'[ $request_text ]');
	$rc = array('Ticket ID'=>'[ $ticket_id ]', 'Reply Text'=>'[ $request_text ]');
	$con = array('Full Name'=>'[ $name ]', 'E-mail Address'=>'[ $email ]', 'Phone'=>'[ $phone ]', 'Company'=>'[ $company ]', 'Message'=>'[ $message]');
	$ri = array('Full Name'=>'[ $name ]', 'Invoice Date'=>'[ $date_invoice ]', 'Due Date'=>'[ $date_expiry ]', 'Invoice ID'=>'[ $id_invoice ]', 'VPN Account'=>'[ $vpn_account ]', 'Total Ammount'=>'[ $total ]');
	$rd = array('Full Name'=>'[ $name ]', 'Invoice Date'=>'[ $date_invoice ]', 'Due Date'=>'[ $date_expiry ]', 'Invoice ID'=>'[ $id_invoice ]', 'VPN Account'=>'[ $vpn_account ]', 'Total Ammount'=>'[ $total ]');
	$ni = array('Full Name'=>'[ $name ]', 'Invoice Date'=>'[ $date ]', 'Invoice ID'=>'[ $id_invoice ]', 'Total Ammount'=>'[ $final_total ]');
	$nu = array('Full Name'=>'[ $name ]', 'Invoice Date'=>'[ $date ]', 'Invoice ID'=>'[ $id_invoice ]', 'Total Ammount'=>'[ $final_total ]');
	$at = array('Full Name'=>'[ $name ]', 'VPN Account'=>'[ $vpn_account ]');
	$cr = array('Full Name'=>'[ $name ]', 'Configuration Name'=>'[ $service_name ]', 'Service ID'=>'[ $service_id ]', 'Credentials Remove'=>'[ $credential ]', 'Date'=>'[ $date ]', 'Cancellation Reason'=>'[ $cancel_reason ]');
	$vp = array('Full Name'=>'[ $name ]', 'User Name'=>'[ $user ]', 'Password'=>'[ $password ]');
	$exp_hr = array('Full Name'=>'[ $name ]', 'Service Id'=>'[ $service_id ]', 'Days'=>'[ $days ]');
	$exp = array('Full Name'=>'[ $name ]', 'Service Id'=>'[ $service_id ]');
	$ser_not = array('Full Name'=>'[ $name ]', 'User ID'=>'[ $user_id ]',  'Service ID'=>'[ $service_id ]',  'Service Status'=>'[ $service_status ]', 'Fund Add'=>'[ $fund_add ]', 'Date'=>'[ $date ]', 'IP Address'=>'[ $ip ]');
	$plan_cust = array('Full Name'=>'[ $name ]', 'Buisness Name'=>'[ $buisness ]',  'Your Title (Post)'=>'[ $title ]',  'E-mail Address'=>'[ $email ]', 'Phone Number'=>'[ $phone ]', 'IP Address'=>'[ $ip ]', 'Requirement'=>'[ $requirement ]');
	$cust_inv = array('Full Name'=>'[ $name ]', 'Invoice ID'=>'[ $id ]',  'Total Ammount'=>'[ $ammount ]');
	$cust_inv_paid = array('Full Name'=>'[ $name ]', 'Invoice ID'=>'[ $id ]',  'Total Ammount'=>'[ $ammount ]',  'Description'=>'[ $description ]');
	$cust_quote = array('Full Name'=>'[ $name ]', 'Quotation ID'=>'[ $id ]',  'Total Ammount'=>'[ $ammount ]',  'Quotation Date'=>'[ $date ]');
	$fund_paid = array('Full Name'=>'[ $name ]', 'Transaction ID'=>'[ $transaction_id ]',  'Transaction Date'=>'[ $date ]', 'Paid Amount'=>'[ $amount ]', 'Service Name'=>'[ $service_name ]', 'Subscription Duration'=>'[ $service_duration ]', 'Payment Method'=>'[ $payment_method ]');
	$ser_query = array('Service Name'=>'[ $ser_name ]', 'Service Page'=>'[ $ser_page ]', 'Date'=>'[ $date ]', 'User Name'=>'[ $user_name ]', 'User E-mail'=>'[ $user_email ]', 'User Website'=>'[ $user_website ]', 'User IP Address'=>'[ $user_ip ]', 'User Query'=>'[ $user_query ]');
	
	$month_inv = array('Full Name'=>'[ $name ]', 'Invoice ID'=>'[ $id ]',  'Total Ammount'=>'[ $ammount ]');
	$inv_pay_success = array('Full Name'=>'[ $name ]', 'Invoice ID'=>'[ $id ]',  'Total Ammount'=>'[ $ammount ]');
	$inv_pay_fail = array('Full Name'=>'[ $name ]', 'Invoice ID'=>'[ $id ]',  'Total Ammount'=>'[ $ammount ]');
	$cc_update_fail = array('User Id'=>'[ $id_users ]', 'Full Name'=>'[ $name ]', 'E-mail Address'=>'[ $email ]');
	$cust_recurr_inv = array('Full Name'=>'[ $name ]', 'Invoice ID'=>'[ $id ]',  'Total Ammount'=>'[ $ammount ]');
	$apply_manage_sub = array('Full Name'=>'[ $name ]', 'Subscription Type'=>'[ $subscription ]');
	$bonus_mature = array('User Id'=>'[ $id_users ]', 'Full Name'=>'[ $name ]', 'E-mail Address'=>'[ $email ]', 'Bonus Type'=>'[ $bonus_type ]', 'Affiliate Commission ID'=>'[ $aff_id ]');
	$inv_reminder = array('Full Name'=>'[ $name ]', 'Invoice ID'=>'[ $id ]',  'Total Ammount'=>'[ $ammount ]');
	$inv_reminder_monthly = array('Full Name'=>'[ $name ]', 'Invoice ID'=>'[ $id ]',  'Total Ammount'=>'[ $ammount ]');
	$inv_reminder_admin = array('Full Name'=>'[ $name ]', 'Invoice ID'=>'[ $id ]',  'Total Ammount'=>'[ $ammount ]');
	$manual_verify_bad = array('Full Name'=>'[ $name ]');
	$manual_verify_good = array('Full Name'=>'[ $name ]');
	$verification_instruc = array('Full Name'=>'[ $name ]');
	
	$list = array('ru'=>$ru, 'fp'=>$fp, 'fpa'=>$fpa, 'pi'=>$pi, 'ui'=>$ui, 'sa'=>$sa, 'ri'=>$ri, 'ar'=>$ar, 'aa'=>$aa, 'pa'=>$pa, 'pr'=>$pr, 'ac'=>$ac, 'ta'=>$ta, 'tc'=>$tc, 'ra'=>$ra, 'rc'=>$rc, 'con'=>$con, 'rd'=>$rd, 'ni'=>$ni, 'nu'=>$nu, 'at'=>$at, 'cr'=>$cr, 'vp'=>$vp, 'exp'=>$exp, 'exp_hr'=>$exp_hr, 'ser_not'=>$ser_not, 'plan_cust'=>$plan_cust, 'cust_inv'=>$cust_inv, 'month_inv'=>$month_inv, 'inv_pay_success'=>$inv_pay_success, 'inv_pay_fail'=>$inv_pay_fail, 'cust_inv_paid'=>$cust_inv_paid, 'fund_paid'=>$fund_paid, 'cust_quote'=>$cust_quote, 'ser_query'=>$ser_query, 'cc_update_fail'=>$cc_update_fail, 'cust_recurr_inv'=>$cust_recurr_inv, 'apply_manage_sub'=>$apply_manage_sub, 'bonus_mature'=>$bonus_mature, 'inv_reminder'=>$inv_reminder, 'inv_reminder_admin'=>$inv_reminder_admin, 'inv_reminder_monthly'=>$inv_reminder_monthly, 'manual_verify_bad'=>$manual_verify_bad, 'manual_verify_good'=>$manual_verify_good, 'verification_instruc'=>$verification_instruc);
	return $list[$legend];
}

function getAlertLegend($legend)
{
	$view = array('Configuration Name'=>'[ $service_name ]', 'Service ID'=>'[ $service_id ]');
	$pend = array('Configuration Name'=>'[ $service_name ]', 'Service ID'=>'[ $service_id ]');
	$exp = array('Configuration Name'=>'[ $service_name ]', 'Service ID'=>'[ $service_id ]');	
	
	$list = array('view'=>$view, 'pend'=>$pend, 'exp'=>$exp);
	return $list[$legend];
}

function getTimeDifference( $start, $end ){
    $uts['start'] = strtotime( $start );
    $uts['end']   = strtotime( $end );

    if( $uts['start']!==-1 && $uts['end']!==-1 ) {
            $diff =  $uts['end'] - $uts['start'];

            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
    }else{
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}

function getVAT($country, $total){
	$q="SELECT tax FROM country WHERE printable_name='$country'"; $sql=mysql_query($q);
	$rw=mysql_fetch_array($sql);

	if($rw['tax']>0){
		$vat=($total/100)*$rw['tax'];
	}else{
		$vat=0;
	}
	return $vat;
}
function addDurationInDate($date,$days){
	$date = strtotime ("+$days", strtotime($date));
	return date ('Y-m-d', $date);
}

function subDurationFromDate($date,$days){
	$date = strtotime ("-$days", strtotime($date));
	return date ('Y-m-d', $date);
}

function callRadius($request, $link){
	$parser=new RESTPARSER();

	$request['api_key']='^Rf7de7igbD';
	$xml=$parser-> callservice($request,'83.170.87.238', $link,'POST');
	return $xml;
}
function getAlphaBates(){
	$arr = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O",
				  "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
	return $arr;
}

function getMonth($month){
	$arr = array("Jan"=>1, "Feb"=>2, "Mar"=>3, "Apr"=>4, "May"=>5, "Jun"=>6,
				 "Jul"=>7, "Aug"=>8, "Sep"=>9, "Oct"=>10, "Nov"=>11, "Dec"=>12);
	
	return $arr[$month];
}
function getMonthName($month){
	$arr = array(1=>"Jan", 2=>"Feb", 3=>"Mar", 4=>"Apr", 5=>"May", 6=>"Jun",
				 7=>"Jul", 8=>"Aug", 9=>"Sep", 10=>"Oct", 11=>"Nov", 12=>"Dec");
	
	return $arr[$month];
}
function getChartColor($c){
	$color = array('1'=>'134FAA', '2'=>'2D8A0D', '3'=>'B40505', '4'=>'856308', '5'=>'097960', '6'=>'2D2D2D', '7'=>'843F79', '8'=>'515E84', '9'=>'A04F1A', '10'=>'7F851D', '11'=>'76478F', '12'=>'7B5656');

	return $color[$c];
}
function firstDayOfMonth($date){ 
	$tmp = explode("-",$date);
	return $tmp[0]."-".$tmp[1]."-01"; 
} 
function lastDayOfMonth($date){ 
	$tmp = explode("-",$date);
	return $tmp[0]."-".$tmp[1]."-31"; 
} 
function getQuarterName($mm){
	$arr = array(1=>"(Jan-Mar)", 2=>"(Apr-Jun)", 3=>"(Jul-Sep)", 4=>"(Oct-Dec)");
	return $arr[$mm];
}
function getQuarter($mm){
	if($mm<=3){	$mm=1;}
	else if($mm<=6){ $mm=2;}
	else if($mm<=9){ $mm=3;}
	else if($mm<=12){ $mm=4;}
	return $mm;
}

function getQuaterFirstDate($q, $yy){
	$arr=array(1=>"$yy-01-01", 2=>"$yy-04-01", 3=>"$yy-07-01", 4=>"$yy-10-01"); return $arr[$q];
}

function getAccQuery($data)
{
	extract($data);
	
	//Monthly Reports
	$arr['funds']="SELECT SUM(amount) AS inv, SUBSTR(fund_date,1,10) AS date FROM pre_paid_funds WHERE currency='$status' AND status='1' AND type!='3' AND amount>'0' AND SUBSTR(fund_date,1,10)>='$from' AND SUBSTR(fund_date,1,10)<='$to1' GROUP BY SUBSTR(fund_date,1,10)";
	$arr['services']="SELECT COUNT(service_id) AS inv, SUBSTR(last_updated,1,10) AS date FROM invoice_details WHERE status='$status' AND SUBSTR(last_updated,1,10)>='$from' AND SUBSTR(last_updated,1,10)<='$to1' GROUP BY SUBSTR(last_updated,1,10)";
	$arr['tickets']="SELECT COUNT(ticket_id) AS inv, SUBSTR(last_updated,1,10) AS date FROM tickets WHERE SUBSTR(last_updated,1,10)>'$from' AND SUBSTR(last_updated,1,10)<'$to1' AND ticket_status_id='$status' GROUP BY SUBSTR(last_updated,1,10)";
	$arr['clients']="SELECT COUNT(id_users) AS inv, date FROM users WHERE date>='$from' AND date<='$to1' GROUP BY date";

	//Quarterly Reports
	$arr['fundsq']="SELECT SUM(amount) AS inv, SUBSTR(fund_date,1,10) AS date FROM pre_paid_funds WHERE currency='$status' AND status='1' AND type!='3' AND amount>'0' AND SUBSTR(fund_date,1,10)>='$from' AND SUBSTR(fund_date,1,10)<='$to1' GROUP BY SUBSTR(fund_date,6,6)";
	$arr['servicesq']="SELECT COUNT(id_invoice_details) AS inv, SUBSTR(last_updated,1,10) AS date FROM invoice_details WHERE status='$status' AND SUBSTR(last_updated,1,10)>='$from' AND SUBSTR(last_updated,1,10)<='$to1' GROUP BY SUBSTR(last_updated,6,6)";
	$arr['ticketsq']="SELECT COUNT(ticket_id) AS inv, SUBSTR(last_updated,1,10) AS date FROM tickets WHERE SUBSTR(last_updated,1,10)>'$from' AND SUBSTR(last_updated,1,10)<'$to1' AND ticket_status_id='$status' GROUP BY SUBSTR(last_updated,6,6)";
	$arr['clientsq']="SELECT COUNT(id_users) AS inv, date FROM users WHERE date>='$from' AND date<='$to1' GROUP BY SUBSTR(date,6,6)";
	
	//Yearly Reports
	$arr['fundsy']="SELECT SUM(amount) AS inv, SUBSTR(fund_date,1,10) AS date FROM pre_paid_funds WHERE currency='$status' AND status='1' AND type!='3' AND amount>'0' AND SUBSTR(fund_date,1,10)>='$from' AND SUBSTR(fund_date,1,10)<='$to1' GROUP BY SUBSTR(fund_date,6,2)";
	$arr['servicesy']="SELECT COUNT(id_invoice_details) AS inv, SUBSTR(last_updated,1,10) AS date FROM invoice_details WHERE status='$status' AND SUBSTR(last_updated,1,10)>='$from' AND SUBSTR(last_updated,1,10)<='$to1' GROUP BY SUBSTR(last_updated,6,2)";
	$arr['ticketsy']="SELECT COUNT(ticket_id) AS inv, SUBSTR(last_updated,1,10) AS date FROM tickets WHERE SUBSTR(last_updated,1,10)>'$from' AND SUBSTR(last_updated,1,10)<'$to1' AND ticket_status_id='$status' GROUP BY SUBSTR(last_updated,6,2)";
	$arr['clientsy']="SELECT COUNT(id_users) AS inv, date FROM users WHERE date>='$from' AND date<='$to1' GROUP BY SUBSTR(date,6,2)";
	
	return $arr[$act];
	
}
function getDropDownData($v)
{
	$srv=array("1"=>"Active", "0"=>"Pending", "C"=>"Cancelled", "E"=>"Expired", "F"=>"Fraud");
	$tik=array("1"=>"Open", "2"=>"Answered", "3"=>"Customer Reply", "4"=>"On-hold", "5"=>"In-progress", "6"=>"Closed");
	$cus=array("Paid"=>"Paid", "Unpaid"=>"Unpaid", "Cancelled"=>"Cancelled");
	$arr=array("services"=>$srv, "tickets"=>$tik, "customers"=>"");
	return $arr[$v];
}
function getChartStatus($st)
{
	switch($st)
	{
		case 'ser_C': $st="Cancelled"; break;
		case 'ser_1': $st="Active"; break;
		case 'ser_0': $st="Pending"; break;		
		case 'ser_E': $st="Expired"; break;
		case 'ser_F': $st="Fraud"; break;
		case 'ser_R': $st="Refund"; break;
		
		case 'tick_1': $st="Open"; break;
		case 'tick_2': $st="Answered"; break;
		case 'tick_3': $st="Customer Reply"; break;
		case 'tick_4': $st="On-hold"; break;
		case 'tick_5': $st="In-progress"; break;
		case 'tick_6': $st="Closed"; break;

		case 'fund_0': $st="Unapprove"; break;
		case 'fund_1': $st="Approve"; break;

		default: break;
	}
	return $st;
}
function cronCheck($cron){
	$date=date("Y-m-d");
	$q="SELECT run_on FROM cronjob_log WHERE run_on LIKE '$date%' AND cron_type='$cron'";
	$sql=mysql_query($q); $rws=mysql_num_rows($sql);
	if($rws>0){ return 0;}
	else
	{
		$q="INSERT INTO cronjob_log SET run_on=now(), cron_type='$cron'";
		$sql	= mysql_query($q);  
		$id		= mysql_insert_id();
		return $id;
	}
}

//--------------------------------------------------Util File Functions--------------------------------------------------------
function getAccCreationMode(){
	$q="SELECT * FROM sys_modes_config WHERE active='1' LIMIT 1"; $sql = mysql_query($q);
	$row = mysql_fetch_array($sql);
	return $row;
}
function getExpDateOnActive($id, $date=""){
	if($date==""){ $date=date('Y-m-d');}
	$res_duration=mysql_query("select duration from inventory where product_id='$id'");
	$row_duration=mysql_fetch_array($res_duration);
	$duration=$row_duration['duration'];
	$newdate = strtotime ( '+'.$duration.' month 1 day' , strtotime ( $date ) ) ;
	$newdate = date ( 'd/m/Y' , $newdate );
	return $newdate;
}
function createRandomPassword() {
   $chars = "abcdefghijkmnopqrstuvwxyz0123456789";
    $i = 0;
	$pass = '' ;

	while ($i <= 6) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
	$num=rand(0,9);
	$pass = $pass . $num;
	$pass = str_shuffle($pass);
	return $pass;
}
function getServersList($serv_id,$pid){
	$q="SELECT cat.attributed FROM inventory inv INNER JOIN inventory_categories cat USING(cat_id) WHERE inv.product_id='$pid'";
	$sql=mysql_query($q); $row=mysql_fetch_array($sql);

	if($row['attributed']==1){
		$q="SELECT cfg.server_code, cfg.ip, s.name FROM inventory_servers s INNER JOIN invoice_details_servers det USING(id_server) INNER JOIN inv_server_config cfg USING(NAME) WHERE  det.id_invoice_details='$serv_id' GROUP BY s.name";
	}else{
		$q="SELECT cfg.server_code, cfg.ip, s.name FROM inventory_servers s INNER JOIN inv_server_config cfg USING(NAME) WHERE s.product_id='$pid' AND s.id_users='0' GROUP BY s.name";
	}
	$sql=mysql_query($q); $arr=array();

	while($row=mysql_fetch_array($sql)){
		$arr[]=array("name"=>$row['name'], "code"=>$row['server_code'], "ip"=>$row['ip']);
	}
	return $arr;
}
function generateFile($arr,$passchk){
	$path = $arr["path"].'upload/';
	$lines[1]=$arr['name']." ";

    if($passchk==1) {
	  	$lines[2]=$arr['pass']." ";
	}
	$lines[3]=$arr['date']." ";

	if(!strstr($arr["file"], "cancel_") || !strstr($arr["file"], "fraud_")){
		$lines[4]=$arr['email']."\r\n";
		$lines[5]=$arr['servers_list'];
	}
	$content = implode('', $lines);
//	echo $path.$arr["file"];
	$fp = fopen($path.$arr["file"],'w') or die('Can\'t write to log file! Please Change the file permissions (CHMOD to 666 on UNIX machines!)');
	//flock($fp, LOCK_EX);
	fputs($fp,$content);
	//flock($fp, LOCK_UN);
	fclose($fp);
	//end create file for ftp
	//begin send file via ftp
	// FTP access parameters:

	$host = '83.170.87.238';
	$usr = 'admin';
	$pwd = 'qaXSad12';
	// file to upload:

/*	$local_file = $path.$arr["file"];
	$ftp_path = "fiporsfcmip/".$arr["file"];

	// connect to FTP server (port 21)
	$conn_id = ftp_connect($host, 21) or die ("Cannot connect to host");

    // send access parameters
	ftp_login($conn_id, $usr, $pwd) or die("Cannot login");
	//echo $conn_i."-- FTP File: ". $ftp_path."-- Local File: ".$local_file."-- FTP ASC: ". FTP_ASCII;
	
	$upload = ftp_put($conn_id, $ftp_path, $local_file, FTP_ASCII);
	ftp_close($conn_id);
    unlink($path.$arr["file"]);*/
}

function getParentActDate($id){
	$q="SELECT date_activation FROM invoice_details WHERE id_invoice_details='$id'"; $sql=mysql_query($q);
	$rw=mysql_fetch_array($sql); return $rw['date_activation'];
	 
}

function renewService($arr, $users=""){
	$passchk=0; extract($arr);
	$q = "SELECT id_vpn_user, pass_vpn FROM vpn_accounts WHERE id_invoice_details='$id_inv_det_parent' ORDER BY id_vpn_accounts DESC LIMIT $qty"; $sq=mysql_query($q); 

	while($rw=mysql_fetch_array($sq)){
		$user_name=$rw['id_vpn_user'];	$password=$rw['pass_vpn'];	$file_name=$act.$user_name;	
		$users[] = array("id"=>$id_users, "name"=>$name, "account"=>$user_name, "password"=>$password, "email"=>$email, "lang"=>$lang);

		if($act == "renew_"){ 
			$q="SELECT * FROM vpn_accounts WHERE id_vpn_user='$user_name' AND id_invoice_details='$service_id'"; $sql=mysql_query($q); $rws=mysql_num_rows($sql);

			if($rws==0){
				$q="INSERT INTO vpn_accounts SET id_vpn_user='$user_name', pass_vpn='".md5($password)."', id_users='$id_users', id_invoice_details='$service_id'"; mysql_query($q);
			}
		}
		$password="";
		$arr = array("file"=>$file_name, "name"=>$user_name, "pass"=>$password, "servers_list"=>$servers_list, "email"=>$email, "date"=>$date, "path"=>$path);
		generateFile($arr,$passchk);
	}
	return $users;
}

//--------------------------------------------------End Util File Functions--------------------------------------------------------

function getVpnAccounts($uid=""){
	if($uid!=""){ $uid="AND id_users='$uid'"; }	
	$q="SELECT id_invoice_details, quantity FROM invoice_details WHERE status='1' $uid";
	$sql=mysql_query($q); $arr=array();
	
	while($row=mysql_fetch_array($sql)){
		$q="SELECT id_vpn_user FROM vpn_accounts WHERE id_invoice_details='$row[id_invoice_details]' GROUP BY id_vpn_user ORDER BY id_vpn_accounts DESC LIMIT $row[quantity]";
		$sq=mysql_query($q); while($rw=mysql_fetch_array($sq)){ $arr[$rw['id_vpn_user']]=$rw['id_vpn_user']; }
	}
	return $arr;
}

function updateIncomeSummary($arr, $curr)
{
	$todaydate = date("Y-m-d"); 
	$tmp = explode("-", $todaydate); 
	extract($arr['today']);
	
	//echo $date;
	
	//Fetching Default Currency
	$q = "SELECT currency_code FROM currency WHERE default_chk='1'"; 
	$sql = mysql_query($q); 
	$row = mysql_fetch_array($sql);
	$def_currency = $row['currency_code']; 
	
	//Getting Time Defferenct
	//$diff		= getTimeDifference(date("Y-m-d H-i-s"), $date);
	
	$today		= date('Y-m-d');
	$this_month	= date('Y-m-d', mktime(0, 0, 0, date("m"), 1, date("Y")));
	$this_year	= date('Y-m-d', mktime(0, 0, 0, 1, 1, date("Y")));

	//Income Summery Calculation Process | Start
	//if($curr != $def_currency || $diff['days']>0 || $diff['minutes']>10)
	if($curr != $def_currency)
	{
		/////-------------------------------Today Income-------------------------------------------------////
		//Calculating Income
		//$tot_1 = getTotalSum2('invoice', 'grand_total_cw', "grand_total_cw > 0 AND payment_status='1' AND SUBSTR(invoice_date, 1, 10)='$todaydate' AND currency = '$curr'");
		//$tot_1 = getTotalSum2('invoice', 'grand_total_cw', "grand_total_cw > 0 AND payment_status='1' AND SUBSTR(invoice_date, 1, 10)='$todaydate'");
		$tot_1	= 0;
		$result	= getFieldsData('invoice', 'sum(grand_total_cw) as income', "payment_status = '1' and invoice_date = '". $today ."'");
		if($result['income'])
			$tot_1	= $result['income'];
			
		//Updating Summery
		$q_1 = "UPDATE income_summary SET amount='$tot_1', currency='$curr', cur_date=now() WHERE field_name='today'";
		$sql_1 = mysql_query($q_1) or die("Mysql Error: ".mysql_error());
		/////-------------------------------End Today Income-------------------------------------------------
		
		/////-------------------------------This Month Income-------------------------------------------------
		//Calculating Income
		//$tot_2 = getTotalSum2('invoice', 'grand_total_cw', "grand_total_cw > 0 AND payment_status='1' AND SUBSTR(invoice_date, 1, 7)='$tmp[0]-$tmp[1]' AND currency = '$curr'");
		//$tot_2 = getTotalSum2('invoice', 'grand_total_cw', "grand_total_cw > 0 AND payment_status='1' AND SUBSTR(invoice_date, 1, 7)='$tmp[0]-$tmp[1]'");
		$tot_2	= 0;
		$result	= getFieldsData('invoice', 'sum(grand_total_cw) as income', "payment_status = '1' and invoice_date >= '". $this_month ."' and invoice_date <= '". date('Y-m-d') ."'");
		if($result['income'])
			$tot_2	= $result['income'];
		
		//Updating Summery
		$q_2 = "UPDATE income_summary SET amount='$tot_2', currency='$curr', cur_date=now() WHERE field_name='thismonth'";
		$sql_2 = mysql_query($q_2) or die("Mysql Error: ".mysql_error());
		/////-------------------------------End This Month Income-------------------------------------------------
		
		/////-------------------------------This Year Income-------------------------------------------------		
		//Calculating Income
		//$tot_3 = getTotalSum2('invoice', 'grand_total_cw', "grand_total_cw > 0 AND payment_status='1' AND SUBSTR(invoice_date, 1, 4)='$tmp[0]' AND currency = '$curr'");
		//$tot_3 = getTotalSum2('invoice', 'grand_total_cw', "grand_total_cw > 0 AND payment_status='1' AND SUBSTR(invoice_date, 1, 4)='$tmp[0]'");
		$tot_3	= 0;
		$result	= getFieldsData('invoice', 'sum(grand_total_cw) as income', "payment_status = '1' and invoice_date >= '". $this_year ."' and invoice_date <= '". date('Y-m-d') ."'");
		if($result['income'])
			$tot_3	= $result['income'];
		
		//Updating Summery
		$q_3 = "UPDATE income_summary SET amount='$tot_3', currency='$curr', cur_date=now() WHERE field_name='thisyear'";
		$sql_3 = mysql_query($q_3) or die("Mysql Error: ".mysql_error());		
		/////-------------------------------End This Year Income-------------------------------------------------		
		
		/////-------------------------------Total Income-------------------------------------------------
		//Calculating Income
		//$tot_4 = getTotalSum2('invoice', 'grand_total_cw', "grand_total_cw > 0 AND payment_status='1' AND currency = '$curr'");
		$tot_4 = getTotalSum2('invoice', 'grand_total_cw', "grand_total_cw > 0 AND payment_status='1'");
		
		//Updating Summery
		$q_4 = "UPDATE income_summary SET amount='$tot_4', currency='$curr', cur_date=now() WHERE field_name='total'";
		$sql_4 = mysql_query($q_2) or die("Mysql Error: ".mysql_error());
		
		/////-------------------------------End Total Income-------------------------------------------------		*/
		return getIncomeSummary();
	
	}//Income Summery Calculation Process | End
	
	return 0;	
}

function getIncomeSummary()
{
	$q="SELECT * FROM income_summary";
	$sql=mysql_query($q); $arr=array();
	while($row=mysql_fetch_array($sql))
	{
		$arr[$row['field_name']]=array("amt"=>$row['amount'], "currency"=>$row['currency'], "date"=>$row['cur_date']);
	}
	return $arr;
}

function setUserStatus($uid, $online, $userAgent)
{
	//$q="UPDATE users SET online='$online' WHERE id_users='$uid' AND type='$chk'";
	$q="UPDATE users SET online='$online', user_agent='$userAgent' WHERE id_users='$uid'";
	mysql_query($q);
}
function setOnlineUser($sid, $uid)
{
	$q="INSERT INTO online_activities SET session_id='$sid', id_users='$uid', last_updated=now()";
	mysql_query($q);
}
function setSecUserStatus($uid, $online, $userAgent)
{
	$q="UPDATE users_secondary SET online='$online', user_agent='$userAgent' WHERE id_users_sec='$uid'";
	mysql_query($q);
}

function removeExpUsers()
{
	$q="SELECT * FROM online_activities";	
	$sql=mysql_query($q);
	while($row=mysql_fetch_array($sql))
	{
	
	}
}

function setAdminStatus($uid, $online){
	$q="UPDATE admins SET online='$online' WHERE id='$uid'";
	mysql_query($q);
}

function getPages()
{
	$page = array(
					'about'=>'About us', 
					'contact'=>'Contact us', 
					'faq'=>"FAQ's", 
					'home'=>'Home Page', 
					'service_list'=>'Service | List Page', 
					'service_detail'=>'Service | Detail Page', 
					'plan_viewed'=>'Service | Viewed Page For New User', 
					'news'=>'News Updates', 
					'privacy'=>'Privacy Policy', 
					'refund_privacy'=>'Refund Policy', 
					'reg'=>'Registration', 
					'terms'=>'Terms and Condition', 
					'partner'=>'Partner', 
					'application'=>'Cloud Application',
					'pricing'=>'Pricing',
					'power_cloud'=>'Power Cloud',
					'login'=>'Login Page',
					'refund_policy'=>'Refund Policy',
					'one_click_application_deployment'=>'Feature: One Click Application Deployment',
					'automated_backups_and_restore'=>'Feature: Automated Backups and Restore',
					'developers_playground'=>'Feature: Developers Playground',
					'cloud_control'=>'Feature: Cloud Control',
					'no_lock_in'=>'Feature: No Lock In',
					'managed_cloud_solutions'=>'Feature: Managed Cloud Solutions',
					'multi_level_management'=>'Feature: Multi Level Management',
					'customer_centric_operations'=>'Feature: Customer Centric Operations',
					'cloud_efficiency'=>'Feature: Cloud Efficiency',
					'service'=>'Service'
				);
	return $page;
}

function getMaxValue($table, $field, $cat=""){
	if($cat != ""){
		$q = "SELECT MAX($field) AS mv FROM $table WHERE $cat LIMIT 1"; 
	}else{
		$q = "SELECT MAX($field) AS mv FROM $table LIMIT 1"; 
	}
	$sql = mysql_query($q);
	$rw = mysql_fetch_array($sql);
	$row = $rw['mv'];
	return $row;
}

function cleanGetData($get, $red="", $int=""){
	$clean1 = strip_tags($get);
	$clean2 = mysql_real_escape_string($clean1);
	$clean2 = stripcslashes($clean2);
	$clean2 = trim($clean2);
	
	if($int != ""){  
		$clean2 = (int)$clean2;
		if($clean2 == 0){ header('Location:'.$red); exit();}
	}
	
	if($clean2 == ""){  exit() or die();  }else{   return $clean2;  }
}

function setSorting1($table, $field, $count_id, $id, $sel, $cat=""){

	if($cat != ""){  $max_sort = getMaxValue($table, $field, $cat);  }else{  $max_sort = getMaxValue($table, $field); }
	$total = $max_sort - $sel;
	$curr_sort = $max_sort;
	$curr = $curr_sort+1;
	//echo 'Total Records -- '.$total.'<br />';
	
	for($i=0; $i <= $total; $i++){
		$chk_sort = getTotalRecords($table, $id, "$field='$curr_sort'");
		//echo $chk_sort.' | '.$curr_sort.'<br />';
		if(($chk_sort != 0)){
			if($cat != ""){
				$q="UPDATE $table SET $field='$curr' WHERE $field='$curr_sort' AND $count_id !='$id' AND $cat LIMIT 1";
			}else{
				$q="UPDATE $table SET $field='$curr' WHERE $field='$curr_sort' AND $count_id !='$id' LIMIT 1";
			}
			//echo $q.'<br />';
			mysql_query($q);
			$curr--;
		}
		$curr_sort--;
	}
}

function setSorting2($table, $field, $count_id, $id, $sel_sort, $old_sort, $cat="")
{
	if($sel_sort < $old_sort){ 
		$total = $old_sort-$sel_sort;
		$curr_sort = $old_sort-1;
		$curr = $curr_sort+1;
		//echo'Going in Minus<br />';
	}else{
		$total = $sel_sort-$old_sort;
		$curr_sort = $old_sort+1;
		$curr = $curr_sort-1;
		//echo'Going in Plus<br />';
	}

	//echo $total.'<br />';
	if($total > 0){
		for($i=0; $i < $total; $i++){
			$chk_sort = getTotalRecords($table, $count_id, "$field='$curr_sort'");
			//echo $chk_sort.' | '.$curr_sort.'<br />';
			if($chk_sort != 0){
				//echo 'Found<br />';
				if($cat != ""){
					$q="UPDATE $table SET $field='$curr' WHERE $field='$curr_sort' AND $count_id!='$id' AND $cat";
				}else{
					$q="UPDATE $table SET $field='$curr' WHERE $field='$curr_sort' AND $count_id!='$id'";
				}
				//echo $q.'<br />';
				mysql_query($q);
				
				if($sel_sort < $old_sort){  $curr--;  }else{  $curr++;}
			}
			if($sel_sort < $old_sort){  $curr_sort--;  }else{  $curr_sort++;  }
		}
	}
}

function getRandomNumber($characters)
{
	/* list all possible characters, similar looking characters and vowels have been removed */
	$possible = '123456789abcdfghjkmnopqrstuvwxyz';
	$code = '';
	$i = 0;
	while ($i < $characters) { 
		$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
		$i++;
	}
	return $code;
}

function serviceActivity($arr)
{
	$q = "INSERT INTO service_logs SET service_id='".$arr['service_id']."', id_users='".$arr['id_users']."', date_time=NOW(), activity='".$arr['activity']."', note='".$arr['note']."'";
	$sql = mysql_query($q);
}

function graphDataUpdate($host, $server, $service, $pm, $val)
{
	$q="INSERT INTO service_graph SET id_server='$server', service_id='$service', host_id='$host', parameter='$pm', graph_id='$val', last_update=NOW()";
	$sql = mysql_query($q) or die(mysql_error());
}

function mem_alert_act($ser_id, $data)
{
	$alert_id = getFieldsData('service_alert', 'id', "service_id='$ser_id'");

	if($alert_id['id'] == "")
	{
		$q = "INSERT INTO service_alert SET $data, alert_date=NOW()";
	}
	else
	{
		$q = "UPDATE service_alert SET $data, alert_date=NOW() WHERE id=".$alert_id['id']." LIMIT 1";
	}
	$sql = mysql_query($q);
}

function unsanitize($str)
{
	return htmlentities(stripslashes($str), ENT_QUOTES, "UTF-8");
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getTopLevelMenus()
{
	$menu	= array('Accounting', 'CMS', 'Clients', 'Click n GO Management', 'Affiliate', 'Utilities');
	return $menu;
}

function applyVAT($country)
{
	//VAT logic
	$vat_applied	= '0';
	if(isset($country) && $country != '')
	{
		//checking if country is in eurpoe
		$in_europe	= getTotalRecords('country', 'iso', "printable_name='$country' and in_europe='1'");
		if($in_europe > 0) //if country is outside the europe then VAT not applied
		{
			$vat_applied	= '1';
		}
	}	
	return $vat_applied;
}

function user_email_country_status($email)
{
	//checking if user is from good country
	include_once('geoplugin.class.php');
	$is_good	= '0';
	$geoplugin	= new geoPlugin();
	$geoplugin->locate(getRealIpAddr());
	$country	= $geoplugin->countryName;
	if(isset($country) && $country != '')
	{
		$rs_country	= getFieldsData('country', 'is_good', "printable_name='$country'");
		$is_good	= $rs_country['is_good'];
	}	
	//echo 'Is Good Country? = '.$is_good.'<br>';
	
	//checking if email domain is free
	include_once('simple_html_dom.php');
	// get DOM from URL or file
	$html = file_get_html('http://www.dnsstuff.com/tools/freemail/?domain=' . $email);
	$email_result	= '';
	// find all pre tags
	foreach($html->find('pre') as $p)
		$email_result	= $p->innertext;
	
	$is_free		= '1'; //email domain is free
	if(strpos($email_result, 'not') !== false)
		$is_free	= '0'; //email domain is not free
	//echo $email_result;	
	//echo 'Is Free Email Domain? = '.$is_free.'<br>';
	
	$oArray				= array();
	$oArray['is_good']	= $is_good;
	$oArray['is_free']	= $is_free;

	return $oArray;
}

function test_port($host,$port=80,$timeout=6)
{
	$fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
	if ( ! $fsock )
	{
		return FALSE;
	}
	else
	{
		return TRUE;
	}
}

?>