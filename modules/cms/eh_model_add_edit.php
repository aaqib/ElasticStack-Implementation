<?php ob_start(); $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php");
require_once(INC."cleanpost.php"); require_once(INC."form_valid.php"); if(isAccessPriv('cms')){ isChildPriv('front_end');}

$id				= (int)base64_decode($_GET['id']);
$table			= 'eh_model';
$pk_col			= 'id_model';
$where			= $pk_col ." = '".$id."'";
$return_page	= 'eh_model_all.php';

if(isset($_POST['act']) && $_POST['act'] != '')
{
	cleaning_2($_POST);
	extract($_POST);
	
	//validation
	$Form->ValidField($model_name,'empty','Enter Model.');$Form->iferror();

	//checking if record alreay exist
	$where_exist	= "model_name='".$model_name."'";
	if($act == "add")
	{
		$rec_count	= getTotalRecords($table, $pk_col, $where_exist);
	}	
	else if($act == "update")
	{
		$where_exist	.= " and ". $pk_col ." <> '".$id."'";
		$rec_count		= getTotalRecords($table, $pk_col, $where_exist);
	}	

	if($rec_count > 0) { $Form->ValidField('','empty','Model already exists.'); $Form->iferror(); }
	
	$entry	= $Form->insert();
	
	if($entry==1) //if not validation error
	{
		if($act == "add")
		{
			$q = "INSERT INTO ".$table." SET model_name='$model_name'";
			if($sql = mysql_query($q))
			{
				$id = mysql_insert_id();
				$arr = array("type"=>"Elastichosts_Model", "activity"=>"Add Elastichosts Model <b>ID-$id</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
				header("Location:".$return_page);
			}
		}
		else if($act == "update")
		{
			$q = "UPDATE ".$table." SET model_name='$model_name' WHERE ".$where;
			if($sql = mysql_query($q)){
				$arr = array("type"=>"Elastichosts_Model", "activity"=>"Update Elastichosts Model <b>ID-$id</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
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
<h1><?php  echo ($act == 'update') ? 'Update' : 'Add' ?> Elastic Hosts Model</h1></div><div class="midcont-contbox">

<div class="inr-detbox">
<form class="inr-frm" action="" method="post" enctype="multipart/form-data">
<?php if(isset($_POST['act']) && $_POST['act']!=""){ ?> 
<div class="inr-err-box"><?php  if($msg!=""){ echo $msg;}else echo $Form->ErrorString.$Form->ErrSufix;?></div><br clear="all" />
<?php } ?>
<div class="inr-note-box">
</div><br clear="all" />
<table class="inr-det-tab2" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="inr-det-row2" style='width:30%'>Model:</td>
<?php 
	$input_key	= 'model_name';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $data[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" /></td>
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