<?php

namespace App\Controllers;

use Core\Database;
use App\Models\Student;

class StudentsController
{
	public function show($id)
	{
		$student = new Student();

		var_dump($student->score($id));
	}
}
