<?php
$host="localhost"; // Host name.
$db_user="radius"; //mysql user
$db_password="p@ssw0rd"; //mysql pass
$db='ubrpt'; // Database name.
$conn=mysqli_connect("$host", "$db_user","$db_password","$db") or die(mysql_error());
//$conn=mysqli_connect($host,$db_user,$db_password) or die (mysql_error());
//mysql_select_db($db) or die (mysql_error());

$filename='userbehaviour.csv';

$file = fopen($filename, "r");
         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
         {
            $sql = "INSERT into userbehavior(dateime,macaddress,username,url,protocol,ipaddress,srcport,dstip,dstport) values('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]','$emapData[8]')";
            mysqli_query($conn,$sql);
         }
         fclose($file);
         echo "CSV File has been successfully Imported.";


?>
