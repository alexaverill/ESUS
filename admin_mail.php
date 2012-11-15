<?php

include('header.php');
if(strlen($_SESSION['admin_name'])>3 && $allow_run==5){
  allowed();
}else{
  echo '<h1>You Are Not allowed here</h1>';
}
function allowed(){
    Echo '<p>This page allows you to send teams their event times via the email that you have for them</p>';

    echo '<h2>Send Teams Their Times</h2>';
    draw_teams_select();
    echo '<h2>Bulk Send Teams Their Times</h2>';
    echo '<form method="POST" action=""><input name="all_teams" type="submit" class="myButton" value="Send All Teams Times"/></form> ';
    echo '<h2>Announcements</h2>';
    echo '<p> Send an email announcement to all teams';
    echo '<form method="POST" action="">
    <textarea name="emessage" id="emess" height="100px" width="15%"></textarea><br/>
    <input name="send_ann" type="submit" class="myButton" value="Send Announcement"/></form>';
    echo '<h2>Send Mail to Team</h2>';
    draw_team_select_email();
    if($_POST['view_teams']){
      display_mail();
    }
    if($_POST['all_teams']){
      send_all_mail();
    }
    if($_POST['send_ann']){
      send_announcement();
    }
    if($_POST['teams_email']){
      send_mail_to();
    }
}
function send_mail_to(){
    $email=mysql_real_escape_string($_POST['email']);
      $email_message=$_POST['message'];
      $email_from = 'esus@sciolyeventsignup.com';
      $email_to=$email;
      $email_subject= "Event Sign Up System";
      $headers = 'From: '.$email_from."\r\n".
      'Reply-To: '.$email_from."\r\n" .
      'X-Mailer: PHP/' . phpversion();
      @mail($email_to, $email_subject, $email_message, $headers); 
      echo '<b>Email Sent to '.$row['name'].'</b><br/>';
    

  }
function draw_team_select_email(){                  //draws reset form for teams
  $sql = "SELECT * FROM `team` ORDER BY `name` ASC";
  $checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());
  echo '<form action="" method="POST">Team:<select name="email">';
  while($row= mysql_fetch_assoc($checker)) {
    echo '<option value="'.$row['email'].'">'.$row['name'].'</option>';
  }
  echo '</select><br/>
  <textarea name="message" id="emess" height="100px" width="15%"></textarea><br/>
  <input name="teams_email" type="submit" class="myButton" value="Send Mail"/>


  </form>';

}
function send_announcement(){
      $sql = "SELECT * FROM `team`";
    $checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());

    while($row= mysql_fetch_assoc($checker)) {  
      $email_message=$_POST['emessage'];
      $email_from = 'esus@sciolyeventsignup.com';
      $email_to=$row['email'];
      $email_subject= "Event Sign Up System";
      $headers = 'From: '.$email_from."\r\n".
      'Reply-To: '.$email_from."\r\n" .
      'X-Mailer: PHP/' . phpversion();
      @mail($email_to, $email_subject, $email_message, $headers); 
      echo '<b>Email Sent to '.$row['name'].'</b><br/>';
    }
}
function send_all_mail(){
$sql = "SELECT * FROM `team`";
$checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());

while($row= mysql_fetch_assoc($checker)) {  
    $id=$row['id'];
    $email_from = 'esus@sciolyeventsignup.com';
    $email_to=$row['email'];
        $query = "SELECT * FROM  `times`";
    $sqlnum = mysql_query($query) or die(mysql_error());
    $email_message = "You have the following events:\n\n";
    while ($row1 = mysql_fetch_array($sqlnum)) {
            if ($row1['team1'] == $id) {
                 $email_message .= $row1['event'] . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team2'] == $id) {
                 $email_message .= $row1['event'] . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team3'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team4'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team5'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team6'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team7'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team8'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team9'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team10'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            }
    }
  $email_message .= "\nThanks,\nEvent Sign Up System";
  $email_subject= "Event Sign Up System";
  $headers = 'From: '.$email_from."\r\n".
  'Reply-To: '.$email_from."\r\n" .
  'X-Mailer: PHP/' . phpversion();
  @mail($email_to, $email_subject, $email_message, $headers); 
  echo '<b>Email Sent to '.$row['name'].'</b><br/>';
}

  
}
function send_mail($id,$email){
    $email_to = $email;

    $email_from = 'esus@sciolyeventsignup.com';
    $email_subject = "Event Sign Up System.";
    $check_admin = "SELECT * FROM `members` WHERE rank = '1'";

     
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
     
    // validation expected data exists
    $email_message = "You have the following events:\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
    $query = "SELECT * FROM  `times`";
    $sqlnum = mysql_query($query) or die(mysql_error());

    while ($row1 = mysql_fetch_array($sqlnum)) {
     if ($row1['team1'] == $id) {
                 $email_message .= $row1['event'] . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team2'] == $id) {
                 $email_message .= $row1['event'] . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team3'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team4'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team5'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team6'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team7'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team8'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team9'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team10'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            }
          }
     $email_from= 'Event Sign Up System';
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers); 
echo 'Email Sent';
}

?>
