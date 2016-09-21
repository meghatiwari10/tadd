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
	<link rel='stylesheet' href='lib/fullcalendar.css' />
	<link rel='stylesheet' href='styles/style.css' />
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<script type="text/javascript" src="lib/jquery-1.11.1.min.js"></script>
<script src='lib/moment.min.js'></script>
<script src='lib/fullcalendar.js'></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<style>
	.navbar-nav > li{
  width: 150px !important;
  
}
	</style>
<script type="text/javascript">
	$(document).ready(function() 
		{

		$('#calendar').fullCalendar({
			events: 'meetings_data.php',
			eventRender: function(event, element) { 
            element.find('.fc-title').append("<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + event.description); 
        } 
		});
	});
</script>
</head>
<body>
<div class="container-fluid">

<div id="header" class="row" style=" background-color: #FEEAD2;">
<div class="container-fluid">
	<div class="col-md-12" style="margin-top: 2%;">

		<div class="row">
	
			<div  class="col-md-2 col-xs-4 col-md-offset-1 col-xs-offset-1" >
				<img class="img-responsive" src="dignitaslogo.png" alt="Dignitas Logo"  />

			</div>
		</div>

		<br/><br/>

	</div>
</div>
</div>

<div class="container-fluid">


		<div align="right"	 class="row" >
			<div align="right" class="col-md-9 col-md-offset-3 col-xs-6 col-xs-offset-6" >
				
			<div class="row">
				
					<nav class = "navbar navbar-default" role = "navigation" style="border: 2px solid white;" >
						<div align="right" class="col-md-12 col-xs-12" style="background-color: white;">
						 	<div class="navbar-header row">
						    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span> 
						      	</button>

						      
						    </div>
						    <div  class="collapse navbar-collapse row" id="myNavbar" style="margin-bottom: 0px;" >
						    	
						    	<ul  class="nav navbar-nav" >
							     
							     <li>
							      
							      	<form action="superuserlogin.php" class="navbar-form navbar-right" role="search" >
										<input class="navigation btn btn-default" type="submit"style="text-align:center;margin-left: 0px;" value="Home">
									</form>	 
								  
							      </li>
							      <li>
							      
							      	<form action="superuser.php" class="navbar-form navbar-right" role="search" >
										<input class="navigation btn btn-default" type="submit"style="text-align:center;margin-left: 0px;" value="Manage Employees">
									</form>	 
								  
							      </li>
							      <li style="padding: 0px;margin: 0px;" >
							      	<form action="superuser_quotes.php" class="navbar-form navbar-right" role="search">
										<input  class="navigation btn btn-default" type="submit" value="Manage Quotes" >
									</form>
							      </li>
							      <li>
							      	<form action="superuser_checkin_record.php" class="navbar-form navbar-right" role="search">
										<input  class="navigation btn btn-default" type="submit" value="Check-in Record" >
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


<div class="row" style=" margin-top: 20px;overflow: auto;"  >
	<div class="col-md-12" id="calendar"></div>
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