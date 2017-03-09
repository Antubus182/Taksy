<?php

$taskId=$_POST["taskId"];
$clicker=$_POST["clicker"];
$taskData=$_POST["taskData"];



$config=json_decode(file_get_contents("../config.json"));
$dbuser=$config->mysqlu;
$dbpass=$config->mysqlp;
$dbhost=$config->mysqls;
$dbname=$config->mysqldb;


$connection=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ("No database connection granted");

switch($taskId){
	case 1:
		$output="case1\n";
		$output=subtaskDone($clicker,$taskData,$connection);
		break;
	case 2:
		$output="case2\n";
		break;
	default:
		$output="ging niet helemaal goed\n";
}

function subtaskDone($clicker,$taskData,$connection){
	$id=substr($clicker,7);
	if($taskData=="true"){
		$query="UPDATE `subs` SET `done`='1' WHERE `id`='".$id."'";
	}
	else{
		$query="UPDATE `subs` SET `done`='0' WHERE `id`='".$id."'";
	}
	mysqli_query($connection,$query);
	return $query;
}



	mysqli_close($connection);
	echo $taskId."\n".$clicker."\n".$taskData."\n";
	echo $output;

?>