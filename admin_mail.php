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

?>
