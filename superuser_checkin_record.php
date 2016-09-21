<?php
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	date_default_timezone_set ("Asia/Calcutta");
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
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
<link rel="stylesheet" href="styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="styles/jqx.classic.css" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
    <script type="text/javascript" src="lib/jqxdata.export.js"></script> 
<script type="text/javascript" src="lib/jqxgrid.export.js"></script> 
	<script src='lib/moment.min.js'></script>

	
	<style>
	.navbar-nav > li{
  width: 150px !important;
  
}
	</style>
<style type="text/css">
	.jqx-grid-column-header{z-index:0!important;}
</style>
<script>
  $(function() {
    $( "#date" ).datepicker({dateFormat: 'yy-mm-dd'});

    
  
  });
</script>



<script type="text/javascript">


$(document).ready(function () {	

	checkin_month='<?=$_GET['month'];?>';
	checkin_year='<?=$_GET['checkin_year'];?>';
	employee_to_search='<?=$_GET['employee_to_search'];?>';
    //alert(checkin_date);

	
    
    //alert(checkin_date);
    
    
/*		    					var new_date=checkin_date.setDate(checkin_date.getDate());
								

								var dd = checkin_date.getDate();
								var mm = checkin_date.getMonth()+1; //January is 0!
								var yyyy = checkin_date.getFullYear();

								if(dd<10) {
								    dd='0'+dd;
								} 

								if(mm<10) {
								    mm='0'+mm;
								} 
								checkin_date = yyyy+'-'+mm+'-'+dd;

	
	
    //alert(checkin_date);*/
    
    var source ={
        datatype: "json",

        datafields: [{ name: 'employee_name' },
        			 { name: 'employee_time_in' },
        			 { name: 'employee_time_out' },
        			 { name: 'employee_isHalfday' }
        			 
        			 
        			],
        
        url: 'superuser_checkin_record_data.php?checkin_month='+checkin_month+'&checkin_year='+checkin_year+'&employee_to_search='+employee_to_search
    };


    $("#jqxgrid").jqxGrid({
        source: source,
        
        sortable: true,
        width: '100%',
        height: '100%',
        pageable: true,
        columns: [
        		  { text: 'Name', datafield: 'employee_name', width: '25%'},
        		  { text: 'Check-in Time', datafield: 'employee_time_in', width: '25%' },
        		  { text: 'Check-out Time', datafield: 'employee_time_out', width: '25%' },
        		  { text: 'Halfday', datafield: 'employee_isHalfday', width: '25%' }
        		  
        		  


        		 ]
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

$("#excel_report").jqxButton({
    theme: 'energyblue'
});

$("#excel_report").click(function() {
    $("#jqxgrid").jqxGrid('exportdata', 'xls', 'jqxgrid');
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



<div id="content">
	<?php 
		$current_date=date("d/m/y",time());
	?>
		  		
		    		<div class="row">
		    			
		    			

		    			<div class="col-md-12 col-xs-12 " >
		 					<div class="row col-md-9 col-md-offset-3" style="margin-top: 50px;">
		 						
						  			
						<div class="col-md-3" >
							<label class="label">Select Month</label>
							<select class="inputbox form-control" id="month">
								<option value="01">January</option>
								<option value="02">February</option>
								<option value="03">March</option>
								<option value="04">April</option>
								<option value="05">May</option>
								<option value="06">June</option>
								<option value="07">July</option>
								<option value="08">August</option>
								<option value="09">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
								
							</select>
						</div>

						<div class="col-md-3" >
							<label class="label">Year</label>
							<input type="text" id="checkin_year" class="form-control inputbox">
						</div>
						<div class="col-md-3">
							<label class="label">Employee User Name</label>
							<input type="email" id="employee_to_search" class="form-control inputbox">
						</div>
						  			<div class="col-md-3" style="margin-top: 20px;">
						  			
						  			<input type="button" onclick="window.location='?month='+$('#month').val()+'&checkin_year='+$('#checkin_year').val()+'&employee_to_search='+$('#employee_to_search').val();" value="Search" name="search" class="button btn btn-default">
						  			
						  			</div><br/><br/><br/><br/><br/>
					  			
					  		</div><br/><br/><br/>
							<div>
							<input type="button"  value="Export to Excel" id="excel_report"> </div>
							<div  id="jqxgrid" style="overflow: auto;" ></div>
							
				 		</div>
		  			</div>
		
	
</div>

<div class="container-fluid" >
    <div align="right" id="footer" class="col-md-12" style="float: right;padding-top: 1%; border-top: 2px solid 	#D9D9D9; font-family: AvantGardeITCbyBT-Book; color: grey; font-size: 14px; padding-top: 5px; padding-bottom: 40px;">
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