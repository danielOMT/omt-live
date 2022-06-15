<?php
get_header();
$header_hero_hintergrundbild = get_field('header_hero_hintergrundbild');
$header_hero_h1 = get_field('header_hero_h1');
$intro_headline = get_field('intro_headline');
$intro_text = get_field('intro_text');
$has_sidebar = get_field('has_sidebar');
$kommentarfunktion_aktivieren = get_field('kommentarfunktion_aktivieren');
$sidebar_welche = get_field('sidebar_welche');
$sticky_button_text = get_field('sticky_button_text');
$sticky_button_link = get_field('sticky_button_link');
$hero_background = get_field('standardseite', 'options');


if (strlen($header_hero_hintergrundbild['url'])>0) { $hero_background = $header_hero_hintergrundbild;}
$h1 = get_the_title();

if ($has_sidebar != false) {
    $extraclass="has-sidebar";
} else {
    $extraclass = "fullwidth";
}
$class_themenwelt = " template-themenwelt";
?>

    <div id="content" class=" <?php print $extraclass;?>" xmlns:background="http://www.w3.org/1999/xhtml">
        <div class="omt-row hero-header header-flat" style="background: url('<?php print $hero_background['url'];?>') no-repeat 50% 0;">
            <div class="wrap">
                <h1><?php _e('Dein Suchergebnis für:', 'bonestheme'); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>
            </div>
        </div>
        <div class="inhaltsverzeichnis-wrap">
            <div class="omt-row wrap no-margin-bottom no-margin-top  placeholder-730"></div>
        </div>
        <div class="omt-row wrap">
            <div class="omt-module module-suchergebnis">
                <a class="button button-blue button-730px" style=";margin-bottom: 30px;" href="#searchwp-modal-5916110af2bd3b2b4d5992f3b0f8059a" data-searchwp-modal-trigger="searchwp-modal-5916110af2bd3b2b4d5992f3b0f8059a">Neue Suche starten</a>
                <?php
                if( have_posts() ) {
                    $types = array(
                        'webinare',
                        'podcasts',
                        'magazin',
                        'affiliate',
                        'amazon',
                        'amazon_marketing',
                        'content',
                        'conversion',
                        'direktmarketing',
                        'emailmarketing',
                        'facebook',
                        'ga',
                        'growthhack',
                        'inbound',
                        'influencer',
                        'p_r',
                        'sea',
                        'seo',
                        'sma',
                        'links',
                        'local',
                        'marketing',
                        'onlinemarketing',
                        'social',
                        'pinterest',
                        'videomarketing',
                        'webanalyse',
                        'webdesign',
                        'wordpress',
                        'seminare',
                        'page',
                        'tool',
                        'agenturen',
                        'lexikon',
                        'quicktipps'
                    );
                    ?>
                    <div class="search-module">
                        <div class="omt-module teaser-modul">
                            <?php
                            $current_id = get_the_id();
                            $today = date("Y-m-d", strtotime("today"));
                            $date1 = date_create($today);
                            $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
                            while (have_posts()) { ?>
                                <?php the_post();
                                $post_type = get_post_type();
                                $post_type_nice = "";
                                $post_type_data = get_post_type_object($post_type);
                                $post_type_slug = $post_type_data->rewrite['slug'];
                                switch ($post_type) {
                                    case "affiliate":
                                        $post_type_nice = "Affiliate Marketing-Artikel";
                                        break;
                                    case "amazon":
                                        $post_type_nice = "Amazon SEO-Artikel";
                                        break;
                                    case "amazon_marketing":
                                        $post_type_nice = "Amazon Marketing";
                                        break;
                                    case "content":
                                        $post_type_nice = "Content Marketing-Artikel";
                                        break;
                                    case "conversion":
                                        $post_type_nice = "Conversion Optimierung-Artikel";
                                        break;
                                    case "direktmarketing":
                                        $post_type_nice = "Direktmarketing-Artikel";
                                        break;
                                    case "emailmarketing":
                                        $post_type_nice = "E-Mail Marketing-Artikel";
                                        break;
                                    case "facebook":
                                        $post_type_nice = "Facebook Ads-Artikel";
                                        break;
                                    case "ga":
                                        $post_type_nice = "Google Analytics-Artikel";
                                        break;
                                    case "growthhack":
                                        $post_type_nice = "Growth Hacking-Artikel";
                                        break;
                                    case "inbound":
                                        $post_type_nice = "Inbound Marketing-Artikel";
                                        break;
                                    case "influencer":
                                        $post_type_nice = "Influencer Marketing-Artikel";
                                        break;
                                    case "links":
                                        $post_type_nice = "Linkbuilding-Artikel";
                                        break;
                                    case "local":
                                        $post_type_nice = "Local SEO-Artikel";
                                        break;
                                    case "magazin":
                                        $post_type_nice = "Magazin-Artikel";
                                        break;
                                    case "marketing":
                                        $post_type_nice = "Marketing-Artikel";
                                        break;
                                    case "onlinemarketing":
                                        $post_type_nice = "Online Marketing-Artikel";
                                        break;
                                    case "pagespeed":
                                        $post_type_nice = "Wordpress Pagespeed-Artikel";
                                        break;
                                    case "pinterest":
                                        $post_type_nice = "Pinterest Marketing-Artikel";
                                        break;
                                    case "plugins":
                                        $post_type_nice = "Wordpress Plugins-Artikel";
                                        break;
                                    case "p_r":
                                        $post_type_nice = "PR-Artikel";
                                        break;
                                    case "sea":
                                        $post_type_nice = "Google Ads-Artikel";
                                        break;
                                    case "seo":
                                        $post_type_nice = "Suchmaschinenoptimierung-Artikel";
                                        break;
                                    case "social":
                                        $post_type_nice = "Social Media Marketing-Artikel";
                                        break;
                                    case "videomarketing":
                                        $post_type_nice = "Video Marketing-Artikel";
                                        break;
                                    case "webanalyse":
                                        $post_type_nice = "Webanalyse-Artikel";
                                        break;
                                    case "webdesign":
                                        $post_type_nice = "Webdesign-Artikel";
                                        break;
                                    case "wordpress":
                                        $post_type_nice = "WordPress-Artikel";
                                        break;
                                    ////nicht-magazin-post types below
                                    case "webinare":
                                        $post_type_nice = "Webinare";
                                        break;
                                    case "lexikon":
                                        $post_type_nice = "Lexikon-Artikel";
                                        break;
                                    case "quicktipps":
                                        $post_type_nice = "Quicktipps-Artikel";
                                        break;
                                    case "podcasts":
                                        $post_type_nice = "Podcasts";
                                        break;
                                    case "seminare":
                                        $post_type_nice = "Seminare";
                                        break;
                                    case "tool":
                                        $post_type_nice = "Online Marketing Tools";
                                        break;
                                    case "agenturen":
                                        $post_type_nice = "Online Marketing Agenturen";
                                        break;
                                    case "post":
                                        $post_type_nice = "weitere Beiträge";
                                        break;
                                    case "page":
                                        $post_type_nice = "Seiten";
                                        break;
                                }
                                ?>
                                <?php if (
                                    "vortrag" != $post_type AND
                                    "expertenstimme" != $post_type AND
                                    "toolrezension" != $post_type AND
                                    "tooltabelle" != $post_type AND
                                    "trend" != $post_type AND
                                    "umfrage" != $post_type AND
                                    "christmas" != $post_type AND
                                    "jobs" != $post_type AND
                                    "product" != $post_type
                                ) {
                                    if ("webinare" == $post_type) {
                                        $user_firstname = "";
                                        $user_lastname = "";
                                        $user_email = "";
                                        if ( is_user_logged_in() ) {
                                            $user = wp_get_current_user();
                                            $user_firstname = $user->first_name;
                                            $user_lastname = $user->last_name;
                                            $user_email = $user->user_email;
                                        }
                                        if (isset($webinar)) { unset($webinar); }
                                        $webinar_url = get_the_permalink();
                                        $webinar_day = get_field("webinar_datum");
                                        $webinar_time = get_field("webinar_uhrzeit_start");
                                        $webinar_time_ende = get_field("webinar_uhrzeit_ende");
                                        $webinar_speaker = get_field("webinar_speaker");
                                        if (is_array($webinar_speaker)) {
                                            $webinar_speaker_1 = $webinar_speaker[0]->ID;
                                            $webinar_speaker_2 = $webinar_speaker[1]->ID;
                                            $webinar_speaker_3 = $webinar_speaker[2]->ID;
                                            $webinar_speaker = $webinar_speaker_1;
                                        } else {
                                            if (strlen($webinar_speaker) > 0) {
                                                $webinar_speaker_1 = $webinar_speaker->ID;
                                            }
                                        }
                                        $speaker1_name = get_the_title($webinar_speaker_1);
                                        $speaker1_url = get_the_permalink($webinar_speaker_1);
                                        if (strlen($webinar_speaker_2) > 0) {
                                            $speaker2_name = get_the_title($webinar_speaker_2);
                                            $speaker2_url = get_the_permalink($webinar_speaker_2);
                                        } else {
                                            $speaker2_name = "";
                                            $speaker2_url = "";
                                        }
                                        if (strlen($webinar_speaker_3) > 0) {
                                            $speaker3_name = get_the_title($webinar_speaker_3);
                                            $speaker3_url = get_the_permalink($webinar_speaker_3);
                                        } else {
                                            $speaker3_name = "";
                                            $speaker3_url = "";
                                        }
                                        $previewImage = get_field('webinar_optional_preview_image');
                                        if (!$previewImage) {
                                            $previewImage = get_field("profilbild", $webinar_speaker);
                                        }
                                        $speaker_url = get_the_permalink($webinar_speaker);
                                        $image_550 = $previewImage['sizes']['550-290'];
                                        $image_350 = $previewImage['sizes']['350-180'];
                                        $webinar_vorschautitel = get_field("webinar_vorschautitel");
                                        $title = get_the_title();
                                        $link = get_the_permalink();
                                        $webinar_youtube_embed_code = get_field('webinar_youtube_embed_code');
                                        $webinar_wistia_embed_code = get_field('webinar_wistia_embed_code');
                                        $webinar_wistia_embed_code_mitglieder = get_field('webinar_wistia_embed_code_mitglieder');
                                        if (strlen($webinar_vorschautitel) < 1) {
                                            $webinar_vorschautitel = $title;
                                        }
                                        if (strlen($webinar_vorschautitel) > 60) {
                                            $webinar_vorschautitel = substr($webinar_vorschautitel, 0, 60) . "...";
                                        };
                                        $webinar_vorschautext = get_field("webinar_vorschautext");
                                        if (strlen($webinar_vorschautitel) < 1) {
                                            $webinar_vorschautitel = $title;
                                        }
                                        $webinar_compare = $webinar_day . " " . $webinar_time;
                                        $webinar_date_compare = strtotime($webinar_compare); //convert seminar date to unix string for future-check the entries
                                        if ($today_date <= $webinar_date_compare) {
                                            $webinar_status = "zukunft";
                                        } else {
                                            $webinar_status = "vergangenheit";
                                        } //set webinar status
                                        $terms = get_the_terms(get_the_ID(), 'kategorie');
                                        $category_name = $terms[0]->name;
                                        $category_slug = $terms[0]->slug;
                                        $origDate = $webinar_day;
                                        $newDate = date("Y-m-d", strtotime($origDate));
                                        $webinar = array(
                                            'ID' => get_the_ID(),
                                            '$title' => $title,
                                            '$link' => $link,
                                            '$speaker1_name' => $speaker1_name,
                                            '$speaker2_name' => $speaker2_name,
                                            '$speaker3_name' => $speaker3_name,
                                            '$speaker1_id' => $webinar_speaker_1,
                                            '$speaker2_id' => $webinar_speaker_2,
                                            '$speaker3_id' => $webinar_speaker_3,
                                            '$speaker1_url' => $speaker1_url,
                                            '$speaker2_url' => $speaker2_url,
                                            '$speaker3_url' => $speaker3_url,
                                            '$webinar_vorschautitel' => $webinar_vorschautitel,
                                            '$category_name' => $category_name,
                                            '$category_slug' => $category_slug,
                                            '$terms' => $terms,
                                            '$webinar_url' => $webinar_url,
                                            '$webinar_status' => $webinar_status,
                                            '$webinar_day' => $webinar_day,
                                            '$webinar_time' => $webinar_time,
                                            '$webinar_time_ende' => $webinar_time_ende,
                                            'date' => $newDate,
                                            '$webinar_vorschautext' => $webinar_vorschautext,
                                            '$webinar_beschreibung' => get_field('webinar_beschreibung'),
                                            '$image_550' => $image_550,
                                            '$image_350' => $image_350,
                                            '$youtube' => $webinar_youtube_embed_code,
                                            '$wistia' => $webinar_wistia_embed_code,
                                            '$wistia_members' => $webinar_wistia_embed_code_mitglieder,
                                            '$webinar_timestamp' => $webinar_date_compare
                                        );
                                        if ($today_date <= $webinar['$webinar_timestamp']) {
                                            $webinar_status = "zukunft";
                                        } else {
                                            $webinar_status = "vergangenheit";
                                        } //set webinar status
                                        include('library/functions/json-webinare/webinar-item.php');
                                    }
                                    elseif ("page" == $post_type) { ?>
                                        <div class="omt-webinar omt-podinar teaser teaser-small teaser-matchbuttons">
                                            <div class="teaser-image-wrap">
                                                <img class="webinar-image podinar-image teaser-img" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php echo getOption('logo', 'image_url') ?>"/>
                                                <img alt="OMT Podinare" title="OMT Podinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
                                            </div>
                                            <?php //if ($webcount == 1 AND $highlight_next != true AND "zukunft" == $podinar_status) { print "<h4 class='teaser-cat'>Nächstes Webinar</h4>"; } ?>
                                            <h2 class="h4 no-ihv"><a href="<?php print get_the_permalink();?>">
                                                    <?php
                                                    $title = str_replace("Themenwelt", "", get_the_title());
                                                    $title =  str_replace("-", "", $title);
                                                    if (strpos(get_the_title(), "Themenwelt")>0) {
                                                        $title = substr($title, 19);
                                                    }
                                                    print $title;
                                                    ?>
                                                </a>
                                            </h2>
                                        </div>
                                    <?php }
                                    elseif ("agenturen" == $post_type) {
                                        $hero_image = get_field('logo');
                                        ?>
                                        <div class="omt-webinar omt-podinar teaser teaser-small teaser-matchbuttons">
                                            <div class="teaser-image-wrap">
                                                <img class="webinar-image podinar-image teaser-img" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $hero_image['url'];?>"/>
                                                <img alt="OMT Podinare" title="OMT Podinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
                                            </div>
                                            <h2 class="h4 no-ihv"><a href="<?php print get_the_permalink();?>">
                                                    <?php
                                                    $title = str_replace("Themenwelt", "", get_the_title());
                                                    $title =  str_replace("-", "", $title);
                                                    if (strpos(get_the_title(), "Themenwelt")>0) {
                                                        $title = substr($title, 19);
                                                    }
                                                    print $title;
                                                    ?>
                                                </a>
                                            </h2>
                                        </div>
                                    <?php }
                                    elseif ("seminare" == $post_type) {
                                        $seminar_image = "asdf";
                                        $seminar_link = get_the_permalink();
                                        $vorschau = get_field('seminar_vorschau-headline');
                                        $seminar_title = get_the_title();
                                        if (strlen($vorschau) > 0) {
                                            $seminar_title = $vorschau;
                                        }
                                        $seminartitle_teaser = $seminar_title;
                                        if (strlen($seminartitle_teaser) > 60) {
                                            $seminartitle_teaser = substr($seminartitle_teaser, 0, 60) . "...";
                                        };
                                        $seminar_woocommerce = get_field('seminar_woocommerce', get_the_id());
                                        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($seminar_woocommerce->ID), 'full');
                                        $image = $featured_image[0];

                                        ?>
                                        <div class="teaser teaser-small">
                                            <img class="teaser-img seminar-image" alt="<?php print $seminar_title ?>"
                                                 title="<?php print $seminar_title; ?>" src="<?php print $image; ?>"/>
                                            <h4 class="seminarcat-title article-title"><a
                                                        href="<?php print $seminar_link ?>"><?php print $seminartitle_teaser; ?></a></h4>
                                            <div class="seminar-meta">
                                            </div>
                                            <a class="button" href="<?php print $seminar_link ?>" title="<?php print $seminar_title; ?>">Termine
                                                & Anmeldung</a>
                                        </div>
                                    <?php }
                                    elseif ("podcasts" == $post_type) {
                                        $podinar_count_id=0;
                                        $podinar_speaker = get_field("podinar_speaker");
                                        $podinar_speaker_helper = get_field("podinar_speaker");
                                        $podinar_speaker = $podinar_speaker[0];
                                        $podinar_vorschautitel = get_field("podinar_vorschautitel");
                                        $hero_image = get_field('podinar_titelbild');
                                        $title = get_the_title();
                                        //$podinar_shorttitle = implode(' ', array_slice(explode(' ', $podinar_vorschautitel), 0, 9));
                                        //$wordcount = str_word_count($podinar_vorschautitel);
                                        //if ($wordcount > 9) { $podinar_vorschautitel = $podinar_shorttitle . "..."; }
                                        if (strlen($podinar_vorschautitel)<1) { $podinar_vorschautitel = $title; }
                                        if (strlen($podinar_vorschautitel)>85) { $podinar_vorschautitel = substr($podinar_vorschautitel, 0, 85) . "..."; } ;
                                        $podcast_vorschautext = get_field("podcast_vorschautext");
                                        if (strlen($podinar_vorschautitel)<1) { $podinar_vorschautitel = $title; }
                                        $speaker_image = get_field("profilbild", $podinar_speaker->ID);
                                        if (strlen($hero_image['url'])>0) { $speaker_image = $hero_image; }
                                        $podinar_count_id++;
                                        ?>
                                        <div class="omt-webinar omt-podinar teaser teaser-small teaser-matchbuttons">
                                            <div class="teaser-image-wrap" style="">
                                                <img class="webinar-image podinar-image teaser-img" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $hero_image['url'];?>"/>
                                                <img alt="OMT Podinare" title="OMT Podinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" style="">
                                            </div>
                                            <?php //if ($webcount == 1 AND $highlight_next != true AND "zukunft" == $podinar_status) { print "<h4 class='teaser-cat'>Nächstes Webinar</h4>"; } ?>
                                            <h2 class="h4 no-ihv"><a data-podcast-count="<?php print $podinar_count_id;?>" href="<?php print get_the_permalink();?>">
                                                    <?php print $podinar_vorschautitel; ?>
                                                </a>
                                            </h2>
                                            <?php //showBeforeMore(get_field('podinar_beschreibung')); ?>
                                            <a data-podcast-count="<?php print $podinar_count_id;?>" class="button" href="<?php print get_the_permalink(); ?>" title="<?php print get_the_title(); ?>">Jetzt reinhören</a>
                                        </div>
                                    <?php }
                                    elseif ("tool" == $post_type) {
                                        $ID = get_the_id();
                                        $link = get_the_permalink();
                                        $tool_image = get_field('logo');
                                        if (strlen($tool_image['url']) < 1) {
                                            $tool_image = getOption('logo', 'image_url');
                                        } else {
                                            $tool_image = $tool_image['url'];
                                        }
                                        $title = get_the_title();
                                        $tool_title = str_replace('Privat: ', "", $title);
                                        $vorschautitel_fur_index = get_field('tool_vorschautitel');
                                        if (strlen($vorschautitel_fur_index)>0) { $tool_title = $vorschautitel_fur_index; }
                                        $zur_preisubersicht = get_field('tool_preisubersicht');
                                        $zur_website = get_field('zur_webseite');
                                        $tool_gratis_testen_link = get_field('tool_gratis_testen_link');
                                        $gesamtwertung = get_field('gesamt');
                                        $gesamt = number_format($gesamtwertung, 1, ".",",");
                                        $toolanbieter = get_field('$toolanbieter');
                                        $buttons_anzeigen = get_field('$buttons_anzeigen');
                                        $anzahl_bewertungen = get_field('anzahl_bewertungen');
                                        $tool_details = get_field('details');
                                        ?>
                                        <div class="tool search-tool teaser-small">
                                            <div class="tool-top">
                                                <div class="tool-logo-wrap">
                                                    <img class="tool-logo" alt="<?php print $tool_title;?>" title="<?php print $tool_title;?>" src="<?php echo $tool_image ?>"/>
                                                </div>
                                                <div class="tool-name">
                                                    <h3>
                                                        <a href="<?php print $link;?>" target="_blank"><?php print $tool_title;?></a>
                                                    </h3>
                                                    <?php if (strlen($toolanbieter)>0) { ?><p>von <?php print $toolanbieter;?></p><?php } ?>
                                                    <?php if ($anzahl_bewertungen>0) { ?>
                                                        <div class="bewertungen">
                                                            <div class="rezensionen-wrap"> <?php //https://codepen.io/andreacrawford/pen/NvqJXW ?>
                                                                <div class="stars-wrap">
                                                                    <?php for ($x = 0; $x < 5; $x++) { ?>
                                                                        <?php if ($x < floor($gesamt)) { ?><img class="rating " src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                                                        $starvalue = $gesamt;
                                                                        if  ( $x == floor($starvalue) ) {
                                                                            if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                                                                if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                                                                    <img class="rating" src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                                                                <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                                                                    <img class="rating" src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                                                                <?php }?>
                                                                            <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                                                                if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                                                                    <img class="rating" src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                                                                } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                                                                    <img class="rating" src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                                                }
                                                                            }
                                                                        }
                                                                        if ( ( $x > $gesamt)) { ?><img class="rating" src="https://www.omt.de/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <p class="nutzerbewertungen-info"><?php print number_format($gesamt,1,",",".") . "/5 (" . $anzahl_bewertungen . ")";?>
                                                            </p>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="tool-details">
                                                    <?php
                                                    $i = 0;
                                                    if (is_array($tool_details)) {
                                                        if (count($tool_details) > 0) { ?>
                                                            <?php foreach ($tool_details as $detail) {
                                                                $i++;
                                                                ?>
                                                                <?php if ($i <= 3) { ?><p class="tool-detail thumbup"><?php print $detail['detail'];?></p><?php }?>
                                                            <?php }
                                                        }
                                                    } ?>
                                                </div>
                                            </div>
                                            <?php if ( (1 == $buttons_anzeigen) AND ( ( strlen($zur_preisubersicht)>0 ) OR ( strlen ($zur_website)>0 ) OR ( strlen($tool_gratis_testen_link)>0 ) ) ) { ?>
                                                <div class="tool-buttons">
                                                    <?php if (strlen($tool_gratis_testen_link)>0) { ?><a id="<?php print $tool_title;?>" class="button button-red" href="<?php print $tool_gratis_testen_link;?>" target="_blank">Gratis testen</a><?php } ?>
                                                    <?php if (strlen($zur_preisubersicht)>0) { ?><a id="<?php print $tool_title;?>" class="button button-pricing button-lightgrey" href="<?php print $zur_preisubersicht;?>" target="_blank">Preisübersicht</a><?php } ?>
                                                    <?php  if (strlen($zur_website)>0) { ?><a id="<?php print $tool_title;?>" class="button button-red" href="<?php print $zur_website;?>" target="_blank">zum Tool</a><?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } else {
                                        $featured_image_teaser = wp_get_attachment_image_src( get_post_thumbnail_id($id), '350-180' );
                                        $featured_image_highlight = wp_get_attachment_image_src( get_post_thumbnail_id($id), '550-290' );
                                        $image_teaser = $featured_image_teaser[0];
                                        if (
                                        ( "omt_downloads" == $post_type ) || ( "omt_student" == $post_type ) || ( "omt_ebook" == $post_type ) || ( "omt_magazin" == $post_type ) ) {
                                            $featured_image = get_field('vorschaubild');
                                            $image_teaser = $featured_image['sizes']['550-290'];
                                        }
                                        ?>
                                        <a href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>" class="teaser teaser-small teaser-matchbuttons">
                                            <div class="teaser-image-wrap" style="">
                                                <img class="webinar-image teaser-img <?php if (in_array($post_type, ["lexikon", "quicktipps"])) {print "lexikon-img"; } ?>" alt="<?php the_title();?>" title="<?php the_title();?>" src="<?php print $image_teaser;?>"/>
                                                <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
                                            </div>
                                            <h2 class="h4 article-title no-ihv"><!--<a href="--><?php //the_permalink()?><!--" title="--><?php //the_title_attribute(); ?><!--">--><?php print get_the_title(); ?><!--</a>--></h2>
                                            <!--                                                    <a class="teaser-cat category-link" href="/--><?php //print $post_type_slug;?><!--/">--><?php //print $post_type_nice;?><!--</a>-->
                                            <!--                                                    <p class="experte no-margin-top no-margin-bottom">-->
                                            <!--                                                        --><?php
                                            //                                                        $vorschautext = get_field('vorschautext');
                                            //                                                        //print $vorschautext; ?>
                                            <!--                                                    </p>-->
                                            <!--                                                    <a class="button" href="--><?php //the_permalink()?><!--" title="--><?php //the_title_attribute(); ?><!--">Artikel lesen</a>-->
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                            <?php }
                            ?>
                        </div>
                    </div>
                <?php  } ?>
            </div>
            <?php //get_sidebar(); ?>
        </div>
    </div>

<?php get_footer(); ?>