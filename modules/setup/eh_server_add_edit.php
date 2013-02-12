<?php ob_start(); $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php");
require_once(INC."cleanpost.php"); require_once(INC."form_valid.php"); if(isAccessPriv('cms')){ isChildPriv('front_end');}
require_once(INC."eh_funcs.php");
eh_check_credentials();

$id				= $_GET['id'];
//$table		= 'eh_model';
//$pk_col		= 'id_model';
//$where		= $pk_col ." = '".$id."'";
$return_page	= 'eh_server_all.php';
$act			= ($id != '') ? 'update' : 'add';

if(isset($_POST['act']) && $_POST['act'] != '')
{
	//cleaning_2($_POST);
	extract($_POST);
	
	//validation
	$Form->ValidField($name,'empty','Enter Server Name.');$Form->iferror();
	$Form->ValidField($cpu,'empty','Enter CPU size.');$Form->iferror();
	if($act == 'add')
	{
		$Form->ValidField($mem,'empty','Enter Memory size.');$Form->iferror();
	}	

	$entry	= $Form->insert();
	
	if($entry==1) //if not validation error
	{
		$params	= array();
		foreach($_POST as $key=>$value)
		{
			if($value != '')
			{
				if($key == 'stop' || $key == 'act' || $key == 'server' || $key == 'old_models' || $key == 'old_vlans') continue;
				if(is_array($value))
					$value	= implode(' ', $value);
					
				$params[ $key ] = $value;
			}
			
			//unsetting values
			if($act == 'update')
			{
				for($i=1; $i<4; $i++) 
				{
					$curr_key	= 'nic:'.$i.':model';
					if($key == $curr_key)
					{
						if((strpos($old_models, $curr_key.',') !== false) && $value == '')
						{
							$params[ $key ] = null;
						}
					}	
					$curr_key	= 'nic:'.$i.':vlan';
					if($key == $curr_key)
					{
						if((strpos($old_vlans, $curr_key.',') !== false) && $value == '')
						{
							$params[ $key ] = null;
						}
					}	
				}	
			}		
		}
	
		if($act == "add")
		{
			$info	= eh_create_server($params, $_POST['stop']);
			if(strpos(strtolower($info), 'invalid') === false)
			{
				$arr = array("type"=>"Elastichosts_Server", "activity"=>"Add Elastichosts Server <b>Name-".$info['name']."</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
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
			$info	= eh_update_server($server, $params);
			if(strpos(strtolower($info), 'invalid') === false)
			{
				$arr = array("type"=>"Elastichosts_Server", "activity"=>"Update Elastichosts Server <b>Name-".$info['name']."</b>", 'c_type'=>0, "id"=>$id, "client"=>$_SESSION['usrId']); addActivity($arr);
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

if(isset($id) && $id != '')
{
	$server_result	= eh_get_server_info($id);
}
//var_dump($server_result);

$models	= getLoopData("* from eh_model");
//drives
$drives	= eh_info_all_drives();
if($drives) 
{
	$drive_results	= array();
	foreach($drives as $key => $value)
	{
		$result	= $value;
		array_push($drive_results, array($result['drive'], $result['name'], $result['tier']));
	}
}	
//servers
$servers	= eh_info_all_servers();
if($servers) 
{
	$server_results	= array();
	foreach($servers as $key => $value)
	{
		$result	= $value;
		array_push($server_results, array($result['server'], $result['name']));
	}
}
//ips
$ips	= eh_list_all_resources('ip');
if($ips) 
{
	$ip_results	= array();
	foreach($ips as $ip)
	{
		$result	= eh_get_resource_info('ip', $ip);
		array_push($ip_results, array($ip, $result['name']));
	}
}
//vlans
$vlans	= eh_list_all_resources('vlan');
if($vlans) 
{
	$vlan_results	= array();
	foreach($vlans as $vlan)
	{
		
		$result	= eh_get_resource_info('vlan', $vlan);
		array_push($vlan_results, array($vlan, $result['name']));
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANGUAGE;?>" />
<title><?=SITE_TITLE;?></title>
<?php $light_box = 'show'; $page_css ='inner'; $editor ='show'; require_once(HEAD); ?>
<script>
	$(function() {
		$('.js-select').change(function() {
			fnAssignValue();
		});
		
		$('.js-select').change();
		$('#popup').click(function() { popitup('eh_drive_add.php'); });
		$('#popup-ip').click(function() { popitup('eh_ip_add.php'); });
	});
	
	function fnAssignValue()
	{
		var sOptions	= '<option value="">:: Select Drive ::</option>';
		$('.js-select').each(function() {
			if($(this).val() != '')
			{
				//sOptions	+= "<option value='"+ $(this).val() +"'>"+ $(this).find('option:selected').text() +"</option>";
				var selected	= ($(this).attr('name') == '<?php  echo $server_result['boot'] ?>') ? 'selected' : '';
				sOptions	+= "<option value='"+ $(this).attr('name') +"' "+selected+">"+ $(this).attr('name') +"</option>";
			}	
		});

		fnCreateDropdownOptions('#slt-boot', sOptions);
	}
	
	function fnUpdateDrives()
	{
		var sURL	= 'eh_get_all_drive.php';
		var sParam	= '';
		$('#spnloader').show();
		jQuery.get(sURL, sParam, function(response)
		{
			$('#spnloader').hide();
			var sOptions	= '<option value="">:: Select Drive ::</option>';
			var oRows		= response.split('|')
			for(var i = 0; i < oRows.length; i++)
			{
				var oCols	= oRows[i].split(',');
				sOptions	+= "<option value='"+ oCols[0] +"'>"+ oCols[1] +"</option>";
			}
			
			$('.js-select').each(function() {
				fnCreateDropdownOptions($(this), sOptions);
			});
		});
	}
	
	function fnUpdateIPs()
	{
		var sURL	= 'eh_get_all_ip.php';
		var sParam	= '';
		$('#spnloader-ip').show();
		jQuery.get(sURL, sParam, function(response)
		{
			$('#spnloader-ip').hide();
			var sOptions	= '<option value="">:: Select DHCP ::</option><option value="auto">Auto</option><option value="0">None</option>';
			var oRows		= response.split('|')
			for(var i = 0; i < oRows.length; i++)
			{
				var oCols	= oRows[i].split(',');
				sOptions	+= "<option value='"+ oCols[0] +"'>"+ oCols[1] +"</option>";
			}
			
			$('#select-ip').each(function() {
				fnCreateDropdownOptions($(this), sOptions);
			});
		});
	}
	
	function fnCreateDropdownOptions(oSelect, sOptions)
	{
		$(oSelect).find('option').remove().end().append(sOptions);
	}
	
	function popitup(url) 
	{
		newwindow=window.open(url,'name','height=400,width=650,scrollbars=yes');
		if (window.focus) {newwindow.focus()}
		return false;
	}
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
<h1><?php  echo ($act == 'update') ? 'Update' : 'Create' ?> Elastic Hosts Server</h1></div><div class="midcont-contbox">

<div class="inr-detbox">
<form class="inr-frm" action="" method="post" enctype="multipart/form-data">
<?php if(isset($_POST['act']) && $_POST['act']!=""){ ?> 
<div class="inr-err-box"><?php  if($msg!=""){ echo $msg;}else echo $Form->ErrorString.$Form->ErrSufix;?></div><br clear="all" />
<?php } ?>
<div class="inr-note-box">
</div><br clear="all" />
<table class="inr-det-tab2" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="inr-det-row2" style='width:30%'>Server Name:</td>
<?php 
	$input_key	= 'name';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $server_result[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" /></td>
</tr>
<tr>
<td class="inr-det-row2" style='width:30%'>VNC Password:</td>
<?php 
	$input_key	= 'vnc:password';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $server_result[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" maxlength='8' /></td>
</tr>
<tr>
<td class="inr-det-row2" style='width:30%'>CPU:</td>
<?php 
	$input_key	= 'cpu';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : ((isset($server_result[$input_key]) && $server_result[$input_key] != '') ? $server_result[$input_key] : '');
?>
<td class="inr-det-row4">
	<input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" style='width:240px' /> MHz
</td>
</tr>

<?php  if($act == 'add' || $server_result['status'] == 'stopped') { //for edit purpose we need to hide options for active server ?>

<tr>
<td class="inr-det-row2" style='width:30%'>Memory:</td>
<?php 
	$input_key	= 'mem';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : ((isset($server_result[$input_key]) && $server_result[$input_key] != '') ? $server_result[$input_key] : '');
?>
<td class="inr-det-row4">
	<input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" style='width:240px' /> MB
</td>
</tr>
<?php  if($act == 'add') { ?>
<tr>
<td class="inr-det-row2" style='width:30%'>Create but stop:</td>
<?php 
	$input_key	= 'stop';
	$enc_array	= array('stopped'=>'Yes', ''=>'No');
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<?php  foreach($enc_array as $k=>$v) { ?>
		<option value='<?php  echo $k ?>'><?php  echo $v ?></option>
		<?php  } ?>
	</select>
</td>
</tr>
<?php  } ?>
<?php  
	if($drives) {
?>
<tr>
<td class="inr-det-row2" style='width:30%'>Avoid Drives:</td>
<td class="inr-det-row4">
	<?php  
		for($i=0; $i<count($drive_results); $i++)
		{
			$data	= $drive_results[$i];
			$checked	= "";
			if($act == 'add')
			{
				if($data[0] == $POST['avoid:drives'][$i])
					$checked	= "checked='checked'";
			}
			else
			{
				$oTemp	= explode(' ', $server_result['avoid:drives']);
				if(in_array($data[0], $oTemp))
					$checked	= "checked='checked'";
			}
			echo "<input type='checkbox' name='avoid:drives[]' value='".$data[0]."' ".$checked."> <b>" . $data[1] . "</b> (". $data[2] .") [ ". $data[0] ." ]<br>";
		}
	?>
</td>
</tr>
<?php  } ?>
<?php  
	if($drives) {
?>
<tr>
<td class="inr-det-row2" style='width:30%'>Avoid Servers:</td>
<td class="inr-det-row4">
	<?php 
		for($i=0; $i<count($server_results); $i++)
		{
			$data		= $server_results[$i];
			$checked	= "";
			if($act == 'add')
			{
				if($data[0] == $POST['avoid:servers'][$i])
					$checked	= "checked='checked'";
			}
			else
			{
				$oTemp	= explode(' ', $server_result['avoid:servers']);
				if(in_array($data[0], $oTemp))
					$checked	= "checked='checked'";
			}
			echo "<input type='checkbox' name='avoid:servers[]' value='".$data[0]."' ".$checked."> <b>" . $data[1] . "</b> [ ". $data[0] ." ]<br>";
		}
	?>
</td>
</tr>
<?php  } ?>
<tr>

<tr>
    <td class="inr-det-row17" colspan="10">Drive:</td>
</tr>

<tr>
	<td class="inr-det-row2">Add New Drive</td>
	<td class="inr-det-row4">
		[<a href='javascript:void(0)' id='popup'>Create New Drive</a>]
		[<a href='javascript:fnUpdateDrives()'>Refresh Drives</a>]
		<span id='spnloader' class='hide'>Please wait...</span>
	</td>
</tr>

<?php  
	$drives	= eh_list_all_drives(); 
	//if($drives) {
	
	$ide		= array('ide:0:0', 'ide:0:1', 'ide:1:0', 'block:0', 'block:1', 'block:2');
	foreach($ide as $v) {
	$input_key	= $v;
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $server_result[$input_key];
?>
	<tr>
	<td class="inr-det-row2" style='width:30%'><?php  echo $v ?>:</td>
	<td class="inr-det-row4">
		<select class="inr-edit-fld14 js-select" name="<?php  echo $v; ?>" style="margin:2px 0px 0px 0px; height:22px;">
			<option value=''>:: Select Drive ::</option>
			<?php  
				for($i=0; $i<count($drive_results); $i++)
				{
					$data		= $drive_results[$i];
					$selected	= ($data[0] == $input_val) ? "selected='selected'" : '';
					echo "<option value='".$data[0]."' ".$selected.">" . $data[1] . " (". $data[2] .")</option>";
				}
			?>
		</select>
	</td>
	</tr>
<?php  } //} ?>
<tr>
<td class="inr-det-row2" style='width:30%'>Boot From:</td>
<?php 
	$input_key	= 'boot';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $server_result[$input_key];
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" id='slt-boot' name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<option value="">:: Select Drive ::</option>
	</select>
</td>
</tr>
<tr>
    <td class="inr-det-row17" colspan="10">Network:</td>
</tr>
<tr>
<td class="inr-det-row2" style='width:30%'>Network Model:</td>
<?php 
	$input_key	= 'nic:0:model';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $server_result[$input_key];
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<option value="">:: Select Model ::</option>
		<?php  for($i=0; $i<count($models); $i++) { ?>
		<option value='<?php  echo $models[$i]['model_name'] ?>' <?php  echo ($models[$i]['model_name'] == $input_val) ? "selected='selected'" : '' ?>><?php  echo $models[$i]['model_name'] ?></option>
		<?php  } ?>
	</select>
</td>
</tr>
<tr>
<td class="inr-det-row2" style='width:30%'>Network IP:</td>
<?php 
	$input_key	= 'nic:0:dhcp';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $server_result[$input_key];
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" id="select-ip" style="margin:2px 10px 0px 0px; height:22px;">
		<option value="">:: Select DHCP ::</option>
		<option value="auto" <?php  echo ('auto' == $input_val) ? "selected='selected'" : '' ?>>Auto</option>
		<option value="0" <?php  echo ('0' == $input_val) ? "selected='selected'" : '' ?>>None</option>
		<?php  
			for($i=0; $i<count($ip_results); $i++)
			{
				$data		= $ip_results[$i];
				$selected	= ($data[0] == $input_val) ? "selected='selected'" : '';
				echo "<option value='".$data[0]."' ".$selected.">" . $data[1] . "</option>";
			}
		?>
	</select>
	
	[<a href='javascript:void(0)' id='popup-ip'>Add New Static IP</a>]
	[<a href='javascript:fnUpdateIPs()'>Refresh IP</a>]
	<span id='spnloader-ip' class='hide'>Please wait...</span>
</td>
</tr>
<?php 
	$old_models		= '';
	$old_vlans		= '';
	for($i=1; $i<4; $i++) {
?>
	<tr>
	<td class="inr-det-row2" style='width:30%'>Private Network <?= $i ?> Model:</td>
	<?php 
		$input_key		= 'nic:'.$i.':model';
		$input_val		= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $server_result[$input_key];
		if($server_result[$input_key] != '')
		{
			$old_models	.= $input_key.',';
		}	
	?>
	<td class="inr-det-row4">
		<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
			<option value="">:: Select Model ::</option>
			<?php  for($j=0; $j<count($models); $j++) { ?>
			<option value='<?php  echo $models[$j]['model_name'] ?>' <?php  echo ($models[$j]['model_name'] == $input_val) ? "selected='selected'" : '' ?>><?php  echo $models[$j]['model_name'] ?></option>
			<?php  } ?>
		</select>
	</td>
	</tr>
	<tr>
	<td class="inr-det-row2" style='width:30%'>Private Network <?= $i ?> VLAN:</td>
	<?php 
		$input_key	= 'nic:'.$i.':vlan';
		$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $server_result[$input_key];
		if(isset($server_result[$input_key]) && $server_result[$input_key] != '')
			$old_vlans	.= $input_key.',';
	?>
	<td class="inr-det-row4">
		<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
			<option value="">No private network VLAN</option>
			<?php  
				for($j=0; $j<count($vlan_results); $j++)
				{
					$data		= $vlan_results[$j];
					$selected	= ($data[0] == $input_val) ? "selected='selected'" : '';
					echo "<option value='".$data[0]."' ".$selected.">" . $data[1] . "</option>";
				}
			?>
		</select>
	</td>
	</tr>
<?php 	
	}
}	
?>
<tr>
<td colspan="2" class="inr-det-row6">
	<input class="inr-edit-btn3" type="submit" value="<?php  echo ($act == 'update') ? 'Update' : 'Add' ?>" />
	<input class="inr-edit-btn3" type="button" value="Back" onclick="window.location.href='<?php  echo $return_page; ?>'" />
</td>
</tr>
</table>
<input type="hidden" name="act" value="<?php  echo $act ?>" />
<?php  if($act == 'add') { ?>
<input type="hidden" name="vnc" value="auto" />
<input type="hidden" name="persistent" value="true" />
<?php  } ?>
<input type="hidden" name="server" value="<?php  echo $id ?>" />
<input type="hidden" name="old_models" value='<?php  echo $old_models ?>' />
<input type="hidden" name="old_vlans" value='<?php  echo $old_vlans ?>' />
</form>
</div>
</div></div><br clear="all" />
</div>
<!--Right Panel End-->
</div></div></div><br clear="all" /></div></div><br clear="all" />
<?php require_once(FOOTER); ?>
</body>
</html>