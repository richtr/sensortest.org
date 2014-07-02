<?php

	if ($_SERVER['REQUEST_METHOD'] != 'GET') {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: Content-Type');
		header('Content-Type: application/json');

		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			exit;
		}
	} else {
		header('Content-Type: text/javascript');
	}

	include('config.php');
	include('libraries/database.php');
	include('libraries/tools.php');
	include('models/browsers.php');
	include('models/results.php');


	$method = $_REQUEST['method'];

	switch($method) {

		case 'getAllResults':
			if ($data = Browsers::getAll()) {
				echo json_encode($data);
			}

			break;

		case 'loadBrowserById':
  		if ($data = Results::getByUniqueId($_REQUEST['id'])) {
  			echo json_encode($data);
  		}

			break;

		case 'submit':
			$payload = json_decode($_REQUEST['payload']);

			if (!$readonly) {
				$useragentHeader = $_SERVER['HTTP_USER_AGENT'];
				$useragentId = preg_replace("/(; ?)[a-z][a-z](?:-[a-zA-Z][a-zA-Z])?([;)])/", '$1xx$2', $useragentHeader);

				mysql_query('
					INSERT INTO
						results
					SET
						version = "' . mysql_real_escape_string($payload->version) . '",
						timestamp = NOW(),
            lastUsed = NOW(),
						ip = "' . mysql_real_escape_string(get_ip_address()) . '",
						uniqueid = "' . mysql_real_escape_string($payload->uniqueid) . '",
						browserName = "' . mysql_real_escape_string($payload->browserName) . '",
						browserChannel = "' . mysql_real_escape_string($payload->browserChannel) . '",
						browserVersion = "' . mysql_real_escape_string($payload->browserVersion) . '",
						browserVersionType = "' . mysql_real_escape_string($payload->browserVersionType) . '",
						browserVersionMajor = "' . intval($payload->browserVersionMajor) . '",
						browserVersionMinor = "' . intval($payload->browserVersionMinor) . '",
						browserVersionOriginal = "' . mysql_real_escape_string($payload->browserVersionOriginal) . '",
						browserMode = "' . mysql_real_escape_string($payload->browserMode) . '",
						engineName = "' . mysql_real_escape_string($payload->engineName) . '",
						engineVersion = "' . mysql_real_escape_string($payload->engineVersion) . '",
						osName = "' . mysql_real_escape_string($payload->osName) . '",
						osVersion = "' . mysql_real_escape_string($payload->osVersion) . '",
						deviceManufacturer = "' . mysql_real_escape_string($payload->deviceManufacturer) . '",
						deviceModel = "' . mysql_real_escape_string($payload->deviceModel) . '",
						deviceType = "' . mysql_real_escape_string($payload->deviceType) . '",
						useragent = "' . mysql_real_escape_string($payload->useragent) . '",
						useragentHeader = "' . mysql_real_escape_string($useragentHeader) . '",
						useragentId = "' . mysql_real_escape_string(md5($useragentId)) . '",
						humanReadable = "' . mysql_real_escape_string($payload->humanReadable) . '",
						status = 0,
            orientationData = "' . mysql_real_escape_string(urldecode($payload->orientationData)) . '"
				');

			}

			break;

		case 'save':
			$payload = json_decode($_REQUEST['payload']);

			if (!$readonly) {
				mysql_query('
					UPDATE
						results
					SET
						used = used + 1,
						lastUsed = NOW()
					WHERE
						uniqueid = "' . mysql_real_escape_string($payload->uniqueid) . '"
				');
			}

			break;

		case 'confirm':
			$payload = json_decode($_REQUEST['payload']);

			if (!$readonly) {
				mysql_query('
					UPDATE
						results
					SET
						status = 1
					WHERE
						uniqueid = "' . mysql_real_escape_string($payload->uniqueid) . '"
				');
			}

			break;

		case 'report':
			$payload = json_decode($_REQUEST['payload']);

			if (!$readonly) {
				mysql_query('
					UPDATE
						results
					SET
						status = -1
					WHERE
						uniqueid = "' . mysql_real_escape_string($payload->uniqueid) . '"
				');
			}

			break;
	}