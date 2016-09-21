	<?php
error_reporting(0);
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
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" href="styles/jqx.base.css" type="text/css" />
	<link rel="stylesheet" href="styles/jqx.classic.css" type="text/css" />
	<link rel="stylesheet" href="styles/jqx.energyblue.css" type="text/css" />
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
	<script src="lib/jquery.min.js"></script>	
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
    <script type="text/javascript" src="lib/jqxgrid.edit.js"></script>

    <link rel="stylesheet" type="text/css" href="styles/shadowbox.css">
	<script type="text/javascript" src="lib/shadowbox.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<style>
	.navbar-nav > li{
  width: 150px !important;
  
}
	</style>
	<script type="text/javascript">
	Shadowbox.init({
	    // skip the automatic setup 
	    skipSetup: true
	});

	window.onload = function() {
	    // open ASA the window loads
	    /*Shadowbox.open({
	        content:    '<img src="image.png" alt="alt" />',
	        player:     "html",
	        title:      "Welcome dude",
	        height:     502,
	        width:      350
	    });*/
	};
	</script>


	<script type="text/javascript">
		function manageusers()
		{
			document.getElementById("manageusers").style.display="";
			document.getElementById("managequotes").style.display= "none";
		}

		function managequotes()
		{
			document.getElementById("manageusers").style.display="none";
			document.getElementById("managequotes").style.display= "";
		}

		function newquote()
		{
			document.getElementById("newquote").style.display="";
		}

		

		function viewinfo(id)
		{
			
			document.getElementById(id).style.display= "";
			
			
			
		}
	</script>
	
	<link rel="stylesheet" type="text/css" href="styles/style.css">

