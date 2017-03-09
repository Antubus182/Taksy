<?php
function getProjectids($usr,$connection){
	
	$query="SELECT `projectids` , `id` , `name` , `about` FROM `Users` WHERE `name`= '".$usr."'";
	$resultobject=mysqli_query($connection,$query);
	$result=mysqli_fetch_object($resultobject);

	return $result;
}

function getProjects($pid,$connection){

	$query="SELECT * FROM `Projects` WHERE `id`= '".$pid."'";
	$resultobject=mysqli_query($connection,$query);
	$result=mysqli_fetch_object($resultobject);
	return $result;
}

function getTasks($pid,$connection){

	$query="SELECT * FROM `Tasks` WHERE `pid`= '".$pid."'";
	$resultobject=mysqli_query($connection,$query);
	$result=array();
	while($results=mysqli_fetch_object($resultobject)){
		$result[]=$results;
	}
	
	return $result;	
}

function getSubTasks($tid,$connection){

	$query="SELECT * FROM `subs` WHERE `tid`= '".$tid."'";
	$resultobject=mysqli_query($connection,$query);
	$result=array();
	while($results=mysqli_fetch_object($resultobject)){
		$result[]=$results;
	}
	return $result;
}
?>
