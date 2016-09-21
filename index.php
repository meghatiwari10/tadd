<?php
	date_default_timezone_set ("Asia/Calcutta");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" href="styles/jqx.base.css" type="text/css" />
	<link rel="stylesheet" href="styles/jqx.classic.css" type="text/css" />
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
	<script src='lib/moment.min.js'></script>


	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>


<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function () {
    // prepare the data
    var source ={
        datatype: "json",
        datafields: [{ name: 'employee_name' },
        			 { name: 'employee_time_in' },
        			 { name: 'employee_time_out' },
        			 { name: 'employee_isHalfday' }
        			 
        			 
        			],
        url: 'checkedin_employees.php'
    };
    $("#jqxgrid").jqxGrid({
        source: source,
        
        sortable: true,
        width: '100%',
        height: '100%',
        pageable: true,
        columns: [
        		  { text: 'Name', datafield: 'employee_name', width: '25%'},
        		  { text: 'Checkin', datafield: 'employee_time_in', width: '25%' },
        		  { text: 'Checkout', datafield: 'employee_time_out', width: '25%' },
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

});
	</script>


	
</head>

<body >

<div class="container-fluid">

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




<div id="content" >
	
		<div class="col-md-5 col-xs-12 col-md-offset-1 " style="margin-top: 3%;">			
				<br/>
				<div class="row" style="border: 2px solid #D9D9D9;">
					<div align="center" class="col-md-12 label col-xs-12">
					<?php 
						echo date("d/m/y",time());
					?>
					</div>
					<div id="jqxgrid" style="margin-top: 0px;overflow: auto;"></div>
				</div>

		</div>
	

	<div class="row">
		<div class="col-md-3  col-xs-10 col-md-offset-1 col-xs-offset-1 " align="center" class="login" style="margin-top: 4.5%; border: 2px solid grey; ">
			<div class="row" style="text-align: center; font-size: 20px;font-family: AvantGardeITCbyBT-Book; color: white; background-color: #a10251; ">
				Welcome
			</div>

			<div class="row">
				<form action="employee_login.php" >
					<input class="button btn btn-default" style="width: 70%; margin-top: 15%;" type="submit" value="Employee Login">
				</form>
			</div>		
			<br/><br/>

			<div class="row">
				<form action="superuserlogin.php">
					<input class="button btn btn-default" style="width: 70%;margin-bottom: 15%;	 " type="submit" value="Superuser Login">
				</form>
			</div>

			<div class="row">
				<form action="list_of_holidays.php">
					<input class="button btn btn-default" style="width: 70%;margin-bottom: 15%;	 " type="submit" value="List of Holidays">
				</form>
			</div>


		</div>
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