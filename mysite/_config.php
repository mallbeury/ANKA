<?php

global $project;
$project = 'mysite';

global $databaseConfig;

$databaseConfig = array(
	'type' => 'MySQLDatabase',
	'server' => 'localhost',
	'username' => 'root',
	'password' => 'root',
	'database' => 'ss_ank',
	'path' => ''
);

/*
$databaseConfig = array(
  'type' => 'MySQLDatabase',
  'server' => 'localhost',
  'username' => 'ankaorga_user',
  'password' => 'IBS4nw;d0ms1',
  'database' => 'ankaorga_site',
  'path' => ''
);
*/

FulltextSearchable::enable();

// Set the site locale
i18n::set_locale('en_US');
