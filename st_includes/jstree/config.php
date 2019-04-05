<?php echo "Luis Burgos";
// Database config & class
include_once('../../st_ModuloSeguridad/DataCN.php');
$DataCN = new DataCN();
$db_config = array(
	"servername"=> $DataCN::server,
	"username"	=> $DataCN::username,
	"password"	=> $DataCN::password,
	"database"	=> $DataCN::database
);
if(extension_loaded("mysqli")) require_once("_inc/class._database_i.php"); 
else require_once("_inc/class._database.php"); 

// Tree class
require_once("_inc/class.tree.php"); 
?>