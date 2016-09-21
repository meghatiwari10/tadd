<?php

	include "db.php";
	header('Content-type: application/json');
	date_default_timezone_set ("Asia/Calcutta");
	$array=array();
	session_start();
	$employee_name=$_SESSION['employee_name'];
	$sql="select * from meeting_record";
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
	
		//$enddate= new DateTime($array[$i]['leave_stop_date']);
		//$enddate=$enddate->modify('+1 day');
		//$enddate=$enddate->format('y/m/d');
		//$enddate=str_replace('/', '-', $enddate);
		//$enddate=date('Y-m-d', strtotime($enddate));
		$guests=substr_replace($array[$i]['requested_guests'],'',0,1);
		$guest_string="Guests: ".$guests;

		$meetings[]=array(
			'title'=> $array[$i]['meeting_description'],
			'start'=> trim($array[$i]['meeting_date'])."T".trim($array[$i]['meeting_start_time']),
			'end'=>trim($array[$i]['meeting_date'])."T".trim($array[$i]['meeting_end_time']),
			'description'=>$array[$i]['meeting_venue'],
			'guests'=>$guest_string,
			'allDay'=>0
			
		);
		/*$events['title']=$array[$i]['name'];
		$events['start']=$array[$i]['leave_start_date'];
		$events['end']=$array[$i]['leave_stop_date'];*/
		
		
		//echo json_encode($events);
	}
	echo json_encode($meetings);
	

?>