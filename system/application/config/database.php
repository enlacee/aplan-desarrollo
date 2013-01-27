<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = "default";
$active_record = TRUE;

$db['default']['hostname'] = "localhost";
$db['default']['username'] = "root";
$db['default']['password'] = "";
$db['default']['database'] = "aplan-desarrollo";
$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";

/*$active_group = "bd_maestros";
$active_record = TRUE;

$db['bd_maestros']['hostname'] = "localhost";
$db['bd_maestros']['username'] = "root";
$db['bd_maestros']['password'] = "";
$db['bd_maestros']['database'] = "seguridad";
$db['bd_maestros']['dbdriver'] = "mysql";
$db['bd_maestros']['dbprefix'] = "";
$db['bd_maestros']['pconnect'] = TRUE;
$db['bd_maestros']['db_debug'] = TRUE;
$db['bd_maestros']['cache_on'] = FALSE;
$db['bd_maestros']['cachedir'] = "";
$db['bd_maestros']['char_set'] = "utf8";
$db['bd_maestros']['dbcollat'] = "utf8_general_ci";*/

/*
$db['bd_transacciones']['hostname'] = "localhost";
$db['bd_transacciones']['username'] = "root";
$db['bd_transacciones']['password'] = "";
$db['bd_transacciones']['database'] = "seguridad";
$db['bd_transacciones']['dbdriver'] = "mysql";
$db['bd_transacciones']['dbprefix'] = "";
$db['bd_transacciones']['pconnect'] = TRUE;
$db['bd_transacciones']['db_debug'] = TRUE;
$db['bd_transacciones']['cache_on'] = FALSE;
$db['bd_transacciones']['cachedir'] = "";
$db['bd_transacciones']['char_set'] = "utf8";
$db['bd_transacciones']['dbcollat'] = "utf8_general_ci";*/



/* End of file database.php */
/* Location: ./system/application/config/database.php */