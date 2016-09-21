<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'attendan_new');
define('DB_PASSWORD', 'y)82VJiMy+*G');
define('DB_DATABASE', 'attendan_new');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$leavegrant="http://192.185.26.7/dignitas/leavegrant.php";
$leavedeny="http://192.185.26.7/dignitas/leavedeny.php";
$leave_early_allow="http://192.185.26.7/dignitas";
$leave_early_deny="http://192.185.26.7/dignitas";
$mail_recipient="rishi@dignitasdigital.com"; //rishi
$mail_recipient1="mansi@dignitasdigital.com"; //dhawal
$mail_recipient3="rishi@dignitasdigital.com"; //for superuser forget password
$mail_to_all="dignitas-all@dignitasdigital.com"; //notification mails to all
$email_link="http://192.185.26.7/dignitas/";
$company_link='http://192.185.26.7/dignitas/employee_login.php';
$superuser_name='superuser';
// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

?>