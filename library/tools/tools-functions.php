<?php

use OMT\Model\User;

function update_tool_bids(int $tool_id = 0, int $catid = 0, float $gebot = 0)
{
    $tool_kategorien_content = get_field('tool_kategorien', $tool_id);
    $i = 0;
    foreach ($tool_kategorien_content as $category) {
        $i++;
        if ($catid == $category['kategorie']) {
            $kategorierow = $i;
        }
    }

//=> NOW WE WRITE THE NEW BID AMOUNT INTO THE CORRESPONDING TOOL / TOOLCAT INFORMATION
//updating ACF COMPLETE SUB ROWS VIA CODE TESTING
    $tool_kategorien_key = "field_5f4632583c143";
    $gebotskey = "field_5f4633083c147";
    $kategorie = "field_5f4632583c144";
//$kategorie_zur_website_link = "field_5f4633943c14b";
//$kategorie_zur_website_clickmeter_link_id = "field_5f46339d3c14c";
//$kategorie_preisubersicht_link = "field_5f46336e3c149";
//$kategorie_preisubersicht_clickmeter_link_id = "field_5f4633833c14a";
//$kategorie_tool_testen_link = "field_5f4633e03c14d";
//$kategorie_tool_testen_clickmeter_link_id = "field_5f4634293c14e";
///                     foreach ($vortrage as $vortrag) {
//                        $i++;
//                        $vortragsid = $vortrag['vortrag']->ID;
//                        $pos = strpos($votes, "$vortragsid");
//                        if ($pos != false) {
//                            $namedvotes .= "<p>" . get_the_title($vortragsid) . "</p>";
//                            $votecount = $vortrag['anzahl_stimmen'];
//                            $votecount++;
//                            update_sub_field(array($key_vortrage, $i, $key_vortragsstimmen), $votecount, $umfrageid);
//                        }
//                    }
//update_sub_field( array("repeater_field_key", $row+1, "repeater_sub_field_key"), $new_value, $post_id);
    if ($kategorierow > 0) {
        update_sub_field(array($tool_kategorien_key, $kategorierow, $gebotskey), $gebot, $tool_id);
    }

///ADDITIONALLY, NEED TO UPDATE THE TOOLS ROW FROM MAXX MARKETING TABLE IF WE WANT TO USE THEIR OUTPUT!!!
///  IN THEIR SYSTEM, BIDS ARE BEING STORED IN THE TABLE "ef2sv_tool_category" USING THE COLUMN "WORTH", WHICH NEEDS TO GET THE VALUE OF THE CURRENT BID AS WELL THEN!
    $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        "connection established!";
    }

//set up and run query:
    $update_ef2sv_tool_category_worth = "UPDATE `ef2sv_tool_category` SET `worth` = " . $gebot . " WHERE `tool_id` = " . $tool_id . " AND `category_id` = " . $catid;
    if ($conn->query($update_ef2sv_tool_category_worth) === false) {
        echo "Error: " . $conn->error;
    } else { //echo "success!"; }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }
}

////////FUNCTION TO LOOP THROUGH ALL USERS WITH ROLE "TOOLANBIETER", CHECK THEIR BUDGETS VS. THEIR TOOLCOST AND ACT ACCORDINGLY
function compare_budgets_costs() {
    //SQL CONNECTION COMES FIRWST
    $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $users = get_users([
        'role'    => 'um_toolanbieter',
        'orderby' => 'user_nicename',
        'order'   => 'ASC'
    ]);

    foreach ($users as $user) {
        // Take balance/guthaben from omt_guthaben
        $query = $conn->query("SELECT * FROM `omt_guthaben` WHERE `user_id` = " . $user->ID);

        if (mysqli_num_rows($query) > 0) { //just loop through it, last row = current budget
            while ($row = mysqli_fetch_assoc($query)) {
                $balance = $row['guthaben'];
            }
        } else {
            $balance = 0;
        }

        //need to loop the toolsql one more to combine tool/overall budget insights
        foreach (User::init()->tools((int) $user->ID) as $tool) {
            $qry = $conn->query("SELECT * FROM `omt_tools` WHERE `id` = " . $tool->ID);

            if (mysqli_num_rows($qry) > 0) {
                while ($toolrow = mysqli_fetch_assoc($qry)) {
                    $query = $conn->query("SELECT * FROM `omt_budgets` WHERE `tool_id` = " . $tool->ID . " AND `user_id` = " . $user->ID);

                    if (mysqli_num_rows($query) > 0) { //just loop through it, last row = current budget
                        while ($row = mysqli_fetch_assoc($query)) {
                            $monthlyBudget = $row['budget'];
                        }
                    } else {
                        $monthlyBudget = 0;
                    }

                    $restMonthlyBudget = $monthlyBudget - $toolrow['aktuelle_kosten'];

                    // Enable "Buttons anzeigen" if the monthly budget has not been hit and the balance > 0 or balance is negative but is enable option "enable_ads_on_negative_balance"
                    if ($restMonthlyBudget > 0 && ($balance > 0 || get_field('enable_ads_on_negative_balance', $tool->ID))) {
                        // Enable ACF "Buttons anzeigen" (buttons_anzeigen) field
                        update_field("field_5e9db691d44b0", true, $tool->ID);
                    } else {
                        // Disable ACF "Buttons anzeigen" (buttons_anzeigen) field
                        update_field("field_5e9db691d44b0", false, $tool->ID);
                    }
                }
            }
        }
    }
}


