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
    
            $clicksql = "SELECT * FROM `omt_clicks` WHERE `timestamp_unix`=$timestamp_unix";
            $clickquery = $conn->query($clicksql);
            if (mysqli_num_rows($clickquery) > 0) {
                while ($singleclickrow = mysqli_fetch_assoc($clickquery)) {
                    $bid_id = $singleclickrow['bid_id'];
                    $bid_kosten = $singleclickrow['bid_kosten'];
                }
            }
    
            //////HELPER FUNCTION FOR TRACKERLINK SQL MOVEMENTS
            $sql = "INSERT INTO omt_clicks (ID, tracking_link_id, time_clickmeter, timestamp_unix, bid_id, bid_kosten, tool_id, toolkategorie_id, os, ip, browser, country)
                VALUES ('$ID', '$tracking_link_id', '$time_clickmeter', '$timestamp_unix', '$bid_id', '$bid_kosten', '" . $trackingLink->tool_id . "', '" . $trackingLink->toolkategorie_id . "','$os', '$ip', '$browser', '$country')
                ON DUPLICATE KEY UPDATE tracking_link_id='$tracking_link_id', time_clickmeter='$time_clickmeter', timestamp_unix='$timestamp_unix', bid_id='$bid_id', bid_kosten='$bid_kosten', tool_id='" . $trackingLink->tool_id . "', toolkategorie_id='" . $trackingLink->toolkategorie_id . "', os='$os', ip='$ip', browser='$browser', country='$country'";
            
            $conn->query($sql);
        }
    }
}
