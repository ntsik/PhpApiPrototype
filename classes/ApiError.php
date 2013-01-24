<?php
	require_once CLASS_PATH . 'Error.php';

	class ApiError extends Error {
		const INVALID_ACTION	= 'Invalid action';
		const MISSING_REQUEST	= 'Missing request';
		const INVALID_JSON		= 'Invalid JSON';
		const MISSING_PARAM		= 'Missing parameter';
	}
?>
