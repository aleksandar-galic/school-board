<?php

namespace App\Logger;

class LogAsJSON implements Logger
{
	public function render($data)
	{
		header('Content-Type: application/json');
		
		echo json_encode($data, JSON_PRETTY_PRINT);
	}
}
