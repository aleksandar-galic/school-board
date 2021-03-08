<?php

namespace App\Models;

use Core\Database;
use App\Logger\LogAsXML;
use App\Logger\LogAsJSON;

class Student
{
	protected $db;

	public function __construct()
	{
		$config = require 'config.php';
		$this->db = Database::get($config['database']);
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

	public function grades($id)
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

		switch ($student['board_id']) {
			case 1:
				// Add the grades to result
				$student['grades'] = $grades;

				// Find the score
				$score = $this->CSM($grades);

				// Add the score to result
				$student['score'] = $score;

				// Check if student passed and add to result
				if ($score >= 7) {
					$student['passed'] = true;
				} else {
					$student['passed'] = false;
				}

				// Final result doesn't need board
				unset($student['board_id']);

				// Return result
				$logger = new LogAsJSON();
				return $logger->render($student);
			case 2:
				// Add the grades to result
				$student['grades'] = $grades;

				// Find the score
				$score = $this->CSMB($grades);

				// Add the score to result
				$student['score'] = $this->avg(array_column($grades, 'value'));

				// Get grades
				$grades = $this->grades($id);
				$student['grades'] = $grades;

				// Check if student passed and add to result
				if ($score >= 8) {
					$student['passed'] = true;
				} else {
					$student['passed'] = false;
				}

				// Final result doesn't need board
				unset($student['board_id']);

				$logger = new LogAsXML();
				return $logger->render($student);
			default:
				echo "Student not found";
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
