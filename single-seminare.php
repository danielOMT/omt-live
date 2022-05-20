<?php
$header_footer_2020 = 1;
get_header(); ?>

<?php
$ID = get_the_id();
$seminar_name = get_the_title();
$seminar_vorschau_headline = get_field('seminar_vorschau-headline');
$seminar_subheadline = get_field("seminar_subheadline");
$seminar_termine = get_field('seminar_termine');
//datum_und_uhrzeit_start
//datum_und_uhrzeit_ende
//location
$seminar_speaker = get_field("seminar_speaker");
$speaker_image = get_field("profilbild", $seminar_speaker->ID);
$speaker_profil = get_field("beschreibung", $seminar_speaker->ID);
$speakerid = $seminar_speaker->ID;
$seminar_location = get_field("seminar_location");
$preis = get_field("preis");
$seminar_introtext = get_field("seminar_introtext");
$seminar_infopaket = get_field("seminar_infopaket");
$seminar_ubersicht = get_field("seminar_ubersicht");
$seminar_beschreibung = get_field("seminar_beschreibung");
$seminar_agenda = get_field("seminar_agenda"); //achtung: wurde zu "Seminar Ziele" umbenannt, FeldID jedoch bei Agenda gelassen wg. der Inhalte!
$seminar_zielgruppe = get_field("seminar_zielgruppe");
$seminar_kosten_agenda = get_field("seminar_kosten_agenda");
$seminar_kurzfassung_auf_einen_blick = get_field("seminar_kurzfassung_auf_einen_blick");
$youtube_video = get_field("youtube_video");
$stimmen_zum_seminar = get_field("stimmen_zum_seminar");
//teilnehmer_name
//teilnehmer_logo
//teilnehmer_stimme
$seminar_titelbild = get_field('seminar_einzelseite_standard_screen', 576);
$seminar_woocommerce = get_field('seminar_woocommerce');
$featured_img_url = get_the_post_thumbnail_url('full');
$h1 = get_field('seminare_einzelansicht_text', 'options');
$seminar_id=0;
$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($seminar_woocommerce->ID), 'full' );
$image = $featured_image[0];
$titelbild = get_field('titelbild');
if (strlen($titelbild['url'])<1) {
    $titelbild = get_field('seminare_einzelansicht', 'options');
}
////////////////////SEMINAR DATA/ARRAY
$handle=new WC_Product_Variable($seminar_woocommerce->ID);
$available_variations = $handle->get_available_variations();
$variations1=$handle->get_children();
foreach ($variations1 as $seminar_termin) {   /*build array with all seminars and all repeater date fields*/
    //collecting data
    $single_variation = new WC_Product_Variation($seminar_termin);
    //get all attribute fields that have been defined
    $seminar_day = $single_variation->attributes['pa_startdatum'];
    $seminar_time = $single_variation->attributes['pa_startuhrzeit'];
    $seminar_time_end = $single_variation->attributes['pa_enduhrzeit'];
    $seminar_day_end = $single_variation->attributes['pa_enddatum'];
    $termin_location = $single_variation->attributes['pa_location'];
    $termin_image = $single_variation->get_image_id();
    ///hybrid offline/offline IDs einsammeln
    $ticket_variation_id = $single_variation->get_variation_id();
    $online_id = get_post_meta( $ticket_variation_id, 'online_id', true );
    $offline_id = get_post_meta( $ticket_variation_id, 'offline_id', true );
    if (!isset($online_id)) { $online_id = ""; }
    if (!isset($offline_id)) { $offline_id = ""; }
    ///array build starts here
    $seminar_array[$seminar_id]['date'] = $seminar_day;
    $seminar_array[$seminar_id]['name'] = $seminar_name;
    $seminar_array[$seminar_id]['id'] = $ID;
    $seminar_array[$seminar_id]['location'] = $single_variation->attributes['pa_location'];
    $seminar_array[$seminar_id]['speaker'] = $seminar_speaker;
    $seminar_array[$seminar_id]['day_start'] = $seminar_day;
    $seminar_array[$seminar_id]['time_start'] =  $seminar_time;
    $seminar_array[$seminar_id]['day_end'] = $seminar_day_end;
    $seminar_array[$seminar_id]['time_end'] = $seminar_time_end;
    $seminar_array[$seminar_id]['price'] = $single_variation->price;
    $seminar_array[$seminar_id]['regularprice'] = $single_variation->regular_price;
    $seminar_array[$seminar_id]['vid'] = $single_variation->get_variation_id();
    $seminar_array[$seminar_id]['product_id'] = $seminar_woocommerce->ID;
    $seminar_array[$seminar_id]['var_img'] = $termin_image;
    $seminar_array[$seminar_id]['online_id'] = $online_id;
    $seminar_array[$seminar_id]['offline_id'] = $offline_id;
    $seminar_id++;
}
$default = "350-180";
//*****now we have array full with all seminar entries including all repeater field dates
wp_reset_postdata();

/*function date_compare($a, $b) ////***helper function to sort the array by starting date via "date" field ****/
/* {
     $t1 = strtotime($a['date']);
     $t2 = strtotime($b['date']);
     return $t1 - $t2;
 } ///*******end of helper function********/
