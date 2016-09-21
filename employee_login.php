<?php 
	session_start();
	//ini_set('error_reporting', 0);
	//ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, user-scalable=false;">
	<title>Login Page</title>
	<link rel='stylesheet' href='lib/fullcalendar.css' />
	<link rel='stylesheet' href='styles/style.css' />
		<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>

	
	<link rel="stylesheet" href="styles/jqx.base.css" type="text/css" />
	<link rel="stylesheet" href="styles/jqx.classic.css" type="text/css" />
	
	<script type="text/javascript" src="lib/jquery-1.11.1.min.js"></script>
	
	<script type="text/javascript" src="lib/jqxcore.js"></script>
	<script type="text/javascript" src="lib/jqxgrid.js"></script>
	<script type="text/javascript" src="lib/jqxdata.js"></script>
	<script type="text/javascript" src="lib/jqxbuttons.js"></script>
	<script type="text/javascript" src="lib/jqxscrollbar.js"></script>
	<script type="text/javascript" src="lib/jqxmenu.js"></script>
	<script type="text/javascript" src="lib/jqxgrid.sort.js"></script>
	<script type="text/javascript" src="lib/jqxgrid.pager.js"></script>
	<script type="text/javascript" src="lib/jqxgrid.selection.js"></script>
	<script type="text/javascript" src="lib/jqxlistbox.js"></script>
    <script type="text/javascript" src="lib/jqxdropdownlist.js"></script>
	<script src='lib/moment.min.js'></script>
	<script src='lib/fullcalendar.js'></script>
	<link rel="stylesheet" type="text/css" href="styles/shadowbox.css">
	<script type="text/javascript" src="lib/shadowbox.js"></script>

	<style type="text/css">
		#shadowbox_body_inner { background-color:#f6f4ee; } 
#sb-body-inner { background-color:#f6f4ee; } 


div#sb-content.html { 
        background-color:#f6f4ee !important; 
} 

#sb-body, #sb-loading { 
    background-color: #f6f4ee; 
} 
.fc-today
{
	background-color: #FF6666 !important;
}
	</style>


<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function() 
		{

		$('#calendar').fullCalendar({
			events: 'events.php'
		});
	});
	</script>

	<script type="text/javascript">
		$(document).ready(function () {
    //rotation speed and timer
    var speed = 5000;
    
    var run = setInterval(rotate, speed);
    var slides = $('.slide');
    var container = $('#slides ul');
    var elm = container.find(':first-child').prop("tagName");
    var item_width = container.width();
    var previous = 'prev'; //id of previous button
    var next = 'next'; //id of next button
    slides.width(item_width); //set the slides to the correct pixel width
    container.parent().width(item_width);
    container.width(slides.length * item_width); //set the slides container to the correct total width
    container.find(elm + ':first').before(container.find(elm + ':last'));
    resetSlides();
    
    
    //if user clicked on prev button
    
    $('#buttonsslider a').click(function (e) {
        //slide the item
        
        if (container.is(':animated')) {
            return false;
        }
        if (e.target.id == previous) {
            container.stop().animate({
                'left': 0
            }, 1500, function () {
                container.find(elm + ':first').before(container.find(elm + ':last'));
                resetSlides();
            });
        }
        
        if (e.target.id == next) {
            container.stop().animate({
                'left': item_width * -2
            }, 1500, function () {
                container.find(elm + ':last').after(container.find(elm + ':first'));
                resetSlides();
            });
        }
        
        //cancel the link behavior            
        return false;
        
    });
    
    //if mouse hover, pause the auto rotation, otherwise rotate it    
    container.parent().mouseenter(function () {
        clearInterval(run);
    }).mouseleave(function () {
        run = setInterval(rotate, speed);
    });
    
    
    function resetSlides() {
        //and adjust the container so current is in the frame
        container.css({
            'left': -1 * item_width
        });
    }
    
});
//a simple function to click next link
//a timer will call this function, and the rotation will begin

function rotate() {
    $('#next').click();
}
</script>
	
