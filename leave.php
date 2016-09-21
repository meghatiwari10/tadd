	<?php
		error_reporting(0);
		ini_set('display_errors', '0');
		session_start();
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, user-scalable=false;">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="styles/jqx.base.css" type="text/css" />
	<link rel="stylesheet" href="styles/jqx.classic.css" type="text/css" />
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
    <script type="text/javascript" src="lib/jqxgrid.edit.js"></script>
    <script type="text/javascript" src="lib/jqxgrid.filter.js"></script>
	<script src='lib/moment.min.js'></script>

	<script>
	  $(function() {
	    $( "#date" ).datepicker();
	     $( "#date1" ).datepicker();
	  
	  });
	</script>
	<script type="text/javascript">
		var employee_name="<?php echo $employee_name=$_SESSION['employee_name']; ?>";
	</script>

	<script type="text/javascript">
	
    
    
	$(document).ready(function () 
	{
    	var generaterow = function (rowdata) 
	    {
		                
		                
		                var row = {};
		                row['leave_id'] = rowdata.leave_id;
		             	row['employee_name']=employee_name;
		                row['leave_start_date']=rowdata.leave_start_date;
		                row['leave_stop_date']=rowdata.leave_stop_date;
		                row['leave_type']=rowdata.leave_type;
		                row['leave_status']=rowdata.leave_status;
		                
		                
		                
		                return row;
		}

		var source =
	    {
	        datatype: "json",
	        datafields: [{ name: 'leave_id' },
	        			 { name: 'leave_start_date' },
	        			 { name: 'leave_stop_date' },
	        			 { name: 'leave_type' },
	        			 { name: 'leave_status' }
	        			],
	        url: 'employee_leaves_data.php?employee_name='+employee_name,

	        deleterow: function (rowdata, commit) 
							{
							    // synchronize with the server - send delete command
							        var data = "delete=true&" + $.param(rowdata);
							        alert(data);
							        
									$.ajax({
							            dataType: 'json',
							            url: 'employee_leaves_data.php',
										cache: false,
							            data: data,
							            
							            success: function (data, status, xhr) 
							            {
											// delete command is executed.
											//alert(data);
											commit(true);
											alert("Selected leave has been deleted from database.");
											location.reload();
										},
										error: function(jqXHR, textStatus, errorThrown)
										{
											commit(false);
										}
									});							
							},
				updaterow: function (rowid, datarow, commit) 
							{
								alert("1");
								var datarow=generaterow(datarow);
									alert("2");
								

							       var data = "update=true&"  + $.param(datarow)  ;
							       alert("3");
										$.ajax(
										{
								            dataType: 'json',
								            url: 'employee_leaves_data.php',
											cache: false,
								            data: data,
								            success: function (data, status, xhr) 
								            {
								            	alert("4");
												console.log("test");
												commit(true);
												alert("Updated!");
												location.reload();
											},
											error: function(jqXHR, textStatus, errorThrown)
											{
												console.log(errorThrown);
												commit(false);
												alert("5");
											}							
										});		
							}
	    };

	    $("#jqxgrid").jqxGrid({
	        source: source,
	        
	        sortable: true,
	        width: '100%',
	        height: '100%',
	        editable: true,

	        pageable: true,
	        columns: [
	        		  { text: '', datafield: 'leave_id', width: '10%'},
	        		  { text: 'From', datafield: 'leave_start_date', width: '23%' },
	        		  { text: 'To', datafield: 'leave_stop_date', width: '23%' },
	        		  { text: 'Type', datafield: 'leave_type', width: '22%' },
	        		  { text: 'Status', datafield: 'leave_status', width: '22%' }
	        		  
	        		  


	        		 ]
	    });

	    $("#delete_leave").jqxButton({theme: 'energyblue'});
		$("#update_leave").jqxButton({theme: 'energyblue'});

		// delete row.
						$("#delete_leave").bind('click', function () 
						{
							var rowid = $('#jqxgrid').jqxGrid('getselectedrowindex');
							
							
							var rowdata = $('#jqxgrid').jqxGrid('getrowdata', rowid);
				                
						    var datarow = generaterow(rowdata);
						    var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
						    var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
						    if (selectedrowindex >= 0 && selectedrowindex < rowscount) 
						    {
						        var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
						        $("#jqxgrid").jqxGrid('deleterow', datarow);
						    }
						});

						$("#update_leave").bind('click', function () 
						{
							
							var rowid = $('#jqxgrid').jqxGrid('getselectedrowindex');
							
							
							var rowdata = $('#jqxgrid').jqxGrid('getrowdata', rowid);
							
							
						    var datarow = generaterow(rowdata);
						    
						    var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
						    var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
						    if (selectedrowindex >= 0 && selectedrowindex < rowscount) 
						    {
						        var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
						        $("#jqxgrid").jqxGrid('updaterow', id, datarow);
						    }
						});
	   

	});
	</script>
	</head>
	<body >
	<?php 
		
		
		date_default_timezone_set ("Asia/Calcutta");
		include "db.php";
		$employee_id=$_SESSION['employee_id'];
		

		function getWorkingDays($leave_start_date,$endDate)
			{
				    // do strtotime calculations just once
				    $endDate = strtotime($endDate);
				    $leave_start_date = strtotime($leave_start_date);


				    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
				    //We add one to inlude both dates in the interval.
				    $days = ($endDate - $leave_start_date) / 86400 + 1;

				    $no_full_weeks = floor($days / 7);
				    $no_remaining_days = fmod($days, 7);

				    //It will return 1 if it's Monday,.. ,7 for Sunday
				    $the_first_day_of_week = date("N", $leave_start_date);
				    $the_last_day_of_week = date("N", $endDate);

				    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
				    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
				    if ($the_first_day_of_week <= $the_last_day_of_week) 
				    {
				        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
				        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
				    }
				    else 
				    {
				        // (edit by Tokes to fix an edge case where the start day was a Sunday
				        // and the end day was NOT a Saturday)

				        // the day of the week for start is later than the day of the week for end
				        if ($the_first_day_of_week == 7) 
				        {
				            // if the start date is a Sunday, then we definitely subtract 1 day
				            $no_remaining_days--;

				            if ($the_last_day_of_week == 6) 
				            {
				                // if the end date is a Saturday, then we subtract another day
				                $no_remaining_days--;
				            }
				        }
				        else 
				        {
				            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
				            // so we skip an entire weekend and subtract 2 days
				            $no_remaining_days -= 2;
				        }
				    }

				    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
					//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
				   $workingDays = $no_full_weeks * 5;
				    if ($no_remaining_days > 0 )
				    {
				      $workingDays += $no_remaining_days;
				    }    
				    return $workingDays;
			}


		if (isset($_POST['logout']))
		{
			session_destroy();
			 echo "<script>window.location = 'index.php'</script>";
		}
		
		if (isset($_POST['submit']))
		{
			
			$leave_start_date=$_POST['leave_start_date'];
			$leave_start_date=date("Y-m-d",strtotime($leave_start_date));	
			$leave_stop_date=$_POST['leave_stop_date'];
			$leave_stop_date=date("Y-m-d",strtotime($leave_stop_date));	
			$leave_type=$_POST['leave_type'];
			
		
			$sql="SELECT employee_name,employee_user_name FROM employee_record_daily WHERE employee_id='$employee_id'";
			$result = $db->query($sql);
			while($row = $result->fetch_assoc()) 
			{
				$employee_name=$row['employee_name'];
				$employee_user_name=$row['employee_user_name'];
				$_SESSION['employee_user_name']=$employee_user_name;
			}
			
			$sql1="Insert into leaves_main(employee_name,employee_user_name,leave_start_date,leave_stop_date,leave_type) values('$employee_name','$employee_user_name','$leave_start_date','$leave_stop_date','$leave_type')";

			$result1=$db->query($sql1);
			$sql2="SELECT leave_id FROM leaves_main WHERE employee_name='$employee_name' and leave_start_date='$leave_start_date' and leave_stop_date='$leave_stop_date'";
			$result2=$db->query($sql2);
			while ($row2=$result2->fetch_assoc()) {

				 //$row2['employee_id'];
				$leave_id=$row2['leave_id'];
			}

			
		
		/*$sql="update leaves_main set leave_status='granted' where leave_id='$leave_id'";
		$result=$db->query($sql);
		if ($result)
		{
			echo "Database updated with response.";
			echo nl2br("\n");

		}
		else
		{	echo "error";}

			

			

			$leavedays = getWorkingDays($leave_start_date,$leave_stop_date);
			$year=date('Y', strtotime($leave_start_date));
			
			$sql="select * from employee_record_leaves where employee_user_name='$employee_user_name'";
			$result=$db->query($sql);
			while($row = $result->fetch_assoc()) 
			{
		       $employee_remaining_leaves=$row['employee_remaining_leaves'];
		       $employee_extra_leaves=$row['employee_extra_leaves'];
		       $employee_PTO=$row['employee_PTO'];
		       $employee_remaining_PTO=$row['employee_remaining_PTO'];
		       $employee_sick_leaves=$row['employee_sick_leaves'];
		       $employee_remaining_sick_leaves=$row['employee_remaining_sick_leaves'];
		       $employee_leave_without_pay=$row['employee_leave_without_pay'];
		  	}

		  	if ($leave_type=="PTO")
		  	{
		  		
			  	if($employee_remaining_PTO < $leavedays)
			  	{
			  		
			  		$diff=$leavedays-$employee_remaining_PTO;
			  		$employee_PTO=$employee_PTO+$employee_remaining_PTO;
			  		$employee_remaining_PTO=0;
			  		$employee_leave_without_pay=$employee_leave_without_pay+$diff;
			  	}

			  	else if($employee_remaining_PTO>=$leavedays)
			  	{
			  		
			  		$employee_remaining_PTO-=$leavedays;
			  		$employee_PTO+=$leavedays;
			  	}

			  		$sql2="UPDATE employee_record_leaves set employee_PTO='$employee_PTO',employee_remaining_PTO='$employee_remaining_PTO', employee_leave_without_pay='$employee_leave_without_pay', year='$year' where employee_user_name='$employee_user_name'";
			  		$result2=$db->query($sql2);
			  		if($result2)
			  			echo "true";
			  		else echo "false";
		  	}

		  	if ($leave_type=="SICK")
		  	{
			  	if($employee_remaining_sick_leaves<$leavedays)
			  	{
			  		$diff=$leavedays-$employee_remaining_sick_leaves;
			  		$employee_sick_leaves+=$employee_remaining_sick_leaves;
			  		$employee_sick_leaves=0;
			  		$employee_remaining_sick_leaves=0;
			  		$employee_leave_without_pay+=$diff;
			  	}

			  	else if($employee_remaining_sick_leaves>=$leavedays)
			  	{
			  		$employee_remaining_sick_leaves-=$leavedays;
			  		$employee_sick_leaves+=$leavedays;
			  	}

			  		$sql2="UPDATE employee_record_leaves set employee_sick_leaves='$employee_sick_leaves',employee_remaining_sick_leaves='$employee_remaining_sick_leaves', employee_leave_without_pay='$employee_leave_without_pay', year='$year' where employee_user_name='$employee_user_name'";
			  		$result2=$db->query($sql2);
		  	}
			*/
			$to      = $mail_recipient;
			$to1	 = $mail_recipient1;
		    $subject = "Dignitas Digital-Leave Information - ".$employee_name;
		    $message = "  <html> 
						  <body>
						  Hi Rishi/Dhawal<br/><br/>
						  Please check leave information for ".$employee_name.".<br/><br/>
						  Employee Name: ".$employee_name."<br/>
						  Leave Type: ".$leave_type."<br/>
						  From: ".$leave_start_date."<br/>
						  To: ".$leave_stop_date."<br><br><br>	
						  <a href='".$leavegrant."?leave_id=" . $leave_id . "& employee_user_name=".$employee_user_name."& leave_start_date=".$leave_start_date." & leave_stop_date=".$leave_stop_date." & leave_type=".$leave_type." & employee_name=".$employee_name." '>Grant</a>
						  <a href='".$leavedeny."?leave_id=" . $leave_id . "&employee_user_name=".$employee_user_name." & leave_start_date=".$leave_start_date." & leave_stop_date=".$leave_stop_date."& leave_type=".$leave_type."  & employee_name=".$employee_name."'>Deny</a><br/><br/>
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
		    if(mail($to, $subject, $message, $headers) and mail($to1, $subject, $message, $headers))
		    {
		    	$message="Your leave request has been sent. Response will be e-mailed to you.";
						echo "<script type='text/javascript'>alert('$message');</script>";
		    }
		    else
		    {
		    	$message="Error! Mail not sent.";
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



	<div id="content" class="row">
		<div class="col-md-4 col-md-offset-1" style="border: 2px solid black;">
			<div style="border: 0.5px solid lightblue; margin-top: 43px;">
	<div  >
		<input type="button btn btn-default" id="update_leave" value="Update Selected Leave">
		<input type="button btn btn-default" id="delete_leave" value="Delete Selected Leave">
	</div>

	<div style="float: left;" id="jqxgrid"></div>
</div>
		</div>

		<div class="login col-md-2 col-md-offset-1" style="border: 2px solid #D9D9D9; margin-top: 50px;padding-top: 30px; padding-bottom: 30px;">
			<form action="leave.php" method="post">
				
				<label class="label">Start Date</label></br>
				<input id="date" class="inputbox form-control" name = "leave_start_date"></input><br/>
				
				<label class="label">End date</label><br/>
				<input id="date1" class="inputbox form-control" name="leave_stop_date" ></input><br/>

				<label class="label">Type</label>
				<label class="radio-inline"></label>
				<input type="radio" name="leave_type" value="PTO" checked />PTO
				<label class="radio-inline"></label>
				<input type="radio" name="leave_type" value="SICK"/>SICK
				
				<div  style="margin-top: 50px;margin-left: 50px;">
					<input type="submit" class="button btn btn-default" name="submit" value="Submit" />
				</div>
				 
			</form>
		</div>

		<div align="left" class="login" style=" width: 300px;margin-left: 20px; margin-top: 40px;
					padding-top: 20px;  float: left;  font-size: 18px;font-family: AvantGardeITCbyBT-Book; ">
			<?php 
				
				$employee_user_name=$_SESSION['employee_user_name'];
				$sql="select * from employee_record_leaves where employee_user_name='$employee_user_name'";
				$result=$db->query($sql);
				while($row=$result->fetch_assoc())
				{
					$employee_PTO=$row['employee_PTO'];
					$employee_remaining_PTO=$row['employee_remaining_PTO'];
					$employee_sick_leaves=$row['employee_sick_leaves'];
					$employee_remaining_sick_leaves=$row['employee_remaining_sick_leaves'];
					$employee_leave_without_pay=$row['employee_leave_without_pay'];

					/*echo "Remaining PTOs: ".$row['employee_remaining_leaves'];
					echo nl2br("\n");
					echo "Extra leaves Taken: ".$row['employee_extra_leaves'];*/
				

				}

				echo "Paid Time-offs taken: ".$employee_PTO;
				echo nl2br("\n");
				echo "Remaining Paid Time-offs: ".$employee_remaining_PTO;
				echo nl2br("\n");
				echo "Sick leaves taken: ".$employee_sick_leaves;
				echo nl2br("\n");
				echo "Remaining Sick Leaves: ".$employee_remaining_sick_leaves;
				echo nl2br("\n");
				echo "Leaves Without Pay taken: ".$employee_leave_without_pay;

			?>
		</div>
	</div>

		<nav class="navbar navbar-default"  >
	  <div class="container-fluid" style="margin-top: 5%;">
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
	</nav>
	</body>
	</html>