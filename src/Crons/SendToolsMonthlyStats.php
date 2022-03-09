<?php

namespace OMT\Crons;

use mysqli;
use OMT\Model\User;
use OMT\Services\Date;

/**
 * Run every morning at ~00:05
 *
 * On the first day of the month loop through all active users and collect their previous monthly statistics
 * Compose an Email with all their relevant info and send it
 * Then set Notification Status to 1, they get this info only once and not on every cron hit
 */
class SendToolsMonthlyStats extends Cron
{
    protected function handle()
    {
        $today = Date::get()->setTime(0, 0, 0);
        $date = clone $today;

        if ($today == $date->modify('first day of this month')) {
            $this->log('Triggered at ' . date('d.m.Y H:i:s') . '. Default timezone ' . date_default_timezone_get());

            //SQL CONNECTION COMES FIRST
            $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
            // Check connection
            if ($conn->connect_error) {
                $this->log("Connection failed: " . $conn->connect_error);
                die("Connection failed: " . $conn->connect_error);
            }

            $previousDay = clone $today;
            $previousDay->modify('-1 days');

            //take from omt_guthaben instead!
            $monthlyquery = $conn->query("SELECT * FROM `omt_guthaben` WHERE `monthly_stats_sent` = 0 AND `active_tooluser` = 1");

            if (mysqli_num_rows($monthlyquery) > 0) { //Loop through all non-notified accounts
                $monate = [
                    "01" => "Januar",
                    "02" => "Februar",
                    "03" => "M&auml;rz",
                    "04" => "April",
                    "05" => "Mai",
                    "06" => "Juni",
                    "07" => "Juli",
                    "08" => "August",
                    "09" => "September",
                    1 => "Januar",
                    2 => "Februar",
                    3 => "M&auml;rz",
                    4 => "April",
                    5 => "Mai",
                    6 => "Juni",
                    7 => "Juli",
                    8 => "August",
                    9 => "September",
                    10 => "Oktober",
                    11 => "November",
                    12 => "Dezember"
                ];

                while ($row = mysqli_fetch_assoc($monthlyquery)) {
                    //Collect user stats for the email
                    $guthaben = number_format($row['guthaben'], 2, ",", ".");
                    $user_id = $row['user_id'];
                    // Get user data by user id
                    $user = get_userdata($user_id);

                    $monthdate = $previousDay->format('m');
                    $monat = $monate[$monthdate];
                    $jahr = $previousDay->format('Y');
                    //end of collect user stats before mail, rest will be in-mail because of tool array
                    $heutedatum = $previousDay->format('d.m.Y');
                    //email headers
                    $to = $user->user_email;
                    $subject = 'Deine Tool-Statistiken im ' . $monat . ' ' . $jahr;
                    $headers = "From: info@omt.de\r\n";
                    $headers .= "Reply-To: info@omt.de\r\n";
                    $headers .= "CC: info@omt.de\r\n";
                    $headers .= "CC: christos.pipsos@omt.de\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    //email headers end here

                    $message = '<html><body>';
                    $message .= '<table rules="all" style="border-color: #666; width:600px;" cellpadding="10" cellspacing="0">';
                    $message .= '<tr style="background: #ffff;"><td colspan="4"><h1>Deine Statistik beim OMT-Toolvergleich für den Monat ' . $monat . ' ' . $jahr . '</h1></td></tr>';
                    $message .= '<tr style="background: #fff;"><td colspan="4">Hallo ' . $user->display_name . ',</td></tr>';
                    $message .= '<tr style="background: #fff;"><td colspan="4">in dieser Mail findest Du eine Übersicht zu Deinem Account im OMT-Toolbackend.,</td></tr>';
                    $message .= '<tr style="background: #f3f3f3;"><td colspan="4" style="font-weight:700; text-align:center;">Dein aktuelles Guthaben beträgt am ' . $heutedatum . ': ' . $guthaben . ' €</td></tr>';
                    $message .= '<tr style="background: #ffffff;"><td colspan="4" style="text-align:center;margin-top:30px;"><a  href="https://www.omt.de/toolanbieter/" title="Jetzt einloggen"><span style="color:#31bbda;font-weight:700;font-size:20px;">Login und Guthaben aufladen</span></a></td></tr>';
                    $message .= '<tr style="background: #fff;margin-top:30px;"><td colspan="4"><h2 style="margin-top:30px;text-align:center;font-weight:700;">Klicks auf Deine Tools im ' . $monat . ':</h2></td></tr>';

                    //looping through the tools to get clicks
                    foreach (User::init()->tools($user_id) as $tool) {
                        $tool_id = $tool->ID;
                        $clicksum = 0;
                        $costsum = 0;
                        //// clickcounter
                        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        //// get the clicks per category on this tool:
                        $toolanbieter_website_clickmeter_link_id = get_field('toolanbieter_website_clickmeter_link_id', $tool_id);
                        $tool_preisubersicht = get_field('tool_preisubersicht', $tool_id);
                        $tool_preisubersicht_clickmeter_link_id = get_field('tool_preisubersicht_clickmeter_link_id', $tool_id);
                        $tool_gratis_testen_link = get_field('tool_gratis_testen_link', $tool_id);
                        $tool_gratis_testen_link_clickmeter_link_id = get_field('tool_gratis_testen_link_clickmeter_link_id', $tool_id);
                        $tool_kategorien_content = get_field('tool_kategorien', $tool_id);
                        $zur_website = get_field('zur_webseite', $tool_id);
                        $trackinglinks = [];
                        $title = get_the_title($tool_id);

                        ////Push Website Link into ARray if available
                        if ($toolanbieter_website_clickmeter_link_id > 0) {
                            array_push($trackinglinks, [
                                '$linkid' => $toolanbieter_website_clickmeter_link_id,
                                '$tracking_link' => $zur_website,
                                '$tool_id' => $tool_id,
                                '$tool_name' => $title,
                                '$toolkategorie_id' => 0,
                                '$toolkategorie_slug' => "",
                                '$toolkategorie_name' => ""
                            ]);
                        }

                        ////Push Price LInk into ARray if available
                        if ($tool_preisubersicht_clickmeter_link_id > 0) {
                            array_push($trackinglinks, [
                                '$linkid' => $tool_preisubersicht_clickmeter_link_id,
                                '$tracking_link' => $tool_preisubersicht,
                                '$tool_id' => $tool_id,
                                '$tool_name' => $title,
                                '$toolkategorie_id' => 0,
                                '$toolkategorie_slug' => "",
                                '$toolkategorie_name' => ""
                            ]);
                        }

                        ////Push Gratis Testen into ARray if available
                        if ($tool_gratis_testen_link_clickmeter_link_id > 0) {
                            array_push($trackinglinks, [
                                '$linkid' => $tool_gratis_testen_link_clickmeter_link_id,
                                '$tracking_link' => $tool_gratis_testen_link,
                                '$tool_id' => $tool_id,
                                '$tool_name' => $title,
                                '$toolkategorie_id' => 0,
                                '$toolkategorie_slug' => "",
                                '$toolkategorie_name' => ""
                            ]);
                        }

                        ///PUSH CATEGORY LINKS INTO ARRAY WHERE AVAILABLE
                        if (is_array($tool_kategorien_content)) {
                            foreach ($tool_kategorien_content as $kategorie) {
                                $link_website = $kategorie['kategorie_zur_website_link'];
                                $clickmeter_link_id_website = $kategorie['kategorie_zur_website_clickmeter_link_id'];
                                $link_preis = $kategorie['kategorie_preisubersicht_link'];
                                $clickmeter_link_id_preis = $kategorie['kategorie_preisubersicht_clickmeter_link_id'];
                                $link_testen = $kategorie['kategorie_tool_testen_link'];
                                $clickmeter_link_id_testen = $kategorie['kategorie_tool_testen_clickmeter_link_id'];
                                $catid = $kategorie['kategorie'];
                                $term = get_term_by('id', $catid, 'tooltyp');
                                $slug = $term->slug;
                                $name = $term->name;

                                if ((strlen($link_website) > 0) and (strlen($clickmeter_link_id_website) > 0)) {
                                    array_push($trackinglinks, [
                                        '$linkid' => $clickmeter_link_id_website,
                                        '$tracking_link' => $link_website,
                                        '$tool_id' => $tool_id,
                                        '$tool_name' => $title,
                                        '$toolkategorie_id' => $catid,
                                        '$toolkategorie_slug' => $slug,
                                        '$toolkategorie_name' => $name
                                    ]);
                                }

                                if ((strlen($link_preis) > 0) and (strlen($clickmeter_link_id_preis) > 0)) {
                                    array_push($trackinglinks, [
                                        '$linkid' => $clickmeter_link_id_preis,
                                        '$tracking_link' => $link_preis,
                                        '$tool_id' => $tool_id,
                                        '$tool_name' => $title,
                                        '$toolkategorie_id' => $catid,
                                        '$toolkategorie_slug' => $slug,
                                        '$toolkategorie_name' => $name
                                    ]);
                                }

                                if ((strlen($link_testen) > 0) and (strlen($clickmeter_link_id_testen) > 0)) {
                                    array_push($trackinglinks, [
                                        '$linkid' => $clickmeter_link_id_testen,
                                        '$tracking_link' => $link_testen,
                                        '$tool_id' => $tool_id,
                                        '$tool_name' => $title,
                                        '$toolkategorie_id' => $catid,
                                        '$toolkategorie_slug' => $slug,
                                        '$toolkategorie_name' => $name
                                    ]);
                                }
                            }
                        }

                        //All tracking LInks are in one Array now. Make Sure we have only one Bid per Toolcategory!
                        ////unique_array wont work because of tool name&id so we use that loop to remove all duplicates => exactly one Bid per Tool/Category having betwenn 1 to 3 active Tracking Links:
                        $taken = [];
                        foreach ($trackinglinks as $key => $item) {
                            if (!in_array($item['$toolkategorie_id'], $taken)) {
                                $taken[] = $item['$toolkategorie_id'];
                            } else {
                                unset($trackinglinks[$key]);
                            }
                        }
                        /// DONE TRACKING LINKS ARRAY

                        $message .= '<tr style="background: #f3f3f3;style=border-bottom:none;"><td colspan="4"><h3>' . get_the_title($tool_id) . ':</h3></td></tr>';
                        $message .= '<tr><th style="width: 250px;border-bottom: 1px solid #004590;"><strong>Kategorie</strong></th>';
                        $message .= '<th style="width: 200px;border-bottom: 1px solid #004590;text-align:right;"><strong>Aktuelles Gebot</strong></th>';
                        $message .= '<th style="width: 125px;border-bottom: 1px solid #004590;text-align:right;"><strong>Klicks diesen Monat</strong></th>';
                        $message .= '<th style="width: 125px;border-bottom: 1px solid #004590;text-align:right;"><strong>Kosten diesen Monat</strong></th>';
                        $message .= '</tr>';

                        foreach ($trackinglinks as $link) {
                            //get current bidding for this link
                            $query = $conn->query("SELECT * FROM `omt_bids` WHERE `tool_id` = " . $link['$tool_id'] . " AND `toolkategorie_id` = " . $link['$toolkategorie_id'] . " AND `is_active` = '1'");
                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $bid_kosten_formatted = number_format($row['bid_kosten'], 2, ",", ".");
                                    $bidid = $row['ID'];
                                }
                            }

                            if ($link['$toolkategorie_id'] > 0) {
                                $sumcosts = 0;
                                $count = 0;

                                $clicks_query = $conn->query("SELECT * FROM `omt_clicks` WHERE `bid_id` = " . $bidid);
                                if (mysqli_num_rows($clicks_query) > 0) {
                                    while ($row = mysqli_fetch_assoc($clicks_query)) {
                                        // Check if click is in previous month
                                        if (Date::timestampToDate($row['timestamp_unix'])->format('Y-m') === $previousDay->format('Y-m')) {
                                            $count++;
                                            $sumcosts += $row['bid_kosten'];
                                        }
                                    }
                                }

                                $message .= '<tr>';
                                $message .= '<td style="border-bottom: 1px solid #004590;">' . $link['$toolkategorie_name'] . '</td>';
                                $message .= '<td style="border-bottom: 1px solid #004590;text-align:right;">' . $bid_kosten_formatted . '€ / Klick</td>';
                                $message .= '<td style="border-bottom: 1px solid #004590;text-align:right;">' . $count . '</td>';
                                $message .= '<td style="border-bottom: 1px solid #004590;text-align:right;">' . number_format($sumcosts, 2, ",", ".") . '€</td>';
                                $message .= '</tr>';

                                $clicksum = $clicksum + $count;
                                $costsum = $costsum + $sumcosts;
                            }
                        }
                        
                        ////TOOL EINZELSEITE KLICKS OUTPUT COMES HERE:
                        $sumcosts = 0;
                        $count = 0;
                        $lastaverage = 0;

                        $clicks_query = $conn->query("SELECT * FROM `omt_clicks` WHERE `tool_id` = " . $tool_id . " AND `toolkategorie_id` = 0 ORDER BY `timestamp_unix` DESC");
                        if (mysqli_num_rows($clicks_query) > 0) {
                            while ($row = mysqli_fetch_assoc($clicks_query)) {
                                // Check if click is in previous month
                                if (Date::timestampToDate($row['timestamp_unix'])->format('Y-m') === $previousDay->format('Y-m')) {
                                    $count++;
                                    $sumcosts += $row['bid_kosten'];

                                    if (1 == $count) {
                                        $lastaverage = $row['bid_kosten'];
                                    }
                                }
                            }
                        }

                        $message .= '<tr>';
                        $message .= '<td>' . get_the_title($tool_id) . ' Profilseite</td>';
                        $message .= '<td style="text-align:right;">Letzter Klickpreis: ' . number_format($lastaverage, 2, ",", ".") . '€</td>';
                        $message .= '<td style="text-align:right;">' . $count . '</td>';
                        $message .= '<td style="text-align:right;">' . number_format($sumcosts, 2, ",", ".") . '€</td>';
                        $message .= '</tr>';

                        //Zusammengefasste Zeile des Tools
                        $clicksum = $clicksum + $count; //add einzelseite klicks
                        $costsum = $costsum + $sumcosts;//add einzelseite costs
                        $message .= '<tr style="background: #f3f3f3;font-weight:700;border-bottom:none;"><td colspan="2"><strong>' . get_the_title($tool_id) . ' Gesamt:</strong></td><td style="text-align:right;"><strong>' . $clicksum . '</strong></td><td style="text-align:right;"><strong>' . number_format($costsum, 2, ",", ".") . '€</td></strong></td></tr>';
                        $message .= '<tr style="background: #ffffff;margin-top:30px;"><td colspan="4">&nbsp;</td></tr>';
                    }

                    $message .= '</table>';
                    $message .= '</body></html>';
                    //end of the email

                    //SEND THE EMAIL:
                    if (wp_mail($to, $subject, $message, $headers)) {
                        $this->log('Email sent. User ID: ' . $user_id);
                    }

                    //UPDATE THE INFORMATION IF STATUS UPDATE HAS BEEN SENT ALREADY
                    if ($conn->query("UPDATE `omt_guthaben` SET `monthly_stats_sent` = '1' WHERE `user_id` = " . $user_id) === false) {
                        $this->log("Error: " . $conn->error);
                    }
                }
            }
        }
    }

    protected function getHook()
    {
        return 'send-tools-monthly-stats';
    }

    protected function getInterval()
    {
        return 'daily';
    }

    protected function getTimestamp()
    {
        $ve = get_option('gmt_offset') > 0 ? '-' : '+';

        return strtotime('00:05 ' . $ve . absint(get_option('gmt_offset')) . ' HOURS');
    }
}
