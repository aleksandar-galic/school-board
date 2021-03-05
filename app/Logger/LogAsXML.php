<?php

namespace App\Logger;

use Spatie\ArrayToXml\ArrayToXml;

class LogAsXML implements Logger
{
	public function render($data)
	{
		header('Content-Type: text/xml');

		echo ArrayToXml::convert($data);
	}
}
