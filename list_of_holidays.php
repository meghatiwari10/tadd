<!DOCTYPE html>
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" href="styles/jqx.base.css" type="text/css" />
	<link rel="stylesheet" href="styles/jqx.classic.css" type="text/css" />
	<script src="lib/jquery.min.js"></script>	
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
        datafields: [{ name: 'date' },
        			 { name: 'day' },
        			 { name: 'holiday' }
        			 
        			 
        			 
        			],
        url: 'list_of_holidays_data.php'
    };
    $("#jqxgrid").jqxGrid({
        source: source,
        
        sortable: true,
        width: '100%',
        height: '100%',
        pageable: true,
        columns: [
        		  { text: 'Date', datafield: 'date', width: '33%'},
        		  { text: 'Day', datafield: 'day', width: '33%' },
        		  { text: 'Holiday', datafield: 'holiday', width: '34%' }
        		  
        		  
        		  


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
<body>

<div class="container-fluid">

<div id="header" class="row" style=" background-color: #FEEAD2;">
<div class="container-fluid">
	<div class="col-md-12" style="margin-top: 2%;">

		<div class="row">
	
			<div   class="col-md-2 col-xs-4 col-md-offset-1 col-xs-offset-1" >
				<img class="img-responsive" src="dignitaslogo.png" alt="Dignitas Logo"  />

			</div>
			
			<div class="col-md-2 col-md-offset-5 col-xs-3 col-xs-offset-4" >
				<form action="index.php">
					<input type="submit" class="button btn btn-default" value="Home">
				</form>
			</div>
		</div>
	</div>
</div></br>
</div>


<div id="content">
	<div id="jqxgrid" style="margin-top: 50px;overflow: auto;"></div>
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