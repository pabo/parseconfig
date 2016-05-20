<?php

require_once('parseconfig.php');

$filename = "influx.config";

# configconfig is the specification of variables that are allowed in the config file. How meta!
$configconfig = array(
	"host" => array(
		"type" => 'string',
		"regex" => '[a-zA-Z0-9-_.]+',
		"value" => null
	),
	"server_id" => array(
		"type" => 'number',
		"regex" => '[0-9.]+',
		"value" => null
	),
	"server_load_alarm" => array(
		"type" => 'number',
		"regex" => '[0-9.]+',
		"value" => null
	),
	"user" => array(
		"type" => 'string',
		"regex" => '[a-zA-Z0-9-_.]+',
		"value" => null
	),
	"verbose" => array(
		"type" => 'boolean',
		"regex" => '(yes|no|true|false|on|off)',
		"value" => FALSE
	),
	"test_mode" => array(
		"type" => 'boolean',
		"regex" => '(yes|no|true|false|on|off)',
		"value" => FALSE
	),
	"debug_mode" => array(
		"type" => 'boolean',
		"regex" => '(yes|no|true|false|on|off)',
		"value" => FALSE
	),
	"log_file_path" => array(
		"type" => 'string',
		"regex" => "[a-zA-Z0-9._\/-]+", #FIXME test this with slashes
		"value" => null
	),
	"send_notifications" => array(
		"type" => 'boolean',
		"regex" => '(yes|no|true|false|on|off)',
		"value" => FALSE
	),
);

$parseconfig = parseConfig($configconfig, $filename);

var_dump($parseconfig);
?>
