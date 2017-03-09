<?php
include('php/login.php');
if(isset($_SESSION['login_user'])){
  header("location: php/personalList.php");
}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tasky by N&pi;</title>
  <link rel="stylesheet" href="css/loginform.css">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
</head>

<body>
  <div id="main">
    <form action="" method ="post" id="login">
      <h1 id="form-title">Welcome to Tasky</h1>
      <fieldset id="inputs" class="form-items">
        <input type="text" id="name" name="username" class="inputfields" placeholder="Username">
        <input type="password" id="password" class="inputfields" name="password" placeholder="********">
      </fieldset>
      <fieldset id="actions" class="form-items">
        <input type="submit" name="submit" id="submit" value="Login">
      </fieldset>
      <span><?php echo $error;?></span>
    </form>
  </div>
</body>
<!-- 
BG: Fancy Pants by Anton Repponen
http://thepatternlibrary.com/#fancy-pants
 -->