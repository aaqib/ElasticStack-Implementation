<?php 
//error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRICATE);
session_set_cookie_params(36000);
session_start();
//if((strstr($_SERVER['HTTP_HOST'],"change-mon-ip")) && ($_SERVER["SERVER_ADDR"] =='72.20.46.66')){}else{exit();}

//************* Site Config ***************//
define('LANGUAGE','utf-8');
define('COMPANY','Cloud Ways');
define('CMPNY','Cloud Ways');
define('SITE_TITLE',COMPANY.' Administration Panel');
define('REC','15');
define('CUR','USD');
define('ADMIN_E_MAIL','no_reply@vpnms.com');
define('WHITE_BRAND','cmi');

//*************** System Files Config *****************//
define('SYSTEM',$path.'system/');
define('CLS',SYSTEM.'classes/');
define('EDITOR',SYSTEM.'editor/');
define('FRONT',SYSTEM.'front-hand/');
define('FUNCTION',SYSTEM.'function/');
define('INC',SYSTEM.'include/');
define('ZABX',SYSTEM.'zabbix/');
define('PDF_GENRATOR',SYSTEM.'pdf_genrator/');
define('CHART',SYSTEM.'charts/');
define('PARSER',INC.'parser/');
define('JS',SYSTEM.'js/');
define('PLUGIN',SYSTEM.'plugin/');
define('SWF',SYSTEM.'swf/');
define('XML',SYSTEM.'xml/');
define('SSH',SYSTEM.'ssh/');

//************* Time Zone Config ***************//
define('TIME_ZONE','100');

//*************** Template Files Config *****************//
define('TEMPLATE',$path.'template/');
define('SKIN',TEMPLATE.'default_1/');
define('FLAG',$path.'template/default/flag/');
define('CSS',SKIN.'css/');
define('IMG',SKIN.'img/');
define('SHOOT',SKIN.'shoot/');

//*************** Site Front Hand Files *****************//
define('HEAD',FRONT.'head.php');
define('HEADER',FRONT.'header.php');
define('LEFT_PANEL',FRONT.'left_side.php');
define('NAVIGATION',FRONT.'navigation.php');
define('FOOTER',FRONT.'footer.php');
define('TEXT_EDITOR',EDITOR.'setting.php');
define('TEXT_EDITOR2',EDITOR.'setting2.php');

//*************** System Included Files *****************//
define('PAGINATION',INC.'paging.php');
define('MAIL',INC.'mail.php');
define('DET_BROWSER',INC.'browser.php');

//************* Server Configs ***************//
include('vars.php');

//************ Connection File **************//
require(INC.'mysql.inc.php');

if ($main_page != 'yes'){
require(INC.'valid.php');}
require_once(INC."privs_func.php");
require_once(INC."util_func.php");

//************ Checking for page access rights **************//
//for ajax files we need to call referer
/*$script_name	= (strrpos($_SERVER["SCRIPT_NAME"], '/ajax_content/') === false) ? $_SERVER["SCRIPT_NAME"] : $_SERVER["HTTP_REFERER"];
//excluding login and home pages
if	( 
		(strrpos($script_name, 'admin/cloud_admin/index.php') === false) &&
		(strrpos($script_name, 'admin/cloud_admin/verify.php') === false) &&
		(strrpos($script_name, 'admin/cloud_admin/home.php') === false)
	)
{
	$parts			= Explode('/', $script_name);
	$menu_path		= $parts[count($parts) - 3] .'/'. $parts[count($parts) - 2] .'/';
	$current_file	= $parts[count($parts) - 1];
	$access_rights	= getAdminRights($_SESSION['type'], $_SESSION['usrId'], $menu_path, $current_file);
	if(!$access_rights[0])
	{
		if(strrpos($script_name, 'mark_invoice_pay') !== false || strrpos($script_name, 'recurring_payment') !== false)
		{
			echo "<script>alert('Access Denied');</script>";
			exit;
		}
		else if(strrpos($script_name, '/ajax_content/') === false) //preventing to redirect ajax pages
		{
			$url	= file_exists('../home.php') ? '../home.php' : '../../home.php';
			$url	.= '?err=Access denied!';
			header("location:".$url);
			exit;
		}
	}
}*/
?>