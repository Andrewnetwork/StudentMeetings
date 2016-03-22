<?php
session_start();

if( !isset( $_SESSION["auth"] ) ||  $_SESSION["auth"] != true )
{
	header("Location: login.php");
}

$mysqli = new mysqli("localhost", "main", "", "test");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if( isset( $_POST["action"] ) )
{
	if( $_POST["action"] === "update" )
	{
		$sql = "UPDATE `member` SET `phone` = '".$_POST["phone"]."', `name` = '".$_POST["name"]."', `grade` = '".$_POST["grade"]."', `email` = '".$_POST["email"]."', `position` = '".$_POST["position"]."' WHERE `member`.`id` = ".$_POST["id"].";";
		
		$mysqli->query($sql);
	}
	else if($_POST["action"] === "create" )
	{
		$sql = "INSERT INTO `member` (`id`, `phone`, `name`, `grade`, `email`, `position`) VALUES (NULL, '".$_POST["phone"]."', '".$_POST["name"]."', '".$_POST["grade"]."', '".$_POST["email"]."', '".$_POST["position"]."');";
		
		$mysqli->query($sql);
	}
	else if( $_POST["action"] === "delete" )
	{
		$sql = "DELETE FROM `member` WHERE `id` = \"".$_POST["id"]."\"";
	
		$mysqli->query( $sql );
	
		header('Location: admin.php');
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Member</title>
</head>

<body>
<strong>Member Editor</strong>

<?php 


if(isset($_POST["id"]) || isset($_POST["name"]) )
{ 
	if( isset($_POST["id"]) )
	{
		$sql = "SELECT * FROM member WHERE id = \"".$_POST["id"]."\"";
	}
	else
	{
		$sql = "SELECT * FROM member WHERE id = \"".$mysqli->insert_id."\"";
	}
	
	$result = $mysqli->query($sql); 
	
	$row = $result->fetch_assoc();
?>
<form id="form1" name="form1" method="post" action="edit_member.php">
  <input type="hidden" name="id" value="<?php echo $row["id"]; ?>" />
  <label for="textfield">Name</label>
  <input type="text" value="<?php echo $row["name"] ?>" name="name" id="textfield" />
  <br />
  <label for="textfield2">Email Address</label>
  <input  name="email" type="text" id="textfield2" value="<?php echo $row["email"] ?>" size="40" />
  <br />
  <label for="textfield3">Position</label>
  <input type="text" value="<?php echo $row["position"] ?>"  name="position" id="textfield3" />
  <br />
  <label for="textfield4">Grade</label>
  <input type="text" value="<?php echo $row["grade"] ?>"  name="grade" id="textfield4" />
  <br />
  <label for="textfield5">Phone Number</label>
  <input type="text" value="<?php echo $row["phone"] ?>"  name="phone" id="textfield5" />
  
  <input type="hidden" name="action" value="update" />
  
<br />

<?php } 
else
{?>

<form id="form1" name="form1" method="post" action="">
  <label for="textfield">Name</label>
  <input type="text" name="name" id="textfield" />
  <br />
  <label for="textfield2">Email Address</label>
  <input  name="email" type="text" id="textfield2" size="40" />
  <br />
  <label for="textfield3">Position</label>
  <input type="text"  name="position" id="textfield3" />
  <br />
  <label for="textfield4">Grade</label>
  <input type="text"  name="grade" id="textfield4" />
  <br />
  <label for="textfield5">Phone Number</label>
  <input type="text" name="phone" id="textfield5" />
  
  <input type="hidden" name="action" value="create" />
<br />

<?php } ?>
<input type="submit" value="Save changes" />
</form>
<a href="admin.php" target="_self">&lt;--- Back to admin page</a>
</body>
</html>