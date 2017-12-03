<?php
	$app_area = "site";
	
	include_once "../app/init.php";
	
	$app = new Core\App($app_area);

    //Layout include
	include "../app/views/site/main/index.tpl.php";
?>	