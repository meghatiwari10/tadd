<?php

	include "db.php";
	header('Content-type: application/json');
	$array=array();
	session_start();
	$employee_name=$_SESSION['employee_name'];
	$sql="select employee_name,leave_start_date,leave_stop_date,leave_type from leaves_main where employee_name='$employee_name' and leave_status='granted'";
	$result=$db->query($sql);
	while($row=$result->fetch_assoc())
	{
		$array[]=$row;

		$count=sizeof($array);
		/*for ($i=0;$i<sizeof($row);i++)
		{
			$array[$i]=$row['name'];
		}
		print_r($array);*/
		//echo $array[0];
	}
	//echo $count;

	for($i=0; $i<$count; $i++)
	{
		date_default_timezone_set ("Asia/Calcutta");
		$enddate= new DateTime($array[$i]['leave_stop_date']);
		$enddate=$enddate->modify('+1 day');
		$enddate=$enddate->format('y/m/d');
		$enddate=str_replace('/', '-', $enddate);
		$enddate=date('Y-m-d', strtotime($enddate));
		$events[]=array(
			'title'=> $array[$i]['employee_name']." ".$array[$i]['leave_type'],
			'start'=> $array[$i]['leave_start_date'],
			'end'=> $enddate
			
		);
		/*$events['title']=$array[$i]['name'];
		$events['start']=$array[$i]['leave_start_date'];
		$events['end']=$array[$i]['leave_stop_date'];*/
		
		
		//echo json_encode($events);
	}
	echo json_encode($events);
	

?>