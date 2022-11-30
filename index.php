<?PHP
	session_start();
	if($_SESSION['sid'] == session_id() && $_SESSION['user'] == "Staff")
	{	
		$staff_id = $_SESSION['staff_id'];
		
		$connection = @mysql_connect("localhost", "root", "") or die(mysql_error());
		
		$sql1 = "SELECT * FROM leavesystemphp.staff WHERE staff_id = '".$staff_id."'";
		
		$sql2 = "SELECT * FROM leavesystemphp.leave_statistics WHERE staff_id = '".$staff_id."'";
		
		$result1 = mysql_query($sql1, $connection);
		
		$result2 = mysql_query($sql2, $connection);
		
		while($row1 = mysql_fetch_array($result1))
		{
			$first_name = $row1['first_name'];
			$middle_name = $row1['middle_name'];
			$last_name = $row1['last_name'];
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Staff Profile</title>
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
    <div id="heading">Home<hr size="2" color="#FFFFFF" ice:repeating=""/></div>
    <div id="form">
    <form method="post" action="approve_reject_db.php">
    <fieldset>
    <legend>Personal Information</legend>
    <label for="staff_id"><span>Staff ID </span>
    	<input type="text" name="staff_id" id="staff_id" readonly="true" value="<?php echo $staff_id ?>" style="background-color:#F6F6F6; color:#a90000" />
    </label>
    <label for="staff_name"><span>Staff Name </span>
    	<input type="text" readonly="true" value="<?php echo $first_name." ".$middle_name." ".$last_name ?>" style="background-color:#F6F6F6; color:#a90000" />
    </label>
    </fieldset>
    <br />
    <fieldset>
    <legend>Current Leave Balances</legend>
    <div id="table">
    	<span><table border="1" bgcolor="#006699" >
				<tr>
                	<th width="190px">Leave Types</th>
					<th width="180px">Maximum Allowed Leaves</th>
					<th width="120px">Leaves Taken</th>
					<th width="150px">Remaining Leaves</th>
				</tr>
			</table></span>
    <?PHP
    while($row2 = mysql_fetch_array($result2))
		{
			$leave_type = $row2['leave_type'];
			$maximum_leaves = $row2['maximum_leaves'];
			$laves_taken = $row2['leaves_taken'];
			$remaining_leaves = $maximum_leaves - $laves_taken;
			echo "<table border=\"1\">
					<tr>
						<td width=\"190px\">".$leave_type."</td>
						<td width=\"180px\">".$maximum_leaves."</td>
						<td width=\"120px\">".$laves_taken."</td>
						<td width=\"150px\">".$remaining_leaves."</td>
					</tr>
				</table>";
		}
		
	?>
    </div>
    </fieldset>
    </form>
    </div>
  </div>
  <?php include 'sidebar.php'?>
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
