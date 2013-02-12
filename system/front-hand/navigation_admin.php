<div id="navbox">
<div class="navcont">
<div class="navleft" id="nav">
    <ul class="nav-box">
        <li class="nav-lifirst"><a class="nav-link" href="<?=$path;?>home.php">Home</a></li>
		<li class="nav-li"><a class="nav-link" href="#">EH CMS</a>
			<ul>
				<?php  $link_path = $path.'modules/cms/'; ?>
				<li><a class="navdrp2tit1" href="javascript:void(0);">Regions</a></li>
				<li><a class="navdrp2-1" href="<?=$link_path;?>eh_region_all.php">Manage Regions</a></li>
				<li><a class="navdrp2-2" href="<?=$link_path;?>eh_region_add_edit.php">Add new Region</a></li>
				<li><a class="navdrp2tit1" href="javascript:void(0);">Images</a></li>
				<li><a class="navdrp2-1" href="<?=$link_path;?>eh_image_all.php">Manage Images</a></li>
				<li><a class="navdrp2-2" href="<?=$link_path;?>eh_image_add_edit.php">Add new Image</a></li>
				<li><a class="navdrp2tit1" href="javascript:void(0);">Models</a></li>
				<li><a class="navdrp2-1" href="<?=$link_path;?>eh_model_all.php">Manage Models</a></li>
				<li><a class="navdrp2-2" href="<?=$link_path;?>eh_model_add_edit.php">Add new Model</a></li>
				<li><a class="navdrp2tit1" href="javascript:void(0);">Server Roles</a></li>
				<li><a class="navdrp2-1" href="<?=$link_path;?>eh_server_role_all.php">Manage Server Roles</a></li>
				<li><a class="navdrpbtm2" href="<?=$link_path;?>eh_server_role_add_edit.php">Add new Server Role</a></li>
			</ul>
		</li>	
		<li class="nav-li"><a class="nav-link" href="#">EH Customer Panel</a>
			<ul>
				<?php  $link_path = $path.'modules/setup/'; ?>
				<li><a class="navdrp2tit1" href="javascript:void(0);">Login Area</a></li>
				<li><a class="navdrp2-2" href="<?=$link_path;?>eh_credentials_update.php">Login Area</a></li>
				<li><a class="navdrp2tit1" href="javascript:void(0);">Manage Resources</a></li>
				<li><a class="navdrp2-1" href="<?=$link_path;?>eh_ip_all.php">Manage Static IPs</a></li>
				<li><a class="navdrp2-1" href="<?=$link_path;?>eh_ip_add_edit.php">Create Static IP</a></li>
				<li><a class="navdrp2-1" href="<?=$link_path;?>eh_vlan_all.php">Manage VLAN</a></li>
				<li><a class="navdrp2-2" href="<?=$link_path;?>eh_vlan_add_edit.php">Create VLAN</a></li>
				<li><a class="navdrp2tit1" href="javascript:void(0);">Drives</a></li>
				<li><a class="navdrp2-1" href="<?=$link_path;?>eh_drive_all.php">Manage Drives</a></li>
				<li><a class="navdrp2-2" href="<?=$link_path;?>eh_drive_add_edit.php">Create Drive</a></li>
				<li><a class="navdrp2tit1" href="javascript:void(0);">Clone Drive</a></li>
				<li><a class="navdrp2-2" href="<?=$link_path;?>eh_clone_drive.php">Clone Drive</a></li>
				<li><a class="navdrp2tit1" href="javascript:void(0);">Servers</a></li>
				<li><a class="navdrp2-1" href="<?=$link_path;?>eh_server_all.php">Manage Servers</a></li>
				<li><a class="navdrpbtm2" href="<?=$link_path;?>eh_server_add_edit.php">Create Server</a></li>
			</ul>
		</li>
    </ul>
</div>
<div class="navright" style='width:500px'>
	<?php  if(isset($_SESSION['eh_credentials']['email']) && $_SESSION['eh_credentials']['email'] != '') { ?>
    <a class="nav-link" href="javascript:void(0)" style='margin-top:-14px'>EH: <?php  echo $_SESSION['eh_credentials']['email'] ?></a>
	<?php  
		} 
		elseif(isset($_SESSION['aws_credentials']['email']) && $_SESSION['aws_credentials']['email'] != '') 
		{
			require_once(INC."aws_funcs.php");
			$ec2_instance	= aws_get_instance();
			$regions		= aws_get_region();
			$reg_names		= aws_get_region_user_friendly_name($regions); //getting user friendly name array for regions
	?>
	<a class="nav-link" href="javascript:void(0)" style='margin-top:-14px;font-size:12px'>AWS: <?php  echo $_SESSION['aws_credentials']['email'] ?> - <?php  echo $reg_names[ "'".$ec2_instance->hostname."'" ]; ?></a>
	<?php  } ?>
</div>
<input type="hidden" id="checked" value="" />
<input type="hidden" id="checked_inner" value="" /><br clear="all" />

</div></div>