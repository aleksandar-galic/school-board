<?php

namespace App\Controllers;

use App\Models\Student;

class StudentsController
{
	public function show($id)
	{
		$student = new Student();

		$student->score($id);
	}
}
