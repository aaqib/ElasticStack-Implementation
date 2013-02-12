<?php  
	$path ='../../'; require_once($path."system/include/config.php"); require_once(INC."eh_funcs.php"); if(isAccessPriv('cms')){ isChildPriv('front_end');}
	eh_check_credentials(); //checking if credentials are saved
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANGUAGE;?>" />
<title><?=SITE_TITLE;?></title>
<?php $page_css ='inner'; $light_box = 'show'; require_once(HEAD); ?>
<script>
	function fnShowProgress()
	{
		var id	= $('.js-reload').attr('id');
		if(id)
		{
			jQuery.get('eh_get_drive_info.php', 'id='+id, function(response)
			{
				if(response)
				{
					$('.js-reload').html(response);
				}
				else
				{
					$('.js-reload').html('Complete');
				}
			});
		}	
		setTimeout('fnShowProgress()', 4000);
	}
</script>
</head>
<body onload="javascript:getData('ajax_content/eh_drive.php','?sort=0&path=ajax_content/eh_drive.php&limit=<?=REC;?>&page=<?=$page;?>&order=desc', 'results'); fnShowProgress();">
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
<div class="right-container"><div class="midcont-box"><div class="midcont-titbox2">
<h1>Elastic Hosts Drives</h1><a class="inv_addlnk" href="eh_drive_add_edit.php">Create New Drive</a></div>
<div class="midcont-contbox">

<div id="results"></div>

</div></div><br clear="all" />
</div>
<!--Right Panel End-->
</div></div></div><br clear="all" /></div></div><br clear="all" />
<?php require_once(FOOTER); ?>
</body>
</html>