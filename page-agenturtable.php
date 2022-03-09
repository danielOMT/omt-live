<?php/*
Template Name: Agenturen Übersicht
*/
?>
<?php get_header();
?>
    <div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
<?php if ( is_user_logged_in() ) {
    $current_user_id = get_current_user_id();
    um_fetch_user($current_user_id);
    $display_name = um_user('display_name');
    $user_roles = um_user('roles');
    $area = $_GET['area'];
    $tooldashboardclass = "active";
    ////get post form variables:
    $chk1 = $_POST['chk1'];
    $chk2 = $_POST['chk2'];
    $chk3 = $_POST['chk3'];
    $chk4 = $_POST['chk4'];
    $chk5 = $_POST['chk5'];
    $chk6 = $_POST['chk6'];
    $chk7 = $_POST['chk7'];
    $chk8 = $_POST['chk8'];
    $chk9 = $_POST['chk9'];
    $chk10 = $_POST['chk10'];
    $chk11 = $_POST['chk11'];
    $chk12 = $_POST['chk12'];
    $chk13 = $_POST['chk13'];
    $chk14 = $_POST['chk14'];
    $chk15 = $_POST['chk15'];
    $chk16 = $_POST['chk16'];
    $chk17 = $_POST['chk17'];
    $chk18 = $_POST['chk18'];
    $chk19 = $_POST['chk19'];
    $chk21 = $_POST['chk21'];
    $sortortplz = $_POST['chk20'];
    ///
    if ($user_roles == "administrator" || $user_roles == "um_admin" || in_array('um_admin', $user_roles) || in_array('administrator', $user_roles)) {
        ?>
        <div class="omt-row agentur-table-wrap" style="margin-top: 0px !important;width:100% !important;">
            <?php
            $args = array( //next
                'posts_per_page'    => -1,
                'post_type'         => "agenturen",
                'posts_status'    => array('publish', 'private'),
                'meta_key'			=> 'agentur_rating_manuell',
                'orderby'			=> 'title',
                'order'				=> 'ASC'
                //'meta_query'		=> $meta_query,
                //'meta_key'	        => 'webinar_datum',
                //'meta_type'			=> 'DATETIME',
                //'tax_query'         => $tax_query,
            );
            ?>
            <?php
            $sort = $_GET['sortby'];
            $arr_data = array(); // create empty array
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post();
                if ( get_post_status () != 'draft' ) {
                    $title = get_the_title();
                    $link = get_the_permalink();
                    $webcount++;
                    $einzugsgebiet = get_field('einzugsgebiet');
                    $einzugsgebiet_orte = get_field('einzugsgebiet_orte');
                    $kategorien = get_field('kategorien');
                    $branchen = get_field('branchen');
                    $logo = get_field('logo');
                    $logo_attachment = get_field('logo_attachment');
                    if (strlen($logo['url']) < 2) {
                        $logo['url'] = $logo_attachment;
                    }
                    $logo = $logo['url'];
                    $services = get_field('services');
                    $anzahl_der_mitarbeiter = get_field('anzahl_der_mitarbeiter');
                    $adresse_stadt = get_field('adresse_stadt');
                    $omt_zertifiziert = get_field('omt_zertifiziert');
                    $beschreibung = get_field('beschreibung');
                    $vorschautext = get_field('vorschautext');
                    $location = get_field('google_maps_adresse');
                    $adresse_plz = get_field('adresse_plz');
                    $adresse_stadt = get_field('adresse_stadt');
                    $interne_notizen = get_field('interne_notizen');
                    $zuverlassigkeit = get_field('zuverlassigkeit');
                    $ausgelastet = get_field('ausgelastet');
                    $teuer = get_field('teuer');
                    $arbeitsqualitat = get_field('arbeitsqualitat');
                    $arbeitsgeschwindigkeit = get_field('arbeitsgeschwindigkeit');
                    $ansprechpartner = get_field('agentur_ansprechpartner');
                    $ansprechpartner_email = get_field('agentur_ansprechpartner_email');
                    $kompetenzen = get_field('branchen');

                    if ( strlen($chk1)>0) { $chkfilter1 = true; foreach ($kompetenzen as $kompetenz) { if ("affiliateagentur" == $kompetenz['value']) { $chkfilter1=false;}; } }
                    if ( strlen($chk2)>0) { $chkfilter2 = true; foreach ($kompetenzen as $kompetenz) { if ("contentagentur" == $kompetenz['value']) { $chkfilter2=false;}; } }
                    if ( strlen($chk3)>0) { $chkfilter3 = true; foreach ($kompetenzen as $kompetenz) { if ("cmagentur" == $kompetenz['value']) { $chkfilter3=false;}; } }
                    if ( strlen($chk4)>0) { $chkfilter4 = true; foreach ($kompetenzen as $kompetenz) { if ("conversion" == $kompetenz['value']) { $chkfilter4=false;}; } }
                    if ( strlen($chk5)>0) { $chkfilter5 = true; foreach ($kompetenzen as $kompetenz) { if ("digitalagentur" == $kompetenz['value']) { $chkfilter5=false;}; } }
                    if ( strlen($chk6)>0) { $chkfilter6 = true; foreach ($kompetenzen as $kompetenz) { if ("gaagentur" == $kompetenz['value']) { $chkfilter6=false;}; } }
                    if ( strlen($chk7)>0) { $chkfilter7 = true; foreach ($kompetenzen as $kompetenz) { if ("inboundagentur" == $kompetenz['value']) { $chkfilter7=false;}; } }
                    if ( strlen($chk8)>0) { $chkfilter8 = true; foreach ($kompetenzen as $kompetenz) { if ("internetagentur" == $kompetenz['value']) { $chkfilter8=false;}; } }
                    if ( strlen($chk9)>0) { $chkfilter9 = true; foreach ($kompetenzen as $kompetenz) { if ("linkbuildingagentur" == $kompetenz['value']) { $chkfilter9=false;}; } }
                    if ( strlen($chk10)>0) { $chkfilter10 = true; foreach ($kompetenzen as $kompetenz) { if ("omagentur" == $kompetenz['value']) { $chkfilter10=false;}; } }
                    if ( strlen($chk11)>0) { $chkfilter11 = true; foreach ($kompetenzen as $kompetenz) { if ("seaagentur" == $kompetenz['value']) { $chkfilter11=false;}; } }
                    if ( strlen($chk12)>0) { $chkfilter12 = true; foreach ($kompetenzen as $kompetenz) { if ("seoagentur" == $kompetenz['value']) { $chkfilter12=false;}; } }
                    if ( strlen($chk13)>0) { $chkfilter13 = true; foreach ($kompetenzen as $kompetenz) { if ("smagentur" == $kompetenz['value']) { $chkfilter13=false;}; } }
                    if ( strlen($chk14)>0) { $chkfilter14 = true; foreach ($kompetenzen as $kompetenz) { if ("texterstellung" == $kompetenz['value']) { $chkfilter14=false;}; } }
                    if ( strlen($chk15)>0) { $chkfilter15 = true; foreach ($kompetenzen as $kompetenz) { if ("videoerstellung" == $kompetenz['value']) { $chkfilter15=false;}; } }
                    if ( strlen($chk16)>0) { $chkfilter16 = true; foreach ($kompetenzen as $kompetenz) { if ("webagentur" == $kompetenz['value']) { $chkfilter16=false;}; } }
                    if ( strlen($chk17)>0) { $chkfilter17 = true; foreach ($kompetenzen as $kompetenz) { if ("webdesignagentur" == $kompetenz['value']) { $chkfilter17=false;}; } }
                    if ( strlen($chk18)>0) { $chkfilter18 = true; foreach ($kompetenzen as $kompetenz) { if ("webanalyseagentur" == $kompetenz['value']) { $chkfilter18=false;}; } }
                    if ( strlen($chk19)>0) { $chkfilter19 = true; foreach ($kompetenzen as $kompetenz) { if ("wpagentur" == $kompetenz['value']) { $chkfilter19=false;}; } }
                    if ( strlen($chk21)>0) { $chkfilter21 = true; foreach ($kompetenzen as $kompetenz) { if ("emailagentur" == $kompetenz['value']) { $chkfilter21=false;}; } }

                    if (strlen($vorschautext) > 0) {
                        $vorschautext .= "...";
                    } else {
                        $vorschautext = strip_tags(substr($beschreibung, 0 , 222)) . "...";
                    }
                    $agenturen_data = array(
                        'number' => $webcount,
                        'ID' => get_the_ID(),
                        '$logo' => $logo,
                        '$title' => $title,
                        '$link' => $link,
                        '$location' => $location,
                        '$ansprechpartner' => $ansprechpartner,
                        '$ansprechpartner_email' => $ansprechpartner_email,
                        '$einzugsgebiet_orte' => $einzugsgebiet_orte,
                        '$einzugsgebiet' => $einzugsgebiet,
                        '$kategorien' => $kategorien,
                        '$branchen' => $branchen,
                        '$services' => $services,
                        '$anzahl_der_mitarbeiter' => $anzahl_der_mitarbeiter,
                        '$adresse_plz' => $adresse_plz,
                        '$adresse_stadt' => $adresse_stadt,
                        '$omt_zertifiziert' => $omt_zertifiziert,
                        '$vorschautext' => $vorschautext,
                        '$interne_notizen' => $interne_notizen,
                        '$zuverlassigkeit' => $zuverlassigkeit,
                        '$ausgelastet' => $ausgelastet,
                        '$teuer' => $teuer,
                        '$arbeitsqualitat' => $arbeitsqualitat,
                        '$arbeitsgeschwindigkeit' => $arbeitsgeschwindigkeit,
                    );
                    if (
                            $chkfilter1 != true AND
                            $chkfilter2 != true AND
                            $chkfilter3 != true AND
                            $chkfilter4 != true AND
                            $chkfilter5 != true AND
                            $chkfilter6 != true AND
                            $chkfilter8 != true AND
                            $chkfilter9 != true AND
                            $chkfilter10 != true AND
                            $chkfilter11 != true AND
                            $chkfilter12 != true AND
                            $chkfilter13 != true AND
                            $chkfilter14 != true AND
                            $chkfilter15 != true AND
                            $chkfilter16 != true AND
                            $chkfilter17 != true AND
                            $chkfilter18 != true AND
                            $chkfilter19 != true AND
                            $chkfilter21 != true
                    ) {
                        array_push($arr_data, $agenturen_data);
                    }
                }
            endwhile;
            wp_reset_postdata();

            if ( "sortort" == $sortortplz) { $sort = "ort"; }
            if ( "sortplz" == $sortortplz) { $sort = "plz"; }
            if (isset($sort)) {
                switch ($sort) {
                    case "plz":
                        function sort_plz($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
                        {
                            $t1 = $a['$adresse_plz'];
                            $t2 = $b['$adresse_plz'];
                            return $t1 - $t2;
                        } ///*******end of helper function
                        usort($arr_data, 'sort_plz'); //***sorting the array by initialsort*******/
                        break;
                    case "zuverlassigkeit":
                        function sort_zuverlassigkeit($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
                        {
                            $t1 = $a['$zuverlassigkeit'];
                            $t2 = $b['$zuverlassigkeit'];
                            return $t2 - $t1;
                        } ///*******end of helper function
                        usort($arr_data, 'sort_zuverlassigkeit'); //***sorting the array by initialsort*******/
                        break;
                    case "auslastung":
                        function sort_auslastung($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
                        {
                            $t1 = $a['$ausgelastet'];
                            $t2 = $b['$ausgelastet'];
                            return $t2 - $t1;
                        } ///*******end of helper function
                        usort($arr_data, 'sort_auslastung'); //***sorting the array by initialsort*******/
                        break;
                    case "preis":
                        function sort_preis($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
                        {
                            $t1 = $a['$teuer'];
                            $t2 = $b['$teuer'];
                            return $t2 - $t1;
                        } ///*******end of helper function
                        usort($arr_data, 'sort_preis'); //***sorting the array by initialsort*******/
                        break;
                    case "qualitat":
                        function sort_qualitat($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
                        {
                            $t1 = $a['$arbeitsqualitat'];
                            $t2 = $b['$arbeitsqualitat'];
                            return $t2 - $t1;
                        } ///*******end of helper function
                        usort($arr_data, 'sort_qualitat'); //***sorting the array by initialsort*******/
                        break;
                    case "geschwindigkeit":
                        function sort_geschwindigkeit($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
                        {
                            $t1 = $a['$arbeitsgeschwindigkeit'];
                            $t2 = $b['$arbeitsgeschwindigkeit'];
                            return $t2 - $t1;
                        } ///*******end of helper function
                        usort($arr_data, 'sort_geschwindigkeit'); //***sorting the array by initialsort*******/
                        break;
                    case "ort":
                        function sort_ort($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
                        {
                            return strcmp(strtolower ($a['$adresse_stadt']), strtolower ($b['$adresse_stadt']));
                        } ///*******end of helper function
                        usort($arr_data, 'sort_ort'); //***sorting the array by initialsort*******/
                        break;
                }
            }
            ///ALL AGENTUREN COLLECTED INTO SOME ARRAY; GOING TO WORK AND SORT WITH THOSE MIS NOW
            ?>
            <div style="margin:30px auto; width: 90%; padding: 30px; border: 2px solid #d3d3d3;">
                <h3>Kompetenzen filtern:</h3>
                <form action="<?php print get_the_permalink();?>" method="post">
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk1)>0) {print "checked"; } ?> type="checkbox" value="affiliateagentur" name="chk1"/><span class="label">Affiliate Marketing</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk2)>0) {print "checked"; } ?> type="checkbox" value="contentagentur" name="chk2"/><span class="label">Content</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk3)>0) {print "checked"; } ?> type="checkbox" value="cmagentur" name="chk3"/><span class="label">Content Marketing</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk4)>0) {print "checked"; } ?> type="checkbox" value="conversion" name="chk4"/><span class="label">Conversion Optimierung</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk5)>0) {print "checked"; } ?> type="checkbox" value="digitalagentur" name="chk5"/><span class="label">Digital</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk21)>0) {print "checked"; } ?> type="checkbox" value="emailagentur" name="chk21"/><span class="label">E-Mail-Marketing</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk6)>0) {print "checked"; } ?> type="checkbox" value="gaagentur" name="chk6"/><span class="label">Google Ads</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk7)>0) {print "checked"; } ?> type="checkbox" value="inboundagentur" name="chk7"/><span class="label">Inbound Marketing</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk8)>0) {print "checked"; } ?> type="checkbox" value="internetagentur" name="chk8"/><span class="label">Internet</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk9)>0) {print "checked"; } ?> type="checkbox" value="linkbuildingagentur" name="chk9"/><span class="label">Linkbuilding</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk10)>0) {print "checked"; } ?> type="checkbox" value="omagentur" name="chk10"/><span class="label">Online Marketing</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk11)>0) {print "checked"; } ?> type="checkbox" value="seaagentur" name="chk11"/><span class="label">SEA</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk12)>0) {print "checked"; } ?> type="checkbox" value="seoagentur" name="chk12"/><span class="label">SEO</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk13)>0) {print "checked"; } ?> type="checkbox" value="smagentur" name="chk13"/><span class="label">Social Media</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk14)>0) {print "checked"; } ?> type="checkbox" value="texterstellung" name="chk14"/><span class="label">Texterstellung</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk15)>0) {print "checked"; } ?> type="checkbox" value="videoerstellung" name="chk15"/><span class="label">Videoerstellung</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk16)>0) {print "checked"; } ?> type="checkbox" value="webagentur" name="chk16"/><span class="label">Web</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk17)>0) {print "checked"; } ?> type="checkbox" value="webdesignagentur" name="chk17"/><span class="label">Webdesign</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk18)>0) {print "checked"; } ?> type="checkbox" value="webanalyseagentur" name="chk18"/><span class="label">Webanalyse</span></p>
                    <p class="agenturkompetenz-filter"><input <?php if (strlen($chk19)>0) {print "checked"; } ?> type="checkbox" value="wpagentur" name="chk19"/><span class="label">Wordpress</span></p>
                    <p class="agenturkompetenz-filter agenturkompetenz-radio"><input <?php if ("sortort" == $sortortplz) {print "checked"; } ?> type="radio" value="sortort" name="chk20"/><span class="label">Nach Ort sortieren</span></p>
                    <p class="agenturkompetenz-filter agenturkompetenz-radio"><input <?php if ("sortplz" == $sortortplz) {print "checked"; } ?> type="radio" value="sortplz" name="chk20"/><span class="label">Nach PLZ sortieren</span></p>
                    <input class="agenturkompetenz-submit" type="submit" name="agenturkompetenz-formsubmit" value="Submit" />
                </form>
                <?php
                ?>
            </div>
            <table class="omt-table agenturen-table"  style="margin-top: 0px !important;width:100% !important;">
                <thead>
                <th>#(ID)</th>
                <th style="width:300px;">Name</th>
                <th style="width:300px;">Ansprechpartner</th>
                <th style="width:300px;">Kompetenzen</th>
                <th><a style="color: white !important;" href="?sortby=plz">PLZ</a></th>
                <th><a style="color: white !important;" href="?sortby=ort">ORT</a></th>
                <th style="width:350px;">Notizen</th>
                <th><a style="color: white !important;font-size:10px;" href="?sortby=zuverlassigkeit">Zuverlässigkeit</a></th>
                <th><a style="color: white !important;;font-size:10px;" href="?sortby=qualitat">Qualität</a></th>
                <th><a style="color: white !important;;font-size:10px;" href="?sortby=geschwindigkeit">Geschwindigkeit</a></th>
                </thead>
                <tbody>
                <?php
                foreach ($arr_data as $agentur) { ?>
                    <tr>
                        <td><?php print $agentur['ID'];?></td>
                        <td><a href="<?php print $agentur['$link'];?>" target="_blank"><?php print $agentur['$title'];?></a><br>
                            <a style="font-size:12px; border-bottom: none;" href="https://www.omt.de/wp-admin/post.php?post=<?php print $agentur['ID'];?>&action=edit" target="_blank">(Agentur bearbeiten)</a>
                        </td>
                        <td><?php print $agentur['$ansprechpartner'];?><br>
                            <a style="font-size:12px; border-bottom: none;" href="mailto:<?php print $agentur['$ansprechpartner_email'];?>" target="_blank"><?php print $agentur['$ansprechpartner_email'];?></a>
                        </td>
                        <td><?php
                            $kompetenzen = get_field('branchen', $agentur['ID']);
                            foreach ($kompetenzen as $kompetenz) {
                                print $kompetenz['label'] . "<br/>";
                            }
                            ?></td>
                        <td><?php print $agentur['$adresse_plz'];?></td>
                        <td><?php print $agentur['$adresse_stadt'];?></td>
                        <td><?php print $agentur['$interne_notizen'];?></td>
                        <td><?php print $agentur['$zuverlassigkeit'];?></td>
                        <td><?php print $agentur['$arbeitsqualitat'];?></td>
                        <td><?php print $agentur['$arbeitsgeschwindigkeit'];?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
    <?php } ?>
<?php } ?>
    </div>
<?php get_footer(); ?>