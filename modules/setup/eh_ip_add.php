<?php $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php");
require_once(INC."cleanpost.php"); require_once(INC."form_valid.php"); if(isAccessPriv('cms')){ isChildPriv('front_end');}
require_once(INC."eh_funcs.php");
eh_check_credentials();

$id				= $_GET['id'];

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
				$msg	= "<span style=color:green>IP successfully created!</span>";
				echo "<script> window.parent.fnUpdate('".$msg."', 'done') </script>";
			}
			else
			{
				$msg	= $info;
				echo "<script> window.parent.fnUpdate('".$msg."', 'error') </script>";
			}
		}
	}
	else
	{
		$msg	= $Form->ErrorString.$Form->ErrSufix;
		echo "<script> window.parent.fnUpdate('".$msg."', 'error') </script>";
	}
	exit;
}

$act	= ($id > 0) ? 'update' : 'add';
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
		});
	});
	
	function fnUpdate(sStatus, sType)
	{
		if(sType)
		{
			if(sType == 'error')
			{
				$('#loading').hide();
				$('.inr-err-box').html(sStatus);
			}
			else if(sType == 'done')
			{
				$('#loading').hide();
				$('.inr-err-box').html(sStatus);
				window.opener.fnUpdateIPs();
			}
		}	
	}
</script>
</head>
<body>
<iframe name='frmServer' style='display:none'></iframe>
<!--Mid Content-->
<div id="container">

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
    <td class="inr-det-row17" colspan="10">Add Static IP</td>
</tr>

<tr>
<td class="inr-det-row2" style='width:30%'>Name:</td>
<?php 
	$input_key	= 'name';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $result[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" /></td>
</tr>

<tr>
<td colspan="2" class="inr-det-row6">
	<input class="inr-edit-btn3" type="submit" name="Submit" value="<?php  echo ($act == 'update') ? 'Update' : 'Add' ?>" onclick="$('#loading').show();" />
</td>
</tr>
</table>
<input type="hidden" name="act" value="<?php  echo $act ?>" />
<input type="hidden" name="drive" value="<?php  echo $id ?>" />
</form>
</div>

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