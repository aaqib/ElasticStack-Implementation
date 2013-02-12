<?php 
	function textEditor($n, $v, $p, $w="", $h=""){
	$oFCKeditor = new FCKeditor($n);
	$oFCKeditor->BasePath = $p;
	
	if(($w != "") && ($h != "")){   $oFCKeditor->Width = $w;  $oFCKeditor->Height = $h;   }
	
	$oFCKeditor->Value = $v;
	$oFCKeditor->Create();
}
?>