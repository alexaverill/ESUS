<?php

include('header.php');

function list_my_events() {
    echo '<h1>Your Event Times</h1>';
    $op = '<h3>';
    $cl = '</h3>';
    $name = $_SESSION['name'];
    $getid = mysql_query("SELECT * FROM `team` WHERE `username` = '$name'") or die(mysql_error());
    while ($getname = mysql_fetch_array($getid)) {
        $id = $getname['id'];
    }
    $query = "SELECT * FROM  `times` ORDER BY `event` ASC";
    $sqlnum = mysql_query($query) or die(mysql_error());
$en= "SELECT * FROM  `enable`";
$enable = mysql_query($en)or die("Could not insert data because ".mysql_error());
while($ren= mysql_fetch_assoc($enable)) {
    if ($ren['enabled']==1){
        $safe=true;
    }
}
    while ($row1 = mysql_fetch_array($sqlnum)) {
        if ($time_left >= 5 || $safe==true) {
           $clear1 = '<form method="POST" action=""><input type="hidden" value="team1" name="slot"/><input type="hidden" value="' . $row1['time_id'] . '" name="time"/><input type="hidden" value="' . $row1['event'] . '" name="event"/><input type="hidden" value="' . $id . '" name="id"/><input class="myButton" type="submit" name="drop" value="Drop This Slot"/></form>';
            $clear2 = '<form method="POST" action=""><input type="hidden" value="team2" name="slot"/><input type="hidden" value="' . $row1['time_id'] . '" name="time"/><input type="hidden" value="' . $row1['event'] . '" name="event"/><input type="hidden" value="' . $id . '" name="id"/><input class="myButton" type="submit" name="drop" value="Drop This Slot"/></form>';
            $clear3 = '<form method="POST" action=""><input type="hidden" value="team3" name="slot"/><input type="hidden" value="' . $row1['time_id'] . '" name="time"/><input type="hidden" value="' . $row1['event'] . '" name="event"/><input type="hidden" value="' . $id . '" name="id"/><input class="myButton" type="submit" name="drop" value="Drop This Slot"/></form>';
            $clear4 = '<form method="POST" action=""><input type="hidden" value="team4" name="slot"/><input type="hidden" value="' . $row1['time_id'] . '" name="time"/><input type="hidden" value="' . $row1['event'] . '" name="event"/><input type="hidden" value="' . $id . '" name="id"/><input class="myButton" type="submit" name="drop" value="Drop This Slot"/></form>';
            $clear5 = '<form method="POST" action=""><input type="hidden" value="team5" name="slot"/><input type="hidden" value="' . $row1['time_id'] . '" name="time"/><input type="hidden" value="' . $row1['event'] . '" name="event"/><input type="hidden" value="' . $id . '" name="id"/><input class="myButton" type="submit" name="drop" value="Drop This Slot"/></form>';
            $clear6 = '<form method="POST" action=""><input type="hidden" value="team6" name="slot"/><input type="hidden" value="' . $row1['time_id'] . '" name="time"/><input type="hidden" value="' . $row1['event'] . '" name="event"/><input type="hidden" value="' . $id . '" name="id"/><input class="myButton" type="submit" name="drop" value="Drop This Slot"/></form>';
            $clear7 = '<form method="POST" action=""><input type="hidden" value="team7" name="slot"/><input type="hidden" value="' . $row1['time_id'] . '" name="time"/><input type="hidden" value="' . $row1['event'] . '" name="event"/><input type="hidden" value="' . $id . '" name="id"/><input class="myButton" type="submit" name="drop" value="Drop This Slot"/></form>';
            $clear8 = '<form method="POST" action=""><input type="hidden" value="team8" name="slot"/><input type="hidden" value="' . $row1['time_id'] . '" name="time"/><input type="hidden" value="' . $row1['event'] . '" name="event"/><input type="hidden" value="' . $id . '" name="id"/><input class="myButton" type="submit" name="drop" value="Drop This Slot"/></form>';
            $clear9 = '<form method="POST" action=""><input type="hidden" value="team9" name="slot"/><input type="hidden" value="' . $row1['time_id'] . '" name="time"/><input type="hidden" value="' . $row1['event'] . '" name="event"/><input type="hidden" value="' . $id . '" name="id"/><input class="myButton" type="submit" name="drop" value="Drop This Slot"/></form>';
            $clear10 = '<form method="POST" action=""><input type="hidden" value="team10" name="slot"/><input type="hidden" value=' . $row1['time_id'] . '" name="time"/><input type="hidden" value="' . $row1['event'] . '" name="event"/><input type="hidden" value="' . $id . '" name="id"/><input class="myButton" type="submit" name="drop" value="Drop This Slot"/></form>';

            if ($row1['team1'] == $id) {
                echo $op . $row1['event'] .' at '. $row1['time_id'] . $cl . $clear1 . '<br/>';
            } else if ($row1['team2'] == $id) {
                echo $op . $row1['event'] . ' at ' . $row1['time_id'] . $cl . $clear2 . '<br/>';
            } else if ($row1['team3'] == $id) {
                echo $op . $row1['event'] . ' at ' . $row1['time_id'] . $cl . $clear3 . '<br/>';
            } else if ($row1['team4'] == $id) {
                echo $op . $row1['event'] .' at '  . $row1['time_id'] . $cl . $clear4 . '<br/>';
            } else if ($row1['team5'] == $id) {
                echo $op . $row1['event'] .' at ' . $row1['time_id'] . $cl . $clear5 . '<br/>';
            } else if ($row1['team6'] == $id) {
                echo $op . $row1['event'] . ' at ' . $row1['time_id'] . $cl . $clear6 . '<br/>';
            } else if ($row1['team7'] == $id) {
                echo $op . $row1['event'] .  ' at '  . $row1['time_id'] . $cl . $clear7 . '<br/>';
            } else if ($row1['team8'] == $id) {
                echo $op . $row1['event'] . ' at ' . $row1['time_id'] . $cl . $clear8 . '<br/>';
            } else if ($row1['team9'] == $id) {
                echo $op . $row1['event'] .  ' at ' . $row1['time_id'] . $cl . $clear9 . '<br/>';
            } else if ($row1['team10'] == $id) {
                echo $op . $row1['event'] . ' at ' . $row1['time_id'] . $cl . $clear10 . '<br/>';
            }
        } else {
            if ($row1['team1'] == $id) {
                echo $op . $row1['event'] . ' at ' . $row1['time_id'] . $cl  . '<br/>';
            } else if ($row1['team2'] == $id) {
                echo $op . $row1['event']  . ' at '  . $row1['time_id'] . $cl . '<br/>';
            } else if ($row1['team3'] == $id) {
                echo $op . $row1['event']  . ' at ' .  $row1['time_id'] . $cl  . '<br/>';
            } else if ($row1['team4'] == $id) {
                echo $op . $row1['event']  . ' at ' .  $row1['time_id'] . $cl  . '<br/>';
            } else if ($row1['team5'] == $id) {
                echo $op . $row1['event'] . ' at ' .  $row1['time_id'] . $cl . '<br/>';
            } else if ($row1['team6'] == $id) {
                echo $op . $row1['event']  . ' at ' .  $row1['time_id'] . $cl . '<br/>';
            } else if ($row1['team7'] == $id) {
                echo $op . $row1['event']  . ' at ' .  $row1['time_id'] . $cl  . '<br/>';
            } else if ($row1['team8'] == $id) {
                echo $op . $row1['event']  . ' at ' .  $row1['time_id'] . $cl  . '<br/>';
            } else if ($row1['team9'] == $id) {
                echo $op . $row1['event']  . ' at ' . $row1['time_id'] . $cl  . '<br/>';
            } else if ($row1['team10'] == $id) {
                echo $op . $row1['event']  . ' at ' .  $row1['time_id'] . $cl  . '<br/>';
            }
        }
    }
}

