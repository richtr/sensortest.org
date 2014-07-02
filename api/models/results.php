<?php

	class Results {

		function getByUniqueId($id) {
			$res = mysql_query("
				SELECT
					*
				FROM
					results
				WHERE
					uniqueid = '" . mysql_real_escape_string($id) . "'
			");

			if ($row = mysql_fetch_object($res)) {

				// Update use counter
				mysql_query('
					UPDATE
						results
					SET
						used = used + 1,
						lastUsed = NOW()
					WHERE
						uniqueid = "' . mysql_real_escape_string($id) . '"
				');

				return $row;
			}
		}

	}
