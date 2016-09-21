<?php
include('db.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');

require 'lib/excel_reader2.php';



if(isset($_POST['import']))
{
    $filename=$_FILES['filename'];
    //print_r($filename);
    //echo $_FILES[$filename]['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($filename["name"]);
//    echo $target_file;
    echo "<script>window.location = 'superuser_quotes.php'</script>";

    if (move_uploaded_file($filename['tmp_name'], $target_file)) {
       echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Possible file upload attack!\n";
    }
  

    
    //$handle = fopen($_FILES[$filename]["tmp_name"], 'r');
	//echo $filedata=$_FILES[$filename]["tmp_name"];
	//$file = fopen($filedata, "r");
    //$content = file_get_contents($file); 
//$lines = array_map("rtrim", explode("\n", $content));
	 /*while (($emapData = str_getcsv($file, ',','"')) != FALSE)
        {
            print_r($emapData);
            //print_r($emapData);
            //exit();
            /*$sql = "INSERT into quote_main(quote,quote_author) values ('$emapData[1]','$emapData[2]')";
            $result=$db->query($sql);
        }
        fclose($file);
        echo 'CSV File has been successfully Imported';
        header('Location: superuser_quotes.php');
    */


    $data = new Spreadsheet_Excel_Reader($target_file);
    //var_dump($data);

    echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";

    for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
    {   

        if(count($data->sheets[$i][cells])>0) // checking sheet not empty
        {
            echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i][cells])."<br />";
            for($j=1;$j<=count($data->sheets[$i][cells]);$j++) // loop used to get each row of the sheet
            { 
                
                $html.="<tr>";
                for($k=1;$k<=count($data->sheets[$i][cells][$j]);$k++) // This loop is created to get data in a table format.
                {
                    
                    $html.="<td>";
                    $html.=$data->sheets[$i][cells][$j][$k];
                    $html.="</td>";
                }
                $quote_id=$data->sheets[$i][cells][$j][1];
                $quote=$data->sheets[$i][cells][$j][2];
                $quote_author=$data->sheets[$i][cells][$j][3];

                $sql="insert into quote_main(quote,quote_author) values('$quote','$quote_author')";
                $result=$db->query($sql);
                if($result)
                    echo "true";
                //$eid = mysqli_real_escape_string($db,$data->sheets[$i][cells][$j][1]);
                
                $html.="</tr>";
                
            }
        }
    }

    $html.="</table>";
    //echo $html;

}

//set_include_path(get_include_path() . PATH_SEPARATOR . '/var/www/html/dignitas');


// This is the file path to be uploaded.
//$inputFileName = $filename; 

/*try 
{
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} 
catch(Exception $e) 
{
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

/*for($i=2;$i<=$arrayCount;$i++)
{
    echo "aaaaaaa";
    $quote = trim($allDataInSheet[$i]["B"]);
    $quote_author = trim($allDataInSheet[$i]["C"]);

    $sql = "UPDATE quote_main set quote='$quote', quote_author='$quote_author'";
    $result=$db->query($sql);
    if($result)
        echo "true";
    else 
        echo "false";
}*/

 
?>