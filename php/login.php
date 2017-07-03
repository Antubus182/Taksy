<?php
session_start();		//starting a session
$error="";
$passvalid=false;
if(isset($_POST['submit'])){
	if(empty($_POST['username'])||empty($_POST['password'])){
		$error="Empty Username or Password";
	}
	else{
		$username=$_POST['username'];
		$password=$_POST['password'];
		//connect to database
		$config=json_decode(file_get_contents("./config.json"));
		$dbuser=$config->mysqlu;
		$dbpass=$config->mysqlp;
		$dbhost=$config->mysqls;
		$dbname=$config->mysqldb;
		$connection=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ("No database connection granted");
		//Calculate the password Hash
		$username=mysqli_real_escape_string($connection,$username);
		$salt="SaltyTask"; //Best practice this should be generated with a crypt function
		$hash=hash('sha512',$password.$salt.$username); //Now we have a unique salt (still not best practice but beter than no or static salt)
		//Get hash from the Database
		$sql = "SELECT `Pass` FROM `Users` WHERE `name`='$username'";
		$passsql=mysqli_query($connection,$sql);
		$result=mysqli_fetch_object($passsql);
		mysqli_close($connection);
		
		//Launch application
		if($result->Pass==$hash){
			$_SESSION['login_user']=$username;	//initialize the session
			header("location: ./php/personalList.php");
		}
		else{
			$error="Username and/or Password is invalid";
			//$error=$hash;
		}
	}
}
?>