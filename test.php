<?php

require_once('parseconfig.php');

$filename = "test.config";
#$filename = "influx.config";

# configconfig is the specification of variables that are allowed in the config file. How meta!
$configconfig = array(
	"host" => array(
		"type" => 'string',
	),
	"server_id" => array(
		"type" => 'number',
	),
	"server_load_alarm" => array(
		"type" => 'number',
	),
	"user" => array(
		"type" => 'string',
	),
	"verbose" => array(
		"type" => 'boolean',
	),
	"test_mode" => array(
		"type" => 'boolean',
	),
	"debug_mode" => array(
		"type" => 'boolean',
	),
	"log_file_path" => array(
		"type" => 'string',
		"regex" => "[a-zA-Z0-9._\/-]+",
	),
	"send_notifications" => array(
		"type" => 'boolean',
	),
);

$config = parseConfig($configconfig, $filename);

if ($config[verbose]) {
	print "User $config[user] on server_id $config[server_id]\n";
}

var_dump($config);

?>
