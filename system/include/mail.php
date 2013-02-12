<?php 
function sendMail($code, $replace)
{
	//Fetching System Default Email Address
	$q_1 = mysql_query("SELECT default_email FROM system_configuration WHERE id='1'");
	$row_1 = mysql_fetch_array($q_1);

	//Fetching Email Template According to User Selected Language 
	$q_2="select subject, message from notifications where code='$code' and language='$replace[lang]'"; 
	$sql_2=mysql_query($q_2); 
	$tot_rws=mysql_num_rows($sql_2);

	if($tot_rws==0)
	{
		$q_3="SELECT nt.subject, nt.message FROM notifications nt INNER JOIN languages lang ON lang.code=nt.language WHERE lang.default_lang='1' LIMIT 1"; 
		$sql_2 = mysql_query($q_3);
	}
	
	$row=mysql_fetch_array($sql_2);
	$to = $replace['email'];
	$subject = $row['subject'];
	$msg = $row['message'];
	foreach($replace as $k=>$v)
	{
		$subject = str_replace("$".$k, $v, $subject);
		$msg = str_replace('$'.$k, $v, $msg);
	}
	$message = $msg;
	$headers = 'From: Cloudways <'.$row_1['default_email'].'>' . "\r\n" .
		'Reply-To: '.$row_1['default_email'].'' . "\r\n" .
		'MIME-Version: 1.0' . "\r\n" .
		'Content-type: text/html; charset=utf-8' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		
	//adding email log
	$q	= "INSERT INTO email_log SET email='$to', sent_on=NOW(), subject='$subject', content='".mysql_escape_string($message)."'";
	$sql	= @mysql_query($q);	

	//sending email
	mail($to, $subject, $message, $headers, '-f '.$row_1['default_email'].'');
	//echo $to.'<br />'.$subject.'<br />'.$message.'<br />'.$headers.'<br />'.'-f '.$row_1['default_email'].'<br /><br />';
}

function sendMail_admin($code, $replace, $custom_email="")
{
	$q="select subject, message from notifications where code='$code' and language='$replace[lang]'";
	$sql=mysql_query($q);
	$row=mysql_fetch_array($sql);

	$subject = $row['subject'];
	$msg = $row['message'];

	foreach($replace as $k=>$v){
		$subject = str_replace("$".$k, $v, $subject);
		$msg = str_replace("$".$k, $v, $msg);
	}
	$message = $msg;	
	
	$q_1 = mysql_query("select admin_email, admin_default_email from system_configuration where id='1'");
	$admin_row = mysql_fetch_array($q_1);
	
	if($custom_email == "")
	{  
		$to = $admin_row['admin_email']; 
	}
	else
	{ 
		$to = $custom_email; 
	}
	$headers = 'From: Cloudways <'.$admin_row['admin_default_email'].'>' . "\r\n" .
		'Reply-To: '.$admin_row['admin_default_email'].'' . "\r\n" .
		'MIME-Version: 1.0' . "\r\n" .
		'Content-type: text/html; charset=utf-8' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

	//adding email log
	$q	= "INSERT INTO email_log SET email='".$replace['email']."', sent_on=NOW(), subject='$subject', content='".mysql_escape_string($message)."'";
	$sql	= @mysql_query($q);
	
	//sending email
	mail($to, $subject, $message, $headers, '-f '.$admin_row['admin_default_email'].'');
}

function sendMassMail($replace)
{
	//Fetching System Default Email Address
	$q1 = mysql_query("SELECT admin_default_email FROM system_configuration WHERE id='1'");
	$rw = mysql_fetch_array($q1);

	$to      = $replace['email'];
	$subject = $replace['subject'];
	$msg = $replace['message'];
	$msg = str_replace('name', $replace['name'], $msg);
	$msg = str_replace('date', $replace['date'], $msg);
	$message = $replace['message'];
	$headers = 'From: Cloudways <'.$rw['admin_default_email'].'>' . "\r\n" .
		'Reply-To: '.$rw['admin_default_email'].'' . "\r\n" .
		'MIME-Version: 1.0' . "\r\n" .
		'Content-type: text/html; charset=utf-8' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

	//adding email log
	$q	= "INSERT INTO email_log SET email='$to', sent_on=NOW(), subject='$subject', content='".mysql_escape_string($message)."'";
	$sql	= @mysql_query($q);
	
	//sending email
	mail($to, $subject, $message, $headers, '-f '.$rw['admin_default_email'].'');
	//echo $to. $subject. $message. $headers. '-f '.$rw['admin_default_email'].'<br /><br />';
}

function sendMailAttachment($code, $replace, $attach_files)
{
	//Fetching System Default Email Address
	$q_1 = mysql_query("SELECT default_email FROM system_configuration WHERE id='1'");
	$row_1 = mysql_fetch_array($q_1);

	//Fetching Email Template According to User Selected Language 
	$q_2="select subject, message from notifications where code='$code' and language='$replace[lang]'"; 
	$sql_2=mysql_query($q_2); 
	$tot_rws=mysql_num_rows($sql_2);

	if($tot_rws==0)
	{
		$q_3="SELECT nt.subject, nt.message FROM notifications nt INNER JOIN languages lang ON lang.code=nt.language WHERE lang.default_lang='1' LIMIT 1"; 
		$sql_2 = mysql_query($q_3);
	}
	
	$row=mysql_fetch_array($sql_2);
	$to = $replace['email'];
	$subject = $row['subject'];
	$msg = $row['message'];
	foreach($replace as $k=>$v)
	{
		$subject = str_replace("$".$k, $v, $subject);
		$msg = str_replace('$'.$k, $v, $msg);
	}
	
	//Creating Unique Number for Email Boundary
	$separator = md5(time());

	//PHP Line Breaker Constant
	$eol = PHP_EOL;
	
	// Set Email header
	$header  = "From: Cloudways <".$row_1['default_email'].'>'.$eol;
	$header .= "MIME-Version: 1.0".$eol; 
	$header .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

	//Set Message Body Header
	$body = "--".$separator.$eol;
	$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
	
	//Set E-mail Message
	$body .= "--".$separator.$eol;
	$body .= "Content-Type: text/html; charset=\"utf-8\"".$eol;
	$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
	$body .= $msg.$eol;

	//Add Attachmed Files
	foreach($attach_files as $k=>$v)
	{
		//File Name or Type Define Here
		$file_path = $v['file_path'];
		$file_name = $v['file_name'];
		
		//Get Attach File Data
		$file_data = file_get_contents($file_path.$file_name); 
		$file_data = chunk_split(base64_encode($file_data)); 
		
		//Set Attachment in Html
		$body .= "--".$separator.$eol;
		$body .= "Content-Type:application/octet-stream; name=\"".$file_name."\"".$eol; 
		$body .= "Content-Transfer-Encoding: base64".$eol;
		$body .= "Content-Disposition: attachment".$eol.$eol;
		$body .= $file_data.$eol;
	}
	$body .= "--".$separator."--";

	//adding email log
	$q	= "INSERT INTO email_log SET email='$to', sent_on=NOW(), subject='$subject', content='".mysql_escape_string($msg)."'";
	$sql	= @mysql_query($q);
	
	//Sending E-mail
	//echo $to.'<br />'.$subject.'<br />'.$body.'<br />'.$headers.'<br />'.'-f '.$rw['admin_default_email'].'<br /><br />';
	mail($to, $subject, $body, $header);
}
?>