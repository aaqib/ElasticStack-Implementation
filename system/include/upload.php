<?php 
function uploadFiles($_FILES, $path, $allowed, $move="1", $size="40000000000")
{
	$type = explode('.', $_FILES["name"]);
	$type = $type[(count($type)-1)];
	
	if (in_array($type, $allowed) && $_FILES["size"] < $size)
	{
		$name = $_FILES["name"];
		if ($_FILES["error"] > 0)
		{
			return  "Return Code: " . $_FILES["file"]["error"];
		}
		
		if (file_exists($path . $name))
		{
			return  '<b>'.$name."</b> - This File Already Exists. ";
		}
		else
		{
			if($move == "1"){    move_uploaded_file($_FILES["tmp_name"], $path . $name);   }
			return 'ok';
		}
	}
	else
	{
		return 'Invalid file '.$_FILES["name"].' '.$type;
	}
}


function uploadMultiple($images, $path, $allowed, $move="1", $child_name="", $size="40000000000")
{
	$errors=array(); $up_ok='1';
	while(list($k,$v) = each($images["name"]))
	{
		if($v != "")
		{
			$type = explode('.', $images["name"][$k]);
			$type = strtolower($type[(count($type)-1)]);
			if(in_array($type, $allowed) && $images["size"][$k] < $size)
			{
				$name = $images["name"][$k];
				if ($images["error"][$k] > 0)
				{	
					$errors[$k]= $child_name.($k+1).' | File Error Code from Server: <b>'.$images["file"]["error"][$k]."</b>"; $up_ok='0';
					
				}
				if (file_exists($path.$name))
				{ 
					$errors[$k] = $child_name.($k+1).' | Error: <b>'.$name."</b> - This File Already exists."; $up_ok='0';
				}
				else
				{ 
					if($move == "1"){    move_uploaded_file($images["tmp_name"][$k], $path.$name);   }
				}
			}
			else
			{
				$errors[$k] = $child_name.($k+1).' | Error: <b>'.$images["name"][$k].'</b> - Invalid file Type.'; $up_ok='0';
			}
		}
	}
	if($up_ok=='1'){ return $up_ok;}
	return $errors;
}

function moveSingleFiles($_FILES, $path)
{
	$name=$_FILES['name'];
	move_uploaded_file($_FILES['tmp_name'], $path.$name);
	chmod($path.$name, 0777);
}

function moveMultipleFiles($images, $path)
{
	while(list($k,$v) = each($images["name"]))
	{
		$name = $images["name"][$k];
		move_uploaded_file($images["tmp_name"][$k], $path.$name);
	}
}

function upload($_FILES, $path){
/*	echo 'fffffffffffffffffff'.$_FILES['name'].'aaaaa'.$_FILES;
	foreach( $_FILES as $k=>$v){
		echo $k.'bbbbbbbbbbb'.$v;
	}*/
	if ($_FILES["type"] == "image/gif"|| $_FILES["type"] == "image/GIF"|| $_FILES["type"] == "image/jpeg" || $_FILES["type"] == "image/JPEG" || $_FILES["type"] == "image/JPG" || $_FILES["type"] == "image/jpg" && $_FILES["size"] < 200000){
	
		$name = $_FILES["name"];
		
		if ($_FILES["error"] > 0) {
			return  "Return Code: " . $_FILES["file"]["error"];
		}
		
		if (file_exists($path . $name)){
			return  $name . " already exists. ";
		}else{
			move_uploaded_file($_FILES["tmp_name"], $path . $name);
			return 'ok';
		}
	}else{
		return 'Invalid file'.$_FILES["type"];
	}
}

function removeFile($file, $path)
{
	if($file!="")
	{
		if(file_exists($path.$file))
		{
			unlink($path.$file);
			if(file_exists($path.'thm/'.$file)){unlink($path.'thm/'.$file);}
		}
	}
}
?>