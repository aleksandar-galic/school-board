<?php

return [
	'database' => [
		'name' => 'school_board',
		'username' => 'root',
		'password' => '',
		'connection' => 'mysql:host=localhost',
		'options' => [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]
	]
];
