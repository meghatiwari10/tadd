<?php 
include("db.php");
	date_default_timezone_set ("Asia/Calcutta");
$today_date=date("d/m/y",time());
$sql = "select * from employee_record_daily";
$result=$db->query($sql);
while ($row=$result->fetch_assoc()) 
{
	
	if($today_date==date("d/m/y",strtotime($row['employee_time_in'])))
	{

		
		if(date("h:i:s", strtotime($row['employee_time_in']))!='12:00:00')
		{
			
			if($row['employee_time_out']=="0000-00-00 00:00:00")
			{
				
				$employee_time_out=" ";
				$employee_time_in=date("h:i:s", strtotime($row['employee_time_in']));
			}	


			else
			{
				
				$employee_time_out=date("h:i:s", strtotime($row['employee_time_out']));
				$employee_time_in=date("h:i:s", strtotime($row['employee_time_in']));			
			}
		}
		

		else if($row['employee_isWfh']=='yes' and date("d/m/y", strtotime($row['employee_wfh_date']))==$today_date)
		{
		 	
			$employee_time_in="WFH";
			$employee_time_out="WFH";
		}

		
		
		$checkedin_employees[]=array 
		(
			'employee_name'=> $row['employee_name'],
			'employee_time_in'=>$employee_time_in,
			'employee_time_out'=>$employee_time_out,
			'employee_isHalfday'=>$row['employee_isHalfday']
					
		);
		
	}

	else 
	{
			
			$employee_time_in=" ";
			$employee_time_out=" ";
			$employee_isHalfday="no";
			
			$checkedin_employees[]=array 
		(
			'employee_name'=> $row['employee_name'],
			'employee_time_in'=>$employee_time_in,
			'employee_time_out'=>$employee_time_out,
			'employee_isHalfday'=>$employee_isHalfday
					
		);
	}

	

	/*foreach($checkedin_employees as $employees)
	{
    	$employees['remarks'] = $row['remarks'];
	}
	/*foreach ($checkedin_employees as $key => $value) 
	{
  		   if ($key == 'remarks') 
  		   {
		   		$checkedin_employees['remarks']['abc'] = $row['remarks'];
		   } 
	}*/
	//$checkedin_employees['remarks'] = $row['remarks'];

	/*$arr=array();
	foreach ($checkedin_employees as $key => $value) 
	{
  		   if ($key == 'remarks') 
  		   {
		   		$arr['abc'] = $row['remarks'];
		   } 
		  else 
		  {
		  		 $arr[$key] = $value;
		  }
	}*/
}
echo json_encode($checkedin_employees);

?>