usort($seminar_array, 'date_compare'); //***sorting the array by date*/
$today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
////////////////////SEMINAR DATA/ARRAY
///
/// FINDING THE NEXT SEMINAR DATE FOR THE SIDEBAR
///
$i = 0;
$has_online = 0;
$has_offline = 0;

foreach ($seminar_array as $seminar){
    if (0 == $i) {
        ///****foreach entry in the array go into the foreach loop***/ ?>
        <?php $seminar_date_compare = strtotime($seminar['date']); //convert seminar date to unix string for future-check the entries ?>
        <?php if ($today_date <= $seminar_date_compare) { ///if current time < seminar-time, event is in the future, so we can proceed and create the output for the seminar entry
            $i++;
            $next_date = $seminar['day_start'];
            $next_date_end = $seminar['day_end'];
            $next_time = $seminar['time_start'];
            $next_time_end = $seminar['time_end'];
            $next_location_url = get_the_permalink($seminar['location']);
            $next_location_stadt_placeholder = get_field('location_stadtname', $seminar['location']);
            if (!strstr($next_location_stadt_placeholder, "Online")) {
                $has_offline++;
                $next_location_stadt = get_field('location_stadtname', $seminar['location']);
                if (strlen($seminar['online_id'])>0) {
                    $next_location_stadt .= " / Online";
                    $has_online++;
                }
            } else { //next termin is an online date, find out if it has offline variation attached
                $has_online++;
                if (strlen($seminar['offline_id'])>0) {
                    foreach ($seminar_array as $seminar_offline) { //search the array for offline id variation
                        if ($seminar_offline['offline_id'] == $seminar['online_id'])
                            $next_location_stadt = get_field('location_stadtname', $seminar_offline['location']) . " / Online";
                        $has_offline++;
                    }
                } else { //only online dates available
                    $next_location_stadt = get_field('location_stadtname', $seminar['location']);
                }
            }
            $next_price = $seminar['price'];
        } //end of if query for future-check
    } //end of if query for future-check
} //end of loop through foreach seminar item
$terminlocations_label = 'Remote oder "vor Ort" buchbar';
if ( ($has_offline>0) AND ($has_online<1)) {
    $terminlocations_label = "Nur als Offline-Seminar buchbar";
} elseif (($has_offline<1) AND ($has_online>0)) {
    $terminlocations_label = "Nur als Online-Seminar buchbar";
}
if (0 != $i) { $hat_termine = true; } else { $hat_termine = false; }
///
/// FINDING THE NEXT SEMINAR DATE FOR THE SIDEBAR
$seminar_preis = get_field("seminar_preis");
if (strlen($seminar_preis)>0) { $next_price = $seminar_preis; }
?>
    <div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
        <div class="hero-header header-flat" style="background: url('<?php print $titelbild['url'];?>') no-repeat 50% 0;">
            <div class="wrap">
                <h1><?php print get_the_title();?></h1>
            </div>
        </div>
        <div id="inner-content" class="clearfix">
            <div id="main" class="seminar-single no-margin-top clearfix" role="main">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article style="" id="post-<?php the_ID(); ?>" class="clearfix omt-row" role="article">
                        <section class="entry-content clearfix" itemprop="articleBody">
                            <div class="module-tabs">
                                <!-- Tab links -->
                                <div class="tab highlight-last tab-buttons termine-sticky">
                                    <div class="seminar-header-sticky">
                                        <?php /*<h3 class="sticky-title">
                                        <span class="title-span"><?php print $seminar_vorschau_headline;?><br><span class="seminar-speakers"> mit <?php $i=0; foreach ($seminar_speaker as $speaker) { if ($i>0) { print ", "; } print get_the_title($speaker->ID); $i++; } ?></span></span>
                                        <div>
                                            <a class="button button-red button-350px sticky-termine" href="#selected" class="" onclick="openTab(event, 'termine')">Termine</a>
                                            <?php if (strlen($seminar_infopaket)>0) {?><a class="button button-red button-350px sticky-termine"  style="" target="_blank" href="<?php print $seminar_infopaket;?>">Infopaket</a><?php } ?>
                                        </div>
                                    </h3>*/?>
                                        <div class="sticky-buttons">
                                            <?php if (strlen($seminar_ubersicht)>0) { ?><span class="tablinks active" onclick="openTab(event, 'ubersicht')">Übersicht</span><?php } ?>
                                            <?php if (strlen($seminar_agenda)>0) { ?><span class="tablinks " onclick="openTab(event, 'agenda')">Agenda</span><?php } ?>
                                            <?php if (strlen($seminar_zielgruppe)>0) { ?><span class="tablinks " onclick="openTab(event, 'zielgruppe')">Zielgruppe</span><?php } ?>
                                            <?php if (strlen($seminar_beschreibung)>0) { ?><span class="tablinks " onclick="openTab(event, 'beschreibung')">Beschreibung</span><?php } ?>
                                            <span class="tablinks" onclick="openTab(event, 'experte')">Experte</span>
                                            <?php if (strlen($stimmen_zum_seminar[0]['teilnehmer_stimme'])>0) { ?><span class="tablinks " onclick="openTab(event, 'teilnehmerstimmen')">Teilnehmerstimmen</span><?php } ?>
                                            <?php if ( (strlen($next_date)>0) OR ( strlen($seminar_infopaket )<1) ) {?><span class="tablinks tablinks-termine stayvisible" onclick="openTab(event, 'termine')">Termine</span><?php } ?>
                                            <?php if (strlen($seminar_infopaket)>0) {?><span class="tablinks tablinks-infopaket"  style="" target="_blank" href="<?php print $seminar_infopaket;?>">Infopaket</span><?php } ?>
                                        </div>
                                        <?php if (strlen($seminar_ubersicht)>0) { ?><span class="no-sticky tablinks active" onclick="openTab(event, 'ubersicht')">Übersicht</span><?php } ?>
                                        <?php if (strlen($seminar_agenda)>0) { ?><span class="no-sticky tablinks " onclick="openTab(event, 'agenda')">Agenda</span><?php } ?>
                                        <?php if (strlen($seminar_zielgruppe)>0) { ?><span class="no-sticky tablinks " onclick="openTab(event, 'zielgruppe')">Zielgruppe</span><?php } ?>
                                        <?php if (strlen($seminar_beschreibung)>0) { ?><span class="no-sticky tablinks " onclick="openTab(event, 'beschreibung')">Beschreibung</span><?php } ?>
                                        <span class="no-sticky tablinks " onclick="openTab(event, 'experte')">Experte</span>
                                        <?php if (strlen($stimmen_zum_seminar[0]['teilnehmer_stimme'])>0) { ?><span class="tablinks no-sticky" onclick="openTab(event, 'teilnehmerstimmen')">Teilnehmerstimmen</span><?php } ?>
                                        <span class="tablinks tabbutton-termine" onclick="openTab(event, 'termine')">Termine & Anmeldung</span>
                                        <?php if (strlen($seminar_infopaket)>0) {?><a style="" target="_blank" href="<?php print $seminar_infopaket;?>" class="tablinks tabbutton-termine tabbutton-infopaket">Infopaket bestellen</a><?php } ?>
                                    </div>
                                    <div class="seminar-buttons-mobile display-none">
                                        <span onclick="openTab(event, 'termine')">Termine</span>
                                        <?php if (strlen($seminar_infopaket)>0) {?><a class=""  style="" target="_blank" href="<?php print $seminar_infopaket;?>">Infopaket</a><?php } ?>
                                    </div>
                                </div>
                                <!-- Tab content -->
                                <div class="seminare-content-wrap wrap">
                                    <section class="omt-row omt-intro wrap article-header page-intro">
                                        <?php /*img class="article-hero" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $titelbild['url'];?>" />*/?>
                                        <?php /*<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>*/?>
                                        <?php print $seminar_introtext;?>
                                    </section>
                                    <div class="tab-content module-with-sidebar">
                                        <span id="selected" class="anchor"></span>
                                        <?php if (strlen($seminar_ubersicht)>0) { ?><div id="ubersicht" class="tabcontent untabbed" style="display:flex;"><?php print $seminar_ubersicht;?></div><?php } ?>
                                        <?php if (strlen($seminar_agenda)>0) { ?><div id="agenda" class="tabcontent untabbed"><?php print $seminar_agenda;?></div><?php } ?>
                                        <?php if (strlen($seminar_zielgruppe)>0) { ?><div id="zielgruppe" class="tabcontent untabbed"><?php print $seminar_zielgruppe;?></div><?php } ?>
                                        <?php if (strlen($seminar_beschreibung)>0) { ?><div id="beschreibung" class="tabcontent untabbed"><?php print $seminar_beschreibung;?></div><?php } ?>
                                        <div id="experte" class="tabcontent untabbed">
                                            <section class="omt-row wrap">
                                                <?php foreach ($seminar_speaker as $speaker) {
                                                    $speaker_image = get_field("profilbild", $speaker->ID);
                                                    $speaker_profil = get_field("beschreibung", $speaker->ID);
                                                    $speaker_titel = get_field("titel", $speaker->ID);
                                                    ?>
                                                    <h2 class="">Der Seminar-Referent</h2>
                                                    <div class="testimonial card clearfix speakerprofil no-margin-top">
                                                        <h3 class="experte"><a target="_self" href="<?php print the_permalink($speaker->ID);?>"><?php print $speaker->post_title;?></a></h3>
                                                        <div class="testimonial-img">
                                                            <a target="_self" href="<?php print the_permalink($speaker->ID);?>">
                                                                <img class="teaser-img" alt="<?php print $speaker_image['alt'];?>" title="<?php print $speaker_image['alt'];?>" src="<?php print $speaker_image['sizes']['350-180'];?>"/>
                                                            </a>
                                                        </div>
                                                        <div class="testimonial-text">
                                                            <?php print $speaker_profil;?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </section>
                                        </div>
                                        <?php if (strlen($stimmen_zum_seminar[0]['teilnehmer_stimme'])>0) { ?><div id="teilnehmerstimmen" class="tabcontent untabbed">
                                            <section class="omt-row testimonial-wrap">
                                                <?php foreach ($stimmen_zum_seminar as $testimonial) { ?>
                                                    <div class="testimonial testimonial-slide card clearfix" style="width: 100%;">
                                                        <div class="testimonial-text">
                                                            <div class="teaser-cat">
                                                                <?php print $testimonial['teilnehmer_name'];?>
                                                            </div>
                                                            <p><?php print $testimonial['teilnehmer_stimme'];?></p>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </section>
                                            </div><?php } ?>
                                        <div id="termine" class="tabcontent tab-termine untabbed">
                                            <section class="omt-module seminare-wrap  warteliste-wrap">
                                                <?php if (false != $hat_termine) { ?>
                                                    <h2>Die nächsten Termine:</h2>
                                                <?php } ?>
                                                <span class="anchor" id="termine"></span>

                                                <div class="seminare-wrap seminartermine teaser-modul">
                                                    <?php
                                                    if ( (false == $hat_termine) AND ( strlen($seminar_infopaket )<1) ) { ?>
                                                        <div class="testimonial card clearfix" style="max-width:100%;">
                                                            <div class="testimonial-text" style="width:100%;">
                                                                <h4 class="no-margin-bottom" style="width:100%;text-align:center;">Die neuen Seminartermine präsentieren wir hier in Kürze</h4>
                                                                <?php echo do_shortcode( '[gravityform id="30" title="false" description="false" tabindex="0"]' ); ?>
                                                            </div>
                                                        </div>
                                                    <?php }
                                                    $i = 0;
                                                    foreach ($seminar_array as $seminar){
                                                        if (strlen($seminar['offline_id'])<1) {
                                                            $speakername = "";
                                                            $i=0;
                                                            foreach ($seminar['speaker'] as $helper) {
                                                                $i++;
                                                                if ($i>1) { $speakername .= ", "; }
                                                                $speakername .= get_the_title($helper->ID);
                                                            }
                                                            ///****foreach entry in the array go into the foreach loop***/ ?>
                                                            <?php $seminar_date_compare = strtotime($seminar['date']); //convert seminar date to unix string for future-check the entries ?>
                                                            <?php if ($today_date <= $seminar_date_compare) { ///if current time < seminar-time, event is in the future, so we can proceed and create the output for the seminar entry?>
                                                                <?php
                                                                $i++;
                                                                $img_atts = wp_get_attachment_image_src( $seminar['var_img'], $default );
                                                                $img_src = $img_atts[0];
                                                                $hotel_adresse = get_field('hotel_adresse', $seminar['location']);
                                                                ?>
                                                                <?php /*SET SCHEMA JSON-LD BEFORE EACH SEMINAR DATE AUTOMATICALLY!:*/?>
                                                                <script type='application/ld+json'>
                                                                [
                                                                    {
                                                                        "@context": "https://schema.org",
                                                                        "@type": "EducationEvent",
                                                                        "name": "&#x1F6A9;<?php the_title_attribute(array('post' => $seminar['id'])); ?>",
                                                                        "description": "<?php print str_replace('"', "'", strip_tags(get_field('seminar_beschreibung', $seminar['id']))) ?>",
                                                                        "url": "<?php echo get_the_permalink() ?>",
                                                                        "image": "<?php print $img_src; ?>",
                                                                        "startDate": "<?php print date("Y-m-d", strtotime($seminar['day_start'])) ?>T<?php print str_replace('-', ':', $seminar['time_start']) ?><?php echo wp_timezone()->getName() ?>",
                                                                        "endDate": "<?php print date("Y-m-d", strtotime($seminar['day_end'])) ?>T<?php print str_replace('-', ':', $seminar['time_end']) ?><?php echo wp_timezone()->getName() ?>",
                                                                        "eventStatus": "https://schema.org/EventScheduled",
                                                                        "eventAttendanceMode": "<?php echo schemaEventAttendanceMode($seminar, true) ?>",
                                                                        "performer": {
                                                                            "@type": "Person",
                                                                            "name": "<?php print $speakername;?>"
                                                                        },
                                                                        "location": {
                                                                            "@type": "Place",
                                                                            "name": "<?php print get_the_title($seminar['location']);?>",
                                                                            "address": {
                                                                                "@type": "PostalAddress",
                                                                                "streetAddress": "<?php print get_field('location_street', $seminar['location']); ?>",
                                                                                "addressLocality": "<?php print get_field('location_stadtname', $seminar['location']); ?>",
                                                                                "postalCode": "<?php print get_field('location_plz', $seminar['location']); ?>",
                                                                                "addressCountry": "DE"
                                                                            }
                                                                        },
                                                                        "offers": {
                                                                            "@type": "Offer",
                                                                            "validFrom": "<?php echo $newdate = date("Y-m-d", strtotime("-1 months"));?>",
                                                                            "name": "<?php the_title_attribute(array('post' => $seminar['id'])); ?> in <?php print get_field('location_stadtname', $seminar['location']); ?>",
                                                                            "price":"<?php print $seminar['price'];?>",
                                                                            "priceCurrency": "EUR",
                                                                            "url": "<?php print get_the_permalink();?>",
                                                                            "availability": "https://schema.org/InStock"
                                                                        },
                                                                        "organizer": {
                                                                            "@type": "Organization",
                                                                            "name": "<?php echo get_bloginfo('name') ?>",
                                                                            "url": "<?php echo get_site_url() ?>"
                                                                        }
                                                                    }
                                                                ]
                                                            </script>
                                                                <div class="omt-seminar seminartermin teaser teaser-small">
                                                                <span id="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>" <?php /*href="/kasse/?add-to-cart=<?php print $seminar_woocommerce->ID;?>&attribute_pa_startdatum=<?php print $seminar['day_start'];?>&attribute_pa_enddatum=<?php print $seminar['day_end'];?>&attribute_pa_startuhrzeit=<?php print $seminar['time_start'];?>&attribute_pa_enduhrzeit=<?php print $seminar['time_end'];?>&attribute_pa_location=<?php print $seminar['location'];?>&speaker_id=<?php print $seminar_speaker->ID;?>"*/?> title="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>">
                                                                    <img
                                                                            class="teaser-img seminar-image"
                                                                            alt="<?php print get_the_title();?> in <?php print get_field('location_stadtname', $seminar['location']); ?>"
                                                                            title="<?php print get_the_title();?> in <?php print get_field('location_stadtname', $seminar['location']); ?>"
                                                                            src="<?php print $img_src;?>"
                                                                    />
                                                                </span>

                                                                    <div class="webinar-meta">
                                                                        <p class="teaser-cat">
                                                                            <?php if ($seminar['day_start'] == $seminar['day_end']) {
                                                                                print str_replace('-','.',$seminar['day_start']);
                                                                            } else {
                                                                                print str_replace('-','.',$seminar['day_start']) . " - " . str_replace('-','.',$seminar['day_end']);
                                                                            } ?><br/>
                                                                            <?php print str_replace('-',':',$seminar['time_start']) . " Uhr - " . str_replace('-',':',$seminar['time_end']) . " Uhr"; ?></p>
                                                                        <b>
                                                                            <?php $location_stadtname = get_field('location_stadtname', $seminar['location']);
                                                                            if ($location_stadtname != "Online Seminar") { ?>
                                                                            <span style="display:block;width:100%;padding-left:10px;padding-right:10px;">in&nbsp;<a href="<?php print get_the_permalink($seminar['location']); ?>">
                                                                            <?php } ?>
                                                                                    <?php if ($location_stadtname != "Online Seminar") { ?>
                                                                                        <div class="tooltip"><?php print get_field('location_stadtname', $seminar['location']); ?><span class="tooltiptext"><h4><?php print get_the_title($seminar['location']);?></h4><?php print $hotel_adresse['address'];?></span></div>
                                                                                    <?php } else { print "<div style='padding-left:10px;'>Online Seminar</div>"; } ?>
                                                                            <?php if ($location_stadtname != "Online Seminar") { ?>
                                                                            </a></span>
                                                                        <?php } ?></b>
                                                                        <span style="display:block;width:100%;padding-right:10px;<?php if ($location_stadtname == "Online Seminar") { print "padding-left:0px;"; } else { print "padding-left:10px;"; } ?>"><?php if ($seminar['regularprice'] != $seminar['price']) { ?><span class="discountbadge">10%</span><?php } ?>
                                                                            <?php if ($seminar['regularprice'] != $seminar['price']) { print "<del>" . $seminar['regularprice'] . "  €</del>";}?>
                                                                            <?php print $seminar['price'];?> € <span class="small">zzgl. 19% MwSt.</span></span>
                                                                    </div>
                                                                    <?php /* <a class="a a-730px a-blue" id="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>" href="/kasse/?add-to-cart=<?php print $seminar_woocommerce->ID;?>&variation_id=<?php print $seminar['vid'];?>" title="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>">*/ ?>
                                                                    <?php /* <a class="button button-730px button-blue" id="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>" href="/kasse/?add-to-cart=<?php print $seminar_woocommerce->ID;?>&attribute_pa_startdatum=<?php print $seminar['day_start'];?>&attribute_pa_enddatum=<?php print $seminar['day_end'];?>&attribute_pa_startuhrzeit=<?php print $seminar['time_start'];?>&attribute_pa_enduhrzeit=<?php print $seminar['time_end'];?>&attribute_pa_location=<?php print $seminar['location'];?>&speaker_id=<?php print $speakerid;?>" title="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>">*/?>
                                                                    <a class="button button-730px button-blue" id="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>" href="/kasse/?add-to-cart=<?php print $seminar['vid'];?>" title="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>">
                                                                        Jetzt <?php if (strlen($seminar['online_id'])>0) { print "vor Ort-Teilnahme "; } ?>Buchen
                                                                    </a>
                                                                    <?php if (strlen($seminar['online_id'])>0) {?>
                                                                        <a class="button button-730px button-blue no-margin-top hybrid-buchen-button" style="" id="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>" href="/kasse/?add-to-cart=<?php print $seminar['online_id'];?>" title="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>">
                                                                            Jetzt Online-Teilnahme Buchen <span class="discountbadge">10%</span>
                                                                        </a>
                                                                    <?php } ?>
                                                                    <?php if (strlen($seminar_infopaket)>0) { ?>
                                                                        <a class="button button-red has-margin-top-30" target="_blank" href="<?php print $seminar_infopaket;?>">Infopaket</a>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php
                                                            } //end of if query for future-check
                                                        } //end of check if item has an offline-ID attached where it would be displayed on (hybride seminare)
                                                    } //end of loop through foreach seminar item
                                                    ?>
                                                </div>
                                                <?php if ( ( $i == 0)  AND ( $countonly == false ) AND ( strlen($seminar_infopaket )<1) ) { ?>
                                                    <div class="testimonial card clearfix warteliste-wrap">
                                                        <div class="testimonial-text" style="width:100%;">
                                                            <h4 class="no-margin-bottom" style="width:100%;text-align:center;">Die neuen Seminartermine präsentieren wir hier in Kürze</h4>
                                                            <?php echo do_shortcode( '[gravityform id="30" title="false" description="false" tabindex="0"]' ); ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="seminar-sidebar-spacer sidebar">
                                        <div id="seminar-sidebar">
                                            <?php
                                            $teilnehmer = get_field('teilnehmer');
                                            $proven_expert_snippet = get_field('proven_expert_snippet');
                                            $vorteile_auf_einen_blick_headline = get_field('vorteile_auf_einen_blick_headline', 'options');
                                            $vorteile_auf_einen_blick = get_field('vorteile_auf_einen_blick', 'options'); //stichpunkt
                                            $noch_fragen_headline = get_field('noch_fragen_headline', 'options');
                                            $noch_fragen_text = get_field('noch_fragen_text', 'options');
                                            $noch_fragen_rufnummer = get_field('noch_fragen_rufnummer', 'options');
                                            $noch_fragen_text_unter_rufnummer = get_field('noch_fragen_text_unter_rufnummer', 'options');
                                            $noch_fragen_bild = get_field('noch_fragen_bild', 'options');
                                            /////
                                            /*
                                            $next_date = $seminar['day_start'];
                                            $next_date_end = $seminar['day_end'];
                                            $next_time = $seminar['time_start'];
                                            $next_time_end = $seminar['time_end'];
                                            $next_location_url = get_the_permalink($seminar['location']);
                                            $next_location_stadt = get_field('location_stadtname', $seminar['location']);
                                            $next_price = $seminar['price'];
                                            */
                                            ?>
                                            <div class="widget widget-shortinfo">
                                                <?php if(strlen($vorteile_auf_einen_blick_headline)>0) { ?><h4 class="widgettitle"><?php print $vorteile_auf_einen_blick_headline;?></h4><?php } ?>
                                                <?php if (strlen($vorteile_auf_einen_blick[0]['stichpunkt'])>0) { ?>
                                                    <ul class="check">
                                                        <?php foreach($vorteile_auf_einen_blick as $vorteil) { ?><li><?php print $vorteil['stichpunkt'];?></li><?php } ?>
                                                        <li><?php print $terminlocations_label;?></li>
                                                        <li>
                                                            <div style="display:flex;flex-wrap:wrap;">
                                                                <div style="margin-right:10px;">Referent<?php if(count($seminar_speaker)>1){print"en";}?>:</div>
                                                                <div>
                                                                    <?php
                                                                    $count = 0;
                                                                    foreach ($seminar_speaker as $speaker) {
                                                                        if ($count>0 AND $count != count($seminar_speaker)) { ?><br/><?php } ?>
                                                                        <a target="_self" href="<?php print the_permalink($speaker->ID);?>"><b><?php print $speaker->post_title;?></b></a>
                                                                        <?php
                                                                        $count++;
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php //if ($next_price>0) {
                                                        if (strlen($next_price)<1) { $next_price = "auf Anfrage"; } ?>
                                                        <li><strong>Preis: </strong><?php print $next_price;?></li>
                                                        <?php //} ?>
                                                        <?php if (strlen($next_date)>0) {?>
                                                            <li><b>Nächster Termin am:</b><br/>
                                                                <?php if ($next_date == $next_date_end) {
                                                                    print str_replace('-','.',$next_date);
                                                                } else {
                                                                    print str_replace('-','.',$next_date) . " - " . str_replace('-','.',$next_date_end);
                                                                } ?><?php if ("Online Seminar" != $next_location_stadt) { print "in"; } else { print ":"; }?> <?php print $next_location_stadt;?></li>
                                                        <?php } else { ?>
                                                            <li><b>Nächster Termin:</b> in Planung</li>
                                                        <?php } ?>
                                                    </ul>
                                                    <?php if (strlen($next_date)>0) {?>
                                                        <span class="button button-red" style="margin-top: 10px;" onclick="openTab(event, 'termine')">Alle Termine</span>
                                                        <?php /*<a class="a a-730px a-blue" id="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>" href="/kasse/?add-to-cart=<?php print $seminar_woocommerce->ID;?>&attribute_pa_startdatum=<?php print $seminar['day_start'];?>&attribute_pa_enddatum=<?php print $seminar['day_end'];?>&attribute_pa_startuhrzeit=<?php print $seminar['time_start'];?>&attribute_pa_enduhrzeit=<?php print $seminar['time_end'];?>&attribute_pa_location=<?php print $seminar['location'];?>&speaker_id=<?php print $seminar_speaker->ID;?>" title="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>">*/?>
                                                    <?php } ?>
                                                    <?php if ( ( strlen($next_date)<1) AND (strlen($seminar_infopaket)<1) ) {?>
                                                        <span class="button button-red" style="margin-top: 10px;" onclick="openTab(event, 'termine')">Zur Warteliste</span>
                                                        <?php /*<a class="a a-730px a-blue" id="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>" href="/kasse/?add-to-cart=<?php print $seminar_woocommerce->ID;?>&attribute_pa_startdatum=<?php print $seminar['day_start'];?>&attribute_pa_enddatum=<?php print $seminar['day_end'];?>&attribute_pa_startuhrzeit=<?php print $seminar['time_start'];?>&attribute_pa_enduhrzeit=<?php print $seminar['time_end'];?>&attribute_pa_location=<?php print $seminar['location'];?>&speaker_id=<?php print $seminar_speaker->ID;?>" title="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>">*/?>
                                                    <?php } ?>
                                                    <?php if (strlen($seminar_infopaket)>0) { ?>
                                                        <a class="button button-red has-margin-top-30" target="_blank" href="<?php print $seminar_infopaket;?>">Infopaket</a>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <?php
                                            $seminar_video_wistia_id = get_field('seminar_video_wistia_id');
                                            if (strlen($seminar_video_wistia_id)>0) {
                                                $seminar_video_titel = get_field('seminar_video_titel');
                                                if (strlen($seminar_video_titel)<1) {$seminar_video_titel = "Gründe für das Seminar:"; }
                                                ?>
                                                <div class="widget widget-seminarvideo">
                                                    <h4 class="widgettitle"><?php print $seminar_video_titel;?></h4>
                                                    <div class="video_wrap no-margin-bottom">
                                                        <div class="webinar-video">
                                                            <div class="video-wrap no-margin-bottom">
                                                                <script src="//fast.wistia.com/embed/medias/<?php print $seminar_video_wistia_id;?>.jsonp" async></script>
                                                                <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                                                                <div class="wistia_responsive_padding">
                                                                    <div class="wistia_responsive_wrapper">
                                                                        <div class="wistia_embed wistia_async_<?php print $seminar_video_wistia_id;?>">&nbsp;</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if (strlen($teilnehmer[0]['url'])>0) {?>
                                                <div class="widget widget-seminarteilnehmer">
                                                    <h4 class="widgettitle">Diese Firmen haben unser Seminar besucht:</h4>
                                                    <?php foreach ($teilnehmer as $img) { ?>
                                                        <img alt="<?php print $img['alt'];?>" title="<?php print $img['alt'];?>" src="<?php print $img['sizes']['350-180'];?>"/>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            <?php if (strlen($proven_expert_snippet)>0) { ?>
                                                <div class="widget">
                                                    <?php print $proven_expert_snippet;?>
                                                </div>
                                            <?php } ?>
                                            <?php $expertensiegel = get_field('expertensiegel', 'options');
                                            if (strlen($expertensiegel['url'])>0) { ?>
                                                <div class="widget widget-expertensiegel">
                                                    <img class="expertensiegel" alt="<?php print $expertensiegel['alt'];?>" title="<?php print $expertensiegel['alt'];?>" src="<?php print $expertensiegel['url'];?>">
                                                </div>
                                            <?php } ?>
                                            <?php if(strlen($noch_fragen_headline)>0 OR strlen($noch_fragen_text)>0 OR strlen($noch_fragen_rufnummer)>0) { ?>
                                                <div class="widget widget-nochfragen">
                                                    <div class="widgettitle">
                                                        <?php if (strlen($noch_fragen_headline)>0) { ?><h4 class="widgettitle"><?php print $noch_fragen_headline;?></h4><?php } ?>
                                                        <?php if (strlen($noch_fragen_text)>0) { ?><p class="noch-fragen-text"><?php print $noch_fragen_text;?></p><?php } ?>
                                                        <?php if (strlen($noch_fragen_rufnummer)>0) { ?><a href="tel:+49<?php print substr(str_replace(" - ", "", $noch_fragen_rufnummer), 1);?>" class="noch-fragen-rufnummer"><?php print $noch_fragen_rufnummer;?></a><?php } ?>
                                                        <?php if (strlen($noch_fragen_text_unter_rufnummer)>0) { ?><p class="noch-fragen-after-rufnummer"><?php print $noch_fragen_text_unter_rufnummer;?></p><?php } ?>
                                                        <?php if (strlen($noch_fragen_bild['url'])>0) { ?><img class="noch-fragen-kontakt" alt="<?php print $noch_fragen_bild['alt'];?>" title="<?php print $noch_fragen_bild['alt'];?>" src="<?php print $noch_fragen_bild['sizes']['350-180'];?>"/><?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if (false != $hat_termine) { ?>
                                            <div class="widget widget-sidebartermine">
                                                <h4 class="widgettitle">Die nächsten Termine:</h4>
                                                <?php } ?>
                                                <div class="seminartermine-list">
                                                    <?php
                                                    if ( (false == $hat_termine) AND ( strlen($seminar_infopaket )<1) ) { ?>
                                                        <div class="testimonial card clearfix" style="max-width:100%;">
                                                            <div class="testimonial-text" style="width:100%;">
                                                                <h4 class="no-margin-bottom" style="width:100%;text-align:center;">Die neuen Seminartermine präsentieren wir hier in Kürze</h4>
                                                                <?php echo do_shortcode( '[gravityform id="30" title="false" description="false" tabindex="0"]' ); ?>
                                                            </div>
                                                        </div>
                                                    <?php }
                                                    $i = 0;
                                                    foreach ($seminar_array as $seminar){
                                                        if (strlen ($seminar['offline_id'])<1) {
                                                            $speakername = "";
                                                            $i=0;
                                                            foreach ($seminar['speaker'] as $helper) {
                                                                $i++;
                                                                if ($i>1) { $speakername .= ", "; }
                                                                $speakername .= get_the_title($helper->ID);
                                                            }
                                                            ///****foreach entry in the array go into the foreach loop***/ ?>
                                                            <?php $seminar_date_compare = strtotime($seminar['date']); //convert seminar date to unix string for future-check the entries ?>
                                                            <?php if ($today_date <= $seminar_date_compare) { ///if current time < seminar-time, event is in the future, so we can proceed and create the output for the seminar entry?>
                                                                <?php
                                                                $i++;
                                                                $img_atts = wp_get_attachment_image_src( $seminar['var_img'], $default );
                                                                $img_src = $img_atts[0];
                                                                $hotel_adresse = get_field('hotel_adresse', $seminar['location']);
                                                                ?>
                                                                <?php /*SET SCHEMA JSON-LD BEFORE EACH SEMINAR DATE AUTOMATICALLY!:*/?>
                                                                <div class="omt-seminar seminartermin seminartermin-listitem">
                                                                    <p class="teaser-cat">
                                                                        <?php if ($seminar['day_start'] == $seminar['day_end']) {
                                                                            print str_replace('-','.',$seminar['day_start']);
                                                                        } else {
                                                                            print str_replace('-','.',$seminar['day_start']) . " - " . str_replace('-','.',$seminar['day_end']);
                                                                        } ?><br/>
                                                                        <?php print str_replace('-',':',$seminar['time_start']) . " Uhr - " . str_replace('-',':',$seminar['time_end']) . " Uhr"; ?></p>
                                                                    <b>
                                                                        <?php $location_stadtname = get_field('location_stadtname', $seminar['location']);
                                                                        if ($location_stadtname != "Online Seminar") { ?>
                                                                        in&nbsp;<a href="<?php print get_the_permalink($seminar['location']); ?>">
                                                                            <?php } ?>
                                                                            <?php if ($location_stadtname != "Online Seminar") { ?>
                                                                            <div class="tooltip"><?php print get_field('location_stadtname', $seminar['location']); ?><span class="tooltiptext"><h4><?php print get_the_title($seminar['location']);?></h4><?php print $hotel_adresse['address'];?></span></div>
                                                                    <?php } else { print "<div>Online Seminar</div>"; } ?>
                                                                            <?php if ($location_stadtname != "Online Seminar") { ?>
                                                                        </a>
                                                                    <?php } ?></b>
                                                                    <?php if ($seminar['regularprice'] != $seminar['price']) { ?><span class="discountbadge" style="<?php if ($location_stadtname == "Online Seminar") { print "margin-left:0px;!important"; } ?>">10%</span><?php } ?>
                                                                    <p><?php if ($seminar['regularprice'] != $seminar['price']) { print "<del>" . $seminar['regularprice'] . "  €</del>";}?>
                                                                        <?php print $seminar['price'];?> € <span class="small">zzgl. 19% MwSt.</span></p>
                                                                    <?php /* <a class="a a-730px a-blue" id="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>" href="/kasse/?add-to-cart=<?php print $seminar_woocommerce->ID;?>&variation_id=<?php print $seminar['vid'];?>" title="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>">*/ ?>
                                                                    <?php /* <a class="button button-730px button-blue" id="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>" href="/kasse/?add-to-cart=<?php print $seminar_woocommerce->ID;?>&attribute_pa_startdatum=<?php print $seminar['day_start'];?>&attribute_pa_enddatum=<?php print $seminar['day_end'];?>&attribute_pa_startuhrzeit=<?php print $seminar['time_start'];?>&attribute_pa_enduhrzeit=<?php print $seminar['time_end'];?>&attribute_pa_location=<?php print $seminar['location'];?>&speaker_id=<?php print $speakerid;?>" title="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>">*/?>
                                                                    <a class="button button-730px button-blue" id="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>" href="/kasse/?add-to-cart=<?php print $seminar['vid'];?>" title="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>">
                                                                        Jetzt <?php if (strlen($seminar['online_id'])>0) { print "vor Ort-Teilnahme "; } ?>Buchen
                                                                    </a>
                                                                    <?php if (strlen($seminar['online_id'])>0) {?>
                                                                        <a class="button button-730px button-blue no-margin-top hybrid-buchen-button" id="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>" href="/kasse/?add-to-cart=<?php print $seminar['online_id'];?>" title="<?php the_title_attribute(array('post'=>$seminar['id'])); ?>">
                                                                            Jetzt Online-Teilnahme Buchen <span class="discountbadge">10%</span>
                                                                        </a>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php
                                                            } //end of if query for future-check
                                                        } //end of checkfor offline id
                                                    } //end of loop through foreach seminar item
                                                    ?>
                                                    <?php if (false != $hat_termine) { ?></div><?php } ?>
                                                <?php if ($i == 0 AND $countonly == false) { ?>
                                                    <div class="testimonial card clearfix">
                                                        <div class="testimonial-text" style="width:100%;">
                                                            <h4 class="no-margin-bottom" style="width:100%;text-align:center;">Die neuen Seminartermine präsentieren wir hier in Kürze</h4>
                                                            <?php echo do_shortcode( '[gravityform id="30" title="false" description="false" tabindex="0"]' ); ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php //<p class="a-termine"><a class="a a-red a-730px centered" href="#termine">Direkt zu den Terminen</a></p>?>
                        </section>
                    </article>
                <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>