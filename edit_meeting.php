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

if( isset( $_POST["action"] ) && $_POST["action"] === "delete" )
{
	$sql = "DELETE FROM `meeting` WHERE `date` = \"".$_POST["date"]."\"";
	
	$mysqli->query( $sql );
	
	header('Location: admin.php');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="student_meeting.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Meeting</title>
</head>

<body>
<?php

if( isset($_POST["action"]) )
{
	if( $_POST["action"] === "update" )
	{
		// If meeting does not exist, create it. 
		$sql = "SELECT * FROM meeting WHERE date = \"".$_POST["date"]."\"";
		
		$result = $mysqli->query($sql);
		
		if( !$result->fetch_assoc() )
		{
			$sql = "INSERT INTO `meeting` (`date`, `notes`) VALUES (\"".$_POST["date"]."\", \"EJreer\");";
			$mysqli->query($sql);
			
			echo($mysqli->error);
		}
		
		
		$sql = "DELETE FROM `meeting_attended` WHERE `meeting_date` = \"".$_POST["date"]."\"";
		
		$mysqli->query( $sql );
		
		foreach($_POST as $key => $val) 
		{
			if( is_int( $key ) )
			{
				$sql = "INSERT INTO `meeting_attended`(`meeting_date`, `member_id`) VALUES (\"".$_POST["date"]."\",\"".$key."\")";
				$mysqli->query( $sql );
			}
		}
	}	
}



function makeMember($name , $id , $attended )
{
	$outStr = '<tr>';
    $outStr .= '<td>'.$name.'</td>';
	
	if( $attended )
	{
    	$outStr .= '<td><input type="checkbox" name="'.$id.'" checked="cheked" value="1" /></td>';
	}
	else
	{
		$outStr .= '<td><input type="checkbox" name="'.$id.'" value="0" /></td>';
	}
	
    $outStr .= '</tr>';
	
	return $outStr;
}

?>

<p><strong>Edit Meeting</strong></p>

<form action="edit_meeting.php" method="post">
Date(yyyy-mm-dd): 
  <input type="text" name="date" value="<?php

if( isset($_POST["date" ] ) )
{
	echo $_POST["date"];
}

?>" /><br /><br />


<table width="400px" style="text-align:center" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="270" class="topCell">Member Name</td>
    <td width="124" class="topCell">Attended</td>
  </tr>
  <?php
  

	
    $res = $mysqli->query("SELECT id,name FROM  member ORDER BY  `name` ASC", MYSQLI_STORE_RESULT);
    

	while( $row = $res->fetch_assoc() )
	{
		if( isset($_POST["date"]) )
		{
			// If this is not a new meeting. 
			$sql = "SELECT `id` FROM meeting_attended,member WHERE meeting_date = \"".$_POST["date"]."\" and member_id = id and id=\"".$row['id']."\"";
			
			$result = $mysqli->query($sql);
	
			if( $result->fetch_assoc() )
			{
				echo makeMember( $row['name'] ,  $row['id'] , true );
			}
			else
			{
				echo makeMember( $row['name'] , $row['id'] , false );
			}
		}
		else
		{
			echo makeMember( $row['name'] , $row['id'] , false );
		}
		
		
	}
  
  ?>
  
</table>

<input type="submit" value="Save" />
<input type="hidden" name="action" value="update" />
</form>

<a href="admin.php" target="_self">&lt;--- Back to admin page</a>

<p>&nbsp;</p>
</body>
</html>
