<?php

require_once('parseconfig.php');

$filename = "test.config";

# configconfig is the specification of variables that are allowed in the config file. How meta!
$configconfig = array(
	# boolean yes/no
	"boolean.yesno.yes" => array(
		"type" => 'boolean',
		"regex" => "(yes|no)"
	),
	"boolean.yesno.no" => array(
		"type" => 'boolean',
		"regex" => "(yes|no)"
	),
	"boolean.yesno.true" => array(
		"type" => 'boolean',
		"regex" => "(yes|no)"
	),
	"boolean.yesno.false" => array(
		"type" => 'boolean',
		"regex" => "(yes|no)"
	),
	"boolean.yesno.null" => array(
		"type" => 'boolean',
		"regex" => "(yes|no)"
	),

	# boolean true/false
	"boolean.truefalse.yes" => array(
		"type" => 'boolean',
		"regex" => "(true|false)"
	),
	"boolean.truefalse.no" => array(
		"type" => 'boolean',
		"regex" => "(true|false)"
	),
	"boolean.truefalse.true" => array(
		"type" => 'boolean',
		"regex" => "(true|false)"
	),
	"boolean.truefalse.false" => array(
		"type" => 'boolean',
		"regex" => "(true|false)"
	),
	"boolean.truefalse.null" => array(
		"type" => 'boolean',
		"regex" => "(true|false)"
	),

	# string regex letters
	"string.regex.letters.abcd" => array(
		"type" => 'string',
		"regex" => "[a-zA-Z]+"
	),
	"string.regex.letters.AbCd" => array(
		"type" => 'string',
		"regex" => "[a-zA-Z]+"
	),
	"string.regex.letters.1abc" => array(
		"type" => 'string',
		"regex" => "[a-zA-Z]+"
	),
	"string.regex.letters.abc_" => array(
		"type" => 'string',
		"regex" => "[a-zA-Z]+"
	),

	# number
	"number.100" => array (
		"type" => 'number',
	),
	"number.one" => array (
		"type" => 'number',
	),
	"number.5.5" => array (
		"type" => 'number',
	),
	"number.0" => array (
		"type" => 'number',
	),
	"number.0.0" => array (
		"type" => 'number',
	),

	# misc
	"uncommented" => array (
		"type" => 'boolean',
	),
	"commented" => array (
		"type" => 'boolean',
	),

	# spaces
	"spaces.none" => array(
		"type" => 'string',
	),
	"spaces.left" => array(
		"type" => 'string',
	),
	"spaces.right" => array(
		"type" => 'string',
	),
	"spaces.leading" => array(
		"type" => 'string',
	),
	"spaces.trailing" => array(
		"type" => 'string',
	),
	"spaces.lots" => array(
		"type" => 'string',
	),
	"spaces.between" => array(
		"type" => 'string',
	),
);

$config = parseConfig($configconfig, $filename);

if ($config[verbose]) {
	print "User $config[user] on server_id $config[server_id]\n";
}

# This tests array of variable key names to expected values could have been merged into the
# $configconfig for easier maintainability, but then we would be constructing the $configconfig
# differently in our test than we would in live, so I decided against it.
$tests = array(
	"boolean.yesno.yes" => true,
	"boolean.yesno.no" => false,
	"boolean.yesno.true" => false,
	"boolean.yesno.false" => false,
	"boolean.yesno.null" => false,

	"boolean.truefalse.yes" => false,
	"boolean.truefalse.no" => false,
	"boolean.truefalse.true" => true,
	"boolean.truefalse.false" => false,
	"boolean.truefalse.null" => false,

	"string.regex.letters.abcd" => "abcd",
	"string.regex.letters.AbCd" => "AbCd",
	"string.regex.letters.1abc" => false,
	"string.regex.letters.abc_" => false,

	"number.100" => 100,
	"number.one" => false,
	"number.5.5" => 5.5,
	"number.0" => 0,
	"number.0.0" => 0,

	"uncommented" => true,
	"commented" => false,

	"spaces.none" => "spaces",
	"spaces.left" => "spaces",
	"spaces.right" => "spaces",
	"spaces.leading" => "spaces",
	"spaces.trailing" => "spaces",
	"spaces.lots" => "spaces",
	"spaces.between" => false, #by default, string type can't contain spaces
);

print "Running parseconfig unit tests...\n";
foreach ($tests as $key => $value) {
	print "$key: " . (($config[$key] == $value) ? "SUCCESS\n" : "FAIL\n");
}

print "\n\n";
var_dump($config);

?>
