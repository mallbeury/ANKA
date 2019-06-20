<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo 'Hello World';

function connect_db() {
  global $databaseConfig;
/*  
  $databaseConfig = array(
    'type' => 'MySQLDatabase',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'database' => 'ss_ank',
    'path' => ''
  );
*/
  $databaseConfig = array(
    'type' => 'MySQLDatabase',
    'server' => 'localhost',
    'username' => 'ankaorga_user',
    'password' => 'IBS4nw;d0ms1',
    'database' => 'ankaorga_site',
    'path' => ''
  );

  $connection = new mysqli($databaseConfig['server'], $databaseConfig['username'], $databaseConfig['password'], $databaseConfig['database']);

  return $connection;
}

function getResultsFromDB($strSQL) {
  $db = connect_db();
  $result = $db->query($strSQL);
  $rows = array();
  $index = 0;
  while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
    $rows[$index] = $row;
    $index++;
  }

  return $rows;
}

$result = getResultsFromDB('select * from SiteTree');
var_dump($result);
