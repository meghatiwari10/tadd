<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php 
	
	include "db.php";
	$leave_id=$_GET['leave_id'];
	$employee_name=$_GET['employee_name'];
	$employee_user_name=$_GET['employee_user_name'];
	//echo $leave_id."\r\n";
	$leave_start_date=$_GET['leave_start_date'];
	$leave_stop_date=$_GET['leave_stop_date'];
	$leave_type=$_GET['leave_type'];
	$sql="update leaves_main set leave_status='granted' where leave_id='$leave_id'";
	$result=$db->query($sql);
	if ($result)
	{
		echo "Database updated with response.";
		echo nl2br("\n");

	}
	else
	{	echo "error";}

		

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

		$leavedays = getWorkingDays($leave_start_date,$leave_stop_date);
		$year=date('Y', strtotime($leave_start_date));
		
		$sql="select * from employee_record_leaves where employee_user_name='$employee_user_name'";
		$result=$db->query($sql);
		while($row = $result->fetch_assoc()) 
		{
	       $employee_remaining_leaves=$row['employee_remaining_leaves'];
	       $employee_extra_leaves=$row['employee_extra_leaves'];
	       $employee_PTO=$row['employee_PTO'];
	       $employee_remaining_PTO=$row['employee_remaining_PTO'];
	       $employee_sick_leaves=$row['employee_sick_leaves'];
	       $employee_remaining_sick_leaves=$row['employee_remaining_sick_leaves'];
	       $employee_leave_without_pay=$row['employee_leave_without_pay'];
	  	}

	  	if (trim("PTO") == trim($leave_type))
	  	{
	  		
		  	if($employee_remaining_PTO < $leavedays)
		  	{
		  		
		  		$diff=$leavedays-$employee_remaining_PTO;
		  		$employee_PTO=$employee_PTO+$employee_remaining_PTO;
		  		$employee_remaining_PTO=0;
		  		$employee_leave_without_pay=$employee_leave_without_pay+$diff;
		  	}

		  	else if($employee_remaining_PTO>=$leavedays)
		  	{
		  		
		  		$employee_remaining_PTO-=$leavedays;
		  		$employee_PTO+=$leavedays;
		  	}

		  		$sql2="UPDATE employee_record_leaves set employee_PTO='$employee_PTO',employee_remaining_PTO='$employee_remaining_PTO', employee_leave_without_pay='$employee_leave_without_pay', year='$year' where employee_user_name='$employee_user_name'";
		  		$result2=$db->query($sql2);
	  	}

	  	if (trim("SICK") == trim($leave_type))
	  	{
		  	if($employee_remaining_sick_leaves<$leavedays)
		  	{
		  		$diff=$leavedays-$employee_remaining_sick_leaves;
		  		$employee_sick_leaves+=$employee_remaining_sick_leaves;
		  		$employee_sick_leaves=0;
		  		$employee_remaining_sick_leaves=0;
		  		$employee_leave_without_pay+=$diff;
		  	}

		  	else if($employee_remaining_sick_leaves>=$leavedays)
		  	{
		  		$employee_remaining_sick_leaves-=$leavedays;
		  		$employee_sick_leaves+=$leavedays;
		  	}

		  		$sql2="UPDATE employee_record_leaves set employee_sick_leaves='$employee_sick_leaves',employee_remaining_sick_leaves='$employee_remaining_sick_leaves', employee_leave_without_pay='$employee_leave_without_pay', year='$year' where employee_user_name='$employee_user_name'";
		  		$result2=$db->query($sql2);
	  	}
		
		


	  	/*if($leavedays<$employee_remaining_leaves)
	  	{
	  		$employee_remaining_leaves=$employee_remaining_leaves-$leavedays;
	  		//$employee_remaining_leaves;
	  		
	  		
	  		if ($leave_type=="PTO")
	  		{
	  			$employee_PTO+=$leavedays;
	  			$sql="UPDATE employee_record_leaves set employee_PTO='$employee_PTO' where employee_user_name='$employee_user_name'";
	  			$result=$db->query($sql);
	  		}
	  		else 
	  		{
	  			$employee_sick_leaves+=$leavedays;
	  			$sql="UPDATE employee_record_leaves set employee_sick_leaves='$employee_sick_leaves' where employee_user_name='$employee_user_name'";
	  			$result=$db->query($sql);	
	  		}
	  		
	  	}
	  	else if($leavedays>$employee_remaining_leaves)
	  	{
	  		$leavediff=$leavedays-$employee_remaining_leaves;
	  		$employee_extra_leaves=$employee_extra_leaves+$leavediff;
	  		$employee_remaining_leaves=0;
	  		$sql2="UPDATE employee_record_leaves set employee_extra_leaves='$employee_extra_leaves', employee_remaining_leaves='$employee_remaining_leaves',year='$year' where employee_user_name='$employee_user_name'";
	  		$result2=$db->query($sql2);
	  		
	  		if ($leave_type=="PTO")
	  		{
	  			$employee_PTO+=$leavedays;
	  			$sql="UPDATE employee_record_leaves set employee_PTO='$employee_PTO' where employee_user_name='$employee_user_name'";
	  			$result=$db->query($sql);
	  		}
	  		else 
	  		{
	  			$employee_sick_leaves+=$leavedays;
	  			$sql="UPDATE employee_record_leaves set employee_sick_leaves='$employee_sick_leaves' where employee_user_name='$employee_user_name'";
	  			$result=$db->query($sql);	
	  		}
	  	}
	  	else if($leavedays==$employee_remaining_leaves)
	  	{
	  		
	  		$sql3="UPDATE employee_record_leaves SET employee_remaining_leaves=0, year='$year' where employee_user_name='$employee_user_name'";
	  		$result3=$db->query($sql3);	
	  		
	  		if ($leave_type=="PTO")
	  		{
	  			$employee_PTO+=$leavedays;
	  			$sql="UPDATE employee_record_leaves set employee_PTO='$employee_PTO' where employee_user_name='$employee_user_name'";
	  			$result=$db->query($sql);
	  		}
	  		else 
	  		{
	  			$employee_sick_leaves+=$leavedays;
	  			$sql="UPDATE employee_record_leaves set employee_sick_leaves='$employee_sick_leaves' where employee_user_name='$employee_user_name'";
	  			$result=$db->query($sql);	
	  		}
	  	}*/
	

		$to      = $employee_user_name;
	    $subject = 'Dignitas Digital- Leave Granted';
	    $message = 	"  <html> 
					  <body>
					  
					  Hi ".$employee_name.",<br/><br/>
					  Your leave (".$leave_start_date." to ".$leave_stop_date.") has been approved.<br/><br/>
					  Thanks<br/>
					  Dignitas Digital Pvt. Ltd.
					  </body> 
					  </html>";
	    $headers = array("From: from@example.com",
		    "Reply-To:".$employee_user_name. "\r\n",
		    "X-Mailer: PHP/" . PHP_VERSION
		);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


		//$headers = implode("\r\n", $headers);
	   


	    $to1      = $mail_to_all;
	    $subject1 = 'Dignitas Digital- Unavailable['.$employee_name.']';
	    $message1 = 	"  <html> 
					  <body>
					  Hi Team,<br/><br/>"
					  .$employee_name." will be unavailable from ".$leave_start_date." to ".$leave_stop_date.".<br/><br/>
					  Thanks<br/>
					  Dignitas Digital Pvt. Ltd.	
					  </body> 
					  </html>";
	    $headers1 = array("From: from@example.com",
		    "Reply-To:mghtwr18@gmail.com\r\n",
		    "X-Mailer: PHP/" . PHP_VERSION
		);
		$headers1  = 'MIME-Version: 1.0' . "\r\n";
		$headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


		//$headers = implode("\r\n", $headers);
	    if(mail($to1, $subject1, $message1, $headers1) and mail($to, $subject, $message, $headers))
	    {
	    	echo "Reply mail sent to ".$employee_user_name;
	    }
	    else
	    {
	    	echo 'Email not Sent.';
	    }

		 
?>


</body>
</html>