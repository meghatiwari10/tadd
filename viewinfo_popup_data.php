
<?php

include("db.php");
$employee_user_name=$_POST['employee_user_name'];

$sql="select * from employee_personal_details where employee_user_name='$employee_user_name' ";
$result=$db->query($sql);

while($row=$result->fetch_assoc())
{
	$employee_data[]= array(
		'employee_name'=>$row['employee_name'],
		'employee_user_name'=>$row['employee_user_name'],
		'employee_phone_number'=>$row['employee_phone_number'],
		'employee_address'=>$row['employee_address'],
		'employee_emergency_phone'=>$row['employee_emergency_phone'],
		'employee_emergency_address'=>$row['employee_emergency_address'],
		'employee_designation'=>$row['employee_designation'],
		'employee_joining_date'=>$row['employee_joining_date'],
		'employee_personal_email'=>$row['employee_personal_email'],
		'employee_machine'=>$row['employee_machine']
		);
}
?>

Employee Personal Details: 

<?php echo "Name: ".$employee_data[0]['employee_name']; ?>

<?php echo "Username: ".$employee_data[0]['employee_user_name'];?>

<?php echo "Phone No: ".$employee_data[0]['employee_phone_number'];?>

<?php echo "Address: ".$employee_data[0]['employee_address'];?>

<?php echo "Emergency Phone No.: ".$employee_data[0]['employee_emergency_phone'];?>

<?php echo "Emergency Address: ".$employee_data[0]['employee_emergency_address'];?>

<?php echo "Designation: ".$employee_data[0]['employee_designation'];?>

<?php echo "Joining Date: ".$employee_data[0]['employee_joining_date'];?>

<?php echo "Personal Email Id: ".$employee_data[0]['employee_personal_email'];?>

<?php echo "Machine: ".$employee_data[0]['employee_machine'];?>






