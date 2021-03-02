<?php

namespace App\Logger;

class LogAsJSON implements Logger
{
	public function render($data)
	{
		var_dump(json_encode($data, JSON_PRETTY_PRINT));
	}
}
