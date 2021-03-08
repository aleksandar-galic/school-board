<?php

namespace App;

use App\Logger\Logger;

class Viewer
{
	protected $logger;

	public function __construct(Logger $logger)
	{
		$this->logger = $logger;
	}

	public function present($student)
	{
		$this->logger->render($student);
	}
}