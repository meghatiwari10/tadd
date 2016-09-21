<?php
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	session_start();
	if($_SESSION['superuser_user_name']!='superuser')
	{
		$message="Superuser has not been logged in!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>window.location = 'superuserlogin.php'</script>";
	}
?>

<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=false;">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
	<script src="lib/jquery.min.js"></script>	
	<script type="text/javascript" src="lib/jquery-1.11.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body >
<?php
	
	include("db.php");
	date_default_timezone_set ("Asia/Calcutta");
	if(isset($_POST['register']))
	{
	// employee_user_name and password sent from Form
		$today_date=date("d/m/y",time());
		echo $year=date('Y', strtotime($today_date));

		$employee_name=mysqli_real_escape_string($db,$_POST['employee_name']); 
		$employee_user_name=mysqli_real_escape_string($db,$_POST['employee_user_name']); 
		$employee_password=mysqli_real_escape_string($db,$_POST['employee_password']); 
		$employee_password_md5=md5($employee_password); // Encrypted Password
		$employee_phone_number=mysqli_real_escape_string($db,$_POST['employee_phone_number']);
		$employee_address=mysqli_real_escape_string($db,$_POST['employee_address']);
		$employee_emergency_phone=mysqli_real_escape_string($db,$_POST['employee_emergency_phone']);
		$employee_emergency_address=mysqli_real_escape_string($db,$_POST['employee_emergency_address']);
		$employee_designation=mysqli_real_escape_string($db,$_POST['employee_designation']);
		$employee_joining_date=mysqli_real_escape_string($db,$_POST['employee_joining_date']);
		$employee_personal_email=mysqli_real_escape_string($db,$_POST['employee_personal_email']);
		$employee_machine=mysqli_real_escape_string($db,$_POST['employee_machine']);
		$sql1="Insert into employee_main(employee_name,employee_user_name,employee_password) values('$employee_name','$employee_user_name','$employee_password_md5')";
		$sql2="Insert into employee_record_daily(employee_name,employee_user_name,employee_password) values('$employee_name','$employee_user_name','$employee_password_md5')";
		$sql3="insert into employee_record_leaves(employee_user_name,year) values('$employee_user_name','$year')";
		$sql4="Insert into employee_personal_details(employee_name,employee_user_name,employee_phone_number,employee_address,employee_emergency_phone,employee_emergency_address,employee_designation,employee_joining_date,employee_personal_email,employee_machine) values('$employee_name','$employee_user_name','$employee_phone_number','$employee_address','$employee_emergency_phone','$employee_emergency_address','$employee_designation','$employee_joining_date','$employee_personal_email','$employee_machine')";
		$result1=mysqli_query($db,$sql1);
		$result2=mysqli_query($db,$sql2);
		$result3=mysqli_query($db,$sql3);
		$result4=mysqli_query($db,$sql4);

		$to      = $employee_user_name;
				
			    $subject = "Dignitas Digital - Welcome ".$employee_name;
			    $message = "  <html> 
							  <body>
							  Hi ".$employee_name.",<br/><br/>
							  Welcome to Dignitas Digital. Your login details are as follows:<br/>
							  Username: ".$employee_user_name."<br/>
							  Password: ".$employee_password."<br/><br/>
							  Thanks,<br/>
							  <a href='".$company_link."'>Dignitas Digital Pvt. Ltd.</a><br/><br/>
							  
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
			    	echo "done";
			    else
			    	echo "false";
			    echo "<script>window.location = 'superuser.php'</script>";
		
		/*if($result1)
		{
			echo "successful result1";
		}
		else
			echo "failed result1";

		if($result2)
		{
			echo "successful result2";
		}
		else
			echo "failed result2";*/
		
}

if (isset($_POST['logout']))
	{
		session_destroy();
		 echo "<script>window.location = 'index.php'</script>";
	}
?>

<div class="container-fluid">

