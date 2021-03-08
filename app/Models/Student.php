<?php

namespace App\Models;

use App\Viewer;
use Core\Database;
use App\Logger\LogAsXML;
use App\Logger\LogAsJSON;

class Student
{
	protected $db;

	public function __construct()
	{
		$this->db = Database::connect()->get();
	}

	public function execute(string $query): array
	{
		$statement = $this->db->prepare($query);

		$statement->execute();

		$result = $statement->fetchAll(\PDO::FETCH_ASSOC);

		return $result;
	}

	public function find($id): array
	{
		$sql = "
			select *
			from students
			where id={$id};
		";

		return $this->execute($sql);
	}

	public function grades($id): array
	{
		$sql = "
			select subject, value from grades
			where student_id = {$id}
			order by (value) desc
			limit 4;
		";

		return $this->execute($sql);
	}


	public function score($id)
	{
		// Find the student
		$student = $this->find($id)[0];

		// Get student's grades
		$grades = $this->grades($id);

		// Add the grades to result
		$student['grades'] = $grades;

		// Find the score for each board, and if the student has passed.
		// Add it to the result and return the result.
		switch ($student['board_id']) {
			case 1:
				$score = $this->CSM($grades);

				$student['score'] = $score;

				if ($score >= 7) {
					$student['passed'] = true;
				} else {
					$student['passed'] = false;
				}

				unset($student['board_id']);

				$viewer = new Viewer(new LogAsJSON());
				return $viewer->present($student);
			case 2:
				$result = $this->CSMB($grades);

				$student['score'] = $this->avg(array_column($grades, 'value'));

				if ($result >= 8) {
					$student['passed'] = true;
				} else {
					$student['passed'] = false;
				}

				unset($student['board_id']);

				$viewer = new Viewer(new LogAsXML());
				return $viewer->present($student);
			default:
				echo "School board not found";
				break;
		}
	}

	private function CSM($grades)
	{
		return $this->avg(array_column($grades, 'value'));
	}

	private function CSMB($grades)
	{
		$grades = array_column($grades, 'value');

		if (count($grades) > 2) {
			array_pop($grades);
		}

		return max($grades);
	}

	private function avg(array $array)
	{
		if (count($array)) {
			return array_sum($array)/count($array);
		}

		return;
	}
}