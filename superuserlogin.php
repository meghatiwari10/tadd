<?php 
//	error_reporting(E_ALL & ~E_NOTICE);
//	ini_set('display_errors', '1');
	ini_set('error_reporting', 0);
	ini_set('display_errors', 0);
	include("db.php");
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, user-scalable=false;">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="styles/shadowbox.css">
	<script type="text/javascript" src="lib/shadowbox.js"></script>

	<script src='lib/moment.min.js'></script>
	
	<link rel='stylesheet' href='lib/fullcalendar.css' />
	<script src='lib/fullcalendar.js'></script>

	<script type="text/javascript">
	$(document).ready(function() 
	{

		$('#calendar').fullCalendar({
			 eventSources: 
			 [
			   {		
			   		url: 'leave_events.php',
			   		
			   },
			   {		
			   		url: 'wfh_events.php',
			   		color: '#F1ED5D',
			   		textColor: 'black'
			   }

			    
    		 ]

		});
	});
	
	</script>

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

	<style type="text/css">
		#shadowbox_body_inner { background-color:#f6f4ee; } 
#sb-body-inner { background-color:#f6f4ee; } 


div#sb-content.html { 
        background-color:#f6f4ee !important; 
} 

#sb-body, #sb-loading { 
    background-color: #f6f4ee; 
} 
	</style>
	<script type="text/javascript">
	Shadowbox.init({
	    // skip the automatic setup 
	    skipSetup: true
	});

	function showBox() {
	    // open ASA the window loads
	    Shadowbox.open({
	        content: '<div class="container-fluid"><div class="col-md-10" style="margin-top: 30px;"><form action="superuserlogin.php" method="post" class="loginform" id="login-form"><label class="label">Enter your Email ID</label></br><input type="email" name="email" class="inputbox form-control"/></br><input type="submit"  name="forgot_password" class="button btn btn-default" value="Submit" /></form></div></div>',
	        player:     "html",
	        
	        height:     200,
	        width:      500
	    });
	};
	</script>
<body>
<?php 
		
	if(isset($_POST['forgot_password']))
	{
		$forgotten_email=$_POST['email'];
		$forgotten_email_md5=md5($forgotten_email);
		$flag=0;
		
		
		
			//if((trim($forgotten_email)==trim($mail_recipient)) or (trim($forgotten_email)==trim($mail_recipient1)))
			if(trim($forgotten_email)==trim($mail_recipient3))
			{
				$flag=1;
				$to      = $forgotten_email;
				
			    $subject = "Dignitas Digital-Password Reset";
			    $message = "  <html> 
							  <body>
							  To reset your password, click on following link: </br></br></br>
							  <a href='".$email_link."password_reset.php?key=".$forgotten_email_md5."&user=superuser'>Reset Password</a>
							  
							  </body> 
							  </html>";
			    $headers = array("From: from@example.com",
				    "Reply-To:".$forgotten_email. "\r\n",
				    "X-Mailer: PHP/" . PHP_VERSION
				);
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


				//$headers = implode("\r\n", $headers);
			    if(mail($to, $subject, $message, $headers))
			    {
			    	$message="A link to reset password has been sent to your email id.";
					echo "<script type='text/javascript'>alert('$message');</script>";
			    }
			    else
			    {
			    	$message="Error! Mail not sent.";
							echo "<script type='text/javascript'>alert('$message');</script>";
			    }
						
				
			}
		
		if($flag==0)
		{
			$message="This Email Id does not exist!!";
			echo "<script type='text/javascript'>alert('$message');</script>";	
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

<div class="col-md-3 col-md-offset-5 col-xs-3 col-xs-offset-4"  >
				<form action="index.php">
					<input type="submit" class="button btn btn-default" value="Home" style="float: left;">
				</form>
			

			
				<form action="superuser.php">
					<input type="submit" class="button btn btn-default" value="Superuser" style="float: left;">
				</form>
			</div>
		</div>
	</div>
</div></br>
</div>

<div id="content">

<div class="col-md-6 col-md-offset-1  col-xs-11" style="margin-top: 50px;">
		<div  style=" overflow: auto;" id="calendar" ></div>
	</div>

<div  class="login col-md-3 col-md-offset-1"  style="border: 2px solid grey;margin-top: 50px;padding-bottom: 50px;">
	
	<div class="row" style="text-align: center; font-size: 20px;font-family: AvantGardeITCbyBT-Book; color: white;background-color: #a10251;">
		Superuser
	</div>

	<p id="wrongdetails" style="height: 20px; width: 100%; font-size: 14px;margin-left: 20px;color: #a10251;"></p>
	<script type="text/javascript">
	function wrongdetails()
	{
	document.getElementById("wrongdetails").innerHTML="Incorrect User Name or Password";
	}
</script>
<?php
	if (isset($_POST['login']))
	{
		$superuser_user_name=$_POST['superuser_user_name'];
		$superuser_password=$_POST['superuser_password'];
		$superuser_password=md5($superuser_password);
		$sql="select * from superuser";
		$result=$db->query($sql);
		while($row=$result->fetch_assoc())
		{
			$superuser_name=$row['name'];
			$superuser_pass=$row['password'];
		}
		if($superuser_user_name==$superuser_name and $superuser_password==$superuser_pass)
		{
			$_SESSION['superuser_user_name']='superuser';
			echo "<script>window.location = 'superuser.php'</script>";
		}
		else 
		{
			echo "<script> wrongdetails(); </script>";

		}

	}
 ?>

 	<div class="col-md-12 ">
		<form action="superuserlogin.php" method="post">
		<div class="row">
			<label class="label">User name  </label><br/>
			<input type="text"  name="superuser_user_name" placeholder: "superuser_user_name" class="inputbox form-control"   /><br />
		</div>
		<div class="row">
			<label class="label">Password</label>
			<input type="password" name="superuser_password" class="inputbox form-control" /><br/>
		</div>
		<div class="row">
			<div class="col-md-4 col-xs-4" >
				<input style="margin-top: 30px;" class="button btn btn-default" type="submit" value=" Login " name="login" /><br />
			</div>
			<div class="col-md-7 col-md-offset-1 col-xs-7 col-xs-offset-1" >
				<a href="#" class="button btn btn-default" style="margin-top: 30px;" onclick="showBox()">Forgot Password</a>
			</div>
		</div>


		</form>
	</div>

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