<script type="text/javascript">

				$(function() {
		            setTimeout( function() {
		                    $.get("quotes.php", function(data) {
		                            // first hide, then insert contents
		                            $("#quotes").hide();
		                            $("#quotes").html(data);
		                            // you can probably chain this together into one command as well
		                            $("#quotes").fadeIn("slow");

		                    });
		            }, 5*60*1000 );
				});
			</script>

			<script type="text/javascript">
		$(document).ready(function () {
    // prepare the data
    var source ={
        datatype: "json",
        datafields: [{ name: 'employee_name' },{ name: 'employee_time_in' },{ name: 'employee_time_out' },{ name: 'employee_isHalfday' }],
        url: 'checkedin_employees.php'
    };
    $("#jqxgrid").jqxGrid({
        source: source,
        
        sortable: true,
        width: 453,
        height: 400,
        pageable: true,
        columns: [{ text: 'Name', datafield: 'employee_name', width: 113},
        		  { text: 'Checkin', datafield: 'employee_time_in', width: 113 },
        		  { text: 'checkout', datafield: 'employee_time_out', width: 113 },
        		  { text: 'Halfday', datafield: 'employee_isHalfday', width: 113 }]
    });

    $("#jqxgrid").bind("pagechanged", function (event) {
    var args = event.args;
    var pagenumber = args.pagenum;
    var pagesize = args.pagesize;
});
$("#jqxgrid").bind("pagesizechanged", function (event) {
    var args = event.args;
    var pagenumber = args.pagenum;
    var pagesize = args.pagesize;
});

});
	</script>



	

<script type="text/javascript">
	Shadowbox.init({
	    // skip the automatic setup 
	    skipSetup: true
	});

	function showBox() {
	    // open ASA the window loads
	    Shadowbox.open({
	        content: '<div class="container-fluid"><div class="col-md-10" style="margin-top: 30px;"><form action="employee_login.php" method="post" class="loginform" id="login-form"><label class="label">Enter your Email ID</label></br><input type="email" name="email" class="inputbox form-control"/></br><input type="submit"  name="forgot_password" class="button btn btn-default" value="Submit" /></form></div></div>',
	        player:     "html",
	        
	        height:     200,
	        width:      500
	    });
	};
	</script>
	
</head>
<body >

<?php
	
	include("db.php");

	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
	if(isset($_POST['employee_login']))
		{
			// employee_user_name and password sent from Form
			$employee_user_name=mysqli_real_escape_string($db,$_POST['employee_user_name']); 
			$employee_password=mysqli_real_escape_string($db,$_POST['employee_password']); 
			$employee_password=md5($employee_password); // Encrypted Password
			$sql="SELECT employee_id FROM employee_record_daily WHERE employee_user_name='$employee_user_name' and employee_password='$employee_password'";
			$result = $db->query($sql);
			//print_r($result);
			//$count=mysqli_num_rows($result);
			
			// If result matched $employee_user_name and $employee_password, table row must be 1 row
			if($result->num_rows>0)
			{
			  
			  while($row = $result->fetch_assoc()) {
		       
		        $_SESSION['employee_id'] = $row["employee_id"];
		        $_SESSION['employee_user_name']=$employee_user_name;
			  }
			  echo "<script>window.location = 'checkin_page.php'</script>";

			}
			else 
			{
			$message="Invalid email address!!";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script>window.location = 'employee_login.php'</script>";
			}
		}	

	if(isset($_POST['forgot_password']))
	{
		$forgotten_email=$_POST['email'];
		$forgotten_email_md5=md5($forgotten_email);
		$flag=0;
		$sql="select employee_user_name from employee_main";
		$result=$db->query($sql);
		while ($row=$result->fetch_assoc()) 
		{
			$email=$row['employee_user_name'];
			if(trim($forgotten_email)==trim($email))
			{
				$flag=1;
				$to      = $forgotten_email;
				
			    $subject = "Dignitas Digital-Password Reset";
			    $message = "  <html> 
							  <body>
							  To reset your password, click on following link: </br></br></br>
							  <a href='".$email_link."password_reset.php?key=".$forgotten_email_md5."&user=employee'>Reset Password</a>
							  
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
			    	$message="A link to reset password has been sent to your email id.";
					echo "<script type='text/javascript'>alert('$message');</script>";
			    }
			    else
			    {
			    	$message="Error! Mail not sent.";
							echo "<script type='text/javascript'>alert('$message');</script>";
			    }
						
				break;
			}
		}
		if($flag==0)
		{
			$message="This Email Id does not exist!!";
			echo "<script type='text/javascript'>alert('$message');</script>";	
		}
	}
}


	
?>	
	
<div class="container-fluid">



