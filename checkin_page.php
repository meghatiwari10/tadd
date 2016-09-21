<?php
	//error_reporting(E_ALL & ~E_NOTICE);
	ini_set('display_errors', '0');
	session_start();
	include("db.php");
	date_default_timezone_set ("Asia/Calcutta");
?>

<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=false;">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel='stylesheet' type='text/css'href='styles/timepicki.css'/>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>



<script type='text/javascript'src='lib/timepicki.js'></script>

<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type='text/javascript'> 
	$(document).ready(function(){
    $("#timepicker").timepicki();
    $("#timepicker1").timepicki();
  });
</script>

<script>
  $(function() {
    $( "#date" ).datepicker();
    $( "#date1" ).datepicker();
    $( "#date2" ).datepicker();
  
  });
</script>

<script type="text/javascript">

function auto_complete() 
{
    
    //autocomplete
    $(".auto").autocomplete({
        source: "autocomplete_employees.php",
        minLength: 1
    });                

}
</script>


<script type="text/javascript">
	function add_new()
	{
		
		var entered_guest=$('#entered_guest').val();
		
		var hidden_guest_list=$('#hidden_guest_list').val();
		
		var hidden_list=$('#hidden_guest_list').val(hidden_guest_list+','+entered_guest);
		var hidden_guest_list = hidden_guest_list.split(',').join('<br>');
		//alert(hidden_guest_list);
		var guests_div=$('#guests_div').html("Guests: "+hidden_guest_list+"<br/>"+entered_guest);
		var hidden_guest_list = hidden_guest_list.split('<br>').join(',');
		//alert(hidden_guest_list);
		//document.getElementById("guests_div").innerHTML = guests_div;
	}
</script>

<script type="text/javascript">
	function outside_office()
	{
		var selected=$( "#meeting_venue option:selected" ).text();
		if(selected=="Outside the office")
		{
			$('#outside_office').html('<label class="label">Enter the venue </label></br><input type="text" class="inputbox form-control" name="outside_venue"/></br></br>');
		}
		//document.getElementById('outside_office').innerHTML('<label class="label">Description </label></br><input type="text" class="inputbox form-control" name="meeting_desc"/></br></br>');
	}