<script type="text/javascript">


		$(document).ready(function () {
			
	    // prepare the data
	    var generaterow = function (employee_id,employee_name,employee_user_name) {
                
                
                var row = {};
                row['employee_id'] = employee_id;
                row["employee_name"] = employee_name;
                row["employee_user_name"] = employee_user_name;
                
                
                return row;
            }
	    var source ={
	        datatype: "json",
	        cache: false,
	        datafields: [{ name: 'employee_id'},
	        			 { name: 'employee_name' },
	        			 { name: 'employee_user_name' }
	        			],
	        id: 'row_id',
	        url: 'superuser_employees_data.php',
	        
			deleterow: function (rowdata, commit) 
						{
						    // synchronize with the server - send delete command
						        var data = "delete=true&" + $.param({rowdata});

						        //alert(data);
								$.ajax({
						            dataType: 'json',
						            url: 'superuser_employees_data.php',
									cache: false,
						            data: data,
						            success: function (data, status, xhr) 
						            {
										// delete command is executed.
										commit(true);
										alert(rowdata+" has been deleted.");
										location.reload();
									},
									error: function(jqXHR, textStatus, errorThrown)
									{
										commit(false);
									}
								});							
						},
			updaterow: function (rowid, rowdata, commit) 
						{
								
							// synchronize with the server - send update command
						       // var data = “update=true&Name=” 	 “&Username=” + rowdata.employee_user_name ;
						       //var olddata = $('#manage_employees').jqxGrid('getrowdata', rowid);
						       //var employee_id=rowdata.employee_id;
						       //var old_user_name=olddata.employee_user_name;
						       //alert("rowdata"+$.param(rowdata));
						       var data = "update=true&"  + $.param(rowdata)  ;
						       //alert(data);
									$.ajax(
									{
							            dataType: 'json',
							            url: 'superuser_employees_data.php',
										cache: false,
							            data: data,
							            success: function (data, status, xhr) 
							            {
											// update command is executed.
											commit(true);
											alert(rowdata.employee_user_name+" has been updated.");
											location.reload();
										},
										error: function(jqXHR, textStatus, errorThrown)
										{
											commit(false);
										}							
									});		
						},

			viewinfo: function(employee_name,employee_user_name,commit)
						{
							var data= "viewinfo=true&employee_name="+employee_name+"&employee_user_name="+employee_user_name;
							$.ajax(
									{
							            dataType: 'json',
							            url: 'superuser_employees_data.php',
							            type: 'get',
										cache: false,
							            data: data,
							            success: function (data, status, xhr) 
							            {
											// update command is executed.
											commit(true);
										},
										error: function(jqXHR, textStatus, errorThrown)
										{
											commit(false);
										}							
									});		
						}
	    };
	    var dataAdapter = new $.jqx.dataAdapter(source);
	    $("#manage_employees").jqxGrid({
	        theme: 'energyblue',
	        sortable: true,
	        width: '100%',
	        height: '100%',
	        source: dataAdapter,
	        editable: true,
	        pageable: true,
	        
	        columns: [
	        		  { text: 'ID', datafield: 'employee_id',width: '10%'},
	        		  { text: 'Name', datafield: 'employee_name', width: '15%'},
	        		  { text: 'Username', datafield: 'employee_user_name', width: '25%' },
	        		  { text: '', 
	        		    datafield: 'view_personal_details',
	        		    columntype: 'button', 
	        		  	width: '25%', 
	        		  	theme: 'energyblue',
	        		  	cellsrenderer: function()
	        		  	{
	        		  		return "Personal Details";
	        		  	},
	        		  	buttonclick: function (row) 
	        		  	{
                      		var rowid = $('#manage_employees').jqxGrid('getselectedrowindex');
                      		var rowdata = $('#manage_employees').jqxGrid('getrowdata', rowid);
                      		var employee_name=rowdata.employee_name;
                      		var employee_user_name=rowdata.employee_user_name;

                      		
                      		/*window.location.href = "viewinfo_popup_data.php?employee_user_name="+employee_user_name+"&employee_name="+employee_name;
                      		var selected_employee_name = getQueryVariable("employee_name");
		*/
							/*Shadowbox.init({
							    // skip the automatic setup 
							    skipSetup: true,
							    height:     502,
						        width:      350
							});

							Shadowbox.open({
						        content:    'viewinfo_popup_data.php?employee_user_name='+employee_user_name,
						        
						        player: 	"html",
						        title:      "Welcome dude",
						        height:     502,
						        width:      350
						    });
		

		/*$('.modal').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
  $(this).find('iframe').attr('src','viewinfo_popup_data.php?employee_user_name='+employee_user_name)
});*/
							$.ajax({ url: "viewinfo_popup_data.php",
							         datatype: 'html',
							         type: "POST",
							         data: {'employee_user_name': employee_user_name },
							         
							         success: function(res)
							         {

							           alert(res);
					        		 }
					    	});
                  		}
                  	  },
	        		  { text: '', 
	        		    datafield: 'viewinfo',
	        		    columntype: 'button', 
	        		  	width: '25%', 
	        		  	theme: 'energyblue',
	        		  	cellsrenderer: function()
	        		  	{
	        		  		return "Leave Details";
	        		  	},
	        		  	buttonclick: function (row) 
	        		  	{
                      		var rowid = $('#manage_employees').jqxGrid('getselectedrowindex');
                      		var rowdata = $('#manage_employees').jqxGrid('getrowdata', rowid);
                      		var employee_name=rowdata.employee_name;
                      		var employee_user_name=rowdata.employee_user_name;

                      		
                      		window.location.href = "viewinfo.php?employee_user_name="+employee_user_name+"&employee_name="+employee_name;
                      		
                  		} 
	        		  }
	        	]
	    });

	    

	    
		$("#delete_employee").jqxButton({theme: 'energyblue'});
		$("#update_employee").jqxButton({theme: 'energyblue'});
		
		// delete row.
					$("#delete_employee").bind('click', function () 
					{
						if(confirm('Are you sure you want to Delete?'))
						{
						    var rowid = $('#manage_employees').jqxGrid('getselectedrowindex');
							//var rowid = $("#manage_employees").jqxGrid('getrowid', selectedrowindex);
							
						    var rowdata = $('#manage_employees').jqxGrid('getrowdata', rowid);
   				                    var old_name=rowdata.employee_name;
				                    var old_user_name=rowdata.employee_user_name;
						    var datarow = generaterow(old_name,old_user_name);
						    var selectedrowindex = $("#manage_employees").jqxGrid('getselectedrowindex');
						    var rowscount = $("#manage_employees").jqxGrid('getdatainformation').rowscount;
						    if (selectedrowindex >= 0 && selectedrowindex < rowscount) 
						    {
						        var id = $("#manage_employees").jqxGrid('getrowid', selectedrowindex);
						        $("#manage_employees").jqxGrid('deleterow', old_user_name);
						    }
						}
					});

					// update row.
					$("#update_employee").bind('click', function () 
					{
						
						var rowid = $('#manage_employees').jqxGrid('getselectedrowindex');
						
						
						var rowdata = $('#manage_employees').jqxGrid('getrowdata', rowid);
						//alert("rowdata: "+rowdata);
						var employee_id=rowdata.employee_id;
			            var employee_name=rowdata.employee_name;
			            var employee_user_name=rowdata.employee_user_name;
					    var datarow = generaterow(employee_id,employee_name,employee_user_name);
					    
					    var selectedrowindex = $("#manage_employees").jqxGrid('getselectedrowindex');
					    var rowscount = $("#manage_employees").jqxGrid('getdatainformation').rowscount;
					    if (selectedrowindex >= 0 && selectedrowindex < rowscount) 
					    {
					        var id = $("#manage_employees").jqxGrid('getrowid', selectedrowindex);
					        $("#manage_employees").jqxGrid('updaterow', id, datarow);
					    }
					});

					

	});


	</script>

