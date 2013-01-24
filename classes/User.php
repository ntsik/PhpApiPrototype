<?php
	// force UTF-8 Ø

	require_once CLASS_PATH . 'Database.php';

	class User {
		protected $info;
		private $new;

		public function __construct($username = NULL) {
			$this->new = is_null($username);

			if (!$this->new) {
				load($username);
			}
		}

		public function __get($key) {
			if (array_key_exists($key, $this->info)) {
				return $this->info[$key];
			}

			return NULL;
		}

		public function __set($key, $value) {
			$this->info[$key] = $value;
		}

		public function reload() {
			load($this->username);
		}

		public function save() {
			$sql = '';

			if (!empty($this->info)) {
				if (!$this->new) {
					// Existing user
					foreach ($this->info as $key => $value) {
						$info[] = $key . " = '" . $value . "'";
					}

					$info = implode(', ', $info);

					$sql = "UPDATE user SET $info WHERE username = '$this->username'";
				} else {
					// New user
					$keys = implode(', ', array_keys($this->info));
					$values = implode("', '", $this->info);

					$sql = "INSERT INTO user ($keys) VALUES ('$values')";
				}
			}

			return Database::query($sql);
		}

		public static function exists($username) {
			$sql = "SELECT EXISTS(SELECT 1 FROM user WHERE username = '$username')";
			return current(Database::query($sql)->fetch_row());
		}

		private function load($username) {
			$sql = "SELECT * FROM user WHERE username = '$username'";
			$this->info = Database::query($sql)->fetch_assoc();
		}
	}
?>
