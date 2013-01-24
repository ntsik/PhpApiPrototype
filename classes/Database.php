<?php
	// force UTF-8 Ø

	require_once ROOT_PATH . 'config.php';
	require_once CLASS_PATH . 'DatabaseException.php';

	/**
	 * Database singleton class.
	 *
	 * TODO: This class should use parameterized queries, but does not (yet) for simplicity.
	 */
	class Database {
		private static $connection;

		private function __clone() {
			trigger_error('Clone is not allowed.', E_USER_ERROR);
		}

		private function __construct() {
			trigger_error('Construct is not allowed.', E_USER_ERROR);
		}

		public static function init() {
			global $database;

			$connection = new mysqli($database['hostname'], $database['username'], $database['password'], $database['database']);

			// mysqli->connect_errno and mysqli->connect_error are broken < PHP 5.3.0
			if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
				if ($connection->connect_error) {
					throw new DatabaseException($connection->connect_error, $connection->connect_errno);
				}
			} else {
				if (mysqli_connect_error()) {
					throw new DatabaseException(mysqli_connect_error(), mysqli_connect_errno());
				}
			}

			$connection->set_charset('utf8');

			self::$connection = $connection;
		}

		public static function query($sql) {
			if (!is_object(self::$connection)) {
				self::init();
			}

			$result = self::$connection->query($sql);

			if ($result === FALSE) {
				throw new DatabaseException(self::$connection->error, self::$connection->errno);
			}

			return $result;
		}
	}
?>
