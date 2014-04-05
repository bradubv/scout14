<html>
    <head>
        <title>Match Report</title>
    </head>
    <?php
    /*
     * Copyright (C) 2014 Bogdan
     *
     * This program is free software; you can redistribute it and/or
     * modify it under the terms of the GNU General Public License
     * as published by the Free Software Foundation; either version 2
     * of the License, or (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     * GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License
     * along with this program; if not, write to the Free Software
     * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
     */

    require_once 'simple_html_dom.php';
    require_once 'infodb.php';

    // Create DOM from URL or file
    $html = file_get_html('http://www2.usfirst.org/2014comp/events/NYLI/ScheduleQual.html');
//$html = file_get_html('http://www2.usfirst.org/2014comp/events/NYNY/ScheduleQual.html');
//$html = file_get_html('http://www2.usfirst.org/2014comp/events/FLOR/ScheduleQual.html');
// Find all tables 
    foreach ($html->find('table') as $table) {
//       echo $table->style . '<br>';
        if (preg_match('/.7pt/', $table->style) === 1) {
            $table_html = str_get_html($table->innertext);
            $cells = $table_html->find('td');
            if (preg_match('/chedule/', $cells[0]->plaintext) === 1) {
                //This is the table we're interested in.
                $db_server = mysql_connect($db_hostname, $db_username
                        , $db_password);

                if (!$db_server)
                    die("Unable to connect to MySQL: " . mysql_error());

                mysql_select_db($db_database) or
                        die("Unable to select database: " . mysql_error());


                foreach ($table_html->find('tr') as $row) {
                    if (isset($row->style)) {
                        echo $row->plaintext . '<BR>';
                        $row_cells = str_get_html($row->innertext)->find('td');
                        save_match($row_cells[1]->plaintext, $row_cells[2]->plaintext, $row_cells[3]->plaintext
                                , $row_cells[4]->plaintext, $row_cells[5]->plaintext, $row_cells[6]->plaintext
                                , $row_cells[7]->plaintext);
                    }
                }
            } else {
                echo 'Table did not match the .7pt style we are looking for <br>';
            }
        }
    }

    function save_match($match_id
    , $red_team1, $red_team2, $red_team3
    , $blue_team1, $blue_team2, $blue_team3
    ) {
        $query = "INSERT match_ (id, red_team1, red_team2, red_team3"
                . ", blue_team1, blue_team2, blue_team3) "
                . "VALUES ($match_id, $red_team1, $red_team2, $red_team3"
                . ", $blue_team1, $blue_team2, $blue_team3)";
 
        echo $query . '<br>';

        $result = mysql_query($query);
        if (!$result)
            die("Database access failed: " . mysql_error());
    }
    ?>
</html>