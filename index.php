<!DOCTYPE html>
<!--
cntsoftware.com
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>FRC 2014 scouting</title>
    </head>
    <body>
        <?php
        require_once 'infodb.php';
        $db_server = mysql_connect($db_hostname, $db_username
                , $db_password);

        if (!$db_server)
            die("Unable to connect to MySQL: " . mysql_error());


        mysql_select_db($db_database) or
                die("Unable to select database: " . mysql_error());

        $query = "SELECT * FROM team";
        $result = mysql_query($query);

        if (!$result)
            die("Database access failed: " . mysql_error());

        $rows = mysql_num_rows($result);

        for ($j = 0; $j < $rows; ++$j) {
            echo 'id: ' . mysql_result($result, $j, 'id') . '<br />';
            echo 'name: ' . mysql_result($result, $j, 'name') . '<br />';
            echo 'nick: ' . mysql_result($result, $j, 'nick') . '<br />';
            echo 'school: ' . mysql_result($result, $j, 'school') . '<br />';
            echo 'link: ' . mysql_result($result, $j, 'link') . '<br /><br />';
        }
        echo "Hello World";
        ?>
    </body>
</html>
