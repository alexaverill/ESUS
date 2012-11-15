<?php
require('database.php');
    $link = mysql_connect($data_host, $data_username,$data_password)
		or die ("Could not connect to mysql because ".mysql_error());
	mysql_select_db($name_database)
		or die ("Could not select database because ".mysql_error());
$text = mysql_escape_string($_GET['text']);
$id = mysql_escape_string($_GET['id']);
$orig= mysql_escape_string($_GET['old']);
$id = $_POST['id'];
$value = $_POST['value'];
//echo $id;
/*if($id && $value)
{*/
$sql="UPDATE  `slots` SET  `time_slot` =  '$value' WHERE  `time_slot` ='$id'";
//echo $sql;
$get="SELECT * FROM `times` WHERE `time_id`='$id'";
//$get=mysql_query($get);
/*while ($event=mysql_fetch_array($get)){
	$got=$event['event'];
}*/
$run=mysql_query($sql)or die(mysql_error());
$changeall="UPDATE `times` SET `time_id`= '$value' WHERE `time_id`='$id'";
$go=mysql_query($changeall);
//}
echo $value;
?>