if ($_POST['drop']) {
    drop();
} else {
    list_my_events();
}

function drop() {
    $slot = $_POST['slot'];
    $time = $_POST['time'];
    $idf = $_POST['id'];
    $event = $_POST['event'];
    $name = mysql_real_escape_string($_SESSION['name']);
    $getid = mysql_query("SELECT * FROM `team` WHERE `username` = '$name'") or die(mysql_error());
    $tblcl = "</td>";
    while ($getname = mysql_fetch_array($getid)) {
        $id = $getname['id'];
    }
    $check = "SELECT * FROM `times` WHERE `time_id` = '$time' AND `event` = '$event'";
    $checking = mysql_query($check);
    while ($get = mysql_fetch_array($checking)) {

        //echo '<br/>'.$id;
        if ($get[$slot] == $id) {
            $change = 1;

            //$id= $getname['id'];
        } else {
            $change = 0;
        }
    }
    if ($change == 1) {
        $sql = "UPDATE `times` SET `$slot`='0' WHERE `time_id` = '$time' AND `event` = '$event' LIMIT 1";
        $num = mysql_query($sql) or die(mysql_error());
        list_my_events();
        echo '<h3>Time Dropped</h3>';
    } else {
        echo 'Something went wrong, please try again';
    }
}

include('footer.php');
?>
