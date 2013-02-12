<?php 
	ob_start(); $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php"); require_once(INC."eh_funcs.php");

	$drives	= eh_info_all_drives();
	if($drives) 
	{
		$drive_results	= '';
		foreach($drives as $key => $value)
		{
			$result	= $value;
			$drive_results	.= trim($result['drive']).','.trim($result['name']).'|'; 
		}
		echo substr($drive_results, 0, -1);
	}
?>