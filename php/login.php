<?php
session_start();		//starting a session
$error="";
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
		//Basis injection prevention

		$dbusername = stripslashes($username);
		$dbpassword = stripslashes($password);
		$dbusername = mysqli_real_escape_string($dbusername);
		$dbpassword = mysqli_real_escape_string($dbpassword);

		//Todo: check Login credentials and use salted hashes
		//$error holds the error message for wrong username/password
		if($connection){
			$_SESSION['login_user']=$username;	//initialize the session
			header("location: ./php/personalList.php");
		}
		mysqli_close($connection);
	}
}
?>