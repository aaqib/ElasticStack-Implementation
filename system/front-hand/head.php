<link href="<?=CSS;?>style.css" rel="stylesheet" type="text/css" />
<?php if ($page_css == 'inner'){?>
<link href="<?=CSS;?>inner.css" rel="stylesheet" type="text/css" />
<?php } else{?>
<link href="<?=CSS;?>default.css" rel="stylesheet" type="text/css" />
<?php } ?>
<script type="text/javascript" src="<?=JS;?>jquery.js"></script>
<script type="text/javascript" src="<?=JS;?>jquery_func.js"></script>
<script type="text/javascript" src="<?=JS;?>fade_slide.js"></script>
<script type="text/javascript" src="<?=JS;?>ajax_func.js"></script>
<script type="text/javascript" src="<?=JS;?>drop_nav.js"></script>
<script type="text/javascript" src="<?=JS;?>notify.js"></script>
<?php if ($light_box == 'show'){?>
<link href="<?=CSS;?>light_box.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=JS;?>light_box.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("a.zoom").fancybox({'zoomSpeedIn': 350, 'zoomSpeedOut':	300, 'overlayOpacity': 0.6, 'overlayColor': '#000000'});
});
</script>
<?php } if ($editor == 'show'){  include_once(EDITOR."fckeditor.php"); include_once(EDITOR."setting.php"); } ?>
