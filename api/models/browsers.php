<?php

	class Browsers {

		function getAll() {
			$results = array();

			$types = array('desktop', 'tablet', 'mobile', 'television', 'gaming');

			foreach($types as $type) {
				$res = mysql_query("
					SELECT
						browserName, browserChannel, browserVersion, osName, osVersion, deviceManufacturer, deviceModel, uniqueid
					FROM
						results
					WHERE deviceType = \"" . $type . "\" AND status = 1
					ORDER BY
						browserName, browserChannel, browserVersion, osName, osVersion, deviceManufacturer, deviceModel, timestamp, lastUsed
				");

				echo mysql_error();

				$results[$type] = array();

				while ($row = mysql_fetch_object($res)) {
					$results[$type][] = $row;
				}
			}

			return $results;
		}

	}
