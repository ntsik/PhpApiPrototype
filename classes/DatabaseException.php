<?php
	// force UTF-8 Ø

	/**
	 *
	 */
	class DatabaseException extends Exception {
		public function __construct($error, $errno) {
			parent::__construct($error, $errno);
		}
	}
?>
