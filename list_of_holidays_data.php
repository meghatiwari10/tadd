
<?php 
include("db.php");

$sql = "select * from list_of_holidays";
$result=$db->query($sql);
while ($row=$result->fetch_assoc()) 
{
	
	
		$holidays[]=array 
		(
			'date'=> $row['Date'],
			'day'=>$row['Day'],
			'holiday'=>$row['Holiday']
			
					
		);
		
	
	

	

	
}
echo json_encode($holidays);

?>
