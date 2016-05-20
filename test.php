<?php

require_once('parseconfig.php');

$filename = "test.config";
#$filename = "influx.config";

# configconfig is the specification of variables that are allowed in the config file. How meta!
$configconfig = array(
	"host" => array(
		"type" => 'string',
		"value" => null
	),
	"server_id" => array(
		"type" => 'number',
		"value" => null
	),
	"server_load_alarm" => array(
		"type" => 'number',
		"value" => null
	),
	"user" => array(
		"type" => 'string',
		"value" => null
	),
	"verbose" => array(
		"type" => 'boolean',
		"value" => FALSE
	),
	"test_mode" => array(
		"type" => 'boolean',
		"value" => FALSE
	),
	"debug_mode" => array(
		"type" => 'boolean',
		"value" => FALSE
	),
	"log_file_path" => array(
		"type" => 'string',
		"regex" => "[a-zA-Z0-9._\/-]+",
		"value" => null
	),
	"send_notifications" => array(
		"type" => 'boolean',
		"value" => FALSE
	),
);

$config = parseConfig($configconfig, $filename);

if ($config[verbose]) {
	print "User $config[user] on server_id $config[server_id]\n";
}

var_dump($config);

?>
