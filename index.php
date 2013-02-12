<?php
/**
 * Copyright 2013 Cloudways Ltd.
 * Author Sarfraz Qasim
 * Contributor Aaqib Gadit
 * http://www.cloudways.com
 */
 
//including required files
$main_page='yes'; require_once("system/include/config.php"); require_once(INC."form_valid.php"); require_once(INC."mail.php");

//forgot password request
if($_POST['act'] == "forget")
{
	//validation
	$email = $_POST['email'];
	$Form->ValidField($email,'email','Please enter your E-mail address in correct Format', '');$Form->iferror(); 
	$entry=$Form->insert();
					
	if($entry==1)
	{
		//selecting details from admins table
		$q = "SELECT id, username, email FROM admins WHERE email='$email'"; $sql = mysql_query($q); $rws = mysql_num_rows($sql);

		if($rws > 0)
		{
			$row = mysql_fetch_array($sql);	
			$pass=rand(1111,9999); $pass1=md5($pass); //generating random password
			
			//updated password into db
			if(mysql_query("UPDATE admins SET password='$pass1' WHERE email='$email'"))
			{
				//sending email to admin
				$arr = array('name'=>$row['username'], 'email'=>$email, 'pass'=>$pass, 'lang'=>'en');
				sendMail('fpa', $arr); 
				$err = "<span>Your Password Successfully Update. Please Check your E-mail.</span>";
			}
		}
		else{ $err = 'Email does not Exist...'; }
	}
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANGUAGE;?>" />
<title><?=SITE_TITLE;?></title>
<?php require_once(HEAD); ?>
</head>
<body class="login-body">
<div class="lgn-mainbox">
<div class="lgn-titbox"><h2>Admin Login Panel</h2></div>
<div class="lgn-midbox">
<form action="verify.php" method="post">
<div class="lgn-inr-mainbox1">
<div class="lgn-inr-box1">Username:</div>
<div class="lgn-inr-box2"><input class="lgn-fld" type="text" name="username" /></div></div>
<div class="lgn-inr-mainbox1">
<div class="lgn-inr-box1">Password:</div>
<div class="lgn-inr-box2"><input class="lgn-fld" type="password" name="password" /></div></div>
<div class="lgn-inr-mainbox1">
<div class="lgn-inr-box3"><input class="lgn-btn" type="submit" name="Submit" value="Enter to Admin Panel" /></div></div>
<?php  if(isset($_GET['err'])){?><div class="lgn-inr-mainbox3"><?php  echo $_GET['err'];?></div><?php  } ?>
<div class="lgn-inr-mainbox2"><span>Your IP - [<b><?=$_SERVER['REMOTE_ADDR'];?></b>]</span><a href="#forgot-pass" onclick="javascript:fadeslide.toggle('forgot-pass')">Forgot your password?</a></div>
</form>
</div><div class="lgn-btmbox">&nbsp;</div></div>
<br clear="all" />


<?php if($_POST['act'] == "forget"){ $display = 'style="display:block"';} else { $display = '';}?>
<div class="lgn-mainbox2" id="forgot-pass"<?=$display;?>>
<div class="lgn-titbox2"><h2>Admin Login Panel</h2></div>
<div class="lgn-midbox">
<form action="#forgot-pass" method="post">
<div class="lgn-inr-mainbox1">
<div class="lgn-inr-box1">E-mail:</div>
<div class="lgn-inr-box2"><input class="lgn-fld" type="text" name="email" value="<?=$_POST['email'];?>" /></div></div>
<div class="lgn-inr-mainbox1">
<div class="lgn-inr-box3"><input class="lgn-btn2" type="submit" name="Submit" value="Enter to Admin Panel" /></div></div>
<?php if($_POST['act'] == "forget"){ ?>
<div class="lgn-inr-mainbox3"><?php if($err !="" ){echo $err;} else {echo $Form->ErrorString.$Form->ErrSufix;}?></div>
<?php } ?>
<input type="hidden" value="forget" name="act" />
</form>
</div><div class="lgn-btmbox">&nbsp;</div></div>

</body>
</html>