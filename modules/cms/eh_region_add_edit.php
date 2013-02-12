<?php ob_start(); $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php");
require_once(INC."cleanpost.php"); require_once(INC."form_valid.php"); if(isAccessPriv('cms')){ isChildPriv('front_end');}

$id				= (int)base64_decode($_GET['id']);
$table			= 'eh_region';
$pk_col			= 'id_region';
$where			= $pk_col ." = '".$id."'";
$return_page	= 'eh_region_all.php';

if(isset($_POST['act']) && $_POST['act'] != '')
{
	cleaning_2($_POST);
	extract($_POST);
	
	//validation
	$Form->ValidField($region_name,'empty','Enter Region Name.');$Form->iferror();
	$Form->ValidField($region_code,'empty','Enter Region Code.');$Form->iferror();

	//checking if record alreay exist
	$where_exist	= "region_code='".$region_code."'";
	if($act == "add")
	{
		$rec_count	= getTotalRecords($table, $pk_col, $where_exist);
	}	
	else if($act == "update")
	{
		$where_exist	.= " and ". $pk_col ." <> '".$id."'";
		$rec_count		= getTotalRecords($table, $pk_col, $where_exist);
	}	

	if($rec_count > 0) { $Form->ValidField('','empty','Region already exists.'); $Form->iferror(); }
	
	$entry	= $Form->insert();
	
	if($entry==1) //if not validation error
	{
		if($act == "add")
		{
			$q = "INSERT INTO ".$table." SET region_name='$region_name', region_code='$region_code', server_region='$server_region'";
			if($sql = mysql_query($q))
			{
				$id = mysql_insert_id();
				$arr = array("type"=>"Elastichosts_Region", "activity"=>"Add Elastichosts Region <b>ID-$id</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
				header("Location:".$return_page);
			}
		}
		else if($act == "update")
		{
			$q = "UPDATE ".$table." SET region_name='$region_name', region_code='$region_code', server_region='$server_region' WHERE ".$where;
			if($sql = mysql_query($q)){
				$arr = array("type"=>"Elastichosts_Region", "activity"=>"Update Elastichosts Region <b>ID-$id</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
				header("Location:".$return_page);
			}
			else
			{
				die(mysql_error());
			}
		}
	}
}

$act	= ($id > 0) ? 'update' : 'add';
$data	= getFieldsData($table, '*', $where);
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
<h1><?php  echo ($act == 'update') ? 'Update' : 'Add' ?> Elastic Hosts Region</h1></div><div class="midcont-contbox">

<div class="inr-detbox">
<form class="inr-frm" action="" method="post" enctype="multipart/form-data">
<?php if(isset($_POST['act']) && $_POST['act']!=""){ ?> 
<div class="inr-err-box"><?php  if($msg!=""){ echo $msg;}else echo $Form->ErrorString.$Form->ErrSufix;?></div><br clear="all" />
<?php } ?>
<div class="inr-note-box">
</div><br clear="all" />
<table class="inr-det-tab2" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="inr-det-row2" style='width:30%'>Region Name:</td>
<?php 
	$input_key	= 'region_name';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $data[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld4" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" style='width:300px' /></td>
</tr>
<tr>
<td class="inr-det-row2">Region Code:</td>
<?php 
	$input_key	= 'region_code';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $data[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld4" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" style='width:300px' /></td>
</tr>
<tr>
<td class="inr-det-row2">Server Region:</td>
<?php 
	$input_key	= 'server_region';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $data[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld4" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" style='width:300px' /></td>
</tr>
<tr>
<td colspan="2" class="inr-det-row6">
	<input class="inr-edit-btn3" type="submit" name="Submit" value="<?php  echo ($act == 'update') ? 'Update' : 'Add' ?>" />
	<input class="inr-edit-btn3" type="button" name="Submit" value="Back" onclick="window.location.href='<?php  echo $return_page; ?>'" />
</td>
</tr>
</table>
<input type="hidden" name="act" value="<?php  echo $act ?>" />
</form>
</div>
</div></div><br clear="all" />
</div>
<!--Right Panel End-->
</div></div></div><br clear="all" /></div></div><br clear="all" />
<?php require_once(FOOTER); ?>
</body>
</html>