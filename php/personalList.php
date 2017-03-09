<?php
include_once 'htmlBuilder.php'; 
include_once 'datacollection.php';
session_start();

$usr=$_SESSION['login_user'];
//$usr="Niels";
$config=json_decode(file_get_contents("../config.json"));
$dbuser=$config->mysqlu;
$dbpass=$config->mysqlp;
$dbhost=$config->mysqls;
$dbname=$config->mysqldb;


	$connection=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ("No database connection granted");

	$projectlist=array();
	$tasklist=array();

	$userdata=getProjectids($usr,$connection);						//get an userobject from the usertable

	$projectids=array_map('intval',explode(',', $userdata->projectids)); //turn the csv of id's into an array

	foreach ($projectids as $pid) {									//get data of each project
		$project=array();											//get an object with project data
		$tasklist=array();											//get an array with taskobjects for the project
		$projectprops=getProjects($pid,$connection);
		$projectTasks=getTasks($pid,$connection);
		foreach ($projectTasks as $ptask) {	
			$sublist=array();
			$subtasks=getSubTasks($ptask->id,$connection);			//get the subtasks for the main task
			foreach ($subtasks as $sub) {
				$subje["id"]=$sub->id;
				$subje["subname"]=$sub->sname;
				$subje["done"]=$sub->done;
				$sublist[]=$subje;
			}
			$task["id"]=$ptask->id;
			$task["tname"]=$ptask->tname;
			$task["color"]=$ptask->color;
			$task["done"]=$ptask->done;
			$task["subtasks"]=$sublist;
			$tasklist[]=$task;
		}
		$project["id"]=$projectprops->id;
		$project["name"]=$projectprops->title;
		$project["owner"]=$projectprops->owner;
		$project["description"]=$projectprops->description;
		$project["color"]=$projectprops->color;
		$project["tasks"]=$tasklist;
		$projectlist[]=$project;
	}

	mysqli_close($connection);


	$html=generatePage($projectlist,$userdata);
	echo $html;
	//print_r($projectlist);
?>
