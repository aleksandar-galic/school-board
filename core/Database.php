<?php

namespace Core;

class Database
{
	private $connection;

	private static $instance = null;

	private function __construct()
	{
		$config = require 'config.php';

		try
		{
			$this->connection = new \PDO(
				$config['database']['connection'] . ';dbname=' . $config['database']['name'],
				$config['database']['username'],
				$config['database']['password'],
				$config['database']['options'],
			);
		}
		
		catch(\PDOException $e) 
		{
			die($e->getMessage());
		}
	}

	public static function connect()
	{
		if (self::$instance == null)
		{
			self::$instance = new Database();
		}

		return self::$instance;
	}

	public function get()
	{
		return $this->connection;
	}
}
