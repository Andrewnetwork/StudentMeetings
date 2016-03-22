<?php

$mysqli = new mysqli("localhost", "main", "", "test");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="student_meeting.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Attendance Viewer</title>
</head>

<body>
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td class="topAttendanceCell" style="width:200px;">Name</td>
    <?php
		// Meeting dates. 
		$res = $mysqli->query("SELECT date from meeting");
		
		while( $row = $res->fetch_assoc() )
		{
			echo '<td class="topAttendanceCell">'.$row["date"].'</td>';
		}
	?>
  </tr>
  <?php
  
  // Create a row for each member. Mark each date absent with a red square; green for present. 
  
  $res = $mysqli->query("SELECT name,id from member ORDER BY name ASC", MYSQLI_STORE_RESULT);
  
  while( $row = $res->fetch_assoc() )
  {
	  echo '<tr>';
	  echo '<td>'.$row["name"].'</td>';
	  
	  $res2 = $mysqli->query("SELECT date from meeting", MYSQLI_STORE_RESULT);
	  
	  // Itterate through the dates
	  while( $row2 = $res2->fetch_assoc() )
	  {
		  // Find out if the current member attended the meeting corresponding to that date. 
		  $sql = "SELECT member_id 
		          FROM meeting_attended 
				  WHERE meeting_date = '".$row2["date"]."' and member_id ='".$row["id"]."'";
				  
		  $res3 = $mysqli->query($sql, MYSQLI_STORE_RESULT);
		  
		  if( $res3->fetch_assoc() )
		  {
			  // Member attended. 
			  echo "<td class='attendanceCellPresent'></td>";
		  }
		  else
		  {
			  echo "<td class='attendanceCellAbsent'></td>";
		  }
	  }
	  
	  echo "<tr />";
  }
  
  
  ?>
</table>


</body>
</html>