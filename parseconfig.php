<?php
# brett.schellenberg@gmail.com
#
# thoughts
# setting a variable twice - should warn
# casing of configconfig - should normalize?

# Configuration variables are whitelisted in $configconfig associative array. These names are case sensitive.
# Each variable has a type, a regex which the value must match, and a value, which may be left null or used
# to set default values. #FIXME merge in default values
#
# There are three types:
#   string - any string of text
#   number - any ints or floats
#   boolean - yes/no, on/off, true/false
#


	function ParseConfig($configconfig, $configfile) {
		$configfile = "influx.config";
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
					print "name |$name| value |$value|\n";

					# if variable name is whitelisted && the value matches the allowed regex
					if (isset($configconfig["$name"]) && preg_match("/^{$configconfig["$name"]["regex"]}$/", $value)) {

						# cast value differently depending on the type.
						if ($configconfig["$name"]["type"] === 'boolean') {
							$configconfig["$name"]["value"] = (bool) preg_match("/^(true|on|yes)$/", $value);
							$variables["$name"] = (bool) preg_match("/^(true|on|yes)$/", $value);
						}
						elseif ($configconfig["$name"]["type"] === 'number') {
							$configconfig["$name"]["value"] = 0 + $value; # ensures we store as a number (int/double/whatever)
							$variables["$name"] = 0 + $value; # ensures we store as a number (int/double/whatever)
						}
						elseif ($configconfig["$name"]["type"] === 'string') {
							$configconfig["$name"]["value"] = "$value";
							$variables["$name"] = "$value";
						}
					}
				}
			}
			fclose($handle);
			print "returning\n";
			return $variables;
		}
		else {
			#error opening file, print error message and return
			print "Error opening file.";
			return;
		}
	}

?>
