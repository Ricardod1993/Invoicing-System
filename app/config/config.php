<?php
	return [
		"emails" => [
			"main" => "geral@myskull.pt",
			"debug" => "ricardo.rodrigues@kriacao.pt",
			"layout" => "../app/views/common/emails/layout.tpl.php"
		],
		"moloni" => [
			"active" => false,
			"credentials" => [
				"developer_id" => "victriusltd",
				"client_secret_code" => "5d0b089702a2b37d9a81e6974503de536ad21b50",
				"username" => "victrius0@gmail.com",
				"password" => "novovictrius1234"
			]
		],
		"nacex" => [
			"active" => false,
			"credentials" => [
				"id" => "VICTRIUS",
				"password" => "B365F912F602BD51586C552EE370946E"
			]
		],
		"easypay" => [
			"active" => true,
			"environment" => "production",
			//"environment" => "development",
			"language" => "PT",
			"country" => "PT",
			"entity" => 10611,
			"credentials" => [
				"id" => "CREW220217",
				"cin" => 6428,
				"code" => "7f61443fda79bfccd50fb059a9c2a466"
			]
		],
		"wheelt" => [
			"dbname" => "influentyellow_testes",
			"user" => "influentyellow",
			"password" => "influentyellow123456"
		]
		/*"wheelt" => [
			"credentials" => [
				"dbname" => "influentyellow",
				"user" => "api",
				"password" => "api123456"
			]
		]*/
	];	
?>