<?php

namespace App\Models;

use Core\Database;

class Student
{
	protected $db;

	public function __construct()
	{
		$config = require 'config.php';

		$this->db = Database::get($config['database']);
	}

	public function find($id)
	{
		$sql = "
		select *
		from students
		where id={$id};
		";

		$statement = $this->db->prepare($sql);

		$statement->execute();

		$result = $statement->fetchAll(\PDO::FETCH_ASSOC);

		return $result[0];
	}


	public function score($id)
	{
		switch ($this->find($id)['board_id']) {
			case 1:
				$sql = "
				select students.id, students.name, avg(grades.value) as score
				from grades
				join students
				on grades.student_id = students.id
				where student_id = {$id};
				";

				$statement = $this->db->prepare($sql);

				$statement->execute();

				$result = $statement->fetchAll(\PDO::FETCH_ASSOC)[0];

				if ($result['score'] >= 7) {
					$result['passed'] = true;
				}

				return json_encode($result, JSON_PRETTY_PRINT);

				break;
			case 2:
				$sql = "
				select students.id, students.name, max(grades.value) as score
				from grades
				join students
				on grades.student_id = students.id
				where student_id = {$id};
				";

				$statement = $this->db->prepare($sql);

				$statement->execute();

				$result = $statement->fetchAll(\PDO::FETCH_ASSOC)[0];

				if ($result['score'] >= 8) {
					$result['passed'] = true;
				}

				return;

				default:
				return;
			break;
		}
	}
}