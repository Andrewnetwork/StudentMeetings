<?php
session_start();

$password = "andy";

if( isset($_POST["action"]) && $_POST["action"] === "Logout" )
{
	$_SESSION["auth"] = false;
}
else if( isset($_POST["password"] ) && $_POST["password"] === $password )
{
	$_SESSION["auth"] = true;
	header('Location: admin.php');
}
else
{
	$_SESSION["auth"] = false;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="login.php">
  <label for="textfield">Password: </label>
  <input type="text" name="password" id="textfield" />
  <input type="submit" value="Enter" />
</form>
</body>
</html>