<div id="header" class="row" style=" background-color: #FEEAD2;">
<div class="container-fluid">
	<div class="col-md-12 col-xs-12" style="margin-top: 2%;">

		<div class="row">
	
			<div  class="col-md-2 col-xs-4 col-md-offset-1 col-xs-offset-1" >
				<img class="img-responsive" src="dignitaslogo.png" alt="Dignitas Logo"  />

			</div>
		</div>


		<div class="row" >
			<div align="right" class="col-md-7 col-md-offset-5 col-xs-6 col-xs-offset-6"  >
				<div class="row" >

				
					<nav class = "navbar navbar-default" role = "navigation" style="border: 2px solid #FEEAD2;" >
						<div class="col-md-12 col-xs-12 col-xs-12" style="background-color: #FEEAD2;padding: 0px;">
						 	<div class="navbar-header row">
						    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span> 
						      	</button>

						      
						    </div>
						    <div class="collapse navbar-collapse" id="myNavbar" style="margin-bottom: 0px;">
						    	
						    	<ul class="nav navbar-nav">
							     
							      <li>
							      
							      	<form action="superuser.php" class="navbar-form navbar-right" role="search" >
										<input class="navigation btn btn-default" type="submit"style="text-align:center;" value="Manage Employees">
									</form>	 
								  
							      </li>
							      <li>
							      	<form action="superuser_quotes.php" class="navbar-form navbar-right" role="search">
										<input  class="navigation btn btn-default" type="submit" value="Manage Quotes" >
									</form>
							      </li> 
							      <li >
							      	<form action="superuser_meetings.php" class="navbar-form navbar-right" role="search">
										<input  class="navigation btn btn-default" type="submit" value="Meetings" >
									</form>
							      </li> 
							      <li >
							      	<form action="superuser.php" method="post" class="navbar-form navbar-right" role="search">
										<input class="navigation btn btn-default" type="submit" value="Logout" name="logout">
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
<div  class="login col-md-5 col-md-offset-4 col-xs-12" style="margin-top: 40px; border: 2px solid #D9D9D9;">
	<div class="row" style="text-align: center; font-size: 20px;font-family: AvantGardeITCbyBT-Book; color: white;background-color: #a10251; ">
		Superuser
	</div>
	<form action = "superuser_add_employee.php" method="post">
		<div class="row" style="height: 50px; margin-top: 20px;">
			<div class="col-md-6 col-xs-6" >
				<label class="label">Name </label><br/>
				<input  class="inputbox form-control" type = "text" name="employee_name"/>
				
			</div>

			<div class="col-md-6 col-xs-6">
				<label class="label">Designation</label><br/>
				<input class="inputbox form-control" type = "text" name="employee_designation" />
				
			</div>
		</div>
		<br/>
		<div class="row" >
			<div class="col-md-12 col-xs-12">
				<label class="label">Address </label><br/>
				<input class="inputbox form-control" type = "text" name="employee_address"  />
			</div>
		</div>
		<br/>
		<div class="row" >
			<div class="col-md-12 col-xs-12">
				<label class="label">Emergency Address </label><br/>
				<input class="inputbox form-control" type = "text" name="employee_emergency_address"  />
			</div>
		</div>

		<div class="row" style="height: 50px; margin-top: 20px;">
			<div class="col-md-6 col-xs-6" >
				<label class="label">Company Email ID </label><br/>
				<input  class="inputbox form-control" type = "email" name="employee_user_name"/>
				
			</div>

			<div class="col-md-6 col-xs-6">
				<label class="label">Password</label><br/>
				<input class="inputbox form-control" type = "password" name="employee_password" />
				
			</div>
		</div>
		

		<div class="row" style="height: 50px; margin-top: 20px;">
			<div class="col-md-6 col-xs-6" >
				<label class="label">Personal Email ID </label><br/>
				<input  class="inputbox form-control" type = "email" name="employee_personal_email"/>
				
			</div>

			<div class="col-md-6 col-xs-6">
				<label class="label">Phone No</label><br/>
				<input class="inputbox form-control" type = "number" name="employee_phone_number" />
				
			</div>
		</div>
		


		<div class="row" style="height: 50px; margin-top: 20px;">
			<div class="col-md-6 col-xs-6" >
				<label class="label">Joining Date </label><br/>
				<input  class="inputbox form-control" type = "date" name="employee_joining_date"/>
				
			</div>
				
			<div class="col-md-6 col-xs-6">
				<label class="label">Emergency Phone No </label><br/>
				<input  class="inputbox form-control" type = "number" name="employee_emergency_phone"/>
				
			</div>
		</div>
		<br/>
		
		<div class="row" >
			<div class="col-md-12 col-xs-12">
				<label class="label">Machine</label><br/>
				<input class="inputbox form-control" type = "text" name="employee_machine" />
			</div>
		</div>
		</br></br>

		
		
		
		
		<div class="row" align="center" >
			<input style="margin-bottom: 20px;" type="submit" class="button btn btn-default" name="register" value="Sign Up"/>	
		</div>

	</form>
	
	
</div>


  <div class="container-fluid" style="margin-top: 10%;margin-bottom: 3%;"  >
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