<?php 
	include("db.php");
	
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	ini_set('error_reporting', 0);
	ini_set('display_errors', 0);
	
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, user-scalable=false;">
	<link rel='stylesheet' href='styles/style.css' />
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
	
	<script type="text/javascript" src="lib/jquery-1.11.1.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	<style type="text/css">
		html,
		body {
			margin:0;
			padding:0;
			height:100%;
		}
		#wrapper {
			min-height:100%;
			position:relative;
		}
		#header {
			background:#ededed;
			padding:10px;
		}
		#content {
			padding-bottom:100px; /* Height of the footer element */
		}
		#footer {
			
			width:100%;
			height:100px;
			position:absolute;
			bottom:0;
			left:0;
		}
	</style>
	
</head>
<body>

<?php

$email_md5=$_GET['key'];
$user=$_GET['user'];
if(isset($_POST['password_reset']) and $_POST['user']=="employee")
{
	$email_md5=$_POST['email_md5'];
	
	$password=$_POST['password'];
	$confirm_password=$_POST['confirm_password'];
	$password_md5=md5($password);
	
	if($password==$confirm_password)
	{
		
		
		$sql="select * from employee_main";
		$result=$db->query($sql);
		while($row=$result->fetch_assoc())
		{
			$employee_user_name=$row['employee_user_name'];
			$employee_user_name_md5=md5($employee_user_name);
			if($email_md5==$employee_user_name_md5)
			{
		
				$employee_user_name=$row['employee_user_name'];
				$sql1="update employee_main set employee_password='$password_md5' where employee_user_name='$employee_user_name'";
				$result1=$db->query($sql1);
				$sql2="update employee_record_daily set employee_password='$password_md5' where employee_user_name='$employee_user_name'";
				$result2=$db->query($sql2);
			}
		}
		$message="Your password has been reset.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>window.location = 'employee_login.php'</script>";

	}

	else
	{
		$message="Passwords did not match!!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>window.location = 'password_reset.php?key=".$email_md5."&user=employee'</script>";
	}	
}


if(isset($_POST['password_reset']) and $_POST['user']=="superuser")
{
	$email_md5=$_POST['email_md5'];
	
	$password=$_POST['password'];
	$confirm_password=$_POST['confirm_password'];
	$password_md5=md5($password);
	
	if($password==$confirm_password)
	{
		
		
		$sql="select * from superuser";
		$result=$db->query($sql);
		while($row=$result->fetch_assoc())
		{
			
			
			
				$sql1="update superuser set password='$password_md5'";
				$result1=$db->query($sql1);
				
			
		}
		$message="Your password has been reset.";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>window.location = 'superuserlogin.php'</script>";

	}

	else
	{
		$message="Passwords did not match!!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>window.location = 'password_reset.php?key=".$email_md5."&user=superuser'</script>";
	}	
}


?>
<div class="container-fluid" id="wrapper">
<div id="header" class="row" style=" background-color: #FEEAD2;">
<div class="container-fluid">
	<div class="col-md-12" style="margin-top: 2%;">

		<div class="row">
	
			<div   class="col-md-2 col-xs-4 col-md-offset-1 col-xs-offset-1" >
				<img class="img-responsive" src="dignitaslogo.png" alt="Dignitas Logo"  />

			</div>
		</div>
	</div>
</div></br>
</div>


<div id="content">
	<div class="col-md-5 col-md-offset-4" style=" margin-top: 10%;">
	<form action="password_reset.php" method="post">
		
		<input type="hidden" value="<?php echo $email_md5;?>" name="email_md5"/>
		<input type="hidden" value="<?php echo $user;?>" name="user"/>
		<div class="row">
			<label class="label" style="color: black;">New Password</label></br>
			<input type="password" name="password" class="inputbox form-control" />	</br></br>
		</div>
		
		<div class="row">
			<label class="label">Confirm Password</label>
			<input type="password" name="confirm_password" class="inputbox form-control"/>	
		</div></br></br>

		<div class="row" align="center">
			
			<input type="submit" name="password_reset" class="button btn btn-default" value="Reset" />	
		</div>		
	</form>	
	</div>
</div>

<div class="container-fluid" style="" >
    <div align="right" id="footer" class="col-md-12" style="padding-top: 1%; border-top: 2px solid 	#D9D9D9; font-family: AvantGardeITCbyBT-Book; color: grey; font-size: 14px; padding-top: 5px; ">
    <div class="row">
    
		<div  class="col-md-11 col-xs-8"  >
			Copyright &copy; 2015 Dignitas Digital. All rights reserved 
		</div>
		<div class="col-md-1 col-xs-4" >
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
	
</div>
  </div>
</div>
</body>
</html>