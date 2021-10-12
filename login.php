<?php
session_start();
$logindex= ($_SESSION) ? $_SESSION['login'] : "";
$validUser = ($logindex === true) ? true : false;
if(isset($_POST["sub"])) {
  $validUser = $_POST["username"] == "admin" && $_POST["password"] == "5007";
  if(!$validUser) $errorMsg = "Invalid username or password.";
  else $_SESSION["login"] = true;
}
if($validUser) {
   header("Location:index.php"); die();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <title>Login</title>   
        <link rel="stylesheet" type="text/css" href="asset/style.css">
</head>
<body>

<div class="master">
<div id="stitle"><h1 style="color: #ffffff51">YawarDUP</h1> 
<h2>Login to System</h2>
</div>

  <form name="input" action="" method="post" class="loginform" >
    <input type="text" placeholder="username" value="" id="username" name="username" />
    <input type="password" placeholder="password" value="" id="password" name="password" />
    
    <button type="submit" name="sub" />Login</button>
  </form>
</div>  
</body>
</html>