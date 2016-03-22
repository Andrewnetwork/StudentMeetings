<?php

session_start();
if( !isset( $_SESSION["auth"] ) ||  $_SESSION["auth"] !== true )
{
	header("Location: login.php");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Meetings | Admin Page</title>
</head>

<body>
<p class="top_title"><strong>Newtown High School Student Government Database</strong></p>

<form method="post" action="login.php">
<input name="action" type="Submit" value="Logout" />
</form>



<p class="top_title">Meetings </p>
<?php

$mysqli = new mysqli("localhost", "main", "", "test");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}


// Function Definitions 

function makeEditMeetingButton($date)
{
	$outStr = '<form id="form1" name="form1" method="post" action="edit_meeting.php">';
    $outStr .= '<input type="submit" name="edit" value="Edit" />';
    $outStr .= '<input type="hidden" name="date" value="'.$date.'" />';
	$outStr .= '</form>';
	
	return $outStr;
}

function makeNewMeetingButton()
{
	$outStr = '<form id="form1" name="form1" method="post" action="edit_meeting.php">';
    $outStr .= '<input type="submit" name="action" value="New meeting" />';
	$outStr .= '</form>';
	
	return $outStr;
}

function makeDeleteMeetingButton( $date )
{
	$outStr = '<form id="form1" name="form1" method="post" action="edit_meeting.php">';
    $outStr .= '<input type="submit" name="delete" value="Delete" />';
    $outStr .= '<input type="hidden" name="date" value="'.$date.'" />';
	$outStr .= '<input type="hidden" name="action" value="delete" />';
	$outStr .= '</form>';
	
	return $outStr;
}

function makeEditMemberButton( $id )
{
	$outStr = '<form id="form1" name="form1" method="post" action="edit_member.php">';
    $outStr .= '<input type="submit" name="edit" value="Edit" />';
    $outStr .= '<input type="hidden" name="id" value="'.$id.'" />';
	$outStr .= '<input type="hidden" name="action" value="edit" />';
	$outStr .= '</form>';
	
	return $outStr;
}

function makeDeleteMemberButton($id)
{
	$outStr = '<form id="form1" name="form1" method="post" action="edit_member.php">';
    $outStr .= '<input type="submit" name="Delete" value="Delete" />';
    $outStr .= '<input type="hidden" name="id" value="'.$id.'" />';
	$outStr .= '<input type="hidden" name="action" value="delete" />';
	$outStr .= '</form>';
	
	return $outStr;
}

?>

<table width="600px" border="1" cellpadding="0" cellspacing="0" style="text-align:center">
  <tr>
    <td class="topCell">Meeting Date</td>
    <td class="topCell">Edit</td>
    <td class="topCell">Delete</td>
  </tr>
  <?php
  	$mysqli->real_query("SELECT * FROM  `meeting` ORDER BY  `date` DESC");
    $res = $mysqli->use_result();
    
   
    while ($row = $res->fetch_assoc()) 
    {
        echo "<tr>";
        echo "<td>" . $row['date'] . "</td>";
        echo  "<td>" . makeEditMeetingButton( $row['date'] ) . "</td>";
        echo  "<td>" . makeDeleteMeetingButton($row['date']) . "</td>";
        echo "</tr>";
        
    }

  ?>
</table>
<?php echo makeNewMeetingButton(); ?>

<p><strong>Members </strong></p>
<table width="600px" border="1" cellpadding="0" cellspacing="0" style="text-align:center">
  <tr>
    <td class="topCell">Member</td>
    <td class="topCell">Edit</td>
    <td class="topCell">Delete</td>
  </tr>
  <?php
  	$mysqli->real_query("SELECT name,id FROM  member ORDER BY name ASC");
    $res = $mysqli->use_result();
    
   
    while ($row = $res->fetch_assoc()) 
    {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo  "<td>" . makeEditMemberButton( $row['id'] ) . "</td>";
        echo  "<td>" . makeDeleteMemberButton($row['id']) . "</td>";
        echo "</tr>";
        
    }

  ?>
</table>
<form action="edit_member.php">
<input type="submit" value="New member" />
</form>
<p>&nbsp;</p>

</body>
</html>
