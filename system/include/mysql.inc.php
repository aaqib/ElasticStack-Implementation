<?php  # mysql.inc.php

// This file establishes a connection to MySQL 
// and selects the database.

// Connect to MySQL:
$dbc = @mysql_pconnect (DB_HOST, DB_USER, DB_PASS);
mysql_query("SET NAMES 'utf8'");

// Confirm the connection and select the database:
if (!$dbc OR !mysql_select_db (DB)) {
  
  // Handle the error, if desired.
  
  // Print a message to the user, complete the page, and kill the script.
  echo '<p class="error">The site is currently experiencing technical difficulties. We apologize for any inconvenience.</p>';
  exit();
  
} 
?>
