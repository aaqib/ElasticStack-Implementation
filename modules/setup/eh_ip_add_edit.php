<?php ob_start(); $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php");
require_once(INC."cleanpost.php"); require_once(INC."form_valid.php"); if(isAccessPriv('cms')){ isChildPriv('front_end');}
require_once(INC."eh_funcs.php");
eh_check_credentials();

$id				= $_GET['id'];
//$table		= 'eh_model';
//$pk_col		= 'id_model';
//$where		= $pk_col ." = '".$id."'";
$return_page	= 'eh_ip_all.php';

if(isset($_POST['act']) && $_POST['act'] != '')
{
	cleaning_2($_POST);
	extract($_POST);
	
	//validation
	$Form->ValidField($name,'empty','Enter IP Name.');$Form->iferror();

	$entry	= $Form->insert();
	
	if($entry==1) //if not validation error
	{
		$params	= array('name'=>$name);
		if($act == "add")
		{
			$info	= eh_create_resource('ip', $params);
			if(is_array($info))
			{
				$arr = array("type"=>"Elastichosts_IP", "activity"=>"Add Elastichosts IP <b>Name-".$info['name']."</b>", 'c_type'=>0, "id"=>$info['resource'], "client"=>$_SESSION['usrId']); addActivity($arr);
				header("Location:".$return_page);
				exit;
			}
			else
			{
				$msg	= $info;
			}
		}
		else if($act == "update")
		{
			$info	= eh_update_resource('ip', $ip, $params);
			if(is_array($info))
			{
				$arr = array("type"=>"Elastichosts_IP", "activity"=>"Update Elastichosts IP <b>Name-".$info['name']."</b>", 'c_type'=>0, "id"=>$info['resource'], "client"=>$_SESSION['usrId']); addActivity($arr);
				header("Location:".$return_page);
				exit;
			}
			else
			{
				$msg	= $info;
			}
		}
	}
}

$act	= ($id != '') ? 'update' : 'add';
if(isset($id) && $id != '')
{
	$result	= eh_get_resource_info('ip', $id);
}	
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANGUAGE;?>" />
<title><?=SITE_TITLE;?></title>
<?php $page_css ='inner'; $editor ='show'; require_once(HEAD); ?>
</head>
<body>
<?php require_once(HEADER); ?>
<!--Mid Content-->
<div id="container">
<?php require_once(NAVIGATION); ?>
<div id="searchbox"></div><br clear="all" />
<!--Mid Box Content-->
<div id="midbox"><div class="midbg1"><div class="midbg2">
<!--Left Panel-->
<?php require_once(LEFT_PANEL); ?>
<!--Right Panel-->
<div class="right-container"><div class="midcont-box"><div class="midcont-titbox">
<h1><?php  echo ($act == 'update') ? 'Update' : 'Create' ?> Elastic Hosts Static IP</h1></div><div class="midcont-contbox">

<div class="inr-detbox">
<form class="inr-frm" action="" method="post" enctype="multipart/form-data">
<?php if(isset($_POST['act']) && $_POST['act']!=""){ ?> 
<div class="inr-err-box"><?php  if($msg!=""){ echo $msg;}else echo $Form->ErrorString.$Form->ErrSufix;?></div><br clear="all" />
<?php } ?>
<div class="inr-note-box">
</div><br clear="all" />
<table class="inr-det-tab2" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="inr-det-row2" style='width:30%'>Name:</td>
<?php 
	$input_key	= 'name';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $result[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" /></td>
</tr>
<tr>

<tr>
<td colspan="2" class="inr-det-row6">
	<input class="inr-edit-btn3" type="submit" name="Submit" value="<?php  echo ($act == 'update') ? 'Update' : 'Add' ?>" />
	<input class="inr-edit-btn3" type="button" name="Submit" value="Back" onclick="window.location.href='<?php  echo $return_page; ?>'" />
</td>
</tr>
</table>
<input type="hidden" name="act" value="<?php  echo $act ?>" />
<input type="hidden" name="ip" value="<?php  echo $id ?>" />
</form>
</div>
</div></div><br clear="all" />
</div>
<!--Right Panel End-->
</div></div></div><br clear="all" /></div></div><br clear="all" />
<?php require_once(FOOTER); ?>
</body>
</html>