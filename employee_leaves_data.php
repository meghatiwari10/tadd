<?php 
include("db.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');


$employee_name=$_GET['employee_name'];






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
		$leave_type=$_GET['leave_type'];
		$leave_id=$_GET['leave_id'];
		$new_leave_status=$_GET['leave_status'];

		$sql="update leaves_main set leave_start_date='$leave_start_date',leave_stop_date='$leave_stop_date',leave_type='$leave_type' where leave_id='$leave_id'";
		$result=$db->query($sql);

		$to      = $mail_recipient;
			$to1	 = $mail_recipient1;
		    $subject = "Dignitas Digital-Leave Update - ".$employee_name;
		    $message = "  <html> 
						  <body>
						  Hi Rishi/Dhawal<br/><br/>
						  Please check edited leave information for ".$employee_name.".<br/><br/>
						  Employee Name: ".$employee_name."<br/>
						  Leave Type: ".$leave_type."<br/>
						  From: ".$leave_start_date."<br/>
						  To: ".$leave_stop_date."<br><br><br>	
						  <a href='".$leavegrant."?leave_id=" . $leave_id . "& employee_user_name=".$employee_user_name."& leave_start_date=".$leave_start_date." & leave_stop_date=".$leave_stop_date." & leave_type=".$leave_type." & employee_name=".$employee_name." '>Grant</a>
						  <a href='".$leavedeny."?leave_id=" . $leave_id . "&employee_user_name=".$employee_user_name." & leave_start_date=".$leave_start_date." & leave_stop_date=".$leave_stop_date."& leave_type=".$leave_type."  & employee_name=".$employee_name."'>Deny</a><br/><br/>
						  Thanks,<br/>
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
		    mail($to, $subject, $message, $headers);
		    mail($to1, $subject, $message, $headers);

		    echo $result;


	}

	else if(isset($_GET['delete']))
	{
		
		 
			$leave_start_date=$_GET['leave_start_date'];
		$leave_stop_date=$_GET['leave_stop_date'];
		$leave_type=$_GET['leave_type'];
		$leave_id=$_GET['leave_id'];
		$new_leave_status=$_GET['leave_status'];
		
		$sql="update leaves_main set leave_isDeleted='yes' where leave_id='$leave_id'";
		$result=$db->query($sql);

		$to      = $mail_recipient;
			$to1	 = $mail_recipient1;
		    $subject = "Dignitas Digital-Leave Update-[".$employee_name."]";
		    $message = "  <html> 
						  <body>
						  Hi Rishi/Dhawal<br/><br/>
						  ".$employee_name." has cancelled the leave application with following details:<br/><br/>
						  
						  Employee Name: ".$employee_name."<br/>
						  Leave Type: ".$leave_type."<br/>
						  From: ".$leave_start_date."<br/>
						  To: ".$leave_stop_date."<br><br><br>	
						  
						  Thanks,<br/>
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
		    mail($to, $subject, $message, $headers);
		    mail($to1, $subject, $message, $headers);
		    echo $result;


	}

	

	else
	{
		
		
		
		$sql="select * from leaves_main where employee_name='$employee_name' and leave_status='pending' and leave_isDeleted='no' ";
		$result = $db->query($sql);
	    while ($row = $result->fetch_assoc()) 
	    {
	        $leave_details[] = array(
	        	'leave_id' => $row['leave_id'],
	            'leave_start_date' => $row['leave_start_date'],
	            'leave_stop_date' => $row['leave_stop_date'],
	            'leave_type' => $row['leave_type'],
	            'leave_status' => $row['leave_status']
	          );
	    }
	 
	    echo json_encode($leave_details);
	}

?>