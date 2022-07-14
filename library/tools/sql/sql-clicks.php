<?php
//HELPFUL: https://www.any-api.com/clickmeter_com/clickmeter_com/docs/_datapoints_id_hits/GET

use OMT\Model\Datahost\TrackingLink;

function get_api_all_clicks() {
    //SQL CONNECTION COMES FIRWST
    $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //END OF SQL CONNECTION + TEST

    $model = TrackingLink::init();

    //get all clicks from the API- we only get UNIQUES to make sure botattacks cannot block our fetching limit of 100 with spam entries/hits
    $api_key = "64436DDF-D094-4E33-B2B1-9CD1E50EA4EB";
    $clicks = api_request('http://apiv2.clickmeter.com/hits?timeframe=last90&limit=100&filter=uniques', 'GET', NULL, $api_key);

    foreach($clicks['hits'] as $click) {
        //KLICKZEITEN UNBEINGT NOCHMAL PRÜFEN MIT UTC OFFSET!! (sollte stimmen..)
        $cdate=date_create_from_format("YmjHis",$click['accessTime'], new DateTimeZone('Europe/Amsterdam'));
        $clicktimestamp = $cdate->getTimestamp() . "<br>";
        $ID = $click['id'];
        $tracking_link_id = $click['entity']['datapointId'];
        $time_clickmeter = $click['accessTime'];
        $timestamp_unix = intval($clicktimestamp);
        $os = $click['os']['name'];
        $ip = $click['ip'];
        $browser = $click['browser']['name'];
        $country = $click['location']['country'];

        // Get tool_id and toolkategorie_id from trackerlink connected to this click
        $trackingLink = $model->item(['id' => $tracking_link_id]);

        if ($trackingLink) {
            //get bid ID from clicks timestamp range + tool/toolkat id:
            $bidsql = "SELECT * FROM `omt_bids` WHERE `timestamp_valid_from`<$timestamp_unix AND `timestamp_valid_until`>$timestamp_unix AND `tool_id`=" . $trackingLink->tool_id . " AND `toolkategorie_id`=" . $trackingLink->toolkategorie_id;
            $bidquery = $conn->query($bidsql);
            if(mysqli_num_rows($bidquery) > 0) {
                while ($bidrow = mysqli_fetch_assoc($bidquery)) {
                    $bid_id = $bidrow['ID'];
                    $bid_kosten = $bidrow['bid_kosten'];
                }
            } else {
                $bid_id = 0;
                $bid_kosten = 0;
            }
    
/*            $clicksql = "SELECT * FROM `omt_clicks` WHERE `timestamp_unix`=$timestamp_unix";
            $clickquery = $conn->query($clicksql);
            if (mysqli_num_rows($clickquery) > 0) {
                while ($singleclickrow = mysqli_fetch_assoc($clickquery)) {
                    $bid_id = $singleclickrow['bid_id'];
                    $bid_kosten = $singleclickrow['bid_kosten'];
                }
            }
*/
            ///zweithöchste gebot system:
            //get all the next highest or equal high bid compared to our current click, from the same tool category:
            $getbidssql = "SELECT * FROM `omt_bids` WHERE `timestamp_valid_from`<$timestamp_unix AND `timestamp_valid_until`>$timestamp_unix AND `toolkategorie_id`=" . $trackingLink->toolkategorie_id . " AND `tool_id` != " . $trackingLink->tool_id . " AND `bid_kosten` <= " . $bid_kosten . " ORDER BY `bid_kosten` DESC LIMIT 1";
            $allbidsquery = $conn->query($getbidssql); //check query if we have found any
            //testing: https://www.omt.de/json-test/
            print "<hr style='width:100%;display:block;'>";
            print "<p style='width:100%;display:block;'>allbidquery:</p>";
            print "<p style='width:100%;display:block;'>Toolkategorie: " . $trackingLink->toolkategorie_id . "</p>";
            print "<p style='width:100%;display:block;'>timestamp Click: " . $timestamp_unix . "</p>";
            print "<p style='width:100%;display:block;'>timestamp xovibidstart: 1657557338</p>";
            print "<p style='width:100%;display:block;'>timestamp xovibidend: 9999999999</p>";
            print "<p style='width:100%;display:block;'>current click costs: " . $bid_kosten . "</p>";
            print "<hr style='width:100%;display:block;'>";

            if (mysqli_num_rows($allbidsquery) > 0) {
                while ($allbidsrow = mysqli_fetch_assoc($allbidsquery)) {
                    print "<hr style='width:100%;display:block;'>";

                    $bid_kosten_next = $allbidsrow['bid_kosten']; //next highest
                    print "<p style='width:100%;display:block;'>bid_kosten_next: " . $bid_kosten_next . "</p>";
                    $bid_kosten_diff = $bid_kosten - $bid_kosten_next; //difference between current click bidding and next highest (or equally high) bid
                    print "<p style='width:100%;display:block;'>bid_kosten_diff: " . $bid_kosten_diff . "</p>";
                    if ($bid_kosten_diff > 0.5) { //if difference is greater than 0.5 (else no action necessary as its either equal or already 0.5 higher)
                        $bid_kosten_new = $bid_kosten_next + 0.5; // set current click cost to next lowest bid cost plus 0.5 (biddings operate in 0.5 steps)
                        print "<p style='width:100%;display:block;'>diff is bigger than 0.5, new bid_kost = next highest+0.5: " . $bid_kosten_new . "</p>";
                    } //(else no action necessary as current click bid cost is either equal or already only 0.5 higher compared to next highest bid)
                }
            } else {
                $bid_kosten_new = 2;
                print "<p style='width:100%;display:block;'>No alternative bid, setting bid cost to 2:" . $bid_kosten_new . "</p>";
            } // if there is no concurrenting bid in the category, the user only pays the minimum cost of 2€ no matter how high his max bid is!
            print "<hr style='width:100%;display:block;'>";
            ///END OF zweithöchste gebot system:

    
            //////HELPER FUNCTION FOR TRACKERLINK SQL MOVEMENTS
            $sql = "INSERT INTO omt_clicks (ID, tracking_link_id, time_clickmeter, timestamp_unix, bid_id, bid_kosten, tool_id, toolkategorie_id, os, ip, browser, country)
                VALUES ('$ID', '$tracking_link_id', '$time_clickmeter', '$timestamp_unix', '$bid_id', '$bid_kosten', '" . $trackingLink->tool_id . "', '" . $trackingLink->toolkategorie_id . "','$os', '$ip', '$browser', '$country')
                ON DUPLICATE KEY UPDATE tracking_link_id='$tracking_link_id', time_clickmeter='$time_clickmeter', timestamp_unix='$timestamp_unix', bid_id='$bid_id', bid_kosten='$bid_kosten', tool_id='" . $trackingLink->tool_id . "', toolkategorie_id='" . $trackingLink->toolkategorie_id . "', os='$os', ip='$ip', browser='$browser', country='$country'";
            
            $conn->query($sql);
        }
    }
}
