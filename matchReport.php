<!DOCTYPE html>
<!--
See license.txt
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>FRC 2014 scouting</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="lib/css/bootstrap.min.css" />
        <link rel="stylesheet" href="lib/css/main.css" />
        <style>
            #side {
                float:left;
                width: 33%;
            }
            #center {
                float:left;
                width: 34%;
            }
            button {
                float:left;
                width: 95%;
                height: 65px;
            }
        </style>

    </head>
    <body>
        <div id="container">

            <?php
            require_once 'infodb.php';

            $match_id = 1; //TODO: should get this from the parameter passed in
            $db_server = mysql_connect($db_hostname, $db_username
                    , $db_password);

            if (!$db_server)
                die("Unable to connect to MySQL: " . mysql_error());

            mysql_select_db($db_database) or
                    die("Unable to select database: " . mysql_error());

            $query = "SELECT red1, blue1 FROM match_ WHERE match_id = $match_id";
            $result = mysql_query($query);

            if (!$result)
                die("Database access failed: " . mysql_error());

            $rows = mysql_num_rows($result);
            
            $red1 = mysql_result($result, 0, 'red_team1');
            $blue1 = mysql_result($result, 0, 'blue_team1');

            for ($j = 0; $j < $rows; ++$j) {
                echo 'id: ' . mysql_result($result, $j, 'id') . '<br />';
                echo 'name: ' . mysql_result($result, $j, 'name') . '<br />';
                echo 'nick: ' . mysql_result($result, $j, 'nick') . '<br />';
                echo 'school: ' . mysql_result($result, $j, 'school') . '<br />';
                echo 'link: ' . mysql_result($result, $j, 'link') . '<br /><br />';
            }
            ?>
            <div id="side">
                <input id="match_id" type="number" class="form-control" placeholder="Match #">
                <input id="team_id" type="number" class="form-control" placeholder="Team #">
            </div>
            <div id="center">
                <button id="red1_btn" onclick="followTeam('<?php echo $red1;?>')"><?php echo $red1;?></button>
            </div>
            <div id="side">
                <button id="blue1_btn" onclick="followTeam('<?php echo $blue1;?>')"><?php echo $blue1;?></button>
            </div>

        </div> <!-- container -->
    </body>
</html>
