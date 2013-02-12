<!--Top Bar-->
<div id="top-box">
<div class="top-left">
<p>Welcome to Admin Panel  [ <b><?php  $tmp = getFieldsData('admins', 'username', "id='$_SESSION[usrId]'"); echo $tmp['username'];?></b> ]</p>
<p>Your IP - [ <b><?php  echo getRealIpAddr(); ?></b> ]</p>
<p class="top-endtxt">System clock - [ <b><?=date('d, M, Y - h:i - a');?></b> ]</p></div>
<div class="top-right">
[ <a href="<?=$path;?>verify.php?code=<?=base64_encode('logout');?>">Logout</a> ]</div></div>
<!--Main Boday Content-->
<div id="body-cont">
<!--Header Content-->
<div id="header"><a class="statlnkbox" href="javascript:fadeslide.toggle('top-box')">Your Status [+]</a></div>
