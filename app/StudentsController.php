<?php

namespace App\Controllers;

use Core\Database;
use App\Logger\Logger;
use App\Models\Student;

class StudentsController
{
	// protected $logger;

	// public function __construct(Logger $logger)
	// {
	// 	$this->logger = $logger;
	// }

	public function show($id)
	{
		$student = new Student();

		$student->score($id);
	}
}
