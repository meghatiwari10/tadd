<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=false;">
	<title></title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
	<link rel='stylesheet' href='lib/fullcalendar.css' />
	<link rel='stylesheet' href='styles/style.css' />
<script type="text/javascript" src="lib/jquery-1.11.1.min.js"></script>
<script src='lib/moment.min.js'></script>
<script src='lib/fullcalendar.js'></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() 
	{

		$('#calendar').fullCalendar({
			events: 'meetings_data.php',
			eventRender: function(event, element) 
			{ 
            	element.find('.fc-title').append("<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + event.description); 

        	},

        	eventMouseover: function(event, jsEvent, view) 
        	{
		        
		            $(jsEvent.target).attr('title', event.guests);
		        
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


<div  style=" margin-top: 20px; width: 100%; height: 100%;overflow: auto;" id="calendar" ></div>

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