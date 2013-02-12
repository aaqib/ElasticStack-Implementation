<?php $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php");
require_once(INC."cleanpost.php"); require_once(INC."form_valid.php"); if(isAccessPriv('cms')){ isChildPriv('front_end');}
require_once(INC."eh_funcs.php");
eh_check_credentials();

$id				= base64_decode($_GET['id']);
$ip				= $_GET['ip'];
$server_roles	= getLoopData("* from eh_server_role");
$server_regions	= getLoopData("server_region from eh_region where region_code = '".$_SESSION['eh_credentials']['region_code']."'");

if(isset($_POST['act']) && $_POST['act'] != '')
{
	cleaning_2($_POST);
	extract($_POST);
	
	//validation
	$Form->ValidField($server_role,'empty','Select Server Role.');$Form->iferror();
	$Form->ValidField($server_region,'empty','Select Server Region.');$Form->iferror();
	//$Form->ValidField($fqdn,'empty','Enter FQDN.');$Form->iferror();

	$entry	= $Form->insert();
	
	if($entry==1) //if not validation error
	{
		$server		= eh_get_server_info($id);
		$server_ip	= $server['nic:0:dhcp:ip']; //server ip
		
		/*echo EH_LOCAL_SCRIPTS_PATH.' = EH_LOCAL_SCRIPTS_PATH<br>';
		echo EH_LOCAL_KEYS_PATH.' = EH_LOCAL_KEYS_PATH<br>';
		echo EH_REMOTE_PATH.' = EH_REMOTE_PATH<br>';
		echo EH_REMOTE_SCRIPT.' = EH_REMOTE_SCRIPT<br>';
		echo EH_LOCAL_SCRIPT.' = EH_LOCAL_SCRIPT<br>';
		echo EH_KEY_NAME.' = EH_KEY_NAME<br>';*/
		
		//defining variables
		define('LOCAL_SCRIPTS_PATH', EH_LOCAL_SCRIPTS_PATH);
		define('LOCAL_KEYS_PATH', EH_LOCAL_KEYS_PATH);
		
		define('REMOTE_PATH', EH_REMOTE_PATH);
		$remote_script	= EH_REMOTE_SCRIPT;
		$local_script	= EH_LOCAL_SCRIPT;
		$key_name		= EH_KEY_NAME;
		
		include(SSH.'Net/SFTP.php');
		include(SSH.'Crypt/RSA.php');
		
		//FILE UPLOADING
		$sftp = new Net_SFTP($server_ip);
		$key = new Crypt_RSA();
		$key->loadKey(file_get_contents(LOCAL_KEYS_PATH.$key_name)); //loading key
		if (!$sftp->login('root', $key)) //connecting to server for SFTP
		{
			//exit('Login Failed');
			$msg	= "Unable to connect with Server for SFTP";
		}
		else
		{
			$sftp->put($remote_script, LOCAL_SCRIPTS_PATH.$local_script, NET_SFTP_LOCAL_FILE); //uploading file using SFTP
			//var_dump($sftp->nlist());
			if($sftp->nlist()) //if file successfully uploaded
			{
				//rename(REMOTE_PATH.'.'.$remote_script, REMOTE_PATH.$remote_script); //rename file name
				if(file_exists(REMOTE_PATH.$remote_script)) unlink(REMOTE_PATH.$remote_script);
				$sftp->rename(REMOTE_PATH.'.'.$remote_script, REMOTE_PATH.$remote_script);

				//SSH FOR EXECUTE COMMAND
				//include('Net/SSH2.php');
				$ssh = new Net_SSH2($server_ip); //new server IP
				$key = new Crypt_RSA();
				$key->loadKey(file_get_contents(LOCAL_KEYS_PATH.$key_name)); //loading key
				if (!$ssh->login('root', $key)) 
				{
					//exit('Login Failed');
					$msg	= "Unable to connect with Server for SSH";
				}
				else
				{
					//$exec_url	= '/var/.puppet_test7.sh -r cloudways -c Elastichosts -R "uk test" -p abc -h inputfromadmin';
					$exec_url	= REMOTE_PATH.$remote_script . ' -r '.$server_role.' -c Elastichosts -R "'.$server_region.'" -p '.$server_password.' -h "'.$fqdn.'"';
				
					//echo $exec_url;
					//exit;

					$ssh->exec('chmod 0755 '.REMOTE_PATH.$remote_script);
					echo '<pre>';
					echo htmlentities($ssh->exec($exec_url), ENT_QUOTES);
					echo '</pre>';
					//option for p are PASS and NOPASS ( drop down )
					//echo $ssh->exec('ls -la');
					//echo "Execution Over <br>";
					//$msg	= "<span style=color:green>Script successfully executed!</span>";
				}	
			}
			else
			{
				$msg	= "Uable to upload script";
			}
		}	
	}
}