//TODOS FOR GUTHABENBERECHNUNG:
//
//1. DECIDE IF GUTHABEN WILL BE KEPT IN omt_guthaben or within omt_tools (as they have a designated user_id assigned to them)
//2. IF omt_guthaben: cycle through all users with role "toolanbieter", coolect their tools with total costs, then collect their entries from "einzahlungen"
//3. Write the result into omt_guthaben
//4. use the result as base for: -toolanbieter backend output on guthaben; -calculations/checks if a tool will be displayed (replaces "total budget")
//5. profit. or?
//
function calculate_balance()
{
    //SQL CONNECTION COMES FIRWST
    $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $users = get_users([
        'role' => 'um_toolanbieter',
        'orderby' => 'user_nicename',
        'order' => 'ASC'
    ]);

    foreach ($users as $user) {
        $zugewiesenes_tool = User::init()->tools((int) $user->ID);
        $gesamtkosten_account = 0;

        foreach ($zugewiesenes_tool as $tool) {
            $query = $conn->query("SELECT * FROM `omt_tools` WHERE `id` = " . $tool->ID);

            if (mysqli_num_rows($query) > 0){
                while ($row = mysqli_fetch_assoc($query)) {
                    $gesamtkosten_account += $row['gesamtkosten'];
                }
            }
        }

        $query = $conn->query("SELECT * FROM `omt_einzahlungen` WHERE `user_id` = " . $user->ID);
        $gesamteinzahlungen = 0;
        if (mysqli_num_rows($query) > 0) {
            // If there is more than 1 deposit, we can declare the user active (if he isnt already)
            $update_user_status = "UPDATE `omt_guthaben` SET `active_tooluser` = '1' WHERE `user_id` = " . $user->ID ." AND `active_tooluser` = 0";
            if ($conn->query($update_user_status) === false) {
                echo "Error: " . $conn->error;
            }

            while ($row = mysqli_fetch_assoc($query)) {
                $gesamteinzahlungen += $row['betrag'];
            }
        }

        $guthaben = $gesamteinzahlungen - $gesamtkosten_account;

        foreach ($zugewiesenes_tool as $tool) {
            // Set ACF "Guthaben" (guthaben) field
            update_field("field_5fd757edc027b", $guthaben, $tool->ID);
        }

        $sql = "INSERT INTO omt_guthaben (user_id, guthaben)
            VALUES ('" . $user->ID . "', '$guthaben')
            ON DUPLICATE KEY UPDATE guthaben='$guthaben'";

        $conn->query($sql);
    }
}

function notification_on_low_budget() {
    //SQL CONNECTION COMES FIRWST
    $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $notifyguthabensql = "SELECT * FROM `omt_guthaben`"; //take from omt_guthaben instead!
    $query = $conn->query($notifyguthabensql);
    $tenthDayThisMonth = date("Y-m-10");
    $today = date("Y-m-d");
    if ($today != $tenthDayThisMonth) {
        if (mysqli_num_rows($query) > 0) { //just loop through it, last row = current budget
            while ($row = mysqli_fetch_assoc($query)) {
                $user_id = $row['user_id'];
                $guthabeninfo_50_sent = $row['guthabeninfo_50_sent'];
                $active_tooluser = $row['active_tooluser'];

                if ($row['guthaben'] <= 50 && $row['guthaben'] > 1 && $active_tooluser >= 1 && 1 != $guthabeninfo_50_sent) {
                    //UPDATE DATABASE ROW THAT INFORMATION CAME OUT:
                    $guthabeninfo_50_sent_update = "UPDATE `omt_guthaben` SET `guthabeninfo_50_sent` =  '1' WHERE `user_id`=$user_id";
                    if ($conn->query($guthabeninfo_50_sent_update) === false) {
                        echo "Error: " . $conn->error;
                    }
                    //END OF DATABASE UPDATE
                    //CREATE EMAIL INFORMATION
                    $user = get_userdata($user_id);
                    // Get display name and email from user object
                    $display_name = $user->display_name;
                    $user_email = $user->user_email;

                    $to = $user_email;
                    $subject = 'OMT ToolAds: Dein Guthaben ist unter 50€';
                    $body = 'The email body content';
                    // Get user data by user id
                    $benachrichtigung_niedriges_guthaben = get_field('benachrichtigung_niedriges_guthaben', 'options');
                    $benachrichtigung_niedriges_guthaben = str_replace("%%user_name%%", $display_name, $benachrichtigung_niedriges_guthaben);
                    $body = str_replace("%%guthaben%%", number_format($row['guthaben'], 2, ",", "."), $benachrichtigung_niedriges_guthaben);
                    //$headers = array('Content-Type: text/html; charset=UTF-8');
                    $headers = "From: info@omt.de\r\n";
                    $headers .= "Reply-To: info@omt.de\r\n";
                    $headers .= "CC: info@omt.de\r\n";
                    $headers .= "CC: christos.pipsos@omt.de\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    wp_mail($to, $subject, $body, $headers);
                    print "Guthabenwarnung sent";
                }
            }
        }
    }
}


