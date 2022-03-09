<?php

use OMT\Model\User;
use OMT\Services\Roles;

function vb_perform_bid() {
    /**
     * Default response
     */
    $response = [
        'status'  => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false
    ];
    /**
     * Setup query
     */
    $bid = $_POST['bid'];
    $bid_id = $_POST['bid_id'];
    $cat_id = $_POST['cat_id'];

    ob_start();
    if (is_numeric($bid) && $bid >= 2) {
        //////////SQL CONNECTION TO DATAHOST
        $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //////////SQL CONNECTION TO DATAHOST

        $date = new DateTime(null, new DateTimeZone('Europe/Amsterdam'));
        $time = $date->getTimestamp();

        $query = $conn->query("SELECT * FROM `omt_bids` WHERE `ID` = " . (int) $bid_id);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)) {
                $bidkosten = $row['bid_kosten'];
                $tool_id = $row['tool_id'];
                $is_active = $row['is_active'];
            }
        }

        $allowedToEdit = Roles::isAdministrator() ? true : false;

        if (!$allowedToEdit) {
            foreach (User::init()->tools(get_current_user_id()) as $tool) {
                if ($tool->ID == $tool_id) { 
                    $allowedToEdit = true;
                    break;
                }
            }
        }

        if ($bid != $bidkosten && $allowedToEdit && 1 == $is_active) {
            //SET OLD BID TO is_active=0 AND TIEMSTAMP OF BID ENDING
            $sqlupdateoldbid ="UPDATE omt_bids SET is_active = '0', timestamp_valid_until = '$time' WHERE ID = " . (int) $bid_id;
            if ($conn->query($sqlupdateoldbid) === TRUE) {
                //   echo "New BIDDING record created or updated successfully";
            } else {
                echo "Error: " . $sqlupdateoldbid . "<br>" . $conn->error;
                echo "Bitte mache einen Screenshot von der Seite und schicke den Fehler + Info (Eingaben und alles was Dir einfällt) an <a href='mailto:daniel.voelskow@reachx.de'>daniel.voelskow@reachx.de</a>";
            }

            //CREATE NEW BID WITH is_active=1 AND VALIDFROM = CURRENT TIMESTAMP
            $sqlbids = "INSERT INTO omt_bids (tool_id, toolkategorie_id, bid_kosten, timestamp_valid_from, timestamp_valid_until, is_active, user_id, user_ip)
                            VALUES ('$tool_id', '$cat_id', '$bid', '$time', '9999999999', '1', '" . get_current_user_id() . "', '" . $_SERVER['REMOTE_ADDR'] . "')";

            if ($conn->query($sqlbids) === TRUE) {
                // //=> NOW WE WRITE THE NEW BID AMOUNT INTO THE CORRESPONDING TOOL / TOOLCAT INFORMATION
                // //updating ACF COMPLETE SUB ROWS VIA CODE TESTING
                // $tool_kategorien = "field_5f4632583c143";
                // $kategorie = "field_5f4632583c144";
                // $kategorie_zur_website_link = "field_5f4633943c14b";
                // $kategorie_zur_website_clickmeter_link_id = "field_5f46339d3c14c";
                // $kategorie_preisubersicht_link = "field_5f46336e3c149";
                // $kategorie_preisubersicht_clickmeter_link_id = "field_5f4633833c14a";
                // $kategorie_tool_testen_link = "field_5f4633e03c14d";
                // $kategorie_tool_testen_clickmeter_link_id = "field_5f4634293c14e";
                // $gebotskey = "field_5f4633083c147";
                //     foreach ($vortrage as $vortrag) {
                //     $i++;
                //     $vortragsid = $vortrag['vortrag']->ID;
                //     $pos = strpos($votes, "$vortragsid");
                //     if ($pos != false) {
                //         $namedvotes .= "<p>" . get_the_title($vortragsid) . "</p>";
                //         $votecount = $vortrag['anzahl_stimmen'];
                //         $votecount++;
                //         update_sub_field(array($key_vortrage, $i, $key_vortragsstimmen), $votecount, $umfrageid);
                //     }
                // }
                // update_sub_field( array("repeater_field_key", $row+1, "repeater_sub_field_key"), $new_value, $post_id);
                // update_sub_field(array($tool_kategorien, 1, $gebotskey), "1121", 30719);
            } else {
                echo "Error: " . $sqlbids . "<br>" . $conn->error;
                echo "Bitte mache einen Screenshot von der Seite und schicke den Fehler + Info (Eingaben und alles was Dir einfällt) an <a href='mailto:daniel.voelskow@reachx.de'>daniel.voelskow@reachx.de</a>";
            }

            ///GET THE DATA FROM NEW BID TO RETRIEVE ITS BIDDING ID
            $newbid = "SELECT * FROM `omt_bids` WHERE `tool_id`=$tool_id AND `toolkategorie_id`=$cat_id AND `is_active`=1";
            $query = $conn->query($newbid);
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)) {
                    $rebid = $row['bid_kosten'];
                    $rebidid = $row['ID'];
                }
            }
            ////OUTPUT FOR THE AJAX REQUEST; WE REPLACE THE FORMER TD WITH A NEW CURRENT TD CONTAINING BIDDING ID OF THE MOST RECENT ACTIVE BID
            print '<td data-bidprice="' . $rebid . '" data-bid="' . $rebidid . '" data-cat="' . $cat_id . '">' . $rebid . ' € / Klick<span class="change-bid">(ändern)</span></td>';
        }

        $response['status'] = 200;
    } else {
        $response['message'] = 'Bitte geben Sie ein gültiges Gebot ein. Der Mindestwert beträgt 2€';
    }

    $response['content'] = ob_get_clean();
    die(json_encode($response));
}

add_action('wp_ajax_do_perform_bid', 'vb_perform_bid');
add_action('wp_ajax_nopriv_perform_bid', 'vb_perform_bid');