$act	= ($id > 0) ? 'update' : 'add';
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANGUAGE;?>" />
<title><?=SITE_TITLE;?></title>
<?php $page_css ='inner'; $editor ='show'; require_once(HEAD); ?>
</head>
<body>
<iframe name='frmServer' style='display:none'></iframe>
<!--Mid Content-->
<div id="container">

<div class="inr-detbox">
<form class="inr-frm" id="frm-admin" action="" method="post">
<?php if(isset($_POST['act']) && $_POST['act']!=""){ ?> 
<div class="inr-err-box"><?php  if($msg!=""){ echo $msg;}else echo $Form->ErrorString.$Form->ErrSufix;?></div><br clear="all" />
<?php } ?>
<div class="inr-err-box"></div><br clear="all" />
<div class="inr-note-box">
</div><br clear="all" />
<table class="inr-det-tab2" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td class="inr-det-row17" colspan="10">Upload Script</td>
</tr>

<?php  if(@test_port($ip, $port=22, $timeout=20)) { ?>

<tr>
<td class="inr-det-row2">Server Role:</td>
<?php 
	$input_key	= 'server_role';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $data[$input_key];
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<option value=''>:: Select Server Role ::</option>
		<?php for($i=0; $i<count($server_roles); $i++){ $value = $server_roles[$i]['role_name']; ?>
		<option value="<?= $value; ?>" <?php if($value == $input_val){ echo 'selected="selected"';  }?>><?= $value; ?></option>
		<?php } ?>
	</select>
</td>
</tr>

<tr>
<td class="inr-det-row2">Server Region:</td>
<?php 
	$input_key	= 'server_region';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $data[$input_key];
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<option value=''>:: Select Server Region ::</option>
		<?php for($i=0; $i<count($server_regions); $i++){ $value = $server_regions[$i]['server_region']; if($value != '') { ?>
		<option value="<?= $value; ?>" <?php if($value == $input_val){ echo 'selected="selected"';  }?>><?= $value; ?></option>
		<?php } } ?>
	</select>
</td>
</tr>

<tr>
<td class="inr-det-row2">Server Password:</td>
<?php 
	$input_key	= 'server_password';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $data[$input_key];
?>
<td class="inr-det-row4">
	<input type='radio' name="<?php  echo $input_key; ?>" value="PASS" checked='checked'> PASS
	<input type='radio' name="<?php  echo $input_key; ?>" value="NOPASS"> NOPASS
</td>
</tr>

<tr>
<td class="inr-det-row2" style='width:30%'>FQDN:</td>
<?php 
	$input_key	= 'fqdn';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $server_result[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" maxlength='100' /></td>
</tr>

<tr>
<td colspan="2" class="inr-det-row6">
	<input class="inr-edit-btn3" type="submit" name="Submit" value="Upload" />
</td>
</tr>

<?php  } else { ?>

<tr>
<td colspan="2" class="inr-det-row6">
	<div class="inr-err-box">Unable to connect with TCP port 22</div><br clear="all" />
</td>
</tr>

<?php  } ?>

</table>
<input type="hidden" name="act" value="<?php  echo $act ?>" />
<input type="hidden" name="drive" value="<?php  echo $id ?>" />
</form>
</div>


</body>
</html>
