<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'u586555303_kerma',
	'password' => 'Kerma0521',
	'database' => 'u586555303_kerma',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['siakad'] = array(
	'dsn'    => '',
	'hostname' => '45.64.255.105',
	'username' => 'simak',
	'password' => 's!4K4d$emas',
	'database' => 'siak101013_public',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => false,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => false,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => false,
	'compress' => false,
	'stricton' => false,
	'failover' => array(),
	'save_queries' => true
);