</head>
<body >

<?php
	
	include("db.php");
	date_default_timezone_set ("Asia/Calcutta");
	if(isset($_POST['register']))
	{
	// employee_user_name and password sent from Form
		$today_date=date("Y-m-d",time());
		$year=date('Y', strtotime($today_date));

		//$employee_name=mysqli_rif(isset($_POST['register']))
	
	// employee_user_name and password sent from Form
		$today_date=date("d/m/y",time());
		$year=date('Y', strtotime($today_date));

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
		$sql1="Insert into employee_main(employee_name,employee_user_name,employee_password) values('$employee_name','$employee_user_name','$employee_password')";
		$sql2="Insert into employee_record_daily(employee_name,employee_user_name,employee_password) values('$employee_name','$employee_user_name','$employee_password')";
		$sql3="insert into employee_record_leaves(employee_user_name,year) values('$employee_user_name','$year')";
		$sql4="Insert into employee_personal_details(employee_name,employee_user_name,employee_phone_number,employee_address,employee_emergency_phone,employee_emergency_address,employee_designation,employee_joining_date,employee_personal_email,employee_machine) values('$employee_name','$employee_user_name','$employee_phone_number','$employee_address','$employee_emergency_phone','$employee_emergency_address','$employee_designation','$employee_joining_date','$employee_personal_email','$employee_machine')";
		$result1=mysqli_query($db,$sql1);
		$result2=mysqli_query($db,$sql2);
		$result3=mysqli_query($db,$sql3);
		$result4=mysqli_query($db,$sql4);
	}	
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
		
	

if (isset($_POST['logout']))
	{
		session_destroy();
		 echo "<script>window.location = 'index.php'</script>";
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



<div class="row" style="margin-top: 30px;">
<div class="col-md-12">
	<form action="superuser_add_employee.php">
		<input type="submit" value="Add an employee" class="navigation btn btn-default" style="width: 150px;float: left;"/>
	</form>
</div>
	
	
</div></br>



<div id="manageusers" >
	

	<div  style=" overflow: auto; overflow-x:auto; height: auto;border: 0.5px solid lightblue;" class="login">
		<div>
			<input type="button" id="update_employee" value="Update Selected Employee">
			<input type="button" id="delete_employee" value="Delete Selected Employee" onclick="return confirm('Are you sure you want to delete?')" >
		</div>
		<div style="float: left;" id="manage_employees"></div>
    	
    	<script type="text/javascript">
			var buttonclick = function (event) 
			{
				var id = event.target.id;
				$("#manage_employees").jqxGrid('viewinfo', id);
			}
		</script>
    
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