<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => getenv('DB_HOST') ?: 'localhost',
	'username' => getenv('DB_USERNAME') ?: 'u586555303_kerma',
	'password' => getenv('DB_PASSWORD') ?: '3ii3M73cTI?F',
	'database' => getenv('DB_DATABASE') ?: 'u586555303_kerma',
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

// Catatan: Koneksi 'siakad' merupakan koneksi eksternal.
// Jika tidak dapat terhubung dari lokal, Anda mungkin perlu menyesuaikan atau men-disable model terkait (Siakad_model.php).
$db['siakad'] = array(
	'dsn'    => '',
	'hostname' => getenv('SIAKAD_DB_HOST') ?: '45.64.255.105',
	'username' => getenv('SIAKAD_DB_USERNAME') ?: 'simak',
	'password' => getenv('SIAKAD_DB_PASSWORD') ?: 's!4K4d$emas',
	'database' => getenv('SIAKAD_DB_DATABASE') ?: 'siak101013_public',
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
