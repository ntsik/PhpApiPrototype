<?php
	// force UTF-8 Ø

	require_once CLASS_PATH . 'AuthError.php';
	require_once CLASS_PATH . 'Database.php';
	require_once CLASS_PATH . 'User.php';

	// TODO: Merge into User class and use mcrypt/blowfish
	class Auth {
		const SALT_LENGTH = 16;

		public static function checkLogin($username, $password) {
			$sql = "SELECT password, salt FROM user WHERE username = '$username'";
			$user = Database::query($sql)->fetch_object();

			if (is_null($user)) {
				return AuthError::INVALID_USERNAME;
			}

			if (self::passwordHash($password, $user->salt) !== $user->password) {
				return AuthError::INVALID_PASSWORD;
			}

			return AuthError::NO_ERROR;
		}

		public static function register($username, $password) {
			if (User::exists($username)) {
				return AuthError::USERNAME_TAKEN;
			}

			$user = new User();
			$user->username = $username;
			$user->salt = self::generateSalt();
			$user->password = self::passwordHash($password, $user->salt);

			$user->save();

			return AuthError::NO_ERROR;
		}

		private static function generateSalt() {
			$salt = '';
			$random = @fopen('/dev/urandom', 'r');

			if ($random !== false) {
				// Attempt to read bytes from /dev/urandom
				$salt .= @fread($random, self::SALT_LENGTH);
				@fclose($random);
			} else {
				// Fall back to the weaker mt_rand()
				for ($i = 0; $i < self::SALT_LENGTH; $i++) {
					$salt .= chr(mt_rand(0, 255));
				}
			}

			return $salt;
		}

		private static function passwordHash($password, $salt) {
			// Split the password in half
			$password = str_split($password, (strlen($password) / 2) + 1);

			// Add salt to middle of password
			return hash('sha512', $password[0] . $salt . $password[1]);
		}
	}
?>
