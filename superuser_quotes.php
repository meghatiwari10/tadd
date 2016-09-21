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
    <script type="text/javascript" src="lib/jqxfileupload.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<style>
	.navbar-nav > li{
  width: 150px !important;
  
}
	</style>
	
	<link rel="stylesheet" type="text/css" href="styles/style.css">

	<script type="text/javascript">
	function addquotes()
	{
		document.getElementById("addquotes").style.display="";
		if(document.getElementById("addquotes").style.display="")
		{
			document.getElementById("addquotes").style.display="none";	
		}
		else
			document.getElementById("addquotes").style.display="";
	}
	</script>

<script type="text/javascript">
		$(document).ready(function () {
			/* $('#jqxFileUpload').jqxFileUpload({ 
			 	width: 300, 
			 	accept: '.csv',
			 	uploadUrl: 'superuser_quotes.php', 
			 	fileInputName: 'fileToUpload' 
			 });



			/* $('#jqxFileUpload').on('uploadEnd', function (event) {
                
			 	 <?php $filename=basename($_FILES["fileToUpload"]["name"]);?>
			  alert(<?php echo $filename; ?>);
                var args = event.args;
                var fileName = args.file;
                var serverResponse = args.response;
                // Your code here.
                console.log(args);
                console.log(fileName);
                console.log(serverResponse);
            });*/

			 	

	    // prepare the data
	    var generaterow = function (quote_id,quote,quote_author) {
                
                
                var row = {};
                row['quote_id'] = quote_id;
                row["quote"] = quote;
                row["quote_author"] = quote_author;
                
                
                return row;
            }
            
	    var source ={
	        datatype: "json",
	        cache: false,
	        datafields: [{ name: 'quote_id'},
	        			 { name: 'quote' },
	        			 { name: 'quote_author' }
	        			],
	        id: 'row_id',
	        url: 'superuser_quotes_data.php',
	        
			deleterow: function (rowdata, commit) 
						{
						    // synchronize with the server - send delete command
						        var data = "delete=true&" + $.param({rowdata});
						        
								$.ajax({
						            dataType: 'json',
						            url: 'superuser_quotes_data.php',
									cache: false,
						            data: data,
						            success: function (data, status, xhr) 
						            {
										// delete command is executed.
										commit(true);
										alert("Selected quote will be deleted.");
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
						       // var data = “update=true&Name=” 	 “&Username=” + rowdata.quote_user_name ;
						       //var olddata = $('#manage_quotes').jqxGrid('getrowdata', rowid);
						       //var quote_id=rowdata.quote_id;
						       //var old_user_name=olddata.quote_user_name;
						       //alert("rowdata"+$.param(rowdata));
						       var data = "update=true&"  + $.param(rowdata)  ;
						       
									$.ajax(
									{
							            dataType: 'json',
							            url: 'superuser_quotes_data.php',
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
	    $("#manage_quotes").jqxGrid({
	        theme: 'energyblue',
	        sortable: true,
	        width: '100%',
	        height: '100%',
	        source: dataAdapter,
	        editable: true,
	        pageable: true,
	        
	        columns: [
	        		  { text: '', datafield: 'quote_id',width: '20%'},
	        		  { text: 'Quote', datafield: 'quote', width: '40%'},
	        		  { text: 'Author', datafield: 'quote_author', width: '40%' },
	        		  
	        	]
	    });

	    

	    
		$("#delete_quote").jqxButton({theme: 'energyblue'});
		$("#update_quote").jqxButton({theme: 'energyblue'});
		
		// delete row.
					$("#delete_quote").bind('click', function () 
					{
						var rowid = $('#manage_quotes').jqxGrid('getselectedrowindex');
						//var rowid = $("#manage_quotes").jqxGrid('getrowid', selectedrowindex);
						
						var rowdata = $('#manage_quotes').jqxGrid('getrowdata', rowid);
			                var quote_id=rowdata.quote_id;
			                
					    
					    var selectedrowindex = $("#manage_quotes").jqxGrid('getselectedrowindex');
					    var rowscount = $("#manage_quotes").jqxGrid('getdatainformation').rowscount;
					    if (selectedrowindex >= 0 && selectedrowindex < rowscount) 
					    {
					        var id = $("#manage_quotes").jqxGrid('getrowid', selectedrowindex);
					        $("#manage_quotes").jqxGrid('deleterow', quote_id);
					    }
					});

					// update row.
					$("#update_quote").bind('click', function () 
					{
						
						var rowid = $('#manage_quotes').jqxGrid('getselectedrowindex');
						
						
						var rowdata = $('#manage_quotes').jqxGrid('getrowdata', rowid);
						//alert("rowdata: "+rowdata);
						var quote_id=rowdata.quote_id;
			            var quote=rowdata.quote;
			            var quote_author=rowdata.quote_author;
					    var datarow = generaterow(quote_id,quote,quote_author);
					    
					    var selectedrowindex = $("#manage_quotes").jqxGrid('getselectedrowindex');
					    var rowscount = $("#manage_quotes").jqxGrid('getdatainformation').rowscount;
					    if (selectedrowindex >= 0 && selectedrowindex < rowscount) 
					    {
					        var id = $("#manage_quotes").jqxGrid('getrowid', selectedrowindex);
					        $("#manage_quotes").jqxGrid('updaterow', id, datarow);
					    }
					});

					

	});
	</script>

</head>
<body>

<?php
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

<div style="height: 40px; width: 100%; margin-top: 43px; margin-bottom: 10px;">
	
	<input type="button" onclick="addquotes()" 
	value="Add quotes" class="navigation btn btn-default" style=" float: left;"/>
	
	
</div>

<div id="addquotes" style="display: none; margin-left: 20px;margin-bottom: 30px;">
	<form action="upload_quotes.php" method="post" enctype="multipart/form-data" >
	    
	        <label class="label"><u>Upload quotes file</u> </label> <br/>
	        <input type="file"  name="filename"  value="choose"  /><br/>
	    
	    <button type="submit" class="button" name="import" style="margin-top: 20px;width: 100px;"value="Import">Upload</button>
	</form>
</div>

	<div  style=" overflow: auto; overflow-x:auto; height: auto;" class="login">
		<div>
		<input type="button" id="update_quote" value="Update Selected Quote">
		<input type="button" id="delete_quote" value="Delete Selected Quote">
		</div>
		<div style="float: left;" id="manage_quotes">
    	</div>
    	
    
	</div></br></br></br></br></br></br>


<nav class="navbar navbar-default navbar-fixed-bottom" >
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
</nav>

</div>


</body>
</html>