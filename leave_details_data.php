<?php 
include("db.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');


$selected_employee_user_name=$_GET['selected_employee_user_name'];
$selected_employee_name=$_GET['selected_employee_name'];



function getWorkingDays($leave_start_date,$endDate)
		{
			    // do strtotime calculations just once
			    $endDate = strtotime($endDate);
			    $leave_start_date = strtotime($leave_start_date);


			    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
			    //We add one to inlude both dates in the interval.
			    $days = ($endDate - $leave_start_date) / 86400 + 1;

			    $no_full_weeks = floor($days / 7);
			    $no_remaining_days = fmod($days, 7);

			    //It will return 1 if it's Monday,.. ,7 for Sunday
			    $the_first_day_of_week = date("N", $leave_start_date);
			    $the_last_day_of_week = date("N", $endDate);

			    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
			    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
			    if ($the_first_day_of_week <= $the_last_day_of_week) 
			    {
			        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
			        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
			    }
			    else 
			    {
			        // (edit by Tokes to fix an edge case where the start day was a Sunday
			        // and the end day was NOT a Saturday)

			        // the day of the week for start is later than the day of the week for end
			        if ($the_first_day_of_week == 7) 
			        {
			            // if the start date is a Sunday, then we definitely subtract 1 day
			            $no_remaining_days--;

			            if ($the_last_day_of_week == 6) 
			            {
			                // if the end date is a Saturday, then we subtract another day
			                $no_remaining_days--;
			            }
			        }
			        else 
			        {
			            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
			            // so we skip an entire weekend and subtract 2 days
			            $no_remaining_days -= 2;
			        }
			    }

			    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
				//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
			   $workingDays = $no_full_weeks * 5;
			    if ($no_remaining_days > 0 )
			    {
			      $workingDays += $no_remaining_days;
			    }    
			    return $workingDays;
		}

	if (isset($_GET['insert']))
	{
	    // INSERT COMMAND
	  	
	   $sql1="Insert into employee_main(employee_name,employee_user_name,employee_password) values('$employee_name','$employee_user_name','$employee_password')";
		$sql2="Insert into employee_record_daily(employee_name,employee_user_name,employee_password) values('$employee_name','$employee_user_name','$employee_password')";
		$sql3="insert into employee_record_leaves(employee_user_name) values('$employee_user_name')";
		$result1=mysqli_query($db,$sql1);
		$result2=mysqli_query($db,$sql2);
		$result3=mysqli_query($db,$sql3);
	   echo $result1;
	   echo $result2;
	   echo $result3;
	}


    

	else if (isset($_GET['update']))
	{
		// UPDATE COMMAND

		$leave_start_date=$_GET['leave_start_date'];
		$leave_stop_date=$_GET['leave_stop_date'];
		$new_leave_type=$_GET['leave_type'];
		$new_leave_type=strtoupper((string)$new_leave_type);
		$leave_id=$_GET['leave_id'];
		$new_leave_status=$_GET['leave_status'];
		$new_leave_status=strtolower((string)$new_leave_status);
		$sql="select * from employee_record_leaves where employee_user_name='$selected_employee_user_name'";
			$result=$db->query($sql);
			while($row=$result->fetch_assoc())
			{
				$employee_remaining_leaves=$row['employee_remaining_leaves'];
				$employee_extra_leaves=$row['employee_extra_leaves'];
				$employee_PTO=$row['employee_PTO'];
				$employee_sick_leaves=$row['employee_sick_leaves'];
				
				
			}

		$leavedays = getWorkingDays($leave_start_date,$leave_stop_date);


		$sql="select * from leaves_main where leave_id='$leave_id'";
		$result=$db->query($sql);
		while($row=$result->fetch_assoc())
		{
			$old_leave_status=$row['leave_status']; 
			$old_leave_type=$row['leave_type'];
		}

		if($old_leave_type!=$new_leave_type)
		{

			if($old_leave_type=="PTO" and $new_leave_type=="SICK" and $new_leave_status=="granted")
			{

				$employee_PTO-=$leavedays;
				$employee_sick_leaves+=$leavedays;
			}

			else if($old_leave_type=="SICK" AND $new_leave_type=="PTO" and $new_leave_status=="granted")
			{
				$employee_sick_leaves=-$leavedays; 
				$employee_PTO+=$leavedays;
			}

		}
		
		if($old_leave_status!=$new_leave_status)
		{
			if(($old_leave_status=="granted" and $new_leave_status=="denied") or ($old_leave_status=='pending' and $new_leave_status="denied"))
			{
				
				if ($employee_extra_leaves=='0')
				{
					if ($new_leave_type=="PTO")
			  		{
			  			$employee_PTO-=$leavedays;
			  			
			  		}
			  		else 
			  		{
			  			$employee_sick_leaves-=$leavedays;
			  		
			  		}
					
					$employee_remaining_leaves+=$leavedays;

				}
				else
				{
					if($employee_extra_leaves<$leavedays)
					{
						if ($new_leave_type=="PTO")
				  		{
				  			$employee_PTO-=$leavedays;
				  			
				  		}
				  		else 
				  		{
				  			$employee_sick_leaves-=$leavedays;
				  		
				  		}

						$leavediff=$leavedays-$employee_extra_leaves;
						$employee_extra_leaves='0';
						$employee_remaining_leaves+=$leavediff;
					}
					else if($employee_extra_leaves>$leavedays)
					{
						if ($new_leave_type=="PTO")
				  		{
				  			$employee_PTO-=$leavedays;
				  			
				  		}
				  		else 
				  		{
				  			$employee_sick_leaves-=$leavedays;
				  		
				  		}

						
						$employee_extra_leaves=$employee_extra_leaves-$leavedays;
					}
					else if($employee_extra_leaves=$leavedays)
					{
						if ($new_leave_type=="PTO")
				  		{
				  			$employee_PTO-=$leavedays;
				  			
				  		}
				  		else 
				  		{
				  			$employee_sick_leaves-=$leavedays;
				  		
				  		}

						$employee_extra_leaves='0';
					}
				}
			}

			else if(($old_leave_status=="denied" and $new_leave_status=="granted") or ($old_leave_status=="pending" and $new_leave_status=="granted"))
			{
				if($leavedays<$employee_remaining_leaves)
			  	{
			  		$employee_remaining_leaves=$employee_remaining_leaves-$leavedays;
			  		
			  		if ($new_leave_type=="PTO")
			  		{
			  			$employee_PTO+=$leavedays;
			  			
			  		}
			  		else 
			  		{
			  			$employee_sick_leaves+=$leavedays;
			  		
			  		}
			  		
			  	}
			  	else if($leavedays>$employee_remaining_leaves)
			  	{
			  		$leavediff=$leavedays-$employee_remaining_leaves;
			  		$employee_extra_leaves=$employee_extra_leaves+$leavediff;
			  		$employee_remaining_leaves=0;
			  		
			  		if ($new_leave_type=="PTO")
			  		{
			  			$employee_PTO+=$leavedays;
			  		
			  		}
			  		else 
			  		{
			  			$employee_sick_leaves+=$leavedays;
			  		
			  		}
			  	}
			  	else if($leavedays==$employee_remaining_leaves)
			  	{
			  		
			  
			  		if ($new_leave_type=="PTO")
			  		{
			  			$employee_PTO+=$leavedays;
			  
			  		}
			  		else 
			  		{
			  			$employee_sick_leaves+=$leavedays;
			  			
			  		}	
				}
			}

		}		

				
				
				

				if($new_leave_type=="PTO")
			{
				
				$sql_pto="UPDATE employee_record_leaves set employee_remaining_leaves='$employee_remaining_leaves',employee_extra_leaves='$employee_extra_leaves',employee_PTO='$employee_PTO' where employee_user_name='$selected_employee_user_name'";
				$result_pto=$db->query($sql_pto);
				$update_sql = "UPDATE leaves_main SET leave_type='$new_leave_type',leave_status='$new_leave_status' WHERE leave_id='$leave_id'";
				$result_update=$db->query($update_sql);

				echo $result_pto;
				
				echo $result_update;
			}

			else if($new_leave_type=="SICK")
			{
				
				$sql_sick="UPDATE employee_record_leaves set employee_remaining_leaves='$employee_remaining_leaves',employee_extra_leaves='$employee_extra_leaves',employee_sick_leaves='$employee_sick_leaves' where employee_user_name='$selected_employee_user_name'";
				$result_sick=$db->query($sql_sick);	
				$sql1 = "UPDATE leaves_main SET leave_type='$new_leave_type',leave_status='$new_leave_status' WHERE leave_id='$leave_id'";
				echo $result1=$db->query($sql1);exit;

				
				echo $result_sick;
				echo $result_update;
			}

				
				
				
		
		
	}

	else if(isset($_GET['delete']))
	{
		
		 
		/*$sql1="UPDATE leaves_main SET leave_isDeleted='yes' WHERE leave_id='$leave_id'";
		$result1=$db->query($sql1);*/
		$leave_start_date=$_GET['leave_start_date'];
		$leave_stop_date=$_GET['leave_stop_date'];
		$leave_type=$_GET['leave_type'];
		$leave_id=$_GET['leave_id'];
		$new_leave_status=$_GET['leave_status'];
		$sql="select * from employee_record_leaves where employee_user_name='$selected_employee_user_name'";
			$result=$db->query($sql);
			while($row=$result->fetch_assoc())
			{
				$employee_remaining_leaves=$row['employee_remaining_leaves'];
				$employee_extra_leaves=$row['employee_extra_leaves'];
				$employee_PTO=$row['employee_PTO'];
				$employee_sick_leaves=$row['employee_sick_leaves'];
				
				
			}

		$leavedays = getWorkingDays($leave_start_date,$leave_stop_date);
		
		

		
		
		
			
			

			if($employee_extra_leaves=='0')
			{
				$employee_remaining_leaves+=$leavedays;
				
			}
			else
			{
				if($employee_extra_leaves<$leavedays)
				{
					$leavediff=$leavedays-$employee_extra_leaves;
					$employee_extra_leaves='0';
					$employee_remaining_leaves+=$leavediff;
				}
				else if($employee_extra_leaves>$leavedays)
				{
					$leavediff=$employee_extra_leaves-$leavedays;
					$employee_extra_leaves=$leavediff;
				}
				else if($employee_extra_leaves=$leavedays)
					$employee_extra_leaves='0';
			}

			if($leave_type=="PTO")
			{
				$employee_PTO=$employee_PTO-$leavedays;
				$sql_pto="UPDATE employee_record_leaves set employee_remaining_leaves='$employee_remaining_leaves',employee_extra_leaves='$employee_extra_leaves',employee_PTO='$employee_PTO' where employee_user_name='$selected_employee_user_name'";
				$result_pto=$db->query($sql_pto);
				$sql2="UPDATE leaves_main set leave_isDeleted='yes' where leave_id='$leave_id'";
				$result2=$db->query($sql2);
				
				echo $result_pto;
				echo $result2;
			}

			else if($leave_type=="SICK")
			{
				$employee_sick_leaves=$employee_sick_leaves-$leavedays;
				$sql_sick="UPDATE employee_record_leaves set employee_remaining_leaves='$employee_remaining_leaves',employee_extra_leaves='$employee_extra_leaves',employee_sick_leaves='$employee_sick_leaves' where employee_user_name='$selected_employee_user_name'";
				$result_sick=$db->query($sql_sick);	
				$sql2="UPDATE leaves_main set leave_isDeleted='yes' where leave_id='$leave_id'";
				$result2=$db->query($sql2);
				
				echo $result_sick;
				echo $result2;
			}

	}

	

	else
	{
		
		
		
		$sql="select * from leaves_main where employee_name='$selected_employee_name' and leave_isDeleted='no' ";
		$result = $db->query($sql);
	    while ($row = $result->fetch_assoc()) 
	    {
	        $leave_details[] = array(
	        	'leave_id' => $row['leave_id'],
	            'employee_name' => $row['employee_name'],
	            'leave_start_date' => $row['leave_start_date'],
	            'leave_stop_date' => $row['leave_stop_date'],
	            'leave_type' => $row['leave_type'],
	            'leave_status' => $row['leave_status']
	          );
	    }
	 
	    echo json_encode($leave_details);
	}

?>