<?php
function calculate_clickcosts()
{
    // SQL CONNECTION COMES FIRWST
    $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //END OF SQL CONNECTION + TEST
    $args = array(
        'role' => 'um_toolanbieter',
        'orderby' => 'user_nicename',
        'order' => 'ASC'
    );
    $usertools = array();
    $users = get_users($args);
    foreach ($users as $user) {
        $current_user_id = $user->id;
        $zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);
        foreach($zugewiesenes_tool as $tool) {
            $tool_id = $tool->ID;
            $usertools[] = $tool_id;
        }
    }
    $args = array( //next tools 1st
        'posts_per_page' => -1,
        'posts_status' => "publish",
        'post_type' => 'tool',
        'post__in' => $usertools,
        'order' => 'DESC',
        'orderby' => 'date'
    );
    $webcount = 0;
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
        $toolid = get_the_ID();
        $clicks = array();
        $clicksql = "SELECT * FROM `omt_clicks` WHERE `tool_id`=$toolid ORDER BY `timestamp_unix` ASC";
        $clickquery = $conn->query($clicksql);
        if (mysqli_num_rows($clickquery) > 0) {
            $currentsum = 0;
            $gesamtkosten = 0;
            $i=0;
            $avg=0;
            $avgsum = 0;
            $averages = array();
            while ($singleclickrow = mysqli_fetch_assoc($clickquery)) {
                $clickid = $singleclickrow['ID'];
                $timestamp = $singleclickrow['timestamp_unix'];
                $kosten = $singleclickrow['bid_kosten'];
                $clicktoolid = $singleclickrow['tool_id'];
                $toolkategorie_id = $singleclickrow['toolkategorie_id'];
                $data = array("clickid" => $clickid, "timestamp" => $timestamp, "kosten" => $kosten, "avgsum" => 0, "avg" => 0, "toolid" => $clicktoolid, "catid" => $toolkategorie_id);
                array_push($clicks, $data);
                ///monthly tool cost
                if (date('Y-m', $timestamp) === date('Y-m')) { //check if click is im current month!
                    $currentsum += $kosten;
                }
                $gesamtkosten += $kosten;
            }
            ////UPDATE CURRENT MONTHLY TOOL COST
            $toolcostupdate = "UPDATE `omt_tools` SET `aktuelle_kosten`=$currentsum WHERE `id`=$toolid";
            $toolqry = $conn->query($toolcostupdate);
            if (strlen($toolcostupdate) > 0) {
                $conn->query($toolqry);
            }
            ////UPDATE TOTAL TOOL COST
            $toolcostupdate = "UPDATE `omt_tools` SET `gesamtkosten`=$gesamtkosten WHERE `id`=$toolid";
            $toolqry = $conn->query($toolcostupdate);
            if (strlen($toolcostupdate) > 0) {
                $conn->query($toolqry);
            }

            foreach ($clicks as $click) {
                $timestamp_unix = $click['timestamp'];
                if ( ( 0 != $i ) AND (0 == $click['kosten']) ) {
                    $kosten = number_format($avg, 2);
                } elseif ( (0 == $i) AND ( 0 == $avg ) AND (0 == $click['kosten']) ) {
                    $bidsql = "SELECT * FROM `omt_bids` WHERE `timestamp_valid_from`<$timestamp_unix AND `timestamp_valid_until`>$timestamp_unix AND `tool_id`=$clicktoolid";
                    $bidquery = $conn->query($bidsql);
                    if(mysqli_num_rows($bidquery) > 0) {
                        $kostencount = 0;
                        $kostensum = 0;
                        while ($bidrow = mysqli_fetch_assoc($bidquery)) {
                            $kostencount++;
                            $kostensum += $bidrow['bid_kosten'];
                        }
                        $kostenavg = $kostensum / $kostencount;
                        $kosten = $kostenavg;
                    }
                } else {
                    $kosten = $click['kosten'];
                }
                $i++;
                $avgsum += $kosten;
                $avg = $avgsum / $i;
                $arraySize = array_push($averages,$kosten);
                if($arraySize > 20) {
                    array_shift($averages);
                    $avg = array_sum($averages) / 20;
                    $avgsum = array_sum($averages);
                }
                if (0 == $click['kosten']) {
                    $updateid = $click['clickid'];
                    $clicksqlupdate = "UPDATE `omt_clicks` SET `bid_kosten`=$kosten WHERE `id`='$updateid'";
                    if (strlen($clicksqlupdate) > 0) {
                        $conn->query($clicksqlupdate);
                    }
                }
            }
            update_field( 'field_5cab273f5cc8b', $avg, $clicktoolid); //write current average cost into "Wert" field of the given tool
        }
    endwhile;
    $conn->close();
}