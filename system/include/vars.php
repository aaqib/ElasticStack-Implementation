<?php 
	//************* Database Config ***************//
	define('DB_HOST','localhost');
	define('DB_USER','root');
	define('DB_PASS','');
	define('DB','automation');
	define('URL','http://localhost/automation/');
	
	//************* EH Global Variables ***************//
	define('EH_LOCAL_SCRIPTS_PATH', $_SERVER['DOCUMENT_ROOT'].'automation/scripts/');
	define('EH_LOCAL_KEYS_PATH', $_SERVER['DOCUMENT_ROOT'].'automation/keys/');
	//for server
	//define('EH_LOCAL_SCRIPTS_PATH', '/var/www/automation/scripts/');
	//define('EH_LOCAL_KEYS_PATH', '/var/www/automation/keys/');
	
	define('EH_REMOTE_PATH', '/root/');
	define('EH_REMOTE_SCRIPT', 'automation.sh');
	define('EH_LOCAL_SCRIPT', 'automation.sh');
	define('EH_KEY_NAME', '');
?>