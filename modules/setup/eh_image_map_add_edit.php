<?php ob_start(); $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php");
require_once(INC."cleanpost.php"); require_once(INC."form_valid.php"); if(isAccessPriv('cms')){ isChildPriv('front_end');}
require_once(INC."eh_funcs.php");
eh_check_credentials();

$id				= $_GET['id'];
//$table		= 'eh_model';
//$pk_col		= 'id_model';
//$where		= $pk_col ." = '".$id."'";
$return_page	= 'eh_drive_all.php';

if(isset($_POST['act']) && $_POST['act'] != '')
{
	cleaning_2($_POST);
	extract($_POST);
	
	//validation
	//validation
	$Form->ValidField($name,'empty','Enter Drive Name.');$Form->iferror();
	$Form->ValidField($size,'empty','Enter Drive Size.');$Form->iferror();
	$Form->ValidField($image,'empty','Select Image.');$Form->iferror();

	$entry	= $Form->insert();
	
	if($entry==1) //if not validation error
	{
		if($act == "update")
		{
			$params	= array('name'=>$name, 'size'=>$size.$unit);
			if($tier != '')
			{
				$params['tier']	= $tier;
			}
			$info	= eh_create_drive($params);
		
			eh_map_image($info['drive'], $image, $encryption);
			$arr = array("type"=>"Elastichosts_Image_Map", "activity"=>"Elastichosts Clone Drive <b>ID-".$info['name']."</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
			header("Location:".$return_page);
			exit;
		}
	}
}

$act	= 'update';
$images	= eh_list_all_images();
$tiers	= array(''=>'Disk', 'ssd'=>'SSD');
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
<h1>Elastic Hosts Clone Drive Image</h1></div><div class="midcont-contbox">

<div class="inr-detbox">
<form class="inr-frm" action="" method="post" enctype="multipart/form-data">
<?php if(isset($_POST['act']) && $_POST['act']!=""){ ?> 
<div class="inr-err-box"><?php  if($msg!=""){ echo $msg;}else echo $Form->ErrorString.$Form->ErrSufix;?></div><br clear="all" />
<?php } ?>
<div class="inr-note-box">
</div><br clear="all" />
<table class="inr-det-tab2" border="0" cellspacing="0" cellpadding="0">

<tr>
<td class="inr-det-row2" style='width:30%'>Drive Name:</td>
<?php 
	$input_key	= 'name';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $result[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" /></td>
</tr>
<tr>
<td class="inr-det-row2" style='width:30%'>Size:</td>
<?php 
	$input_key	= 'size';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : ((isset($result['size']) && $result['size'] != '') ? ($result['size'] / 1024 / 1024 / 1024) : '');
?>
<td class="inr-det-row4">
	<input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" style='width:240px' />
	<select class="inr-edit-fld11" name="unit" style="margin:0px 0px 0px 5px; height:22px; width:50px">
		<option value='G'>GB</option>
		<option value='M'>MB</option>
		<option value='k'>KB</option>
	</select>
</td>
</tr>
<tr>
<td class="inr-det-row2" style='width:30%'>Type:</td>
<?php 
	$input_key	= 'tier';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $data[$input_key];
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<?php foreach($tiers as $key=>$value){ ?>
		<option value="<?= $key; ?>" <?php if($key == $input_val){ echo 'selected="selected"';  }?>><?= $value; ?></option>
		<?php } ?>
	</select>
</td>
</tr>

<tr>
<td class="inr-det-row2" style='width:30%'>Image:</td>
<?php 
	$input_key	= 'image';
	$input_val	= $_POST[$input_key];
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<option value=''>:: Select Image ::</option>
		<?php  
			$drives	= eh_info_all_drives();
			if($drives) 
			{
				foreach($drives as $key => $value)
				{
					$result		= $value;
					$selected	= ($result['drive'] == $input_val) ? "selected='selected'" : '';  
					echo "<option value='".$result['drive']."' ".$selected.">".$result['name']." (".$result['tier'].") [Drive]</option>";
				}
			}
			for($i=0; $i<count($images); $i++)
			{
				$selected	= ($images[$i]['image_uid'] == $input_val) ? "selected='selected'" : '';  
				echo "<option value='". $images[$i]['image_uid'] ."' ".$selected.">". $images[$i]['image_name'] ." [Image]</option>";
			}
		?>
	</select>
</td>
</tr>
<tr>
<td class="inr-det-row2" style='width:30%'>Encryption:</td>
<?php 
	$input_key	= 'encryption';
	$input_val	= $_POST[$input_key];
	$enc_array	= array(''=>'None', 'gunzip'=>'Gunzip', 'gzip'=>'Gzip');
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<?php  foreach($enc_array as $k=>$v) { ?>
		<option value='<?php  echo $k ?>'><?php  echo $v ?></option>
		<?php  } ?>
	</select>
</td>
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