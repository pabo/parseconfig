<?php
# brett.schellenberg@gmail.com
#
# parseConfig() parses a configuration file which may contain comments and configuration variable key/pairs
# and spits out an associative array of the variables which it set. This parsing is done line by line.
#
# Lines beginning with the '#' character are treated as comments and ignored.
# Lines containing the '=' character are treated as configuration variable key/value pairs and we attempt
#   to parse them as such. If they fail either the key or value regex they are ignored.
# All other lines are ignored.
# If a key is given more than once in the configuration file, the value in the last valid definition will be used.
#
# Configuration variables are whitelisted in the $configspec associative array. These names are case sensitive.
# Each variable in the specification has a type and an optional regex which the value must match. If no regex
# is given, we fall back to a default regex per-type (see below).
#
# There are three supported types:
#   string - any string of text. default regex is /^[a-zA-Z0-9_.-]+$/ (Note that spaces are not included.)
#   number - any ints or floats. default regex is /^\d*\.?\d+$/
#   boolean - yes/no, on/off, true/false. default regex is /^(yes|no|true|false|on|off)$/
#
# Example configspec:
# $configspec = array(
#  "user" => array(
#    "type" => 'string',
#    "regex" => '[a-z]+',
#  ),
#  "server_id" => array(
#    "type" => 'number',
#  ),
#  "verbose" => array(
#    "type" => 'boolean',
#  ),
# );
#
# Example usage:
# $config = parseConfig($configspec, $configfile);
#
# # config variables are now available in $config associative array with their names as keys.
# # $config[user]
# # $config[server_id]
# # $config[verbose]
# # etc
#
# if ($config[verbose]) {
#     print "User $config[user] on server_id $config[server_id]\n";
# }
#
# TODO: possible enhancements
# option to warn if value doesn't match regex


function parseConfig($configspec, $configfile) {
	# an associative array for the values parsed from the file

	#open config file and process it
	if (($handle = fopen($configfile, "r")) !== FALSE) {
		while (($line = fgets($handle)) !== FALSE) {

			# skip comments
			if ($line[0] === "#") {
				continue;
			}

			$line = rtrim($line);

			# if the line has an = in it, ignore optional spaces directly on either side and try to parse as name=value
			if (preg_match("/^(.+?)\s*=\s*(.+?)$/", $line, $matches)) {
				$name = $matches[1];
				$value = $matches[2];

				# if variable name is whitelisted
				# then check against provided regex, or this type's default regex
				if (isset($configspec["$name"])) {

					if ($configspec["$name"]["type"] === 'boolean') {
						$regex = $configspec["$name"]["regex"] ?: "(yes|no|true|false|on|off)";

						if (preg_match("/^$regex$/", $value)) {
							$variables["$name"] = (bool) preg_match("/^(true|on|yes)$/", $value);
						}
					}
					elseif ($configspec["$name"]["type"] === 'number') {
						$regex = $configspec["$name"]["regex"] ?: "\d*\.?\d+";

						if (preg_match("/^$regex$/", $value)) {
							$variables["$name"] = 0 + $value; # ensures we store as a number (int/double/whatever)
						}
					}
					elseif ($configspec["$name"]["type"] === 'string') {
						$regex = $configspec["$name"]["regex"] ?: "[a-zA-Z0-9_.-]+";

						if (preg_match("/^$regex$/", $value)) {
							$variables["$name"] = "$value";
						}
					}
				}
			}
		}
		fclose($handle);
		return $variables;
	}
	else {
		#error opening file, print error message and return
		print "Error opening file.";
		return;
	}
}

?>
