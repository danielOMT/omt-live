<?php

//////////SQL CONNECTION TO DATAHOST
$conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//////////SQL CONNECTION TO DATAHOST

$current_user_id = get_current_user_id();
um_fetch_user($current_user_id);
$display_name = um_user('display_name');
$zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);

$toolanbieter_website_clickmeter_link_id = get_field('toolanbieter_website_clickmeter_link_id', $toolid);
$tool_preisubersicht = get_field('tool_preisubersicht', $toolid);
$tool_preisubersicht_clickmeter_link_id = get_field('tool_preisubersicht_clickmeter_link_id', $toolid);
$tool_gratis_testen_link = get_field('tool_gratis_testen_link', $toolid);
$tool_gratis_testen_link_clickmeter_link_id = get_field('tool_gratis_testen_link_clickmeter_link_id', $toolid);
$tool_kategorien_content = get_field('tool_kategorien', $toolid);


if ( ( !isset($toolid) ) OR ("budget" == $toolid) ) {
    $gesamtbudget = "SELECT * FROM `omt_budgets` WHERE `tool_id`=0 AND `user_id`=$current_user_id";
    $query = $conn->query($gesamtbudget);
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)) {
            $currentbid = $row['budget'];
        }
    } else { $currentbid = 0; }

    $guthabensql = "SELECT * FROM `omt_guthaben` WHERE `user_id`=$current_user_id";
    $query = $conn->query($guthabensql);
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)) {
            $guthaben += $row['guthaben'];
        }
    } else { $einzahlungen = 0; }

    ?>
    <h4>Aktuelles Guthaben: <?php print $guthaben;?> €</h4>
    <div class="budget-aufladen">
        <span class="">Guthaben aufladen:</span>
        <?php echo do_shortcode( '[add_to_cart_form id="201855"]' ); ?>
        <p style="width:100% !important;" class="no-margin-top no-margin-bottom"><strong>(Nettobetrag)</strong></p>
    </div>
    <h4>Gesamtbudgets pro Monat festlegen</h4>
    <table class="budgets">
        <tr>
            <th class="">Tool</th>
            <th class="">Budgetlimit / Monat<div class="tooltip"><sup>(?)</sup><span class="tooltiptext">Bitte wähle einen Wert über 0, um das Tool zu aktivieren</span></div></th>
        </tr>
        <?php foreach($zugewiesenes_tool as $tool) {
            $tool_id = $tool->ID;
            $title = get_the_title($tool_id);
            $gesamtbudget = "SELECT * FROM `omt_budgets` WHERE `tool_id`=$tool_id";
            $query = $conn->query($gesamtbudget);
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)) {
                    $currentbid = $row['budget'];
                }
            } else { $currentbid = 0; }
            ?>
            <tr>
                <td><?php print $title;?> <?php if ($currentbid < 1) { ?><span style="font-weight:700;color:#444444;">(inaktiv)</span><div class="tooltip"><sup>(?)</sup><span class="tooltiptext">Bitte wähle ein Budget über 0, um das Tool zu aktivieren</span></div>   <?php } ?></td>
                <td data-tool="<?php print $tool->ID;?>" data-budget="<?php print $currentbid;?>"><?php print $currentbid;?>€ <span class="change-budget">(ändern)</span>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="klicks-summary">
        <h4>Übersicht bisheriger Klicks und Kosten diesen Monat</h4>
        <table class="clicks-info">
            <tr>
                <th>Tool</th>
                <th>Anzahl</th>
                <th>Kosten</th>
            </tr>
            <?php
            $allclicks = array();
            foreach($zugewiesenes_tool as $tool) {
                $tool_id = $tool->ID;
                $title = get_the_title($tool_id);
                $clicks = "SELECT * FROM `omt_clicks` WHERE `tool_id`=$tool_id";
                $query = $conn->query($clicks);
                $sumcosts = 0;
                $count = 0;
                if(mysqli_num_rows($query) > 0){
                    while($row = mysqli_fetch_assoc($query)) {
                        $timestamp_unix = $row['timestamp_unix'];
                        if(date('Y-m', $timestamp_unix) === date('Y-m')) { //check if click is im current month!
                            $bid_kosten = $row['bid_kosten'];
                            $tool_id = $row['tool_id'];
                            $toolkategorie_id = $row['toolkategorie_id'];
                            $arr_data = array(
                                "timestamp" => $timestamp_unix,
                                "kosten" => $bid_kosten,
                                "catid" => $toolkategorie_id
                            );
                            array_push($allclicks, $arr_data); //array im Moment not in use
                            $count++;
                            $sumcosts += $bid_kosten;
                        }
                    }
                }
                ?>
                <tr>
                    <td><?php print $title;?></td>
                    <td><?php print $count;?></td>
                    <td><?php print $sumcosts;?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } else { ?>
    <h4>Budgets und Gebote für das Tool <?php print get_the_title($toolid);?></h4>
    <?php
    //////////CREATE AND FILL ARRAY MIT TRACKING LINKS
    $trackinglinks = array();
    ////Push Website Link into ARray if available
    if ( $toolanbieter_website_clickmeter_link_id>0 ) {
        $arr_data = array(
            '$linkid' => $toolanbieter_website_clickmeter_link_id,
            '$tracking_link' => $zur_website,
            '$tool_id' => $toolid,
            '$tool_name' => $title,
            '$toolkategorie_id' => 0,
            '$toolkategorie_slug' => "",
            '$toolkategorie_name' => ""
        );
        array_push($trackinglinks, $arr_data);
    }
    ////Push Price LInk into ARray if available
    if ( $tool_preisubersicht_clickmeter_link_id>0 ) {
        $arr_data = array(
            '$linkid' => $tool_preisubersicht_clickmeter_link_id,
            '$tracking_link' => $tool_preisubersicht,
            '$tool_id' => $toolid,
            '$tool_name' => $title,
            '$toolkategorie_id' => 0,
            '$toolkategorie_slug' => "",
            '$toolkategorie_name' => ""
        );
        array_push($trackinglinks, $arr_data);
    }
    ////Push Gratis Testen into ARray if available
    if ( $tool_gratis_testen_link_clickmeter_link_id>0 ) {
        $arr_data = array(
            '$linkid' => $tool_gratis_testen_link_clickmeter_link_id,
            '$tracking_link' => $tool_gratis_testen_link,
            '$tool_id' => $toolid,
            '$tool_name' => $title,
            '$toolkategorie_id' => 0,
            '$toolkategorie_slug' => "",
            '$toolkategorie_name' => ""
        );
        array_push($trackinglinks, $arr_data);
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
            if ( ( strlen( $link_website)>0 ) AND ( strlen($clickmeter_link_id_website)>0 ) ) {
                $arr_data = array(
                    '$linkid' => $clickmeter_link_id_website,
                    '$tracking_link' => $link_website,
                    '$tool_id' => $toolid,
                    '$tool_name' => $title,
                    '$toolkategorie_id' => $catid,
                    '$toolkategorie_slug' => $slug,
                    '$toolkategorie_name' => $name
                );
                array_push($trackinglinks, $arr_data);
            }
            if ( ( strlen( $link_preis)>0 ) AND ( strlen($clickmeter_link_id_preis)>0 ) ) {
                $arr_data = array(
                    '$linkid' => $clickmeter_link_id_preis,
                    '$tracking_link' => $link_preis,
                    '$tool_id' => $toolid,
                    '$tool_name' => $title,
                    '$toolkategorie_id' => $catid,
                    '$toolkategorie_slug' => $slug,
                    '$toolkategorie_name' => $name
                );
                array_push($trackinglinks, $arr_data);
            }
            if ( ( strlen( $link_testen)>0 ) AND ( strlen($clickmeter_link_id_testen)>0 ) ) {
                $arr_data = array(
                    '$linkid' => $clickmeter_link_id_testen,
                    '$tracking_link' => $link_testen,
                    '$tool_id' => $toolid,
                    '$tool_name' => $title,
                    '$toolkategorie_id' => $catid,
                    '$toolkategorie_slug' => $slug,
                    '$toolkategorie_name' => $name
                );
                array_push($trackinglinks, $arr_data);
            }
        }
    }

    //All tracking LInks are in one Array now. Make Sure we have only one Bid per Toolcategory!
    ////unique_array wont work because of tool name&id so we use that loop to remove all duplicates => exactly one Bid per Tool/Category having betwenn 1 to 3 active Tracking Links:
    foreach($trackinglinks as $key => $item) {
        if(!in_array($item['$toolkategorie_id'], $taken)) {
            $taken[] = $item['$toolkategorie_id'];
        } else {
            unset($trackinglinks[$key]);
        }
    }
    /// DONE TRACKING LINKS ARRAY
    $title = get_the_title($toolid);
    $zur_website = get_field('zur_webseite', $toolid);
    ?>
    <table class="gebote-wrap">
        <tr>
            <th style="width: 250px;">Kategorie</th>
            <th style="width: 200px;">Aktuelles Maximalgebot<div class="tooltip"><sup>(?)</sup><span class="tooltiptext" style="width:450px;height:auto;white-space:break-spaces;line-height:2em;hyphens:auto;word-break:break-word;">Lege hier Dein Maximalgebot fest, welches Du pro Klick zu zahlen bereit bist. Die tatsächlichen Kosten pro Klick werden jedoch an dem nächst-niedrigerem Gebot der Konkurrenz berechnet. Beispiel: Wenn Du 5€ bietest und das nächste Gebot bei 3€ liegen sollte, wird das System nur 3,50€ anstelle der vollen 5€ für diesen Klick berechnen.</span></div></th>
            <th style="width: 125px;">Klicks / <?php print date('M');?><div class="tooltip"><sup>(?)</sup><span class="tooltiptext">Summe ALLER Klicks auf dieser Kategorie im aktuellen Monat</span></div></th>
            <th style="width: 125px;">Kosten / <?php print date('M');?><div class="tooltip"><sup>(?)</sup><span class="tooltiptext">Summe ALLER Klick-Kosten dieser Kategorie im aktuellen Monat</span></div></th>
        </tr>
        <?php foreach ($trackinglinks as $link) {
            //get current bidding for this link:
            $tool_id = $link['$tool_id'];
            $toolkategorie_id = $link['$toolkategorie_id'];

            $bid = "SELECT * FROM `omt_bids` WHERE `tool_id`=$tool_id AND `toolkategorie_id`=$toolkategorie_id AND `is_active`='1'";
            $query = $conn->query($bid);
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)) {
                    $bid_kosten = $row['bid_kosten'];
                    $bidid = $row['ID'];
                }
            }
            if ($link['$toolkategorie_id']>0) {
                $sqlclicks = "SELECT * FROM `omt_clicks` WHERE `bid_id`=$bidid";
                $clicks_query = $conn->query($sqlclicks);
                $sumcosts = 0;
                $count = 0;
                if(mysqli_num_rows($clicks_query) > 0){
                    while($row = mysqli_fetch_assoc($clicks_query)) {
                        $timestamp_unix = $row['timestamp_unix'];
                        if(date('Y-m', $timestamp_unix) === date('Y-m')) { //check if click is im current month!
                            $this_bid_kosten = $row['bid_kosten'];
                            $tool_id = $row['tool_id'];
                            $toolkategorie_id = $row['toolkategorie_id'];
                            $arr_data = array(
                                "timestamp" => $timestamp_unix,
                                "kosten" => $this_bid_kosten,
                                "catid" => $toolkategorie_id
                            );
                            array_push($allclicks, $arr_data); //array im Moment not in use
                            $count++;
                            $sumcosts += $this_bid_kosten;
                        }
                    }
                }
                ?>
                <tr>
                    <td><?php print $link['$toolkategorie_name'];?></td>
                    <td data-bidprice="<?php print $bid_kosten;?>" data-bid="<?php print $bidid;?>" data-cat="<?php print $link['$toolkategorie_id'];?>">
                        <?php print $bid_kosten;?> € / Klick
                        <span class="change-bid">(ändern)</span>
                    </td>
                    <td><?php print $count;?></td>
                    <td><?php print $sumcosts;?></td>
                </tr>
            <?php } ?>
        <?php }
        ////TOOL EINZELSEITE KLICKS OUTPUT COMES HERE:
        $sqlclicks = "SELECT * FROM `omt_clicks` WHERE `tool_id`=$toolid AND `toolkategorie_id` = 0 ORDER BY `timestamp_unix` DESC";
        $clicks_query = $conn->query($sqlclicks);
        if(mysqli_num_rows($clicks_query) > 0){
            $sumcosts = 0;
            $count = 0;
            $lastaverage = 0;
            while($row = mysqli_fetch_assoc($clicks_query)) {
                $timestamp_unix = $row['timestamp_unix'];
                if(date('Y-m', $timestamp_unix) === date('Y-m')) { //check if click is im current month!
                    $bid_kosten = $row['bid_kosten'];
                    $tool_id = $row['tool_id'];
                    $toolkategorie_id = $row['toolkategorie_id'];
                    $arr_data = array(
                        "timestamp" => $timestamp_unix,
                        "kosten" => $bid_kosten,
                        "catid" => $toolkategorie_id
                    );
                    array_push($allclicks, $arr_data); //array im Moment not in use
                    $count++;
                    $sumcosts += $bid_kosten;
                    if (1 == $count) { $lastaverage = $bid_kosten; }
                }
            }
        }
        ?>
        <tr>
            <td><?php print get_the_title($toolid);?> Profilseite<br>(<?php print get_the_permalink($toolid);?>)</td>
            <td>
                Letzter Klickpreis (Durchschnitt der letzten 20): <?php print $lastaverage;?> € <div class="tooltip"><sup>(?)</sup><span class="tooltiptext">Für die Einzelseite wird ein Durchschnitt der Klick-Kosten der letzten 20 Klicks berechnet - unabhängig vom aktuellen Gebot</span></div>
            </td>
            <td><?php print $count;?></td>
            <td><?php print $sumcosts;?></td>
        </tr>
    </table>

    <div class="history">
        <h4>Gebote Historie für das Tool <?php print get_the_title($toolid);?></h4>
        <table class="bid-history">
            <tr>
                <th class="">Kategorie</th>
                <th class="">Maximalgebot</th>
                <th class="">Klicks</th>
                <th class="">Kosten</th>
                <th class="">Start</th>
                <th class="">Ende</th>
                <th class="">User</th>
                <th class="">IP</th>
            </tr>
            <?php
            ///GET THE DATA FROM NEW BID TO RETRIEVE ITS BIDDING ID
            $newbid = "SELECT * FROM `omt_bids` WHERE `tool_id`=$tool_id ORDER BY timestamp_valid_from DESC;";
            $query = $conn->query($newbid);
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)) {
                    if ( ($row['toolkategorie_id'] != 0) AND ($row['timestamp_valid_from'] != 0 ) ) {
                        $bid = $row['bid_kosten'];
                        $bidid = $row['ID'];
                        $validfrom = $row['timestamp_valid_from'];
                        $validuntil = $row['timestamp_valid_until'];
                        if (9999999999 == $validuntil ) { $validuntil = 0; }
                        $sqlclicks = "SELECT * FROM `omt_clicks` WHERE `bid_id`=$bidid";
                        $clicks_query = $conn->query($sqlclicks);
                        $clickscount = mysqli_num_rows($clicks_query);
                        //calculate actual cost for current bid (coult be lower than actual bidding price!)
                        $sumcosts = 0;
                        while($costrow = mysqli_fetch_assoc($clicks_query)) {
                                $this_bid_kosten = $costrow['bid_kosten'];
                                $sumcosts += $this_bid_kosten;
                        }

                        //end of actual cost calculation!


                        um_fetch_user($row['user_id']);
                        if ($row['user_id'] >0) { $display_name = um_user('display_name'); } else { $display_name = ""; }
                        ?>
                        <tr <?php if ($row['timestamp_valid_until']<1) { print 'class="bid-active"'; } ?>>
                            <td><?php print get_the_category_by_ID($row['toolkategorie_id']); ?></td>
                            <td><?php print $row['bid_kosten']; ?> € / Klick</td>
                            <td><?php print $clickscount;?></td>
                            <td><?php print $sumcosts;?></td>
                            <td><?php
                                $validfromoffset = $row['timestamp_valid_from']+7200; //UTC is 2hours behind, so we fix the displayed timezone according to GMT=> +2hours;
                                //Databank values will be kept in UTC to stay unified/comparable!
                                $date=date_create_from_format("U",$validfromoffset, new DateTimeZone('Europe/Amsterdam'));
                                print $date->format('d.m.Y H:i'); ?></td>
                            <td><?php if ($validuntil>0) {
                                    $validuntiloffset = $row['timestamp_valid_until']+7200; //UTC is 2hours behind, so we fix the displayed timezone according to GMT=> +2hours
                                    $date=date_create_from_format("U",$validuntiloffset, new DateTimeZone('Europe/Amsterdam'));
                                    print $date->format('d.m.Y H:i'); } else { print "aktuell aktiv"; } ?></td>
                            <td><?php print $display_name; ?></td>
                            <td style="word-break: break-all;"><?php print $row['user_ip']; ?></td>
                        </tr>
                        <?php
                    }
                }
            }
            ?>
        </table>
    </div>
<?php } ?>