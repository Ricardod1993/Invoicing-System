<?php
	use Core\Database as Database;

	/** CORE REQUIREMENTS **/
	require_once '../app/core/App.php';


	/** COMPOSER AUTOLOADER REQUIREMENT **/
	require_once __DIR__ . "/../vendor/autoload.php"; 

	/** LOAD CONFIGURATION ARRAY **/
	Libs\Common\Config::load("../app/config/config.php");


	/** MAIN CONFIGURATION **/
	date_default_timezone_set('Europe/Lisbon');

	//Setting databse configurations, hostname, database name, username, password
	Database::config("localhost", "invoicing_system", "root", "");
?>
