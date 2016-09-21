<?php
	ini_set('error_reporting', 0);
	ini_set('display_errors', 0);
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
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" href="styles/jqx.base.css" type="text/css" />
	<link rel="stylesheet" href="styles/jqx.classic.css" type="text/css" />
	<link rel="stylesheet" href="styles/jqx.energyblue.css" type="text/css" />
	<script src="lib/jquery.min.js"></script>	
	<script type="text/javascript" src="lib/jquery-1.11.1.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
    <style>
	.navbar-nav > li{
  width: 150px !important;
  
}
	</style>
	<script type="text/javascript">
		function getQueryVariable(variable) 
		{
		  var query = window.location.search.substring(1);
		  var vars = query.split("&");
		  for (var i=0;i<vars.length;i++) 
		  {
			    var pair = vars[i].split("=");
			    if (pair[0] == variable) 
			    {
			      return pair[1];
			    }
		  } 
		  alert('Query Variable ' + variable + ' not found');
		}
$(document).ready(function () 
{
		
		
		
  
		var selected_employee_user_name=getQueryVariable("employee_user_name");
		var selected_employee_name = getQueryVariable("employee_name");
		
		
		
	    // prepare the data
	    var generaterow = function (rowdata) {
                
                
                var row = {};
                row['leave_id'] = rowdata.leave_id;
                row['selected_employee_user_name']=selected_employee_user_name;
                row["selected_employee_name"] = rowdata.employee_name;
                row['leave_start_date']=rowdata.leave_start_date;
                row['leave_stop_date']=rowdata.leave_stop_date;
                row['leave_type']=rowdata.leave_type;
                row['leave_status']=rowdata.leave_status;
                
                
                
                return row;
            }
	    var source ={
	        datatype: "json",
	        cache: false,
	        datafields: [{ name: 'leave_id'},
	        			 
	        			 { name: 'employee_name' },
	        			 { name: 'leave_start_date' },
	        			 { name: 'leave_stop_date' },
	        			 { name: 'leave_type' },
	        			 { name: 'leave_status' }
	        			 
	        			 
	        			],
	        id: 'row_id',
	        url: 'leave_details_data.php?selected_employee_name='+selected_employee_name+'&selected_employee_user_name='+selected_employee_user_name,
	        
			deleterow: function (rowdata, commit) 
						{
						    // synchronize with the server - send delete command
						        var data = "delete=true&" + $.param(rowdata);
						        
						        
								$.ajax({
						            dataType: 'json',
						            url: 'leave_details_data.php',
									cache: false,
						            data: data,
						            /*data: {'delete': true,
						            	   'selected_employee_name': selected_employee_name,
						            	   'leave_start_date': rowdata.leave_start_date,
						            	   'leave_stop_date': rowdata.leave_stop_date
						        		  },*/
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
							var datarow=generaterow(datarow);
								
							// synchronize with the server - send update command
						       // var data = “update=true&Name=” 	 “&Username=” + rowdata.leave_user_name ;
						       //var olddata = $('#leave_details').jqxGrid('getrowdata', rowid);
						       //var leave_id=rowdata.leave_id;
						       //var old_user_name=olddata.leave_user_name;
						       //alert("rowdata"+$.param(rowdata));

						       var data = "update=true&"  + $.param(datarow)  ;
						       
									$.ajax(
									{
							            dataType: 'json',
							            url: 'leave_details_data.php',

										cache: false,
							            data: data,
							            success: function (data, status, xhr) 
							            {
											// update command is executed.
											
											commit(true);
											location.reload();
										},
										error: function(jqXHR, textStatus, errorThrown)
										{
											commit(false);
										}							
									});		
						},

			
	    };
	    var dataAdapter = new $.jqx.dataAdapter(source);
	    $("#leave_details").jqxGrid({
	        theme: 'energyblue',
	        sortable: true,
	        width: '100%',
	        height: '100%',
	        source: dataAdapter,
	        editable: true,
	        pageable: true,
	        
	        columns: [
	        		  { text: 'Leave ID', datafield: 'leave_id',width: '10%',align: 'center'},
	        		  { text: 'Name', datafield: 'employee_name', width: '20%',align: 'center' },
	        		  { text: 'Leave Start Date', datafield: 'leave_start_date', width: '20%',align: 'center' },
	        		  { text: 'Leave Stop Date', datafield: 'leave_stop_date', width: '20%',align: 'center' },
	        		  { text: 'Leave Type', datafield: 'leave_type', width: '20%',align: 'center' },
	        		  { text: 'Leave Status', datafield: 'leave_status', width: '10%',align: 'center' }
	        		  
	        		  
	        	]
	    });

	    

	    
		$("#delete_leave").jqxButton({theme: 'energyblue'});
		$("#update_leave").jqxButton({theme: 'energyblue'});
		
		// delete row.
					$("#delete_leave").bind('click', function () 
					{
						var rowid = $('#leave_details').jqxGrid('getselectedrowindex');
						//var rowid = $("#leave_details").jqxGrid('getrowid', selectedrowindex);
						
						var rowdata = $('#leave_details').jqxGrid('getrowdata', rowid);
			                
					    var datarow = generaterow(rowdata);
					    var selectedrowindex = $("#leave_details").jqxGrid('getselectedrowindex');
					    var rowscount = $("#leave_details").jqxGrid('getdatainformation').rowscount;
					    if (selectedrowindex >= 0 && selectedrowindex < rowscount) 
					    {
					        var id = $("#leave_details").jqxGrid('getrowid', selectedrowindex);
					        $("#leave_details").jqxGrid('deleterow', datarow);
					    }
					});

					// update row.
					$("#update_leave").bind('click', function () 
					{
						
						var rowid = $('#leave_details').jqxGrid('getselectedrowindex');
						
						
						var rowdata = $('#leave_details').jqxGrid('getrowdata', rowid);
						//alert("rowdata: "+rowdata);
						
					    var datarow = generaterow(rowdata);
					    
					    var selectedrowindex = $("#leave_details").jqxGrid('getselectedrowindex');
					    var rowscount = $("#leave_details").jqxGrid('getdatainformation').rowscount;
					    if (selectedrowindex >= 0 && selectedrowindex < rowscount) 
					    {
					        var id = $("#leave_details").jqxGrid('getrowid', selectedrowindex);
					        $("#leave_details").jqxGrid('updaterow', id, datarow);
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

</div>

<div style="border: 0.5px solid lightblue; margin-top: 43px;">
	<div  >
		<input type="button btn btn-default" id="update_leave" value="Update Selected Leave">
		<input type="button btn btn-default" id="delete_leave" value="Delete Selected Leave">
	</div>

	<div style="float: left;" id="leave_details"></div>
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