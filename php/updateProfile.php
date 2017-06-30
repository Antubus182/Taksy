<?php

$updateTaskId=(isset($_POST["updateTask"])? $_POST["updateTask"]:NULL);
$clicker=(isset($_POST["clicker"])? $_POST["clicker"]:NULL);
$taskData=(isset($_POST["taskData"])? $_POST["taskData"]:NULL);
$idToUse=(isset($_POST["idToUse"])? $_POST["idToUse"]:NULL);
$taskId=(isset($_POST["taskId"])? $_POST["taskId"]:NULL);
$subName=(isset($_POST["subName"])? $_POST["subName"]:NULL);


$config=json_decode(file_get_contents("../config.json"));
$dbuser=$config->mysqlu;
$dbpass=$config->mysqlp;
$dbhost=$config->mysqls;
$dbname=$config->mysqldb;

$output="No database connection granted";
$connection=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ("No database connection granted");

switch($updateTaskId){
	case 1:
		$output="subtaskDone\n";
		$output=subtaskDone($clicker,$taskData,$connection);
		break;
	case 2:
		$output="TaskDone\n";
		$output=taskDone($connection,$idToUse);
		break;
	case 3:
		$output="ProjectDone\n";
		break;
	case 4:
		$output="add subtask\n";
		$output=addSubTask($connection,$taskId,$subName);
		break;
	default:
		$output="ging niet helemaal goed\n";
}

function subtaskDone($clicker,$taskData,$connection){
	$id=substr($clicker,7);
	if($taskData=="true"){
		$query="UPDATE `Subs` SET `done`='1' WHERE `id`='".$id."'";
	}
	else{
		$query="UPDATE `Subs` SET `done`='0' WHERE `id`='".$id."'";
	}
	mysqli_query($connection,$query);
	return $query;
}

function ProjectDone($connection,$idToUse){
	//first get all tasks for this project,
	//then get all subtasks for the tasks
	//remove all subtasks
	//remove the tasks
	//remove the project
}

function taskDone($connection,$idToUse){
	$query="UPDATE `Tasks` SET `done`='1' WHERE `id`='".$idToUse."'";
	mysqli_query($connection,$query);
	return $query;
}

function addSubTask($connection,$taskId,$subName){
	$subName=mysqli_real_escape_string($connection,$subName);
	$taskId=mysqli_real_escape_string($connection,$taskId);
	$query="INSERT INTO `Subs` (`sname`,`done`,`tid`) VALUES ('".$subName."','0','".$taskId."')";
	mysqli_query($connection,$query);
	return $query;
}



	mysqli_close($connection);
	echo $output;

?>