<div id="header" class="row" style=" background-color: #FEEAD2;">
<div class="container-fluid">
	<div class="col-md-12" style="margin-top: 2%;">

		<div class="row"  >
	
			<div  class="col-md-2 col-xs-4 col-md-offset-1 col-xs-offset-1">
				<img class="img-responsive" src="dignitaslogo.png" alt="Dignitas Logo"  />

			</div>

			<div class="col-md-5 col-md-offset-4 col-xs-6 col-xs-offset-1 " style="text-align:right;">
			<?php
						if(isset($_SESSION['employee_user_name']))
						{
			?>	
				<div class="col-md-6 col-md-offset-1" >
				<div class="row" >
						<?php
							$employee_user_name = $_SESSION['employee_user_name'];
							$sql="select * from employee_main where employee_user_name='$employee_user_name'";
							$result=$db->query($sql);
							while ($row=$result->fetch_assoc())
							{
								$employee_name=$row['employee_name'];
								$_SESSION['employee_name']=$employee_name;
							}
							echo "Howdy, ".$employee_name." !!";
						
						?>
						
						
						
				</div>
				</div>
			
				<div align="right" class="col-md-4 col-xs-12 " style="padding: 0px; margin-left: 12px;" >
				
					<form action="change_password.php" method="post">
						<input type="hidden" value="<?php echo $_SESSION['employee_user_name']; ?>" name="employee_user_name">
						<input type="submit" value="Change Password"  name="change_password" class="button btn btn-default">
					</form>
				
				</div>
				<?php 
						}
						?>
			</div>
		

			
				
				
					
						
						
					
					
					<?php 
						if(!isset($_SESSION['employee_user_name']))
						{
					?>
					<div class="row col-xs-offset-1 col-md-offset-5">
						<form action="employee_login.php" method="post">
							<div class="col-md-4 col-xs-4" >
								<div class="row" >
									<label class="label ">Email ID </label><br/>
									<input type="text" name="employee_user_name" placeholder: "employee_user_name" class="inputbox form-control"  />
								</div>
							</div>
							<div class="col-md-4 col-xs-4" style="margin-left: 5px;">
								<div class="row ">
									<label class="label">Password </label><br/>	
									
									<input type="password" name="employee_password" class="inputbox form-control"  />

									
								</div>
							</div>
							<div  class="col-md-1 col-xs-2 col-xs-offset-1" style="margin-top:20px; margin-left: 10px;">
								<div class="row">
									<input class="button btn btn-default" type="submit" name="employee_login" value=" Login "/>
								</div>
							</div>

							

						</form>

						
							<div  class="col-md-2 col-xs-2 col-xs-offset-1" style="margin-top:20px; margin-left: 10px;width: 150px;">
									<div class="row">
										<a href="#" class="button btn btn-default" onclick="showBox()">Forgot Password</a>
										
									</div>
							</div>
						
					</div></br>

					<?php
						}
					?>
					
					
			
		</div>

		<div class="row">
			<?php
				if(isset($_SESSION['employee_user_name']))
				{

			?>

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
		
			<?php
				}
			?>
		</div>
	</div>
</div>
</div>





<div id="content" style="padding-top: 20px;">
	<div id="quotes" class="col-md-4 col-md-offset-1 login col-xs-12" style="" >
		
					
		
		  		
		    		<div id="buttonsslider"  class="row">
		    			<div class="col-md-1 col-xs-1">
		    				<div class="row" style="margin-top: 60px;">
		    					<a id="prev" href="#"><</a>
		    				</div>
		    				
		    			</div>
		    			

		    			<div id="slides" class="col-md-9 col-xs-9" >
		 					
						    <ul>
						     <?php
						  	$sql1="select * from quote_main";
						  	$result1=$db->query($sql1);
						  	while($row1=$result1->fetch_assoc())
						  	{
						  		
						  	?>
						  	
						      <li class="slide" style="float: left;">
							        <div class="quoteContainer" >
								        <p class="quote-phrase"> <?php echo $quote=$row1['quote'];?> </p>
							        </div>
							        <div  style="height: 30px;margin-top: 100px;" >
							    	    <p class="quote-author"> <?php echo $author=$row1['quote_author'];?></p>
							        </div>
						      </li>
						    
						    <?php }
						    ?>
						    </ul>
						   
				 		</div>


		    			<div class="col-md-1 col-xs-1">
		    				<div style="margin-top: 60px; ">
		    					<a  id="next" href="#">></a> 
		    				</div>
		    				
		    			</div>
		  			</div>
		
	</div>	

	<div class="col-md-6  col-xs-11" style="margin-left: 4%;">
		<div  style=" overflow: auto;" id="calendar" ></div>
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