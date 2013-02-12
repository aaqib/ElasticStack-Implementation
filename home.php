<?php require_once("system/include/config.php"); require_once(INC.'util_func.php'); isAccessPriv('home');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANGUAGE;?>" />
<title><?=SITE_TITLE;?></title>
<?php require_once(HEAD); ?>
</head>
<body>
<?php require_once(HEADER); ?>
<!--Mid Content-->
<div id="container">
<?php require_once(NAVIGATION); 
$acc_privs = split(',', $_SESSION['access_priv']); $chld_privs = split(',', $_SESSION['child_priv']);?>
<div id="searchbox"></div><br clear="all" />
<!--Mid Box Content-->
<div id="midbox"><div class="midbg1"><div class="midbg2">
<!--Left Panel-->
<?php require_once(LEFT_PANEL); ?>
<!--Right Panel-->
<div class="right-container">

<?php  if($_GET['err'] !="" ) { ?> 
<div class="inr-note-box">
<table class="inr-note-tab" cellspacing="0" cellpadding="0">
<tr>
<td class="inr-note-row1">
<h1><?php  echo $_GET['err']; ?></h1><br clear="all" />
</td>
</tr>
</table>
</div><br clear="all" />
<?php  } ?> 

<!--Recent Activities-->
<?php  if(isChecked('all', $acc_privs) || isChecked('web_act', $chld_privs)){?>
<div class="midcont-box">
<div class="midcont-titbox"><h1>Recent Activities</h1></div>
<div class="midcont-contbox">
<table class="mid-tab1" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="mid-tab1row1">User Name</td>
<td class="mid-tab1row1">Activity description</td>
<td class="mid-tab1row1end">Date</td>
</tr>
<?php 
$date = date('Y-m-d');
$q = "SELECT a.username, w.activity, w.act_date FROM web_activities w INNER JOIN admins a ON w.client=a.id WHERE w.client_type=0 AND w.act_date LIKE '%$date%' order by a.id desc LIMIT 12";
//echo $q;
$sql = mysql_query($q);
while($row = mysql_fetch_array($sql)){?>
<tr>
<td class="mid-tab4row1"><?=strtoupper($row['username']);?></td>
<td class="mid-tab4row2"><?=$row['activity'];?></td>
<td class="mid-tab4row3"><?=date('d, M, Y | h:i a', strtotime($row['act_date']));?></td>
</tr>
<?php  }?><tr>
<td colspan="3" class="mid-tab2row4"><b>Today Total Activities:</b> [ <b class="mid-tabhl4"><?=getTotalRecords('web_activities', 'activity_id', "act_date LIKE '%$date%' AND client_type=0");?> Activities</b> ]</td>
</tr>
</table>
</div>
</div><br clear="all" />
<?php  }?>

</div>
<!--Right Panel End-->
</div></div></div><br clear="all" /></div></div><br clear="all" />
<?php require_once(FOOTER); ?>
</body>
</html>