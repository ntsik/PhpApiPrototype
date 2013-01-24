<?php
	require_once 'definitions.php';
	require_once CLASS_PATH . 'ApiError.php';

	// Since the JSON is not formatted as a query string,
	// we need to get the raw POST data directly from the input stream.
	$post = file_get_contents('php://input');

	if ($post !== false) {
		$json = json_decode($post);

		if (!is_null($json)) {
			switch ($_GET['action']) {
				case 'login':
					require_once CLASS_PATH . 'Auth.php';

					if(!isset($json->username) || !isset($json->password)) {
						$response = ApiError::MISSING_PARAM;

						break;
					}

					$response = Auth::checkLogin($json->username, $json->password);

					break;

				case 'register':
					require_once CLASS_PATH . 'Auth.php';

					if(!isset($json->username) || !isset($json->password)) {
						$response = ApiError::MISSING_PARAM;

						break;
					}

					$response = Auth::register($json->username, $json->password);

					break;

				default:
					$response = ApiError::INVALID_ACTION;
			}
		} else {
			$response = ApiError::INVALID_JSON;
		}
	} else {
		$response = ApiError::MISSING_REQUEST;
	}

	@header('Content-Type: text/json; charset=UTF-8');
	echo json_encode($response);
?>
