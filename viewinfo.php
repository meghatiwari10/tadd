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
		
<script type="text/javascript">
		//var employee_user_name=<?php echo json_encode($employee_user_name); ?>;
		//alert(employee_user_name);
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
		var selected_employee_name = getQueryVariable("employee_name");
		var selected_employee_user_name=getQueryVariable("employee_user_name");
		
		/*$.ajax({ url: "viewinfo_popup_data.php",
		         datatype: 'html',
		         type: "POST",
		         data: {'employee_user_name': selected_employee_user_name },
		         
		         success: function(res)
		         {
		           alert(res);
        		 }
    	});*/
  

		
		
	    // prepare the data
	    var generaterow = function (rowdata) {
                
                
                var row = {};
                row['employee_id'] = rowdata.employee_id;
                row['selected_employee_user_name']=selected_employee_user_name;
                row["employee_user_name"] = rowdata.employee_user_name;
                row['year']=rowdata.year;
                row['employee_remaining_PTO']=rowdata.employee_remaining_PTO;
                row['employee_remaining_sick_leaves']=rowdata.employee_remaining_sick_leaves;
                row['employee_leave_without_pay']=rowdata.employee_leave_without_pay;
                
                
                
                return row;
            }

	    var source ={
	        datatype: "json",
	        cache: false,
	        datafields: [{ name: 'employee_id'},
	        			 
	        			 { name: 'employee_user_name' },
	        			 
	        			 { name: 'employee_remaining_PTO' },
	        			 { name: 'employee_remaining_sick_leaves' },
	        			 { name: 'employee_leave_without_pay' },
	        			 { name: 'year' }
	        			 
	        			],
	        id: 'row_id',
	        url: 'view_info_data.php?selected_employee_user_name='+selected_employee_user_name,
	        
			deleterow: function (rowdata, commit) 
						{
						    // synchronize with the server - send delete command
						        var data = "delete=true&" + $.param(rowdata);
						        
						        
								$.ajax({
						            dataType: 'json',
						            url: 'view_info_data.php',
									cache: false,
						            data: data,
						            success: function (data, status, xhr) 
						            {
										// delete command is executed.
										commit(true);
										alert(rowdata.employee_user_name+" has been deleted.");
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
								
							// synchronize with the server - send update command
						       // var data = “update=true&Name=” 	 “&Username=” + rowdata.employee_user_name ;
						       //var olddata = $('#view_info').jqxGrid('getrowdata', rowid);
						       //var employee_id=rowdata.employee_id;
						       //var old_user_name=olddata.employee_user_name;
						       //alert("rowdata"+$.param(rowdata));
						       //var rowdata=generaterow(datarow);
						       var data = "update=true&"  + $.param(datarow);
						       //alert(data);
									$.ajax(
									{
							            dataType: 'text',
							            url: 'view_info_data.php?selected_employee_user_name='+selected_employee_user_name,

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
	    $("#view_info").jqxGrid({
	        theme: 'energyblue',
	        sortable: true,
	        width: '100%',
	        height: '100%',
	        source: dataAdapter,
	        editable: true,
	        pageable: true,
	        showfilterrow: true,
	        filterable: true,
	        selectionmode: 'multiplecellsextended',
	        columns: [
	        		  { text: 'ID', datafield: 'employee_id',width: '5%',align: 'center'},
	        		  { text: 'Username', datafield: 'employee_user_name', width: '15%' ,align: 'center'},
	        		  { text: 'Year', datafield: 'year', width: '10%',align: 'center' },
	        		  { text: 'Remaining PTOs', datafield: 'employee_remaining_PTO', width: '10%',align: 'center' },
	        		  { text: 'Remaining sick leaves', datafield: 'employee_remaining_sick_leaves', width: '15%',align: 'center' },
	        		  
	        		  { text: 'Total Leaves Without Pay', datafield: 'employee_leave_without_pay', width: '15%',align: 'center' },
	        		   { text: '', 
	        		    datafield: 'leave_details',
	        		    columntype: 'button', 
	        		  	width: '30%', 
	        		  	theme: 'energyblue',
	        		  	cellsrenderer: function()
	        		  	{
	        		  		return "Leave Details";
	        		  	},
	        		  	buttonclick: function (row) 
	        		  	{
                      		var rowid = $('#view_info').jqxGrid('getselectedrowindex');
                      		var rowdata = $('#view_info').jqxGrid('getrowdata', rowid);
                      		//var employee_name=rowdata.employee_name;
                      		//var employee_user_name=rowdata.employee_user_name;


                      		window.location.href = "leave_details.php?employee_name="+selected_employee_name+"&employee_user_name="+selected_employee_user_name;
                      		
                  		} 
	        		  }
	        		  
	        	]
	    });

	    

	    
		$("#delete_employee").jqxButton({theme: 'energyblue'});
		$("#update_employee").jqxButton({theme: 'energyblue'});
		
		// delete row.
					$("#delete_employee").bind('click', function () 
					{
						var rowid = $('#view_info').jqxGrid('getselectedrowindex');
						//var rowid = $("#view_info").jqxGrid('getrowid', selectedrowindex);
						
						var rowdata = $('#view_info').jqxGrid('getrowdata', rowid);
			                
					    var datarow = generaterow(rowdata);
					    var selectedrowindex = $("#view_info").jqxGrid('getselectedrowindex');
					    var rowscount = $("#view_info").jqxGrid('getdatainformation').rowscount;
					    if (selectedrowindex >= 0 && selectedrowindex < rowscount) 
					    {
					        var id = $("#view_info").jqxGrid('getrowid', selectedrowindex);
					        $("#view_info").jqxGrid('deleterow', rowdata);
					    }
					});

					// update row.
					$("#update_employee").bind('click', function () 
					{
						
						var rowid = $('#view_info').jqxGrid('getselectedrowindex');
						
						
						var rowdata = $('#view_info').jqxGrid('getrowdata', rowid);
						//alert("rowdata: "+rowdata);
						
					    
					    
					    var selectedrowindex = $("#view_info").jqxGrid('getselectedrowindex');
					    var rowscount = $("#view_info").jqxGrid('getdatainformation').rowscount;
					    if (selectedrowindex >= 0 && selectedrowindex < rowscount) 
					    {
					        var id = $("#view_info").jqxGrid('getrowid', selectedrowindex);
					    	var datarow = generaterow(rowdata);    
					        $("#view_info").jqxGrid('updaterow', id, datarow);
					    }
					});
	});
	</script>
</head>
<body >

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

				
					<nav class = "navbar navbar-default" role = "navigation" style="border: 2px solid #FEEAD2;" >
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

<?php
$selected_employee_user_name=$_GET['employee_user_name'];
?>

<div style="border: 0.5px solid lightblue;margin-top: 43px;">
	<div>
		<input type="button" id="update_employee" value="Update Selected Employee">
		<input type="button" id="delete_employee" value="Delete Selected Employee">
	</div>

	<div style="float: left;height: 100px;" id="view_info"></div>
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