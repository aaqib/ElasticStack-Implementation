<?php ob_start(); $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php");
require_once(INC."cleanpost.php"); require_once(INC."form_valid.php"); if(isAccessPriv('cms')){ isChildPriv('front_end');}
require_once(INC."eh_funcs.php");
eh_check_credentials();

$msg	= $_GET['err'];
if(isset($_POST['act']) && $_POST['act'] != '')
{
	cleaning_2($_POST);
	extract($_POST);
	
	//validation
	$Form->ValidField($image,'empty','Select Image.');$Form->iferror();
	if($drive_type == '0')
	{
		$Form->ValidField($name,'empty','Enter Drive Name.');$Form->iferror();
		$Form->ValidField($size,'empty','Enter Drive Size.');$Form->iferror();
	}
	else
	{
		$Form->ValidField($drive,'empty','Select Drive.');$Form->iferror();
	}
	$entry	= $Form->insert();
	
	if($entry==1) //if not validation error
	{
		$params			= array('name'=>$name, 'size'=>$size.$unit);
		if($tier != '')
		{
			$params['tier']	= $tier;
		}
		$single_image	= getFieldsData('eh_image', 'image_type', "image_uid='". $image ."'");
		if($single_image['image_type'] == '1') //checking if using image uuid or image file
		{
			if($drive == '')
			{
				$info		= eh_create_drive($params);
				$drive		= $info['drive'];
			}
			if($image != '') //maping image to drive
			{
				$info	= eh_map_image($drive, $image, $encryption);
				if(strpos(strtolower($info), 'invalid') !== false || strpos(strtolower($info), 'failed') !== false)
				{
					$msg	= $info;
				}
				else
				{
					$arr = array("type"=>"Elastichosts_Drive", "activity"=>"Mapped EH Image with Drive <b>ID-$drive</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
					$msg	= "<span style='color:green'>Image successfully uploaded!</span>";
				}	
			}
			else { $msg	= "Image not found"; }
		}
		else
		{
			$file		= '../../eh_images/'.$image;
			if(file_exists($file))
			{
				if($drive == '')
				{
					$info		= eh_create_drive($params);
					$drive		= $info['drive'];
				}
			
				$limit		= 1024 * 1024 * 50; //50 MB
				$handle		= fopen($file, "rb");
				$counter	= 0;
				while (!feof($handle)) 
				{
					$contents	= fread($handle, $limit);
					$offset		= $limit * $counter;
					eh_write_drive_data($drive, $offset, $contents);
					$counter++;
				}
				fclose($handle);
				$arr = array("type"=>"Elastichosts_Drive", "activity"=>"Mapped Custom Image with Drive <b>ID-$drive</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
				$msg	= "<span style='color:green'>Image successfully uploaded!</span>";
			}
			else
			{
				$msg	= "Image file not found";
			}
		}	
	}
}

$act		= 'update';
$images		= eh_list_all_images();
$tiers		= array(''=>'Disk', 'ssd'=>'SSD');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANGUAGE;?>" />
<title><?=SITE_TITLE;?></title>
<?php $page_css ='inner'; $editor ='show'; require_once(HEAD); ?>
<script>
	$(function() {
		$('.js-drive-type').click(function() {
			if($(this).val() == '0')
			{
				$('.js-existing-drive').hide();
				$('.js-new-drive').show();
				$('#drive').val('');
			}
			else
			{
				$('.js-new-drive').hide();
				$('.js-existing-drive').show();
			}
		});
		$('.js-drive-type').each(function() {
			if($(this).is(':checked'))
			{
				$(this).click();
			}
		});
	});
</script>
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
<h1>Upload Drive</h1></div><div class="midcont-contbox">

<div class="inr-detbox">
<form class="inr-frm" action="" method="post" enctype="multipart/form-data">
<?php if(isset($_POST['act']) && $_POST['act']!=""){ ?> 
<div class="inr-err-box"><?php  echo $Form->ErrorString.$Form->ErrSufix; ?></div><br clear="all" />
<?php } ?>
<div class="inr-err-box"><?php  if($msg!=""){ echo $msg; } ?></div><br clear="all" />
<div class="inr-note-box">
</div><br clear="all" />
<table class="inr-det-tab2" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td class="inr-det-row17" colspan="10">Read From:</td>
</tr>
<tr>
<td class="inr-det-row2" style='width:30%'>Map Image:</td>
<?php 
	$input_key	= 'image';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $data[$input_key];
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" id="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<option value=''>:: Select Image ::</option>
		<?php for($i=0; $i<count($images); $i++){ ?>
		<option value="<?= $images[$i]['image_uid']; ?>" <?php if($images[$i]['image_uid'] == $input_val){ echo 'selected="selected"';  }?>><?= $images[$i]['image_name']; ?></option>
		<?php } ?>
	</select>
</td>
</tr>
<tr>
<td class="inr-det-row2">Encryption:</td>
<?php 
	$input_key	= 'encryption';
	$enc_array	= array(''=>'None', 'gunzip'=>'Gunzip', 'gzip'=>'Gzip');
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<?php  foreach($enc_array as $k=>$v) { ?>
		<option value='<?php  echo $k ?>' <?php  echo ($k == $_POST[$input_key]) ? "selected='selected'" : '' ?>><?php  echo $v ?></option>
		<?php  } ?>
	</select>
</td>
</tr>
<tr>
    <td class="inr-det-row17" colspan="10">Write To:</td>
</tr>
<tr>
<td class="inr-det-row2">Drive Type:</td>
<td class="inr-det-row4">
	<?php 
		$input_key	= 'drive_type';
		$drive_type	= array('0'=>'New Drive', '1'=>'Existing Drive');
		$counter	= 0;
		foreach($drive_type as $key => $value)
		{
			$checked	= (isset($_POST[$input_key]) && $_POST[$input_key] == $key) ? "checked='checked'" : (($counter == 0) ? "checked='checked'" : '');
			echo "&nbsp;<input type='radio' name='".$input_key."' class='js-drive-type' value='". $key ."' ".$checked."> " . $value;
			$counter++;
		}
	?>
</td>
</tr>
<tr class='js-new-drive'>
<td class="inr-det-row2">Drive Name:</td>
<?php 
	$input_key	= 'name';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : '';
?>
<td class="inr-det-row4"><input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" /></td>
</tr>
<tr class='js-new-drive'>
<td class="inr-det-row2" style='width:30%'>Size:</td>
<?php 
	$input_key	= 'size';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : '';
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
<td class="inr-det-row2">Type:</td>
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
<?php  
	$drives	= eh_info_all_drives();
	if($drives) {
		$input_key	= 'drive';
		$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $data[$input_key];
?>
<tr class='js-existing-drive'>
<td class="inr-det-row2">Existing Drive:</td>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" id="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<option value=''>:: Select Drive ::</option>
		<?php  
			foreach($drives as $key => $value)
			{
				$result		= $value;
				$selected	= ($result['drive'] == $input_val) ? "selected='selected'" : '';
				echo "<option value='". $result['drive'] ."' ".$selected.">". $result['name'] ." (". $result['tier'] .")</option>";
			}
		?>
	</select>	
</td>
</tr>
<?php  } ?>
<tr>
<td colspan="2" class="inr-det-row6">
	<input class="inr-edit-btn3" type="submit" name="Submit" value="Upload" onclick="$('#loading').show();" />
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

<!--Loader-->
<div id="loading" class="hide"><div class="load-box"><div class="load-anim"></div></div></div>
<!--Loader-->

<?php require_once(FOOTER); ?>
</body>
</html>