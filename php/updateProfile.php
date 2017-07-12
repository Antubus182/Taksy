<?php
if($_SERVER['REQUEST_METHOD']!=='POST'){
	exit("only for post request");
}

$updateTaskId=(isset($_POST["updateTask"])? $_POST["updateTask"]:NULL);
$clicker=(isset($_POST["clicker"])? $_POST["clicker"]:NULL);
$taskData=(isset($_POST["taskData"])? $_POST["taskData"]:NULL);
$idToUse=(isset($_POST["idToUse"])? $_POST["idToUse"]:NULL);
$taskId=(isset($_POST["taskId"])? $_POST["taskId"]:NULL);
$subName=(isset($_POST["subName"])? $_POST["subName"]:NULL);
$projectId=(isset($_POST["projectId"])? $_POST["projectId"]:NULL);
$taskName=(isset($_POST["taskName"])? $_POST["taskName"]:NULL);
$taskColor=(isset($_POST["taskColor"])? $_POST["taskColor"]:NULL);
$userId=(isset($_POST["userId"])? $_POST["userId"]:NULL);
$ProjectName=(isset($_POST["ProjectName"])? $_POST["ProjectName"]:NULL);
$ProjectDescription=(isset($_POST["ProjectDescription"])? $_POST["ProjectDescription"]:NULL);
$ProjectDoneId=(isset($_POST["ProjectDoneId"])? $_POST["ProjectDoneId"]:NULL);


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
		$output="Delete Project\n";
		$output=ProjectDone($connection,$ProjectDoneId);
		break;
	case 4:
		$output="add subtask\n";
		$output=addSubTask($connection,$taskId,$subName);
		break;
	case 5:
		$output="add Task\n";
		$output=addTask($connection,$projectId,$taskName,$taskColor);
		break;
	case 6:
		$output="add Project\n";
		$output=addProject($connection,$userId,$ProjectName,$ProjectDescription);
		break;
	default:
		$output="ging niet helemaal goed\n";
}

function subtaskDone($clicker,$taskData,$connection){
	$id=substr($clicker,7);
	$id=mysqli_real_escape_string($connection,$id);
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
	//Future note: When a Project is shared, the owner field in the Project table should match with who issues the delete
	$idToUse=mysqli_real_escape_string($connection,$idToUse);
	$dummy="";
	$sql = "SELECT `id`,`projectids` FROM `Users` WHERE `projectids` REGEXP ',$idToUse(,|$)'";//deze query vind alle gebruikers die in dit project zaten
	$taskQuery="SELECT `id` FROM `Tasks` WHERE `pid`='$idToUse'";
	$result=mysqli_query($connection,$taskQuery);
	$taskArray=[];
	while($results=mysqli_fetch_array($result, MYSQLI_NUM)){
		$taskArray[]=$results[0];
	}
	$subArray=[];
	
	foreach($taskArray as $t){
		$subTaskQuery="SELECT `id` FROM `Subs` WHERE `tid`='$t'";
		$result=mysqli_query($connection,$subTaskQuery);
		while($results=mysqli_fetch_array($result,MYSQLI_NUM)){
			$subArray[]=$results[0];
		}
	}
	foreach ($subArray as $sub) {
		$deleteSub="DELETE FROM `Subs` WHERE `id`='$sudid'";
		mysqli_query($connection,$deleteSub);
	}

	foreach($taskArray as $t){
		$deleteTask="DELETE FROM `Tasks` WHERE `id`='$t'";
		mysqli_query($connection,$deleteTask);
	}

	$deleteProject="DELETE FROM `Projects` WHERE `id`='$idToUse'";
	mysqli_query($connection,$deleteProject);
	
	$result=mysqli_query($connection,$sql);
	while($results=mysqli_fetch_array($result,MYSQLI_NUM)){
		$dummy.=$results[1];
		$cut=",".$idToUse;
		$newids=str_replace($cut, "", $results[1]);
		$uid=$results[0];
		$updateProjectQuery="UPDATE `Users` SET `projectids`='$newids' where `id`='$uid'";
		mysqli_query($connection,$updateProjectQuery);
	}
	return($deleteProject);
}

function taskDone($connection,$idToUse){
	$idToUse=mysqli_real_escape_string($connection,$idToUse);
	$query="UPDATE `Tasks` SET `done`='1' WHERE `id`='".$idToUse."'";
	mysqli_query($connection,$query);
	return $query;
}

function addSubTask($connection,$taskId,$subName){
	$subName=mysqli_real_escape_string($connection,$subName);
	$taskId=mysqli_real_escape_string($connection,$taskId);
	$query="INSERT INTO `Subs` (`sname`,`done`,`tid`) VALUES ('$subName','0','$taskId')";
	mysqli_query($connection,$query);
	return $query;
}

function addTask($connection,$projectId,$taskName,$taskColor){
	$projectId=mysqli_real_escape_string($connection,$projectId);
	$taskName=mysqli_real_escape_string($connection,$taskName);
	$taskColor=mysqli_real_escape_string($connection,$taskColor);
	$query="INSERT INTO `Tasks` (`tname`,`color`,`done`,`pid`) VALUES ('$taskName','$taskColor','0','$projectId')";
	mysqli_query($connection,$query);
	return $query;
}

function addProject($connection,$userId,$ProjectName,$ProjectDescription){
	$userId=mysqli_real_escape_string($connection,$userId);
	$ProjectName=mysqli_real_escape_string($connection,$ProjectName);
	$ProjectDescription=mysqli_real_escape_string($connection,$ProjectDescription);
	$query="INSERT INTO `Projects` (`title`,`owner`,`description`,`color`) VALUES ('$ProjectName','$userId','$ProjectDescription','red')";
	mysqli_query($connection,$query);
	$sql = "SELECT `id` FROM `Projects` WHERE `owner` ='$userId' AND `title`='$ProjectName' AND `description`='$ProjectDescription' ORDER BY `id` DESC LIMIT 1";
	$selectsql=mysqli_query($connection,$sql);
	$result=mysqli_fetch_object($selectsql);
	$pid=$result->id;
	$pidAdd=",".$pid;
	$query2="UPDATE `Users` SET `projectids`=CONCAT(`projectids`,'$pidAdd') WHERE `id`='$userId'";
	mysqli_query($connection,$query2);
	return $query2;
}

	mysqli_close($connection);
	echo $output;

?>