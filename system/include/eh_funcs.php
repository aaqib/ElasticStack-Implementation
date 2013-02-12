<?php
	// function to check EH credentails are valid
	// redirects user to login page if sessions variables of credentails are not found
	function eh_check_credentials()
	{
		if(empty($_SESSION['eh_credentials']) || (!is_array($_SESSION['eh_credentials'])))
		{
			$filename					= explode('/', $_SERVER["SCRIPT_NAME"]);
			$filename					= end($filename);
			$_SESSION['redirect_url']	= $filename;
			header("Location:eh_credentials_update.php?err=Please provide Elastic Hosts Credentials first.");
			exit;
		}
	}
	
	// function to build api url
	function eh_get_api_url()
	{
		return "https://api-".$_SESSION['eh_credentials']['region_code'].".elastichosts.com/";
	}
	
	// function to list images from local db
	function eh_list_all_images()
	{
		return getLoopData("* from eh_image as i, eh_region as r where i.id_region = r.id_region and (r.region_code = '".$_SESSION['eh_credentials']['region_code']."' or r.region_code = 'all') ");
	}
	

	//********API FUNCTIONS BEGINS********
	
	//[DRIVE FUNCTIONS]
	
	// function to list all EH drives
	function eh_list_all_drives()
	{
		$url		= eh_get_api_url()."drives/list";
		$result		= eh_fetch_data($url);
		if(!$result)
		{
			return null;
		}
		$drives		= nl2br(trim($result));
		$drives		= explode('<br />', str_replace("\n","",$drives));
		return $drives;
	}
	
	// function to list all EH drives with detailed info
	function eh_info_all_drives()
	{
		$url		= eh_get_api_url()."drives/info";
		$result		= eh_fetch_data($url);
		if(!$result)
		{
			return null;
		}
		$drives		= nl2br(trim($result));
		$drives		= explode('<br />', str_replace("\n","",$drives));
		$results	= array();
		$data		= '';
		for($i=0; $i<count($drives); $i++)
		{
			if($drives[$i] == '' || $i == count($drives)-1)
			{
				array_push($results, $data);
				$data = '';
				continue;
			}
			$data	.= $drives[$i].'|-|';
		}
		$return	= array();
		for($i=0; $i<count($results); $i++)
		{
			$info	= explode('|-|', $results[$i]);
			$result	= array();
			for($j=0; $j<count($info); $j++)
			{
				if($info[$j] != '')
				{
					$data				= explode(' ', $info[$j]);
					$result[$data[0]]	= substr($info[$j], strpos($info[$j], ' ')+1);
				}	
			}
			$return[ $result['drive'] ]	= $result;
		}
		//var_dump($return);
		return $return;
	}
	
	// function to get single EH drive info
	function eh_get_drive_info($drive)
	{
		$url	= eh_get_api_url()."drives/".$drive."/info";
		$info	= explode("\n", eh_fetch_data($url));
		$result	= array();
		for($i=0; $i<count($info); $i++)
		{
			$data				= explode(' ', $info[$i]);
			$result[$data[0]]	= substr($info[$i], strpos($info[$i], ' ')+1);
		}
		//var_dump($result);
		return $result;
	}
	
	// function to destroy EH drive
	function eh_destroy_drive($drive)
	{
		$url		= eh_get_api_url()."drives/".$drive."/destroy";
		//$info		= explode("\n", eh_fetch_data($url));
		$info		= eh_fetch_data($url);
		echo $info;
	}
	
	// function to create EH drive
	function eh_create_drive($params)
	{
		$url		= eh_get_api_url()."drives/create";
		$info		= explode("\n", eh_fetch_data($url, $params));
		if(strpos($info[0], 'negative') !== false)
		{
			return $info[0];
		}
		$result	= array();
		for($i=0; $i<count($info); $i++)
		{
			$data				= explode(' ', $info[$i]);
			$result[$data[0]]	= substr($info[$i], strpos($info[$i], ' ')+1);
		}
		return $result;
	}
	
	// function to update EH drive
	function eh_update_drive($drive, $params)
	{
		$url		= eh_get_api_url()."drives/".$drive."/set";
		//$info		= explode("\n", eh_fetch_data($url, $params));
		$info		= str_replace("\n", "", eh_fetch_data($url, $params));
		if(strpos($info[0], 'negative') !== false)
		{
			return $info[0];
		}
		return $info;
	}
	
	// function to map image on EH drives
	function eh_map_image($drive, $image, $encryption='')
	{
		$url		= eh_get_api_url()."drives/".$drive."/image/".$image;
		if($encryption != '')
			$url	.= "/".$encryption;
		$info		= str_replace("\n", "", eh_fetch_data($url));
		if(strpos($info[0], 'negative') !== false)
		{
			return $info[0];
		}
		return $info;
	}
	
	// function to read binary data from EH drive
	function eh_read_drive_data($drive, $offset, $limit)
	{
		$url	= eh_get_api_url()."drives/".$drive."/read/".$offset."/".$limit;
		return eh_fetch_data($url);
	}
	
	// function to write binary data on EH drive
	function eh_write_drive_data($drive, $offset, $contents)
	{
		$url	= eh_get_api_url()."drives/".$drive."/write/".$offset;
		$info	= eh_fetch_data($url, null, $contents);
	}
	
	// function to write binary data on EH drive with custom image present on local server
	function eh_write_drive_custom_image($file, $drive)
	{
		//for flush
		@ini_set('zlib.output_compression',0); 
		@ini_set('implicit_flush',1); 
		@ob_end_clean(); 
		set_time_limit(0); 
		ob_implicit_flush(1); 
	
		// close the session
		session_write_close();
		
		$limit		= 1024 * 1024 * 50; //MB
		$counter	= 0;
		$size		= filesize($file);
		$chunk		= ceil($size / $limit);
		$handle		= fopen($file, "rb");
		while (!feof($handle)) 
		{
			//progress counter
			$progress	= ($counter > 0) ? (($counter / $chunk) * 100) : '0';
			echo "<script> window.parent.fnUpdate('".number_format($progress, 2)."%') </script>";
			//this is for the buffer achieve the minimum size in order to flush data
			echo str_repeat(' ',1024*64);
		
			//reading file
			$contents	= fread($handle, $limit);
			$offset		= $limit * $counter;
			eh_write_drive_data($drive, $offset, $contents);
			$counter++;
		}
		fclose($handle);
	}
	
	// [SERVER FUNCTIONS]
	
	// function to list all EH servers
	function eh_list_all_servers()
	{
		$url		= eh_get_api_url()."servers/list";
		$result		= eh_fetch_data($url);
		if(!$result)
		{
			return null;
		}
		$servers	= nl2br(trim($result));
		$servers	= explode('<br />', str_replace("\n","",$servers));
		return $servers;
	}
	
	// function to list all EH servers with detailed info
	function eh_info_all_servers()
	{
		$url		= eh_get_api_url()."servers/info";
		$result		= eh_fetch_data($url);
		if(!$result)
			return null;
		$servers		= nl2br(trim($result));
		$servers		= explode('<br />', str_replace("\n","",$servers));
		$results		= array();
		$data			= '';
		for($i=0; $i<count($servers); $i++)
		{
			if($servers[$i] == '' || $i == count($servers)-1)
			{
				array_push($results, $data);
				$data = '';
				continue;
			}
			$data	.= $servers[$i].'|-|';
		}
		$return	= array();
		for($i=0; $i<count($results); $i++)
		{
			$info	= explode('|-|', $results[$i]);
			$result	= array();
			for($j=0; $j<count($info); $j++)
			{
				if($info[$j] != '')
				{
					$data				= explode(' ', $info[$j]);
					$result[$data[0]]	= substr($info[$j], strpos($info[$j], ' ')+1);
				}	
			}
			$return[ $result['server'] ]	= $result;
		}
		//var_dump($return);
		return $return;
	}
	
	// function to get single EH server info
	function eh_get_server_info($server)
	{
		$url	= eh_get_api_url()."servers/".$server."/info";
		$info	= explode("\n", eh_fetch_data($url));
		$result	= array();
		for($i=0; $i<count($info); $i++)
		{
			$data				= explode(' ', $info[$i]);
			$result[$data[0]]	= substr($info[$i], strpos($info[$i], ' ')+1);
		}
		//var_dump($result);
		return $result;
	}
	
	// function to change EH server state
	// destroy, start, stop, shutdown, reset
	function eh_server_action($server, $type)
	{
		$url		= eh_get_api_url()."servers/".$server."/".$type;
		//$info		= explode("\n", eh_fetch_data($url));
		$info		= eh_fetch_data($url);
		echo $info;
	}
	
	// function to create EH server
	function eh_create_server($params, $stopped='')
	{
		$url		= ($stopped != '') ? 'servers/create/stopped' : 'servers/create';
		$url		= eh_get_api_url().$url;
		//$info		= explode("\n", eh_fetch_data($url, $params));
		$info		= str_replace("\n", "", eh_fetch_data($url, $params));
		if(strpos($info[0], 'negative') !== false)
		{
			return $info[0];
		}
		return $info;
	}
	
	// function to update EH server details
	function eh_update_server($server, $params)
	{
		$url		= eh_get_api_url()."servers/".$server."/set";
		//$info		= explode("\n", eh_fetch_data($url, $params));
		$info		= str_replace("\n", "", eh_fetch_data($url, $params));
		if(strpos($info[0], 'negative') !== false)
		{
			return $info[0];
		}
		return $info;
	}
	
	//[RESOURCES (IP or VLAN)]
	
	// function to list EH resources
	// type can be ip or vlan
	function eh_list_all_resources($type)
	{
		$url		= eh_get_api_url()."resources/".$type."/list";
		$result		= eh_fetch_data($url);
		if(!$result)
		{
			return null;
		}
		$res	= nl2br(trim($result));
		$res	= str_replace("\n","",$res);
		$res	= explode('<br />', str_replace($type." ","",$res));
		return $res;
	}
	
	// function to get EH resource info
	function eh_get_resource_info($type, $res)
	{
		$url	= eh_get_api_url()."resources/".$type."/".$res."/info";
		$info	= explode("\n", eh_fetch_data($url));
		$result	= array();
		for($i=0; $i<count($info); $i++)
		{
			$data				= explode(' ', $info[$i]);
			$result[$data[0]]	= substr($info[$i], strpos($info[$i], ' ')+1);
		}
		//var_dump($result);
		return $result;
	}
	
	// function to create EH resource
	function eh_create_resource($type, $params)
	{
		$url		= eh_get_api_url()."resources/".$type."/create";
		$info		= explode("\n", eh_fetch_data($url, $params));
		if(strpos($info[0], 'negative') !== false)
		{
			return $info[0];
		}
		return $info;
	}
	
	// function to update EH resource
	function eh_update_resource($type, $resource, $params)
	{
		$url		= eh_get_api_url()."resources/".$type."/".$resource."/set";
		$info		= explode("\n", eh_fetch_data($url, $params));
		if(strpos($info[0], 'negative') !== false)
		{
			return $info[0];
		}
		return $info;
	}
	
	// function to destroy EH resource
	function eh_destroy_resource($type, $res)
	{
		$url		= eh_get_api_url()."resources/".$type."/".$res."/destroy";
		$info		= explode("\n", eh_fetch_data($url));
		if(strpos($info[0], 'negative') !== false)
		{
			return $info[0];
		}
		return $info;
	}
	
	//********API FUNCTIONS ENDS********
	
	
	// curl function to fetch data from EH
	function eh_fetch_data($url, $params=null, $content=null)
	{
		$data		= eh_get_credentials();
		$username	= $data['username'];
		$password	= $data['password'];
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		if($params)
		{
			$json_string	= json_encode($params);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);
		}
		if($content) //to upload file
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/octet-stream'));
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE); // --data-binary
			curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		}
		else
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		}
		curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		//print_r($info);
		curl_close($ch);
		
		return $output;
	}
	
	// function to get EH credentials save in session variables
	function eh_get_credentials()
	{
		return array('username'=>$_SESSION['eh_credentials']['user_uid'], 'password'=>$_SESSION['eh_credentials']['secret_key']);
	}
?>