<?php
/**
 * Function to Display Podinare by Parameters given from user.
 * Params:
 * Anzahl
 * Title_only?
 * Kategorie
 * Autor
 * Status (zukünftige, vergangene, alle)
 */

function display_podcasts_json(int $anzahl = 9999, string $kategorie_id=NULL, int $autor_id=NULL, bool $countonly = false, int $speakerid=NULL, string $multiautor = "", bool $ladenbutton = FALSE, bool $newtab=false, bool $teasersmall=false) {
    //*******************WEBINARE LOGIK VOM ALTEN OMT START*********************// ?>
    <?php

    wp_enqueue_script('alpine-lines-clamping', get_template_directory_uri() . '/library/js/core/lines-clamping.js');
    wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js');

    if (!isset($podinar_count_id)) { $podinar_count_id = 0; }
    $webcount = 0;
    $url = get_template_directory() . '/library/json/podcasts.json';
    $content_json = file_get_contents($url);
    $json = json_decode($content_json, true);
    if ($countonly != true) { $webcount=1; }
    //$webtotal = $loop->post_count;
    //$count = 0;
    if (strpos($kategorie_id, "|" )>0) {
        $manycats = TRUE;
        $kategorie_id = substr($kategorie_id, 0, -1);
        $kategorie_id = explode("|", $kategorie_id);
    } else { $manycats = FALSE; }


    if (strpos($multiautor, "|" )>0) {
        $manyauthors = 1;
        $multiautor = substr($multiautor, 0, -1);
        $multiautor = explode("|", $multiautor);
    } else { $manyauthors = 0; }


    $currentid = get_the_ID();
    foreach ($json as $podcast) { ///LÖSEN: Mehrfachkategorien. Bei SEO-Podcasts werden die mit primär webanalyse nicht ausgegeben!
        if (NULL == $kategorie_id) {
            $podcast['$category_slug'] = NULL;
        } else {
            if ($manycats != TRUE) {
                $term = get_term($kategorie_id, 'podcastkategorie');
                $slug = $term->slug;
                if (has_term($slug, 'podcastkategorie', $podcast['ID'])) {
                    $podcast['$category_slug'] = $slug;
                }
            } else {
                foreach ($kategorie_id as $kategorie) {
                    $term = get_term($kategorie, 'podcastkategorie');
                    $slug = $term->slug;
                    if (has_term($slug, 'podcastkategorie', $podcast['ID'])) {
                        $podcast['$category_slug'] = $slug;
                        break;
                    }
                }
            }
        }
        if ($slug == $podcast['$category_slug']) {
            $podinar_speaker = $podcast['$podcast_speaker'];
            $podinar_speaker_helper = $podcast['$podcast_speaker'];
            $podinar_speaker = $podinar_speaker[0];
            //$podinar_vorschautitel = $podcast['$podcast_vorschautitel'];
            $podinar_vorschautitel = $podcast['$title'];
            $hero_image = $podcast['$podcast_titelbild'];
            $title = $podcast['$title'];
            if (strlen($podinar_vorschautitel)<1) { $podinar_vorschautitel = $title; }
            //if (strlen($podinar_vorschautitel)>85) { $podinar_vorschautitel = substr($podinar_vorschautitel, 0, 85) . "..."; } ;
            $podcast_vorschautext = $podcast['$podcast_vorschautext'];
            if (strlen($podinar_vorschautitel)<1) { $podinar_vorschautitel = $title; }

            if (1 == $manyauthors) {
                $podcast_speaker_id = $podcast['$speaker1_id'];
                $podcast2_speaker_id = $podcast['$speaker2_id'];
                $podcast3_speaker_id = $podcast['$speaker3_id'];
                $autor_id = $multiautor[0];
                foreach ($multiautor as $helper) {
                    if ($helper == $podcast_speaker_id) { $autor_id = $podcast_speaker_id; }
                    if ($helper == $podcast2_speaker_id) { $autor_id = $podcast2_speaker_id; }
                    if ($helper == $podcast3_speaker_id) { $autor_id = $podcast3_speaker_id; }
                }
            } else {
                if ($autor_id != NULL) {
                    $podcast_speaker_id = $podcast['$speaker1_id'];
                    $podcast2_speaker_id = $podcast['$speaker2_id'];
                    $podcast3_speaker_id = $podcast['$speaker3_id'];
                } else {
                    $podcast_speaker_id = NULL;
                    $podcast2_speaker_id = NULL;
                    $podcast3_speaker_id = NULL;
                }
            }
            $podinar_count_id++; ?>
            <?php if ($webcount == 1 AND ( $podcast_speaker_id == $autor_id OR $podcast2_speaker_id == $autor_id OR $podcast3_speaker_id == $autor_id) AND $teasersmall != true ) {
                $webcount++;?>
                <?php if ($countonly != true ) { ?>
                    <div class="teaser-modul-highlight webinare-highlight podinare-highlight">
                        <h4 class="text-red">Aktuelle Folge</h4>
                        <div class="teaser-image-wrap">
                            <a title="<?php print $podinar_vorschautitel;?>" data-podcast-count="<?php print $podinar_count_id;?>" href="<?php print $podcast['$link'];?>">
                            <img
                                    class="webinare-image podinar-image teaser-img"
                                    alt="<?php print $podcast['$title'];?>"
                                    title="<?php print $podcast['$title'];?>"
                                    width="550"
                                    height="290"
                                    srcset="
            <?php print $hero_image;?> 480w,
            <?php print $hero_image;?> 800w,
            <?php print $hero_image;?> 1400w"
                                    sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                                    src="<?php print $hero_image;?>"
                            />
                            <img width="550" height="66" alt="OMT Podinare" title="OMT Podinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-550.png">
                            </a>
                        </div>
                        <div class="textarea"><?php
                            ?>
                            <h2 class="h4 no-ihv">
                                <a data-podcast-count="<?php print $podinar_count_id;?>" href="<?php print $podcast['$link'];?>">
                                    <?php print $podinar_vorschautitel; ?>
                                </a>
                            </h2>
                            <div class="teaser-expert">
                                <?php
                                $i=0;
                                if ($podcast['$speaker1_id'] == $current_page_id) { ?>
                                    <span><?php print $podcast['$speaker1_name']; ?></span>
                                <?php } else { ?>
                                    <a target="_self"
                                       href="<?php print $podcast['$speaker1_link']; ?>"><?php print $podcast['$speaker1_name']; ?></a>
                                <?php }
                                if (strlen($podcast['$speaker2_name'])>0) {
                                    print ", ";
                                    if ($podcast['$speaker1_id'] == $current_page_id) { ?>
                                        <span><?php print $podcast['$speaker2_name']; ?></span>
                                    <?php } else { ?>
                                        <a target="_self"
                                           href="<?php print $podcast['$speaker2_link']; ?>"><?php print $podcast['$speaker2_name']; ?></a>
                                    <?php }
                                }
                                if (strlen($podcast['$speaker3_name'])>0) {
                                    print "& ";
                                    if ($podcast['$speaker3_id'] == $current_page_id) { ?>
                                        <span><?php print $podcast['$speaker3_name']; ?></span>
                                    <?php } else { ?>
                                        <a target="_self"
                                           href="<?php print $podcast['$speaker3_link']; ?>"><?php print $podcast['$speaker3_name']; ?></a>
                                    <?php }
                                } ?>
                            </div>
                            <p>
                                <?php if (strlen($podcast_vorschautext)<1) { showBeforeMore(get_field('podcast_vorschautext')); } else { print $podcast_vorschautext; } ?>
                                <a <?php if (true == $newtab) {?>target="_blank" <?php }?> data-podcast-count="<?php print $podinar_count_id;?>" class="button" href="<?php print $podcast['$link'];?>" title="<?php print $podcast['$title']; ?>"><?php print "Jetzt reinhören";?></a>
                            </p>
                        </div>
                    </div>
                    <?php if ($speakerid != NULL) { ?>
                        <div class="omt-row">
                            <h2 style="margin:0 0 10px 0;">Der Gastgeber</h2>
                            <div class="testimonial card clearfix speakerprofil" style="margin:0 0 45px 0 !important;">
                                <?php
                                $titel = get_field('titel', $speakerid);
                                $profilbild = get_field('profilbild', $speakerid);
                                $firma = get_field('firma', $speakerid);
                                $speaker_galerie = get_field('speaker_galerie', $speakerid);
                                $beschreibung = get_field('beschreibung', $speakerid);
                                $beschreibung_alternativ = get_field('beschreibung_alternativ', $speakerid);
                                if (strlen($beschreibung_alternativ)>0) { $beschreibung = $beschreibung_alternativ; }
                                $social_media = get_field('social_media', $speakerid);
                                $speaker_name = get_the_title($speakerid);
                                ?>
                                <div class="testimonial-img">
                                    <a target="_self" href="<?php print get_the_permalink($speakerid);?>">
                                        <img
                                                class="teaser-img"
                                                alt="<?php print $speaker_name;?>"
                                                title="<?php print $speaker_name;?>"
                                                width="350"
                                                height="180"
                                                src="<?php print $profilbild['sizes']['350-180'];?>"
                                        />
                                    </a>
                                </div>
                                <div class="testimonial-text">
                                    <p class="teaser-cat speakerauswahl-info"><?php print $text_extra;?></p>
                                    <h3 class="experte has-margin-bottom-30"><a target="_self" href="<?php print get_the_permalink($speakerid);?>"><?php print $speaker_name; ?></a></h3>
                                    <?php print $beschreibung;?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="omt-row">
                        <div class="omt-module podcast-abonnieren teaser-modul">
                            <?php $podinar_abonnieren_optionen = get_field('podinar_abonnieren_optionen', 'options');?>
                            <?php foreach ($podinar_abonnieren_optionen as $option) { ?>
                                <a class="teaser-small teaser-xsmall abonnieren" target="_blank" href="<?php print $option['link'];?>">
                                    <h3>Podcast<br/>abonnieren</h3>
                                    <?php switch ($option['titel']) {
                                        case "Apple Podcasts": ?><i class="fa fa-apple"></i><?php break;
                                        case "Google Podcast": ?><i class="fa fa-google"></i><?php break;
                                        case "Spotify": ?><i class="fa fa-spotify"></i><?php break;
                                        case "Soundcloud": ?><i class="fa fa-soundcloud"></i><?php break;
                                    } ?>
                                    <span style="color:white;"><?php print $option['titel'];?></span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

            <?php } else {
                if ( ( $webcount <= $anzahl ) AND  ( $podcast_speaker_id == $autor_id OR $podcast2_speaker_id == $autor_id OR $podcast3_speaker_id == $autor_id ) ) { $webcount++; ?>
                    <?php if ($countonly != true ) { ?>
                        <div class="omt-webinar omt-podinar teaser teaser-small teaser-matchbuttons">
                            <div class="teaser-image-wrap">
                                <a <?php if (true == $newtab) {?>target="_blank" <?php }?> title="<?php print $podinar_vorschautitel;?>" data-podcast-count="<?php print $podinar_count_id;?>" href="<?php print $podcast['$link'];?>">
                                <img
                                        class="webinar-image podinar-image teaser-img"
                                        alt="<?php print $podinar_vorschautitel;?>"
                                        title="<?php print $podinar_vorschautitel;?>"
                                        width="350"
                                        height="180"
                                        src="<?php print $podcast['$podcast_titelbild'];?>"
                                />
                                <img alt="<?php print $podinar_vorschautitel;?>" title="<?php print $podinar_vorschautitel;?>" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
                                </a>
                            </div>
                            <h2 class="h4 no-ihv teaser-two-lines-title">
                                <a 
                                    x-data="xLinesClamping()"
                                    x-init="clamp(2)"
                                    title="<?php echo htmlspecialchars($podinar_vorschautitel) ?>"
                                    <?php if (true == $newtab) {?>target="_blank" <?php }?> 
                                    data-podcast-count="<?php print $podinar_count_id;?>" 
                                    href="<?php print $podcast['$link'];?>"
                                >
                                    <?php echo truncateString($podinar_vorschautitel) ?>
                                </a>
                            </h2>
                            <div class="webinar-meta podinar-meta">
                                <div class="teaser-expert">
                                    <?php if ($podcast['$speaker1_id'] == $current_page_id) { ?>
                                        <span><?php print $podcast['$speaker1_name']; ?></span>
                                    <?php } else { ?>
                                        <a target="_self"
                                           href="<?php print $podcast['$speaker1_link']; ?>"><?php print $podcast['$speaker1_name']; ?></a>
                                    <?php }
                                    if (strlen($podcast['$speaker2_name'])>0) {
                                        print ", ";
                                        if ($podcast['$speaker1_id'] == $current_page_id) { ?>
                                            <span><?php print $podcast['$speaker2_name']; ?></span>
                                        <?php } else { ?>
                                            <a target="_self"
                                               href="<?php print $podcast['$speaker2_link']; ?>"><?php print $podcast['$speaker2_name']; ?></a>
                                        <?php }
                                    }
                                    if (strlen($podcast['$speaker3_name'])>0) {
                                        print "& ";
                                        if ($podcast['$speaker3_id'] == $current_page_id) { ?>
                                            <span><?php print $podcast['$speaker3_name']; ?></span>
                                        <?php } else { ?>
                                            <a target="_self"
                                               href="<?php print $podcast['$speaker3_link']; ?>"><?php print $podcast['$speaker3_name']; ?></a>
                                        <?php }
                                    } ?>
                                </div>
                            </div>

                            <a data-podcast-count="<?php print $podinar_count_id;?>" class="button" href="<?php print $podcast['$link']?>" title="<?php print $podcast['$title']; ?>">Jetzt reinhören</a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    <?php }
    if ( ( $webcount > $anzahl ) AND (TRUE == $ladenbutton) ) {
        ?>
        <div style="display:block;width:100%;"><a data-anzahl="<?php print $anzahl;?>" data-cat="<?php print $kategorie_id;?>" class="button button-gradient button-730px button-center button-loadmore podcasts-loadmore" href="#">Weitere Podcasts</a></div>
        <div class="status podcasts-ajax-status"><i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Podcasts werden geladen</div>
        <div class="teaser-loadmore podcasts-results"></div>
    <?php }

    wp_reset_postdata();
    if ($webcount == 1 AND $countonly == false ) { print "<p class='text-center'>Derzeit keine anstehenden Podcasts.</p>"; }

    ?>
    <?php //*******************PODCAST LOGIK VOM ALTEN OMT ENDE**********************//

    return $webcount;
}