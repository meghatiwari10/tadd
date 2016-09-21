<?php
include("db.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<?php 



	if (isset($_GET['insert']))
	{
	    // INSERT COMMAND
	   $sql1="Insert into employee_main(employee_name,employee_user_name,employee_password) values('$employee_name','$employee_user_name','$employee_password')";
		$sql2="Insert into employee_record_daily(employee_name,employee_user_name,employee_password) values('$employee_name','$employee_user_name','$employee_password')";
		$sql3="insert into employee_record_leaves(employee_user_name) values('$employee_user_name')";
		$result1=mysqli_query($db,$sql1);
		$result2=mysqli_query($db,$sql2);
		$result3=mysqli_query($db,$sql3);
	   echo $result1;
	   echo $result2;
	   echo $result3;
	}


    

	else if (isset($_GET['update']))
	{
		// UPDATE COMMAND
		$employee_id=$_GET['employee_id'];
		$employee_name=$_GET['employee_name'];
		$employee_user_name=$_GET['employee_user_name'];

		$sql="select * from employee_main where employee_id='$employee_id'";
		$result=$db->query($sql);
		while($row=$result->fetch_assoc())
		{
			$old_user_name=$row['employee_user_name'];
		}
		
		$update_sql1 = "UPDATE employee_main SET employee_name='$employee_name', employee_user_name='$employee_user_name' WHERE employee_id='$employee_id'";
		$result_update1=$db->query($update_sql1);

		$update_sql2 = "UPDATE employee_record_daily SET employee_name='$employee_name', employee_user_name='$employee_user_name' WHERE employee_user_name='$old_user_name'";
		$result_update2=$db->query($update_sql2);

		$update_sql3 = "UPDATE employee_record_leaves SET employee_user_name='$employee_user_name' WHERE employee_user_name='$old_user_name'";
		$result_update3=$db->query($update_sql3);	

		$update_sql4 = "UPDATE employee_personal_details SET employee_name='$employee_name', employee_user_name='$employee_user_name' WHERE employee_user_name='$old_user_name'";
		$result_update4 = $db->query($update_sql4);	

		$update_sql5="UPDATE leaves_main set employee_name='$employee_name' where employee_user_name='$employee_user_name'";
		$result_update5=$db->query($update_sql5);
		
		echo $result_update1;
		echo $result_update2;
		echo $result_update3;
		echo $result_update4;
		echo $result_update5;
	}

	else if(isset($_GET['delete']))
	{
		$employee_user_name=$_GET['rowdata'];
		$sql1="UPDATE employee_main SET employee_isDeleted='yes' WHERE employee_user_name='$employee_user_name'";
		$sql2="UPDATE employee_record_daily SET employee_isDeleted='yes' WHERE employee_user_name='$employee_user_name'";
		$sql3="UPDATE employee_record_leaves SET employee_isDeleted='yes' WHERE employee_user_name='$employee_user_name'";
		$sql4="update leaves_main set leave_isDeleted='yes' where employee_user_name='$employee_user_name'";

		$result1=$db->query($sql1);
		$result2=$db->query($sql2);
		$result3=$db->query($sql3);
		$result4=$db->query($sql4);
		echo $result1;
		echo $result2;
		echo $result3;
		echo $result4;
	}

	

	else
	{
		$sql="select * from employee_main where employee_isDeleted='no' ";
		$result = $db->query($sql);
	    while ($row = $result->fetch_assoc()) 
	    {
	        $employees[] = array(
	        	'employee_id' => $row['employee_id'],
	            'employee_name' => $row['employee_name'],
	            'employee_user_name' => $row['employee_user_name']
	          );
	    }
	 
	    echo json_encode($employees);
	}

?>