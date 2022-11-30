<?PHP
	session_start();
	if($_SESSION['sid'] == session_id() && $_SESSION['user'] == "Staff")
	{	
		$staff_id = $_SESSION['staff_id'];
		
		$connection = @mysql_connect("localhost", "root", "") or die(mysql_error());
		
		$sql = "SELECT * FROM leavesystemphp.leave_requests WHERE staff_id = '".$staff_id."' AND leave_status = 'Pending'";
		
		$result = mysql_query($sql, $connection);
		
		if(mysql_num_rows($result)==0)
		{
			echo 	"<script>
					alert(\"No Leave History to Show!\");
					window.location=\"view_leave_history.php\";</script>";
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Leave Status</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(../images/bg.gif);
}
</style>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="container">
  <div id="header">
    <div id="title">Leave Management System</div>
    <div id="quick_links">
      <ul>
        <li><a class="home" href="index.php">Home</a></li>
        <li>|</li>
        
        <li><a class="logout" href="../logout.php">Logout</a></li>
        <li>|</li>
        <li><a class="greeting" href="#">Hi <?php echo $_SESSION['user']; ?></a></li>
      </ul>
    </div>
  </div>
  <div id="content_panel">
    <div id="heading">Applied Leave Status<hr size="2" color="#FFFFFF" ice:repeating=""/></div>
    <div id="table">
    	<span><table border="1" bgcolor="#006699" >
				<tr>
					<th width="190px">Leave Type</th>
					<th width="90px">Start Date</th>
					<th width="90px">End Date</th>
					<th width="90px">No. of Days</th>
					<th width="120px">Applied Date</th>
					<th width="120px">Status</th>
				</tr>
			</table></span>
     <?PHP
		while($row = mysql_fetch_array($result))
		{
			$leave_type = $row['leave_type'];
			$start_date = $row['start_date'];
			$end_date = $row['end_date'];
			$no_of_days = $row['days_requested'];
			$date_applied = $row['date_applied'];
			$status = $row['leave_status'];
			
			echo "<table border=\"1\">
					<tr>
						<td width=\"190px\">".$leave_type."</td>
						<td width=\"90px\">".$start_date."</td>
						<td width=\"90px\">".$end_date."</td>
						<td width=\"90px\">".$no_of_days."</td>
						<td width=\"120px\">".$date_applied."</td>
						<td width=\"120px\">".$status."</td>
					</tr>
				</table>";
		}
	?>
    </table>
    </label>
  </div>
  </div>
  <?php $page="view_leave_status"; include 'sidebar.php'?>
  <div id="footer">
  	<p><br />&copy; J!N <?php echo date("Y"); ?> Leave Management System</p>
  </div>
</div>
</body>
</html>
<?php
	}
	else
	{
		header("Location: ../index.php");
	}
	mysql_close($connection);
?>
