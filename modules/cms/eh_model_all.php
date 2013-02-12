<?php $path ='../../'; require_once($path."system/include/config.php"); if(isAccessPriv('cms')){ isChildPriv('front_end');} ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANGUAGE;?>" />
<title><?=SITE_TITLE;?></title>
<?php $page_css ='inner'; $light_box = 'show'; require_once(HEAD); ?>
</head>
<body onload="javascript:getData('ajax_content/eh_model.php','?sort=0&path=ajax_content/eh_model.php&limit=<?=REC;?>&page=<?=$page;?>&order=desc', 'results');">
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
<h1>Elastic Hosts Models</h1><a class="inv_addlnk" href="eh_model_add_edit.php">Add New Model</a></div>
<div class="midcont-contbox">

<div id="results"></div>

</div></div><br clear="all" />
</div>
<!--Right Panel End-->
</div></div></div><br clear="all" /></div></div><br clear="all" />
<?php require_once(FOOTER); ?>
</body>
</html>