function notification_on_no_budget() {
    //SQL CONNECTION COMES FIRWST
    $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $notifyguthabensql = "SELECT * FROM `omt_guthaben`"; //take from omt_guthaben instead!
    $query = $conn->query($notifyguthabensql);
    $tenthDayThisMonth = date("Y-m-10");
    $today = date("Y-m-d");
    if ($today != $tenthDayThisMonth) {
        if (mysqli_num_rows($query) > 0) { //just loop through it, last row = current budget
            while ($row = mysqli_fetch_assoc($query)) {
                $user_id = $row['user_id'];
                $guthabeninfo_0_sent = $row['guthabeninfo_0_sent'];
                $active_tooluser = $row['active_tooluser'];

                if ($row['guthaben'] <= 1 && $active_tooluser >= 1 && 1 != $guthabeninfo_0_sent) {
                    //UPDATE DATABASE ROW THAT INFORMATION CAME OUT:
                    $guthabeninfo_0_sent_update = "UPDATE `omt_guthaben` SET `guthabeninfo_0_sent` =  '1' WHERE `user_id`=$user_id";
                    if ($conn->query($guthabeninfo_0_sent_update) === false) {
                        echo "Error: " . $conn->error;
                    }
                    //END OF DATABASE UPDATE
                    //CREATE EMAIL INFORMATION
                    // Get user data by user id
                    $user = get_userdata($user_id);
                    // Get display name from user object
                    $display_name = $user->display_name;
                    $user_email = $user->user_email;
                    $to = $user_email;
                    $subject = 'OMT ToolAds: Dein Guthaben ist aufgebraucht';
                    $body = 'The email body content';
                    $benachrichtigung_verbrauchtes_guthaben = get_field('benachrichtigung_verbrauchtes_guthaben', 'options');
                    $benachrichtigung_verbrauchtes_guthaben = str_replace("%%user_name%%", $display_name, $benachrichtigung_verbrauchtes_guthaben);
                    $body = str_replace("%%guthaben%%", number_format($row['guthaben'], 2, ",", "."), $benachrichtigung_verbrauchtes_guthaben);
                    //$headers = array('Content-Type: text/html; charset=UTF-8');
                    $headers = "From: info@omt.de\r\n";
                    $headers .= "Reply-To: info@omt.de\r\n";
                    $headers .= "CC: info@omt.de\r\n";
                    $headers .= "CC: christos.pipsos@omt.de\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    wp_mail($to, $subject, $body, $headers);
                    print "Guthabenwarnung sent";
                }
            }
        }
    }
}

function month_end_stats()
{
    $tenthDayThisMonth = date("Y-m-10");
    $today = date("Y-m-d");

    //reset 5ßeur warning notification to zero on 10th of each month:
    if ($today == $tenthDayThisMonth) {
        //SQL CONNECTION COMES FIRST
        $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $guthabeninfo_50_sent_update = "UPDATE `omt_guthaben` SET `guthabeninfo_50_sent` =  '0' WHERE `guthabeninfo_50_sent`>0";
        if ($conn->query($guthabeninfo_50_sent_update) === false) {
            echo "Error: " . $conn->error;
        }
        $guthabeninfo_0_sent_update = "UPDATE `omt_guthaben` SET `guthabeninfo_0_sent` =  '0' WHERE `guthabeninfo_0_sent`>0";
        if ($conn->query($guthabeninfo_0_sent_update) === false) {
            echo "Error: " . $conn->error;
        }
    }
}
?>