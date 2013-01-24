<?php
	require_once CLASS_PATH . 'Error.php';

	class AuthError extends Error {
		const INVALID_USERNAME	= 'Invalid username';
		const INVALID_PASSWORD	= 'Invalid password';
		const USERNAME_TAKEN	= 'Username already in use';
	}
?>
