<?php
include('db.php');


if (isset($_GET['term']))
{
	$term=$_GET['term'];

	$return_arr = array();
	$stmt = "SELECT employee_user_name FROM employee_main WHERE employee_user_name LIKE '$term%'";
	$result=$db->query($stmt);
	
	
	//$stmt->execute(array('term' => '%'.$_GET['term'].'%'));
	        
	while($row = $result->fetch_assoc()) 
	{
	  $return_arr[] =  $row['employee_user_name'];
	}
}


echo json_encode($return_arr);
?>