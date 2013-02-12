<?php 
function cleaning ($_POST, $arr="")
{
	foreach($_POST as $key => $value)
	{
		//if($arr !="" && !in_array($key, $arr))
		//{
			if(is_array($value))
			{
				foreach($value as $k=>$v)
				{
					if($arr!="tags"){ $value[$k]=strip_tags($value[$k]); }
					//$value[$k] = mysql_real_escape_string($value[$k]);
					$value[$k] = mysql_escape_string($value[$k]);
				}
				$_POST[$key]=$value;
			}
			else
			{
				//if($arr!="tags"){ $value =strip_tags ($_POST[$key]); }
				//$_POST[$key] = mysql_real_escape_string ($value);
				$_POST[$key] = mysql_escape_string($value);
				//$_POST[$key] = addslashes($_POST[$key]);
			}
		//}
    }
	return $_POST;
}


function cleaning_2(&$data)
{
	foreach($data as $key => $value)
	{
		if(is_array($value))
		{
			cleaning_2($data[$key]);
		} 
		else 
		{
			$data[$key] = mysql_real_escape_string( trim( (string)$value ) );
		}
	}
}

function clean_data($str)
{
	return mysql_real_escape_string ($str);
}

function remove($_POST){

	foreach($_POST as $key => $value) {

		if($key!=='submit'){

			$_POST[$key] = stripslashes($value);

		}

    }return $_POST;

}

function unsanitize_all ($data)
{
	foreach($data as $key => $value)
	{
		if(is_array($value))
		{
			foreach($value as $k=>$v)
			{
				$value[$k] = htmlentities(stripslashes($value[$k]), ENT_QUOTES, "UTF-8");
			}
			$data[$key]=$value;
		}
		else
		{
			$data[$key] = htmlentities(stripslashes($data[$key]), ENT_QUOTES, "UTF-8");
		}
    }
	return $data;
}

?>