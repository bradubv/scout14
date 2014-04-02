<!--
(c) cntsoftware.com
-->
<?php
// savestats.php

require_once 'infodb.php';
$db_server = mysql_connect($db_hostname, $db_username
        , $db_password);

if (!$db_server)
    die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database) or
        die("Unable to select database: " . mysql_error());

(isset($_POST['match_id']) && isset($_POST['team_id'])) or
        die("Primary key missing.  Cannot save these stats");

$match_id = SanitizeString($_POST['match_id']);
$team_id = SanitizeString($_POST['team_id']);
$auto_move = SanitizeString($_POST['auto_move']);
$auto_high = SanitizeString($_POST['auto_high']);
$auto_low = SanitizeString($_POST['auto_low']);
$pass_start = SanitizeString($_POST['pass_start']);
$pass_end = SanitizeString($_POST['pass_end']);
$truss = SanitizeString($_POST['truss']);
$defense = SanitizeString($_POST['defense']);
$penalty = SanitizeString($_POST['penalty']);
$low_goal = SanitizeString($_POST['low_goal']);
$high_goal = SanitizeString($_POST['high_goal']);

$query = "INSERT stat (match_id, team_id, pass_start, pass_end, truss"
        . ", low_goal, high_goal, defense) "
        . "VALUES ($match_id, $team_id, $pass_start, $pass_end, $truss "
        . ", $low_goal, $high_goal, $defense )";

$result = mysql_query($query);

if (!$result)
    die("Database access failed: " . mysql_error());

function SanitizeString($var) {
    if (empty($var)) {
        $var = 'NULL';
    } else {
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);
    }
    return $var;
}
?>