</script>
</head>
<body>
<?php
	date_default_timezone_set ("Asia/Calcutta");
	$employee_user_name=$_SESSION['employee_user_name'];
	$employee_name=$_SESSION['employee_name'];
	$employee_id = $_SESSION['employee_id'];

	
	if (isset($_POST['logout']))
	{
		session_destroy();
		 echo "<script>window.location = 'employee_login.php'</script>";
	}
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		//echo $_POST['checkin'];
		
		
		//echo $checkout;
		if (isset($_POST['checkin']))
		{
			$sql="select * from employee_record_daily where employee_id='$employee_id'";
			$result=$db->query($sql);
			while($row=$result->fetch_assoc())
			{
				$employee_time_in=$row['employee_time_in'];
			}
			$datetime = explode(" ",$employee_time_in);
			$date_last_checked_in = $datetime[0];
			$time_last_checked_in = $datetime[1];
			


			$var="checkin";
			$time=date("Y-m-d H:i:s");
			$today_date=date("Y-m-d");
			$flag=0;
			$checkin_time=date("h:i:s", strtotime($time));
			$hour = date('H',strtotime($time));
			$sql2="select * from employee_checkin_record where employee_id='$employee_id'";
			$result2=$db->query($sql2);
			while($row=$result2->fetch_assoc())
			{
				if (($row['entry_date']==$today_date and $row['employee_time_in']!='00:00:00') or ($row['entry_date']==$today_date and $row['employee_time_in']=='00:00:00' and $row['employee_isWfh']=='yes'))
				{
					$flag=1;
					$message="You have already checked-in today!!";
					echo "<script type='text/javascript'>alert('$message');</script>";	
					break;
					
				}
			}
				
			if($flag==0)	
			{
					$message = "Dear ".$employee_user_name.", You have been checked-in at ".$checkin_time." . Thank You.";
					echo nl2br("<script type='text/javascript'>alert('$message');</script>");
					if ($hour<11)
					{
						$sql="UPDATE employee_record_daily SET employee_time_in='$time',employee_time_out='',entry_type='checkin',employee_isHalfday='no',employee_wfh_date='0000-00-00',leave_early_date='0000-00-00',leave_early_time='00:00:00',employee_isWfh='no' WHERE employee_id='$employee_id'";	
						$result=$db->query($sql);
						$sql1="insert into employee_checkin_record(employee_id,entry_date,employee_name,employee_user_name,employee_time_in,entry_type) values('$employee_id','$today_date','$employee_name','$employee_user_name','$time','$entry_type')";
						$result1=$db->query($sql1);
					}
					else
					{
						$sql="UPDATE employee_record_daily SET employee_time_in='$time',employee_time_out='',entry_type='checkin',employee_isHalfday='yes',employee_wfh_date='0000-00-00',leave_early_date='0000-00-00',leave_early_time='00:00:00',employee_isWfh='no' WHERE employee_id='$employee_id'";	
						$result=$db->query($sql);
						$sql1="insert into employee_checkin_record(employee_id,entry_date,employee_name,employee_user_name,employee_time_in,entry_type,employee_isHalfday) values('$employee_id','$today_date','$employee_name','$employee_user_name','$employee_time_in','$entry_type','yes')";
						$result1=$db->query($sql1);
					}
			
			}
			
			/*$sql2="select * from employee_record_daily where employee_id='$employee_id'";
			$result2=$db->query($sql2);
			while($row=$result2->fetch_assoc())
			{
				if ($row['employee_time_in']!='0000-00-00 00:00:00' and $date_last_checked_in==$today_date)
				{
					$message="You have already checked-in today!!";
					echo "<script type='text/javascript'>alert('$message');</script>";
				}
				else
				{
					$message = "Dear ".$employee_user_name.", You have been checked-in at ".$checkin_time." . Thank You.";
					echo nl2br("<script type='text/javascript'>alert('$message');</script>");
					if ($hour<11)
					{
						$sql="UPDATE employee_record_daily SET employee_time_in='$time',employee_time_out='',entry_type='checkin',employee_isHalfday='no',employee_wfh_date='0000-00-00',leave_early_date='0000-00-00',leave_early_time='00:00:00',employee_isWfh='no' WHERE employee_id='$employee_id'";	
						$result=$db->query($sql);
						$sql1="insert into employee_checkin_record(employee_id,entry_date,employee_name,employee_user_name,employee_time_in,entry_type) values('$employee_id','$today_date','$employee_name','$employee_user_name','$time','$entry_type')";
						$result1=$db->query($sql1);
					}
					else
					{
						$sql="UPDATE employee_record_daily SET employee_time_in='$time',employee_time_out='',entry_type='checkin',employee_isHalfday='yes',employee_wfh_date='0000-00-00',leave_early_date='0000-00-00',leave_early_time='00:00:00',employee_isWfh='no' WHERE employee_id='$employee_id'";	
						$result=$db->query($sql);
						$sql1="insert into employee_checkin_record(employee_id,entry_date,employee_name,employee_user_name,employee_time_in,entry_type,employee_isHalfday) values('$employee_id','$today_date','$employee_name','$employee_user_name','$employee_time_in','$entry_type','yes')";
						$result1=$db->query($sql1);
					}
			
				}
			}*/
		}
			

		if (isset($_POST['checkout']))
		{
			
				
			$sql1="select * from employee_record_daily where employee_id='$employee_id'";
			$result1=$db->query($sql1);
			while($row=$result1->fetch_assoc())
			{
				$checkin=$row['employee_time_in'];
				$checkout=$row['employee_time_out'];
			}
			$today_date=date("Y-m-d");
			$datetime = explode(" ",$checkin);
			$date_last_checked_in = $datetime[0];
				if ($checkin=="0000-00-00 00:00:00" or($checkin!="0000-00-00 00:00:00" and $date_last_checked_in!=$today_date))
				{
					$message = "Please checkin first.!!";
					echo "<script type='text/javascript'>alert('$message');</script>";
				}	

				else if($checkout!="0000-00-00 00:00:00")
				{
					$message = "You have already checked out today.!!";
					echo "<script type='text/javascript'>alert('$message');</script>";
				}
				else
				{
					$time=date("Y-m-d H:i:s");
					$time;
					
					$sql="UPDATE employee_record_daily SET employee_time_out='$time',entry_type='checkout' WHERE employee_id='$employee_id'" ;	
					$result=$db->query($sql);
					$sql1="UPDATE employee_checkin_record SET employee_time_out='$time',entry_type='checkout' WHERE employee_id='$employee_id' and entry_date='$today_date' " ;	
					$result1=$db->query($sql1);
					$message = "Dear ".$employee_name.", you are now checked out.";
					echo "<script type='text/javascript'>alert('$message');</script>";

				}
			
			
		}
		
		if(isset($_POST['wfh']))
		{
			$employee_wfh_date=$_POST['employee_wfh_date'];
			$employee_wfh_date=date("Y-m-d",strtotime($employee_wfh_date));
			$today_date=date("d-m-Y");
			$sql="select * from employee_record_daily where employee_id='$employee_id'";
			$result=$db->query($sql);
			while($row=$result->fetch_assoc())
			{
				$employee_name=$row['employee_name'];
				$employee_user_name=$row['employee_user_name'];
			}
			$flag=0;
			//$wfh_date=date("Y-m-d");
			$wfh_time_in=$wfh_date." "."00:00:00";
			$wfh_time_out=$wfh_date." "."00:00:00";
			if(trim($today_date)==trim($employee_wfh_date))
			{
				$employee_wfh_date=$today_date;
			}
			$sql3="select * from employee_checkin_record";
			$result3=$db->query($sql3);
			while($row=$result3->fetch_assoc())
			{
				$entry_date=$row['entry_date'];
				$user_name=$row['employee_user_name'];
			
				if($entry_date==$employee_wfh_date and $employee_user_name==$user_name)
				{
					//echo "a";
					$sql1="UPDATE employee_checkin_record set employee_time_in='00:00:00',employee_time_out='00:00:00',entry_type='WFH',employee_isHalfday='no',employee_isWfh='yes' where employee_id='$employee_id' and entry_date='$employee_wfh_date'";
					
					$result1=$db->query($sql1);
					
					$flag=1;
					break;
				}
			}
				if($flag==0)

				{
					//echo 'b';
					$sql1="insert into employee_checkin_record(employee_id,entry_date,employee_name,employee_user_name,employee_time_in,employee_time_out,entry_type,employee_isWfh) values('$employee_id','$employee_wfh_date','$employee_name','$employee_user_name','00:00:00','00:00:00','WFH','yes')";
					$result1=$db->query($sql1);	
					
				}
			
			
			$sql2="UPDATE employee_record_daily set employee_time_in='$wfh_time_in',employee_time_out='$wfh_time_out',entry_type='NULL',employee_isHalfday='no',employee_wfh_date='$employee_wfh_date',employee_isWfh='yes' where employee_id='$employee_id'";
			$result2=$db->query($sql2);
			
			
			$to1      = $mail_to_all;
		    $subject1 = 'Dignitas Digital- Working From Home - '.$employee_name;
		    $message1 = 	"  <html> 
						  <body>
						  Hi All,<br/><br/>
						  ".$employee_name." is working from home on date ".$employee_wfh_date.".<br/><br/><br/>
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
		    if(mail($to1, $subject1, $message1, $headers1))
		    {
			    $message="You have been marked as working from home.";
				echo "<script type='text/javascript'>alert('$message');</script>";
		    } 
		    else
		    {
		    	$message="Error in sending notification mail!!";
				echo "<script type='text/javascript'>alert('$message');</script>";
		    }		

		}

		if(isset($_POST['leave_early_time_submit']))
		{
			$today_date=date("d-m-Y");
			$leave_early_date=$_POST['leave_early_date'];
			$leave_early_time=$_POST['leave_early_time'];
			$leave_early_reason=$_POST['leave_early_reason'];
			$sql="select * from employee_record_daily where employee_id='$employee_id'";
			$result=$db->query($sql);
			while($row=$result->fetch_assoc())
			{
				$employee_name=$row['employee_name'];
				$employee_user_name=$row['employee_user_name'];
			}
			
			$sql="UPDATE employee_record_daily set leave_early_date='$leave_early_date',leave_early_time='$leave_early_time','remarks'='Leave Early' where employee_id='$employee_id'";
			$result=$db->query($sql);
			
			$to      = $mail_recipient;
			$to1	 = $mail_recipient1;
		    $subject = "Dignitas Digital-Leave Early Notificaton-".$employee_name;
		    $message = "  <html> 
						  <body>
						   Hi Rishi/Dhawal,<br/><br/>
						  ".$employee_name." will leave early on ".$leave_early_date." at ".$leave_early_time." due to ".$leave_early_reason.".<br/><br/><br/>
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

			$to2      = $mail_to_all;
		    $subject2 = "Dignitas Digital-Leave Early Notificaton-[".$employee_name."]";
		    $message2 = "  <html> 
						  <body>
						   Hi Rishi/Dhawal,<br/><br/>
						  ".$employee_name." will leave early on ".$leave_early_date." at ".$leave_early_time." due to ".$leave_early_reason.".<br/><br/><br/>
						  Thanks<br/>
						  Dignitas Digital Pvt. Ltd.
						  
						  
						  
						  
						  </body> 
						  </html>";
		    $headers2 = array("From: from@example.com",
			    "Reply-To:".$employee_user_name. "\r\n",
			    "X-Mailer: PHP/" . PHP_VERSION
			);
			$headers2  = 'MIME-Version: 1.0' . "\r\n";
			$headers2 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			//$headers = implode("\r\n", $headers);
		    if(mail($to, $subject, $message, $headers) and mail($to1, $subject, $message, $headers) and mail($to2, $subject2, $message2, $headers2))
		    {
		    	$message="Your Early Checkout notification has been sent. ";
						echo "<script type='text/javascript'>alert('$message');</script>";
		    }
		    else
		    {
		    	$message="Error! Mail not sent.";
						echo "<script type='text/javascript'>alert('$message');</script>";
		    }

			echo "<script>window.location = 'checkin_page.php'</script>";

		}
		
	}

	 

	  if(isset($_POST['setup']))
	  {
	  	$employee_name=$_SESSION['employee_name'];
	  	$employee_user_name=$_SESSION['employee_user_name'];
	  	$meeting_date=$_POST['meeting_date'];
	  	$meeting_desc=$_POST['meeting_desc'];
	  	$meeting_start_time=$_POST['meeting_start_time'];
	  	$meeting_end_time=$_POST['meeting_end_time'];
	  	$meeting_venue=$_POST['meeting_venue'];
	  	$meeting_date=date("y-m-d",strtotime($meeting_date));
	  	//echo $time_in_24_hour_format  = date("H:i:s", strtotime($meeting_start_time));
	  	//echo date("H:i", strtotime($meeting_start_time));
	  	$meeting_start_time_array=explode(':', trim($_POST['meeting_start_time']));
	  	//print_r($meeting_start_time_array);
	  	$meeting_start_time_string=trim($meeting_start_time_array[0]).":".trim($meeting_start_time_array[1])." ".$meeting_start_time_array[2];
	  	
	  	$meeting_start_time=date("H:i", strtotime($meeting_start_time_string));

	  	$meeting_end_time_array=explode(':', trim($_POST['meeting_end_time']));
	  	//print_r($meeting_start_time_array);
	  	$meeting_end_time_string=trim($meeting_end_time_array[0]).":".trim($meeting_end_time_array[1])." ".$meeting_end_time_array[2];
	  	
	  	$meeting_end_time=date("H:i", strtotime($meeting_end_time_string));

		$guests = explode(',', trim($_POST['guest_list']));//start with index 1
		
		

		for($guest_number=1;$guest_number<sizeof($guests);$guest_number++)
		{
			
			$guest_string=$guest_string.", ".$guests[$guest_number];
			
		}
		

		$guest_string1=substr_replace($guest_string,'',0,2);
		

		
		if($meeting_venue=='Outside the office')
	  	{
	  		$meeting_venue=$_POST['outside_venue'];
	  	}
		//echo $guest_string;
		$sql="insert into meeting_record(meeting_description, meeting_start_time, meeting_end_time, meeting_venue,meeting_date, requested_guests) values('$meeting_desc','$meeting_start_time','$meeting_end_time','$meeting_venue','$meeting_date','$guest_string')";
		$result=$db->query($sql);	
		

		foreach ($guests as $g ) 
		{
			

			$to      = $g;
			
		    $subject = "Dignitas Digital-Meeting Update-[".$meeting_desc."]";
		    $message = "  <html> 
						  <body>
						  ".$employee_name." has requested you to attend the following <a href='".$email_link."meeting.php'>meeting</a>: <br/><br/>
						  Description: ".$meeting_desc."<br/>
						  Date: ".$meeting_date."<br/>
						  Start Time: ".$meeting_start_time."<br/>
						  End Time: ".$meeting_end_time."<br/>
						  Venue: ".$meeting_venue."<br/>
						  Guests: ".$guest_string1."<br><br><br>	
						  <a href='".$email_link."meeting_response.php?employee_name=" . $employee_name . "& attend_meeting=yes & employee_user_name=".$employee_user_name." & guest=".$g." & meeting_desc=".$meeting_desc." & meeting_venue=".$meeting_venue." & meeting_start_time=".$meeting_start_time."' >Attend</a>
						  <a href='".$email_link."meeting_response.php?employee_name=" . $employee_name . "& attend_meeting=no & employee_user_name=".$employee_user_name." & guest=".$g." '>Reject</a>
					  	  
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
		    
		    	
		    
		   
		}	

		$message="The meeting has been set. ";
		echo "<script type='text/javascript'>alert('$message');</script>";
		
	  }


	  if(isset($_POST['submit_notes']))
	  {
	  		$notes_content=$_POST['notes_content'];
	  		$today_date=date("Y-m-d",time());

	  		$sql="insert into employee_notes(date,employee_name,note) values('$today_date','$employee_name','$notes_content')";
	  		$result=$db->query($sql);


	  		$to      = $mail_recipient;
			$to1      = $mail_recipient1;
		    $subject = "Dignitas Digital - Notes from ".$employee_name;
		    $message = "  <html> 
						  <body>
						  Hi Rishi/Dhawal<br/><br/>
						  Here are the notes of ".$employee_name." on date ".$today_date.":<br/><br/>
						  
						  ".$notes_content."<br/><br/>
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
		    if (mail($to, $subject, $message, $headers) and mail($to1, $subject, $message, $headers))
		    {
		    	$message="Your note has been sent. ";
				echo "<script type='text/javascript'>alert('$message');</script>";	
		    }


		    

	  }
  
