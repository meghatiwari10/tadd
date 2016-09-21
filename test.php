<?php 
	include("db.php");
	$sql="delete from employee_checkin_record where entry_date='2016-07-13' and employee_time_in='00:15:44'";
	$result=$db->query($sql);
	if($result)
		echo "true";
?>