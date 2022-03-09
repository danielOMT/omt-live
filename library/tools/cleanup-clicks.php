<?php
function cleanup_clicks_by_bots()
{
    //SQL CONNECTION COMES FIRWST
    $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //END OF SQL CONNECTION + TEST

    $t = time();
    $t90d = $t - 7776000; //take only clicks from last 3 months into consideration because of performance
    $clicksql = "SELECT * FROM `omt_clicks` WHERE `timestamp_unix`>$t90d ORDER BY `timestamp_unix` ASC";
    $clickquery = $conn->query($clicksql);
    if (mysqli_num_rows($clickquery) > 0) {
        $allclicks = array();
        while ($clickrow = mysqli_fetch_assoc($clickquery)) {
            $arr_data = array(
                "id" => $clickrow['id'],
                "timestamp" => $clickrow['timestamp_unix'],
                "ip" => $clickrow['ip'],
                "tool_id" => $clickrow['tool_id'],
                "toolkategorie_id" => $clickrow['toolkategorie_id'],
            );
            array_push($allclicks, $arr_data);
        }
        $duplicates = $allclicks;
        $taken = array();
        foreach ($allclicks as $key => $item) {
            if (!in_array($item['ip'], $taken)) {
                $taken[] = $item['ip'];
            } else {
                unset($allclicks[$key]);
                $ip = $item['ip'];
            }
        }
        foreach ($allclicks as $key => $item) {
            unset($duplicates[$key]);
        }

        $processed = array();
        $removeips = array(); //this will be the array of IPs to be removed from our list because of flag to click ratio
        foreach ($duplicates as $key => $dupitem) {
            if (!in_array($dupitem['ip'], $processed)) {
                $processed[] = $dupitem['ip'];
                $ip = $dupitem['ip'];
                $iparray = array();
                foreach ($duplicates as $subkey => $subitem) { //collect all Clicks from a given IP in one Array so we can sort and analyse this IP
                    if ($subitem['ip'] == $ip) {
                        array_push($iparray, $subitem);
                    }
                }
                usort($iparray, 'sort_by_timestamp'); //***sorting the /**
                $flags = 0; //setting flags to 0
                $timestamp = 0;
                $lasttimestamp = 0;
                foreach ($iparray as $clickkey => $click) {
                    if (0 != $clickkey) {
                        $diff = $click['timestamp'] - $iparray[$clickkey - 1]['timestamp'];
                        if ($diff <= 86400) { //if time between clicks is less than 24hrs
                            if ($diff <= 1) { //any global click time below or equal to 1 second creates one flag
                                $flags++;
                                $timestamp = $click['timestamp'];
                            }
                            if ($diff < 1) { //any global click time BELOW 1 second creates one extra flag
                                $flags++;
                            }
                            if ($diff <= 1 AND $click['toolkategorie_id'] != $iparray[$clickkey - 1]['toolkategorie_id']) {
                                //if it manages to create a click between 2 categories within 1 second, we create ANOTHER flag, because this is very botvious
                                $flags++;
                            }
                        } else {  //if diff is more than a day stop the foreach cycle so only the current timearea is being selected for the ip ban
                            $lasttimestamp = $timestamp;
                            break;
                        }
                    }
                }
                if (is_array($iparray)) {
                    if (count($iparray) >= 1) {
                        $flagstoclicks = $flags / count($iparray);
                    }
                    if ((count($iparray > 10) AND $flagstoclicks >= 0.9)) {
                        //   print $timestamp . " | ";
                        $banend = $timestamp + 86400;
                        $banstart = $timestamp - 86400;
//                    $ip = str_replace(".", "", $ip);
//                    $ip = str_replace("%", "", $ip);
                        //  print $ip;
                        $bansql = "SELECT * FROM `omt_banlist` WHERE `ip`='$ip'";
                        $banquery = $conn->query($bansql);
                        if (mysqli_num_rows($banquery) > 0) {
//                        while ($banitem = mysqli_fetch_assoc($banquery)) {
//                            print_r($banitem);
//                        }
                        } else { //if this ip in given timeframe is not banned already, make it so
                            $sql = "INSERT INTO omt_banlist (ip, ban_start, ban_end)
            VALUES ('$ip', '$banstart', '$banend')";
                            if ($conn->query($sql) === TRUE) {
                                //  print "banitem added";
                            }
                        }
                    } else {
                        unset($duplicates[$key]);
                    }
                }
            }
        }
    }

    //////////select and delete all clicks from omt_clicks database that are a fit to omt_banlist clicks!
    $bansql2 = "SELECT * FROM `omt_banlist` WHERE `ban_start`>$t90d ORDER BY `ban_start` ASC";
    $banquery2 = $conn->query($bansql2);
    if (mysqli_num_rows($banquery2) > 0) {
        $delcount = 0;
        while ($ban = mysqli_fetch_assoc($banquery2)) {
            $ip = $ban['ip'];
            $banstart = $ban['ban_start'];
            $banend = $ban['ban_end'];
            $delsql = "DELETE FROM `omt_clicks` WHERE `timestamp_unix`>$banstart AND `timestamp_unix`<$banend AND `ip`='$ip'";
            if ($conn->query($delsql) === TRUE) {
                $delcount++;
           //     echo "#" . $delcount . " click deleted for ip " . $ip;
            } else {
                echo "Error: " . $delsql . "<br>" . $conn->error;
            }
        }
    }

    /////restart the duplicates array to fetch users clicking on same category (we got up to 3 links there!) and make sure only 1 will be counted!
    $t = time();
    $t90d = $t - 7776000; //take only clicks from last 3 months into consideration because of performance
    $clicksql = "SELECT * FROM `omt_clicks` WHERE `timestamp_unix`>$t90d ORDER BY `timestamp_unix` ASC";
    $clickquery = $conn->query($clicksql);
    if (mysqli_num_rows($clickquery) > 0) {
        $allclicks = array();
        while ($clickrow = mysqli_fetch_assoc($clickquery)) {
            $arr_data = array(
                "clickid" => $clickrow['ID'],
                "id" => $clickrow['id'],
                "timestamp" => $clickrow['timestamp_unix'],
                "ip" => $clickrow['ip'],
                "tool_id" => $clickrow['tool_id'],
                "toolkategorie_id" => $clickrow['toolkategorie_id'],
            );
            array_push($allclicks, $arr_data);
        }
        $duplicates = $allclicks;
        $taken2 = array();
        $doubles = array();
        foreach ($allclicks as $key => $item) {
            $iptoolcat = $item['ip'] . $item['tool_id'] . $item['toolkategorie_id'];
            if (!in_array($iptoolcat, $taken2)) {
                $taken2[] = $iptoolcat;
            } else {
                unset($allclicks[$key]);
                foreach ($allclicks as $key2 => $item2) {
                    if ( ( $item2['ip'] == $item['ip'] ) AND ($item2['tool_id'] == $item['tool_id']) AND $item['toolkategorie_id']) {
                        unset ($allclicks[$key]);
                    }
                }
                    $ip = $item['ip'];
            }
        }

        foreach ($allclicks as $key => $item) {
            unset($duplicates[$key]);
        }

        usort($duplicates, 'sort_by_timestamp'); //***sorting the /**
        $processeddupes = array(); //we are going to collect all processed IPs in this array to make sure it wont get doubletaken = completely deleted!
        foreach ($duplicates as $key => $dupitem) {
            $iptoolcat = $dupitem['ip'] . $dupitem['tool_id'] . $dupitem['toolkategorie_id'];
            if (!in_array($iptoolcat, $processeddupes)) {
                array_push($processeddupes, $iptoolcat); //codiert mit ip, toolid, toolkategorieid
                $toolid = $dupitem['tool_id'];
                $toolcat = $dupitem['toolkategorie_id'];
                $timestamp = $dupitem['timestamp'];
                $clickid = $dupitem['clickid'];
                $timestamp12less = $timestamp - 43200;
                $timestamp12plus = $timestamp + 43200;
                $dupip = $dupitem['ip'];
/*                ?><!--<p style="padding:30px;background: blue; color: white;">--><?php //print $dupip . " | " . $timestamp . " | " . $dupitem['tool_id'] . " | " . $dupitem['toolkategorie_id'];;?><!--</p>--><?php
//                $dupesql = "SELECT * FROM `omt_clicks` WHERE `ip`='$dupip' AND `tool_id`='$toolid' AND `toolkategorie_id`='$toolcat' AND `timestamp_unix`>$timestamp12less AND `timestamp_unix`<$timestamp12plus AND `ID`!='$clickid' ORDER BY `timestamp_unix` ASC";
//                $dupquery = $conn->query($dupesql);
//                if (mysqli_num_rows($dupquery) > 0) {
//                    while ($dupe = mysqli_fetch_assoc($dupquery)) {
//                        print "<hr>" . $dupe['ip'] . " | " . $dupe['timestamp_unix'] . " | " . $dupe['tool_id'] . " | " . $dupe['toolkategorie_id'];
//                    }
//                }*/
                $dupedelsql = "DELETE FROM `omt_clicks` WHERE `ip`='$dupip' AND `tool_id`='$toolid' AND `toolkategorie_id`='$toolcat' AND `timestamp_unix`>$timestamp12less AND `timestamp_unix`<$timestamp12plus AND `ID`!='$clickid'";
                if ($conn->query($dupedelsql) === TRUE) {
             //       echo " click deleted for ip " . $dupip;
                } else {
                    echo "Error: " . $dupedelsql . "<br>" . $conn->error;
                }
            }
        }
    }
}
