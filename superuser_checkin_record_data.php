
<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
include("db.php");
date_default_timezone_set ("Asia/Calcutta");

$checkin_month=$_GET['checkin_month'];
$checkin_year=$_GET['checkin_year'];
$employee_to_search=trim($_GET['employee_to_search']);

$today_date=date("d/m/y",time());
$sql = "select * from employee_checkin_record";
$result=$db->query($sql);

while($row=$result->fetch_assoc())
{
	$entry_month=date('m', strtotime($row['entry_date']));
	$entry_year=date('Y', strtotime($row['entry_date']));
	$employee_user_name=trim($row['employee_user_name']);
	if($entry_month==$checkin_month and $entry_year==$checkin_year and $employee_user_name==$employee_to_search)
	{
		if($row['employee_time_in']!='12:00:00')
		{
			
			if($row['employee_time_out']=="00:00:00" or $row['employee_time_out']=="")
			{
				
				$employee_time_out=" ";
				$employee_time_in=$row['employee_time_in'];
			}	


			else
			{
				
				$employee_time_out=$row['employee_time_out'];
				$employee_time_in=$row['employee_time_in'];			
			}
		}
		

		else if($row['employee_isWfh']=='yes')
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

