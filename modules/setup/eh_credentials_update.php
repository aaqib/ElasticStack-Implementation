<?php ob_start(); $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php");
require_once(INC."cleanpost.php"); require_once(INC."form_valid.php"); if(isAccessPriv('cms')){ isChildPriv('front_end');}
$msg	= $_GET['err'];
if(isset($_POST['act']) && $_POST['act'] != '')
{
	cleaning_2($_POST);
	extract($_POST);
	
	//validation
	$Form->ValidField($region_code,'empty','Select Region Name.');$Form->iferror();
	$Form->ValidField($user_name,'empty','Enter User Name.');$Form->iferror();
	$Form->ValidField($password,'empty','Enter Password.');$Form->iferror();
	$entry	= $Form->insert();
	
	if($entry==1) //if not validation error
	{
		$par	= array("username"=>$user_name,"password"=>$password,"next"=>"/accounts/profile/");
		$params	= preparePostFields($par);
		
		//checking if email domain is free
		include_once(INC.'simple_html_dom.php');
		// get DOM from URL or file
		$html	= file_get_html('https://'.$region_code.'.elastichosts.com/accounts/login/', $params);
		
		$cred	= array();
		// find all pre tags
		foreach($html->find('.uneditable-input') as $inp)
		{
			array_push($cred, $inp->innertext);
		}	
		
		if(count($cred) < 2)
		{
			$msg	= "<span style='color:red'>Unable to login</span>";
		}
		else
		{
			$msg	= "<span style='color:green'>Successfully Logged In.</span>";
			$_POST['user_name'] = $_POST['password'] = '';
			$_SESSION['eh_credentials']	= array('region_code'=>$region_code, 'user_uid'=>$cred[0], 'secret_key'=>$cred[1], 'email'=>$user_name);
			if(!empty($_SESSION['redirect_url']))
			{
				//header("Location:".$_SESSION['redirect_url']);
				//exit;
			}
		}	
	}
}

function preparePostFields($array) 
{
	$params = array();

	foreach ($array as $key => $value) 
	{
		$params[] = $key . '=' . urlencode($value);
	}
	return implode('&', $params);
}

$act		= 'update';
$regions	= getLoopData("* from eh_region");
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
<h1>Login Area</h1></div><div class="midcont-contbox">

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
<td class="inr-det-row2" style='width:30%'>Region Name:</td>
<?php 
	$input_key	= 'region_code';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $_SESSION[$input_key];
?>
<td class="inr-det-row4">
	<select class="inr-edit-fld14" name="<?php  echo $input_key; ?>" style="margin:2px 0px 0px 0px; height:22px;">
		<?php for($i=0; $i<count($regions); $i++){ ?>
		<option value="<?= $regions[$i]['region_code']; ?>" <?php if($regions[$i]['region_code'] == $input_val){ echo 'selected="selected"';  }?>><?= $regions[$i]['region_name']; ?> [<?= $regions[$i]['region_code']; ?>]</option>
		<?php } ?>
	</select>
</td>
</tr>
<tr class="child_fld2">
<td class="inr-det-row2">User Name:</td>
<?php 
	$input_key	= 'user_name';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $_SESSION[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld14" type="text" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" /></td>
</tr>
<tr class="child_fld2">
<td class="inr-det-row2">Password:</td>
<?php 
	$input_key	= 'password';
	$input_val	= (isset($_POST[$input_key]) && $_POST[$input_key] != '') ? $_POST[$input_key] : $_SESSION[$input_key];
?>
<td class="inr-det-row4"><input class="inr-edit-fld14" type="password" name="<?php  echo $input_key; ?>" value="<?php  echo $input_val; ?>" /></td>
</tr>
<tr>
<td colspan="2" class="inr-det-row6">
	<input class="inr-edit-btn3" type="submit" name="Submit" value="<?php  echo ($act == 'update') ? 'Update' : 'Add' ?>" />
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