<?php

include("db.php");
date_default_timezone_set ("Asia/Calcutta");


$employee_user_name=$_GET['employee_user_name'];
$employee_name=$_GET['employee_name'];
$meeting_desc=$_GET['meeting_desc'];
$meeting_venue=$_GET['meeting_venue'];
$meeting_start_time=$_GET['meeting_start_time'];
$guest=$_GET['guest'];
if (trim($_GET['attend_meeting'])=='yes')
{
	
	$sql="select * from meeting_record";
	$result=$db->query($sql);
	while($row=$result->fetch_assoc())
	{
		$attendants=$row['attendants'];
		if ($attendants=="")
			$attendants=$guest;
		else
			$attendants=$attendants.",".trim($guest);		
	}
	
	$sql1="update meeting_record set attendants='$attendants'";
	$result1=$db->query($sql1);

	$to      = $employee_user_name;
			
	$subject = "Dignitas Digital-Meeting Guest Response-[".$meeting_desc."]";
	$message = "  <html> 
	<body>
	Hi ".$employee_name.",<br/><br/>
	".$guest." will be attending the following meeting scheduled by you: <br/><br/>
	Description: ".$meeting_desc."<br/>
	Start Time: ".$meeting_start_time."<br/>
	Venue: ".$meeting_venue."<br/>	<br/>
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
	if(mail($to, $subject, $message, $headers))
	{
		$message="Your response has been mailed. ";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>window.location = 'meeting.php'</script>";
	}
}


else if (trim($_GET['attend_meeting'])=='no')
{
	$to      = $employee_user_name;
			
	$subject = "Dignitas Digital-Meeting Guest Response-[".$meeting_desc."]";
	$message = "  <html> 
	<body>
	Hi ".$employee_name.",<br/><br/>
	".$guest." will not be attending the following meeting scheduled by you: <br/><br/>
	Description: ".$meeting_desc."<br/>
	Start Time: ".$meeting_start_time."<br/>
	Venue: ".$meeting_venue."<br/>	<br/>
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
	if(mail($to, $subject, $message, $headers))
	{
		$message="Your response has been mailed. ";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>window.location = 'meeting.php'</script>";
	}
}
?>