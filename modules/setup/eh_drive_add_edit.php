<?php $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php");
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
	//cleaning_2($_POST);
	extract($_POST);
	
	//validation
	$Form->ValidField($name,'empty','Enter Drive Name.');$Form->iferror();
	$Form->ValidField($size,'empty','Enter Drive Size.');$Form->iferror();

	$entry	= $Form->insert();
	
	if($entry==1) //if not validation error
	{
		$params		= array('name'=>$name, 'size'=>$size.$unit);
		if($tier != '')
		{
			$params['tier']	= $tier;
		}
		if($act == "add")
		{
			if(count($aviod) > 0)
			{
				$params['avoid'] = implode(' ', $aviod);
			}
			$info	= eh_create_drive($params); //creating drive
			if(is_array($info))
			{
				$drive	= $info['drive'];
				if($image != '') //maping image to drive
				{
					$eh_image	= getFieldsData('eh_image', 'image_type', "image_uid='". $image ."'");
					if($eh_image['image_type'] == '1') //if Elasctic hosts image
					{
						$info	= eh_map_image($drive, $image, $encryption);
						echo "<script> window.parent.fnUpdate('Done') </script>";
					}
					else
					{
						$file		= '../../eh_images/'.$image;
						if(file_exists($file))
						{
							eh_write_drive_custom_image($file, $drive);
							$arr = array("type"=>"Elastichosts_Drive", "activity"=>"Mapped Custom Image with Drive <b>ID-$drive</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
							//$msg	= "<span style='color:green'>Image successfully uploaded!</span>";
							echo "<script> window.parent.fnUpdate('Done') </script>";
						}
						else
						{
							$msg	= "Image file not found";
							echo "<script> window.parent.fnUpdate('".$msg."', 'error') </script>";
						}
					}
				}
				else if(is_array($info))
				{
					$arr = array("type"=>"Elastichosts_Drive", "activity"=>"Add Elastichosts Drive <b>ID-$drive</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
					//header("Location:".$return_page);
					//exit;
					//$msg	= "true";
					echo "<script> window.parent.fnUpdate('Done') </script>";
				}
				else
				{
					$msg	= $info;
					echo "<script> window.parent.fnUpdate('".$msg."', 'error') </script>";
				}
			}
			else
			{
				$msg	= $info;
				echo "<script> window.parent.fnUpdate('".$msg."', 'error') </script>";
			}
		}
		else if($act == "update")
		{
			$info	= eh_update_drive($drive, $params);
			if(is_array($info))
			{
				if(strpos($info, 'invalid') === false)
				{
					$arr = array("type"=>"Elastichosts_Drive", "activity"=>"Update Elastichosts Drive <b>ID-$drive</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
					//header("Location:".$return_page);
					//exit;
					//$msg	= "true";
					echo "<script> window.parent.fnUpdate('Done') </script>";
				}
				else
				{
					$msg	= $info;
					echo "<script> window.parent.fnUpdate('".$msg."', 'error') </script>";
				}
			}
			else
			{
				$msg	= $info;
				echo "<script> window.parent.fnUpdate('".$msg."', 'error') </script>";
			}
		}
		//echo $msg;
	}
	else
	{
		//echo $Form->ErrorString.$Form->ErrSufix;
		echo "<script> window.parent.fnUpdate('". $Form->ErrorString.$Form->ErrSufix ."', 'error') </script>";
	}
	exit;
}

$act	= ($id > 0) ? 'update' : 'add';
$images	= eh_list_all_images();
if(isset($id) && $id != '')
{
	$result	= eh_get_drive_info($id);
}
$tiers	= array(''=>'Disk', 'ssd'=>'SSD');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANGUAGE;?>" />
<title><?=SITE_TITLE;?></title>
<?php $page_css ='inner'; $editor ='show'; require_once(HEAD); ?>
<script>
	$(function() {
		$('#submit').click(function() {
			$('#loading').show();
			$('.inr-err-box').html('');
			/*var data	= $('#frm-admin').serialize();
			jQuery.post('eh_drive_add_edit.php', data, function(response) {
				if(response == 'true')
				{
					window.location.href = '<?php  echo $return_page ?>';
				}
				else
				{
					$('.inr-err-box').html(response);
				}	
				$('#loading').hide();
			});*/
		});
	});
	
	function fnUpdate(sStatus, sType)
	{
		if(sType)
		{
			$('#loading').hide();
			$('.inr-err-box').html(sStatus);
		}
		else
		{
			if(sStatus == 'Done')
			{
				window.location.href = '<?php  echo $return_page ?>';
			}
			else
			{
				$('#load-status').html(sStatus);
			}	
		}	
	}
</script>
</head>
<body>
<iframe name='frmServer' style='display:none'></iframe>
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
<h1><?php  echo ($act == 'update') ? 'Update' : 'Create' ?> Elastic Hosts Drive</h1></div><div class="midcont-contbox">

<div class="inr-detbox">
<form class="inr-frm" id="frm-admin" action="" method="post" target='frmServer' enctype="multipart/form-data">
<?php if(isset($_POST['act']) && $_POST['act']!=""){ ?> 
<div class="inr-err-box"><?php  if($msg!=""){ echo $msg;}else echo $Form->ErrorString.$Form->ErrSufix;?></div><br clear="all" />
<?php } ?>
<div class="inr-err-box"></div><br clear="all" />
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
<?php  if($act == 'add') { ?>
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
<td class="inr-det-row2" style='width:30%'>Map Image:</td>
<?php 
	$input_key	= 'image';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $data[$input_key];
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<option value=''>:: Select Image ::</option>
		<?php for($i=0; $i<count($images); $i++){ ?>
		<option value="<?= $images[$i]['image_uid']; ?>" <?php if($images[$i]['id_image'] == $input_val){ echo 'selected="selected"';  }?>><?= $images[$i]['image_name']; ?> [<?php  echo ($images[$i]['image_type'] == '1') ? 'EH Image' : 'Custom Image' ?>]</option>
		<?php } ?>
	</select>
</td>
</tr>
<tr>
<td class="inr-det-row2" style='width:30%'>Encryption:</td>
<?php 
	$input_key	= 'encryption';
	$enc_array	= array('gunzip'=>'Gunzip', 'gzip'=>'Gzip', ''=>'None');
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<?php  foreach($enc_array as $k=>$v) { ?>
		<option value='<?php  echo $k ?>'><?php  echo $v ?></option>
		<?php  } ?>
	</select> (Will not effect on Custom Images)
</td>
</tr>
<?php  
	$drives	= eh_info_all_drives(); 
	if($drives) {
?>
<tr>
<td class="inr-det-row2" style='width:30%'>Avoid Drives:</td>
<td class="inr-det-row4">
	<?php  
		foreach($drives as $key => $value)
		{
			$result		= $value;
			echo "<input type='checkbox' name='aviod[]' value='".$result['drive']."'> <b>" . $result['name'] . "</b> (". $result['tier'] .") [ ". $result['drive'] ." ]<br>";
		}
	?>
</td>
</tr>
<?php  } } ?>
<tr>
<td colspan="2" class="inr-det-row6">
	<input class="inr-edit-btn3" type="submit" id="submit" name="Submit" value="<?php  echo ($act == 'update') ? 'Update' : 'Add' ?>" />
	<input class="inr-edit-btn3" type="button" name="Submit" value="Back" onclick="window.location.href='<?php  echo $return_page; ?>'" />
</td>
</tr>
</table>
<input type="hidden" name="act" value="<?php  echo $act ?>" />
<input type="hidden" name="drive" value="<?php  echo $id ?>" />
</form>
</div>
</div></div><br clear="all" />
</div>
<!--Right Panel End-->
</div></div></div><br clear="all" /></div></div><br clear="all" />
<?php require_once(FOOTER); ?>

<!--Loader-->
<div id="loading" class="hide">
<div class="load-box">
	<div class="load-anim"></div>
	<br style="clear:both">
	<div style="background-color:#3b3b3b;text-align:center;margin-left:-25px;width:80px;margin-top:9px;color:#fff;font-weight:bold" id="load-status">PLEASE WAIT</div>
</div>
</div>
<!--Loader-->
</body>
</html>