?>


<div class="container-fluid">

<div id="header" class="row" style=" background-color: #FEEAD2;">
<div class="container-fluid">
	<div class="col-md-12" style="margin-top: 2%;">

		<div class="row">
	
			<div  class="col-md-2 col-xs-4 col-md-offset-1 col-xs-offset-1" >
				<img class="img-responsive" src="dignitaslogo.png" alt="Dignitas Logo"  />

			</div>
		</div>


		<div class="row" >
			<div align="right" class="col-md-7 col-md-offset-5 col-xs-6 col-xs-offset-6"  >
				<div class="row" >

				
					<nav class = "navbar navbar-default" role = "navigation_emp" style="border: 2px solid #FEEAD2;" >
						<div class="col-md-12 col-xs-12" style="background-color: #FEEAD2;padding: 0px;">
						 	<div class="navbar-header row">
						    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span> 
						      	</button>

						      
						    </div>
						    <div class="collapse navbar-collapse" id="myNavbar" style="margin-bottom: 0px;">
						    	
						    	<ul class="nav navbar-nav">
							     <li class="active">
							      	<form action="index.php" class="navbar-form navbar-right" role="search" >
										<input class="navigation_emp btn btn-default" type="submit"style="text-align:center; " value="Home" >
									</form>	
							      </li>
							      <li>
							      
							      	<form action="employee_login.php" class="navbar-form navbar-right" role="search" >
										<input class="navigation_emp btn btn-default" type="submit"style="text-align:center;" value="Dashboard">
									</form>	 
								  
							      </li>
							      <li>
							      	<form action="checkin_page.php" class="navbar-form navbar-right" role="search">
										<input  class="navigation_emp btn btn-default" type="submit" value="My Page" >
									</form>
							      </li> 
							      <li >
							      	<form action="meeting.php" class="navbar-form navbar-right" role="search">
										<input  class="navigation_emp btn btn-default" type="submit" value="Meetings" >
									</form>
							      </li> 
							      <li >
							      	<form action="leave.php" method="post" class="navbar-form navbar-right" role="search">
										<input class="navigation_emp btn btn-default" type="submit" value="Logout" name="logout">
									</form>
							      </li>
				    			</ul>
				    			
				    		</div>	
			    		</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="row" id="content">
	<div align="center" class="login col-md-3 col-md-offset-5 col-xs-6" style="border: 1px solid grey;margin-top: 50px;padding-bottom: 60px; padding-top: 50px; ">
		<form action="checkin_page.php" method="post">
			<?php 
				$today_date=date("d/m/y",time());
				$sql_checkin="select * from employee_record_daily where employee_id='$employee_id'";
				$result_checkin=$db->query($sql_checkin);
				while($row=$result_checkin->fetch_assoc())
				{
					$entry_type=$row['entry_type'];
					//echo $row['employee_time_in'];
					//echo "today date: ".$today_date;
					//echo date("d/m/y",strtotime($row['employee_time_in']));
					if ($entry_type!='checkin') 
					{
						$flag_checkin=1;
					}

					else if ($today_date!=date("d/m/y",strtotime($row['employee_time_in'])) and $entry_type=='checkin')						
					{
						$flag_checkin=1;
					}
				
					if($flag_checkin==1)
					{
						
			?>
			<button class="button btn btn-default" name="checkin" type="submit" style="margin-top: 20px;width: 70%;"  >Check-in</button><br/><br/>
			<?php
					}
									
			?>

			<?php
				if ($entry_type!='checkout') 
					{
						$flag_checkout=1;
					}

					else if ($today_date!=date("d/m/y",strtotime($row['employee_time_out'])) and $entry_type=='checkout')						
					{
						$flag_checkout=1;
					}
				
					if($flag_checkout==1)
					{
				
			?>
			<input type="submit" class="btn btn-default button" name="checkout" value="Checkout" style="width: 70%;"  onclick="return confirm('Are you sure you want to checkout?')"></input>
			<?php
				}	
			}
			?>
		</form>
		<form action="leave.php">
			<input type="submit" value="PTO" class="button btn btn-default" style="margin-top: 20px; width: 70%;"/>
		</form>

		<form action="checkin_page.php" method="post">
			<input type="submit" name="work_from_home" value="Work From Home" class="button btn btn-default" style="margin-top: 20px; width: 70%;"/>
		</form>

		<form action="checkin_page.php" method="post">
			<input type="submit" name="leave_early" value="Leave Early" class="button btn btn-default" style="margin-top: 20px; width: 70%;"/>
		</form>

		<form action="checkin_page.php" method="post">
			<input type="submit" name="setup_meeting" value="Setup a meeting" class="button btn btn-default" style="margin-top: 20px; width: 70%;"/>
		</form>

		<form action="checkin_page.php" method="post">
			<input type="submit" name="notes" value="Notes" class="button btn btn-default" style="margin-top: 20px; width: 70%;"/>
		</form>

		
	</div>

	<?php 
		if(isset($_POST['notes']))
		{
	?>
	
	<div  class="login col-md-3 col-xs-5" style=" margin-top: 40px;padding-top: 40px;  padding-left: 5px;margin-left: 10px;">
		<label>Enter the content</label> <br/>
		<form action="checkin_page.php" method="post">
			<input type="text" name="notes_content" style="float: left;" class="inputbox form-control"  >
			<br/><br/>
			
			<input type="submit" value="Submit" name="submit_notes" class="button btn btn-default" style="margin-left: 0px;"/>


		</form>
	</div>

	<?php
		}
	?>

	<?php
		if(isset($_POST['work_from_home']))
		{
	?>
	<div  class="login col-md-3 col-xs-5" style=" margin-top: 40px;padding-top: 40px;  padding-left: 5px;margin-left: 10px;">
		<label>On what date do you want to work from home?</label> <br/>
		<form action="checkin_page.php" method="post">
			<input type="text" name="employee_wfh_date" style="float: left;" class="inputbox form-control" id="date" >
			<br/><br/>
			
			<input type="submit" value="Submit" name="wfh" class="button btn btn-default" style="margin-left: 0px;" onclick="return confirm('Are you sure you want to work from home?')"/>


		</form>

		
	</div>

	<?php
		}
	?>

	<?php
		if(isset($_POST['leave_early']))
		{
	?>
	<div  class="login col-md-3 col-xs-5" style=" margin-top: 40px;padding-top: 40px;  padding-left: 5px;margin-left: 10px;">
		
		<form action="checkin_page.php" method="post">
			<label>Date</label> <br/>
			<input type="text" name="leave_early_date" style="float: left;" class="inputbox form-control" id="date2" >
			<label>At what time do you want to leave?</label> <br/>
			<input type="text" name="leave_early_time" style="float: left;" class="inputbox form-control" id="timepicker" >
			<br/><br/>
			<label class="label">Reason </label></br>
			<input type="text" class="inputbox form-control" name="leave_early_reason"/></br></br>
			<input type="submit" value="Submit" name="leave_early_time_submit" class="button btn btn-default" style="margin-left: 0px;"/>


		</form>

		
	</div>

	<?php
		}
	?>


	<?php
		if(isset($_POST['setup_meeting']))
		{
	?>
	<div  class="login col-md-3 col-xs-5" style=" margin-top: 30px; padding-top: 20px; margin-left: 10px;">
		
		<form action="checkin_page.php" method="post" name="my-form">
			<label>Meeting Date</label>
			<input type="text" name="meeting_date" style="float: left;" class="inputbox form-control" id="date1" /></br>

			
				
				<label style="font-size: 14px;">Start Time </label> <br/>
				<input type="text" name="meeting_start_time" style="float: left;" class="inputbox form-control" id="timepicker" />
			

			
				<label style="font-size: 14px;">End Time </label> <br/>
				<input type="text" name="meeting_end_time" style="float: left;" class="inputbox form-control" id="timepicker1" />
			

			<br/>
			<label class="label">Description </label></br>
			<input type="text" class="inputbox form-control" name="meeting_desc"/>

			<label class="label">Venue </label></br>
			<select class="inputbox form-control form-control" name="meeting_venue" id="meeting_venue" onchange="outside_office()">
				<option value="Conference Room">Conference Room</option>
				<option value="Interns' Table">Interns' Table</option>
				<option value="Cabin">Rishi's Cabin</option>
				<option value="Outside the office">Outside the office</option>
			</select><br/>

			<div id="outside_office"></div>

			<label class="label">Guest(s)</label>
			
			<br/>

			<div class="row">
			<div class="col-md-7 col-xs-7">
			<input type='text' class='auto form-control' style='font-size: 14px; font-family:"AvantGardeITCbyBT-Book"' id='entered_guest' onkeypress="auto_complete()">
			</div>

			<div class="col-md-5  col-xs-5 ">
			<input type='button' onclick="add_new()" value='Add' class='button btn btn-default' name="add_more_guest">
			</div>

			</div></br>
			<input type="hidden" name="guest_list" id="hidden_guest_list"/>

			
			<div id="guests_div"></div>
			</br>

			<input type="submit" value="Setup" class="button btn btn-default" name="setup">


			

		</form>

		
	</div>

	<?php
		}
	?>

	
</div>
	

	
  <div class="container-fluid" >
    <div align="right" id="footer" class="col-md-12" style="float: right;padding-top: 1%; border-top: 2px solid 	#D9D9D9; font-family: AvantGardeITCbyBT-Book; color: grey; font-size: 14px; padding-top: 5px; ">
    <div class="row">
    
		<div  class="col-md-11 col-xs-8"  >
			Copyright &copy; 2015 Dignitas Digital. All rights reserved 
		</div>
		<div class="col-md-1 col-xs-4" >
			<a href=" https://www.facebook.com/DignitasDigital">
				<img border="0" alt="Facebook" src="styles/images/social/FB.png" width="20" height="20">
			</a>
		

		
			<a href=" https://twitter.com/dignitasdigital">
				<img border="0" alt="Twitter" src="styles/images/social/Twitter.png" width="20" height="20">
			</a>
		

		
			<a href="mail to: contactus@dignitasdigital.com">
				<img border="0" alt="gmail" src="styles/images/social/Email.png" width="20" height="20">
			</a>
		</div>
	</div>
	
</div>
  </div>


</div>
</body>
</html>