<?php 
include("db.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');


	/*if (isset($_GET['insert']))
	{
	    // INSERT COMMAND
	   $sql1="Insert into quote_main(quote_name,quote_user_name,quote_password) values('$quote_name','$quote_user_name','$quote_password')";
		$sql2="Insert into quote_record_daily(quote_name,quote_user_name,quote_password) values('$quote_name','$quote_user_name','$quote_password')";
		$sql3="insert into quote_record_leaves(quote_user_name) values('$quote_user_name')";
		$result1=mysqli_query($db,$sql1);
		$result2=mysqli_query($db,$sql2);
		$result3=mysqli_query($db,$sql3);
	   echo $result1;
	   echo $result2;
	   echo $result3;
	}*/


    

	 if (isset($_GET['update']))
	{
		// UPDATE COMMAND
		$quote_id=$_GET['quote_id'];
		$quote=$_GET['quote'];
		$quote_author=$_GET['quote_author'];

		
		
		$update_sql = "UPDATE quote_main SET quote='$quote', quote_author='$quote_author' WHERE quote_id='$quote_id'";
		$result_update=$db->query($update_sql);

		
		
		echo $result_update;
		
	}

	else if(isset($_GET['delete']))
	{
		$quote_id=$_GET['rowdata'];
		$sql="UPDATE quote_main SET quote_isDeleted='yes' WHERE quote_id='$quote_id'";
		
		
		$result=$db->query($sql);
		
		echo $result;
		
	}

	

	else
	{
		$sql="select * from quote_main where quote_isDeleted='no' ";
		$result = $db->query($sql);
	    while ($row = $result->fetch_assoc()) 
	    {
	        $quotes[] = array(
	        	'quote_id' => $row['quote_id'],
	            'quote' => $row['quote'],
	            'quote_author' => $row['quote_author']
	          );
	    }
	 
	    echo json_encode($quotes);
	}

?>