<?php
//	error_reporting(E_ALL);
//	ini_set('display_errors', '1');
	include "db.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php 
	
	$leave_id=$_GET['leave_id'];
	$employee_user_name=$_GET['employee_user_name'];
	$leave_start_date=$_GET['leave_start_date'];
	$leave_stop_date=$_GET['leave_stop_date'];
	$employee_name=$_GET['employee_name'];
	$sql1="select ";
	$sql="update leaves_main set leave_status='denied' where leave_id='$leave_id'";
	$result=$db->query($sql);
	if ($result)
	{
		echo "Database updated with response";
		echo nl2br("\n");

	}
	else
	{	echo "error";}

		$to      = $employee_user_name;
	    $subject = 'Dignitas Digital- Leave Denied';
	    $message = 	"  <html> 
					  <body>
					  Hi ".$employee_name.",<br/><br/>
					  Your leave (".$leave_start_date." to ".$leave_stop_date.") is not approved.<br/><br/>
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
	    if(mail($to, $subject, $message, $headers))
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