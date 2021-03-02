<?php

namespace Core;

class Database
{
	public static function get($config)
	{
		try
		{
			return new PDO(
				$config['connection'] . ';dbname=' . $config['name'],
				$config['username'],
				$config['password'],
				$config['options']
			);
		}
		
		catch(PDOException $e) 
		{
			die($e->getMessage());
		}
	}
}
