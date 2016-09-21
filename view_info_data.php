<?php 
include("db.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');

/*if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$employee_user_name=$_GET['employee_user_name'];
}*/	
	
//echo $employee_user_name=$_GET['employee_user_name'];
//exit;
//	echo $selected_employee_user_name=$_GET['selected_employee_user_name'];

if (isset($_GET['update']))
{
	$employee_user_name=$_GET['employee_user_name'];
	$employee_id=$_GET['employee_id'];
	$year=$_GET['year'];
	$employee_remaining_PTO=$_GET['employee_remaining_PTO'];
	$employee_remaining_sick_leaves=$_GET['employee_remaining_sick_leaves'];
	
 	$employee_leave_without_pay=$_GET['employee_leave_without_pay'];

 	$sql="select employee_user_name from employee_main where employee_id='$employee_id'";
 	$result=$db->query($sql);

 	while($row=$result->fetch_assoc())
 	{
 		 $old_user_name=$row['employee_user_name'];
 	}


 	$sql1="UPDATE employee_record_leaves set employee_user_name='$employee_user_name',employee_remaining_PTO='$employee_remaining_PTO',employee_remaining_sick_leaves='$employee_remaining_sick_leaves',employee_leave_without_pay='$employee_leave_without_pay',year='$year' where employee_user_name='$old_user_name'";
 	$result1=$db->query($sql1);
 	$sql2="UPDATE employee_main set employee_user_name='$employee_user_name' where employee_user_name='$old_user_name'";
 	$result2=$db->query($sql2);
 	$sql3="UPDATE employee_record_daily set employee_user_name='$employee_user_name' where employee_user_name='$old_user_name'";
 	$result3=$db->query($sql3);

 	echo $result1;
 	echo $result2;
 	echo $result3;
}

if(isset($_GET['delete']))
{
		$employee_user_name=$_GET['employee_user_name'];
		$sql1="UPDATE employee_main SET employee_isDeleted='yes' WHERE employee_user_name='$employee_user_name'";
		$sql2="UPDATE employee_record_daily SET employee_isDeleted='yes' WHERE employee_user_name='$employee_user_name'";
		$sql3="UPDATE employee_record_leaves SET employee_isDeleted='yes' WHERE employee_user_name='$employee_user_name'";
		
		$result1=$db->query($sql1);
		$result2=$db->query($sql2);
		$result3=$db->query($sql3);
		echo $result1;
		echo $result2;
		echo $result3;
}


else
{
		$selected_employee_user_name=$_GET['selected_employee_user_name'];

		
		$sql="SELECT * from employee_record_leaves where employee_user_name='$selected_employee_user_name' and employee_isDeleted='no' ";
		
		$result = $db->query($sql);
	    while ($row = $result->fetch_assoc()) 
	    {
	    	$employee_id=$row['employee_id'];
	    	$employee_user_name=$row['employee_user_name'];
	    	$employee_PTO=$row['employee_PTO'];
	    	$employee_sick_leaves=$row['employee_sick_leaves'];
	    	$year=$row['year'];
	    	

	        $employees[] = array(
	        	'employee_id' => $employee_id,
	            'employee_user_name' => $employee_user_name,
	            'year'=>$year,
	            'employee_remaining_PTO'=>$row['employee_remaining_PTO'],
	            'employee_remaining_sick_leaves'=>$row['employee_remaining_sick_leaves'],
	            'employee_leave_without_pay'=>$row['employee_leave_without_pay']
	            
	          );
	    
	 	}
	    echo json_encode($employees);
	}
?>