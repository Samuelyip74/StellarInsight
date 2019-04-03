<?php
if (!session_id()) {
    session_start();
}

$servername = "localhost";
$username = "radius";
$password = "p@ssw0rd";
$dbname = "radius";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$qry_body = "`id`                = '".rand(5,65535)."',
             `username`          = '".$_POST['user']."',
             `attribute`         = 'Cleartext-Password',
             `op`                = ':=',
	     `value`             = '".$_POST['password']."' ";


      $select_qry = "select * from `radcheck` where `username`= '".$_POST['user']."'";
      $res = $conn->query($select_qry);

                if($res->num_rows > 0) {
                        //Update user details if it is already exists in the table
                        $sql = "update "."`radcheck`"." set `value` = ".$_POST['password']." WHERE `username` = '".$_POST['user']."'";
                } else {
                //Insert into table if user not exists in the table
                        $sql = "insert into "."radcheck"." set ".$qry_body.";";
                        //                      echo $qry;
                }

                //      echo $qry_body;
//              $sql = "insert into "."radcheck"." set ".$qry_body.";";
        //      echo $sql;



//echo $qry_body;
//$sql = "insert into "."radcheck"." set ".$qry_body.";";
//echo $sql;
if ($conn->query($sql) === TRUE) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Begin: Meta Data -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <title>Free WIFI HotSpot</title>
    <meta name="description" content=""/>
    <meta http-equiv="content-language" content="en">
    <meta name="viewport" content="width=device-width" />
    <!-- END: Meta Data -->
    <!-- Begin: Coveo CSS (Template ID=Search Page) -->
    <!-- END: Coveo CSS -->
    <!-- Begin: Global CSS -->

    <!-- Begin: Global JavaScript Top -->
<script src="/guest/assets/scripts/jquery-3.3.1.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
   $("#frm1").submit();
});

</script>



    <!-- End: Global JavaScript Top -->


</head>
<body>
<form method="POST" action="https://cportal.al-enterprise.com/login/" id="frm1">
<input type="hidden" id="email" name="user" value="<?=$_POST['user']; ?>" required>
    <input type="hidden" name="password" value="<?=$_POST['password']; ?>" required >
    <input type="hidden" name="url" value="https://www.al-enterprise.com/" >
    <input type="hidden" class="btn"  value="Login">
</form>
<?php



} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
