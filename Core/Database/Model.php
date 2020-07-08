<?php

namespace Chr15k\Core\Database;

use PDO;
use Chr15k\Core\Database\Connector;

abstract class Model
{
	static $table;

	public static function all()
	{
		$statement = static::db()
			->query('SELECT * FROM ' . static::$table);

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function db()
	{
		return Connector::getInstance();
	}
}