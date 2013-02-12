<?php 
	ob_start(); $path ='../../'; require_once($path."system/include/config.php");require_once(INC."util_func.php"); require_once(INC."eh_funcs.php");

	$resources	= eh_list_all_resources('ip');
	if($resources) 
	{
		$results	= '';
		foreach($resources as $resource)
		{
			$result		= eh_get_resource_info('ip', $resource);
			$results	.= trim($resource).','.trim($result['name']).'|'; 
		}
		echo substr($results, 0, -1);
	}
?>