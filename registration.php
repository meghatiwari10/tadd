<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register Page</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body >
<?php
	
	include("db.php");
	date_default_timezone_set ("Asia/Calcutta");
	if(isset($_POST['register']))
	{
	// employee_user_name and password sent from Form
		$today_date=date("Y-m-d",time());
		echo $year=date('Y', strtotime($today_date));

		if(empty($_POST['employee_name']))
		{

		}
		$employee_name=mysqli_real_escape_string($db,$_POST['employee_name']); 
		$employee_user_name=mysqli_real_escape_string($db,$_POST['employee_user_name']); 
		$employee_password=mysqli_real_escape_string($db,$_POST['employee_password']); 
		$employee_password=md5($employee_password); // Encrypted Password
		$employee_phone_number=mysqli_real_escape_string($db,$_POST['employee_phone_number']);
		$employee_address=mysqli_real_escape_string($db,$_POST['employee_address']);
		$employee_emergency_phone=mysqli_real_escape_string($db,$_POST['employee_emergency_phone']);
		$employee_emergency_address=mysqli_real_escape_string($db,$_POST['employee_emergency_address']);
		$employee_designation=mysqli_real_escape_string($db,$_POST['employee_designation']);
		$employee_joining_date=mysqli_real_escape_string($db,$_POST['employee_joining_date']);
		$employee_personal_email=mysqli_real_escape_string($db,$_POST['employee_personal_email']);
		$employee_machine=mysqli_real_escape_string($db,$_POST['employee_machine']);
		
		$sql3="insert into employee_record_leaves(employee_user_name,year) values('$employee_user_name','$year')";
		
		
		$result3=mysqli_query($db,$sql3);
		
		
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
?>

<div style="height: 130px;   background-color: #FEEAD2;">
	<div style="height: 64px; width: 30%; margin-left: 146px;margin-top: 28px; float: left;">
		<img src="dignitaslogo.png" alt="Dignitas Logo" style="height: 64px; width: 40%;" />

	</div>
</div>
<div  class="login" style="height: 512px; width: 453px; margin-top: 40px; margin-left: 30%;
			border: 2px solid #D9D9D9;">
	<div style="text-align: center; font-size: 20px;font-family: AvantGardeITCbyBT-Book; color: white;
				background-color: #a10251; height: 32px;padding-top:5px;">
		Register
	</div>
	<form action = "registration.php" method="post">
	
		<div style="height: 50px; margin-top: 20px;">
			<div style="float: left;margin-left: 20px;">
				<label class="label">Name* </label><br/>
				<input  class="inputbox" type = "text" name="employee_name"/>
				
			</div>

			<div style="float: left;margin-left: 60px;">
				<label class="label">Designation*</label><br/>
				<input class="inputbox" type = "text" name="employee_designation" />
				
			</div>
		</div>

		<div style=" height: 50px; margin-top: 5px; padding-left: 20px;">
			<label class="label">Address* </label><br/>
			<input class="inputbox" type = "text" name="employee_address" style="width: 393px;" /><br/><br/>
		</div>

		<div style=" height: 50px; margin-top: 5px; padding-left: 20px;">
		<label class="label">Emergency Address </label><br/>
			<input class="inputbox" type = "text" name="employee_emergency_address" style="width: 393px;" /><br/><br/>
		</div>

		<div style="height: 50px; margin-top: 5px;">
			<div style="float: left;margin-left: 20px;">
				<label class="label">Company Email ID* </label><br/>
				<input  class="inputbox" type = "email" name="employee_user_name"/>
				
			</div>

			<div style="float: left;margin-left: 60px;">
				<label class="label">Password*</label><br/>
				<input class="inputbox" type = "password" name="employee_password" />
				
			</div>
		</div>

		<div style="height: 50px; margin-top: 5px;">
			<div style="float: left;margin-left: 20px;">
				<label class="label">Personal Email ID* </label><br/>
				<input  class="inputbox" type = "email" name="employee_personal_email"/>
				
			</div>

			<div style="float: left;margin-left: 60px;">
				<label class="label">Phone No*</label><br/>
				<input class="inputbox" type = "number" name="employee_phone_number" />
				
			</div>
		</div>		

		<div style="height: 50px; margin-top: 5px;">
			<div style="float: left;margin-left: 20px;">
				<label class="label">Joining Date </label><br/>
				<input  class="inputbox" type = "date" name="employee_joining_date"/>
				
			</div>

			<div style="float: left;margin-left: 60px;">
				<label class="label">Machine</label><br/>
				<input class="inputbox" type = "text" name="employee_machine" />
				
			</div>
		</div>		
		
		<div style="height: 50px; margin-top: 5px;">
			<div style="float: left;margin-left: 20px;">
				<label class="label">Emergency Phone No </label><br/>
				<input  class="inputbox" type = "number" name="employee_emergency_phone"/>
			</div>
		</div>			
		
		<div align="center" style="margin-top: 30px;">
			<input style="width: 90px;" type="submit" class="button" name="register" value="Sign Up"/>	
		</div>

	</form>
	
	
</div>

<div align="right" style="float: right;padding-top: 10px; border-top: 2px solid #D9D9D9;font-size: 14px;
		 margin-top: 155px; font-family: AvantGardeITCbyBT-Book; color: grey; width: 100%;height: 50px;">
	Copyright &copy; 2015 Dignitas Digital. All rights reserved 
	<div style="margin-left: 20px; float: right;margin-right: 20px;">
		<a href="http://www.facebook.com">
			<img border="0" alt="Facebook" src="styles/images/social/FB.png" width="20" height="20">
		</a>
		<a href="http://www.twitter.com">
			<img border="0" alt="Twitter" src="styles/images/social/Twitter.png" width="20" height="20">
		</a>
		<a href="http://www.gmail.com">
			<img border="0" alt="gmail" src="styles/images/social/Email.png" width="20" height="20">
		</a>
	</div>
</div>
</body>
</html>