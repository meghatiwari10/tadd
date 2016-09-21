<?php

	include "db.php";
	header('Content-type: application/json');
	date_default_timezone_set ("Asia/Calcutta");
	
	$today_date=date("Y-m-d");
	
	$sql="select * from employee_checkin_record where employee_isWfh='yes'";
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
		
		
		$employee_wfh_date=new DateTime($array[$i]['employee_wfh_date']);
		
		
		
		
		$events[]=array(
			'title'=> $array[$i]['employee_name']." WFH",
			'start'=> $array[$i]['entry_date'],
			'end'=> $array[$i]['entry_date']
			
		);
		/*$events['title']=$array[$i]['name'];
		$events['start']=$array[$i]['leave_start_date'];
		$events['end']=$array[$i]['leave_stop_date'];*/
		
		
		//echo json_encode($events);
	}
	echo json_encode($events);
	
	

?>