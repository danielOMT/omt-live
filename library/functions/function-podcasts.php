<?php
/**
Function to Display Podinare by Parameters given from user.
 * Params:
 * Anzahl
 * Title_only?
 * Kategorie
 * Autor
 * Status (zukünftige, vergangene, alle)
 */

function display_podcasts(int $anzahl = 9999, string $kategorie_id=NULL, int $autor_id=NULL, bool $countonly = false, int $speakerid=NULL, string $multiautor = "" ) {
    //*******************WEBINARE LOGIK VOM ALTEN OMT START*********************// ?>
    <?php

    if (strpos($multiautor, "|" )>0) {
        $manyauthors = 1;
        $multiautor = substr($multiautor, 0, -1);
        $multiautor = explode("|", $multiautor);
    } else { $manyauthors = 0; }


    if ($kategorie_id != NULL) {
        if (strpos($kategorie_id, "|" )>0) {
            $kategorie_id = substr($kategorie_id, 0, -1);
            $kategorie_id = explode("|", $kategorie_id);
        }
        $tax_query[] =  array(
            'taxonomy' => 'podcastkategorie',
            'field' => 'id',
            'terms' => $kategorie_id
        );
    }
    $currentID = get_the_ID();

    $args = array( //next seminare 1st
        'posts_per_page'    => $anzahl,
        'posts_status'    => "publish",
        'post_type'         => 'podcasts',
        'order'				=> 'DESC',
        'orderby'			=> 'date',
        'tax_query'         => $tax_query,
        'post__not_in' => array($currentID)
    );
    if (!isset($podinar_count_id)) { $podinar_count_id = 0; }

    $loop = new WP_Query( $args );
    $webcount = 0;
    if ($countonly != true) { $webcount=1; }
    //$webtotal = $loop->post_count;
    //$count = 0;
    if ( have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <?php
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


        if (1 == $manyauthors) { //abfrage ob man mehrere Speaker IDs übergeben bekommen hat
            $autor_id = $multiautor[0];
            $podinar_speaker_id = 0000;
            foreach ($multiautor as $helper) {
                $multiautor_id = $helper;
                foreach ($podinar_speaker_helper as $helper2) {
                    if ( $helper2->ID == $multiautor_id ) {
                        $podinar_speaker_id = $autor_id;
                    }
                }
            }
        } else {
            if ($autor_id != NULL) { //eine autorenid übergeben, aber es wird geprüft ob mehrere ids im element hinterlegt sind bzw eine davon identisch ist
                $podinar_speaker_id = $podinar_speaker->ID;
                foreach ($podinar_speaker_helper as $helper) {
                    if ($helper->ID == $autor_id) {
                        $podinar_speaker_id = $helper->ID;
                    }
                }
            } else {
                $podinar_speaker_id = NULL;
            }
        }
        $speaker_image = get_field("profilbild", $podinar_speaker->ID);
        if (strlen($hero_image['url'])>0) { $speaker_image = $hero_image; }
        $podinar_count_id++; ?>
        <?php if ($webcount == 1 AND ( $podinar_speaker_id == $autor_id )) {
            $webcount++;?>
            <?php if ($countonly != true ) { ?>
                <div class="teaser-modul-highlight webinare-highlight podinare-highlight">
                    <h4 class="text-red">Aktuelle Folge</h4>
                    <div class="teaser-image-wrap" style="">
                        <img class="webinare-image podinar-image teaser-img" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $speaker_image['sizes']['550-290'];?>"/>
                        <img alt="OMT Podinare" title="OMT Podinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-550.png" style="">
                    </div>
                    <div class="textarea"><?php
                        $podinar_count_id++;
                        ?>
                        <h2 class="h4 no-ihv">
                            <a data-podinar--count="<?php print $podinar_count_id;?>" href="<?php print get_the_permalink()?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>">
                                <?php print $podinar_vorschautitel; ?>
                            </a>
                        </h2>
                        <p class="">
                            <?php
                            $i=0;
                            foreach ($podinar_speaker_helper as $helper) {
                                $i++;
                                if ($i>1) { print ", "; }
                                ?>
                                <?php if ( get_the_permalink($helper->ID) == get_the_permalink($currentID)) { ?>
                                    <span style="font-family: 'Sanuk W01 Black';"><?php print get_the_title($helper->ID); ?></span>
                                <?php } else { ?>
                                    <a target="_self" href="<?php print get_the_permalink($helper->ID);?>"><b><?php print get_the_title($helper->ID); ?></b></a>
                                <?php } ?>
                            <?php } ?>
                            <br/>
                            <?php if (strlen($podcast_vorschautext)<1) { showBeforeMore(get_field('podcast_vorschautext')); } else { print $podcast_vorschautext; } ?>
                        </p>
                        <a data-podinar-count="<?php print $podinar_count_id;?>" class="button" href="<?php print get_the_permalink()?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>" title="<?php the_title_attribute(); ?>"><?php print "Jetzt reinhören";?></a>
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
                                    <img class="teaser-img" alt="<?php print $speaker_name;?>" title="<?php print $speaker_name;?>" src="<?php print $profilbild['sizes']['350-180'];?>"/>
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
                                <span class="button button-red"><span><?php print $option['titel'];?></span></span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

        <?php } else {
            if ( $podinar_speaker_id == $autor_id ) { $webcount++; } ?>
            <?php if ($countonly != true AND ( $podinar_speaker_id == $autor_id )) { ?>
                <div class="omt-webinar omt-podinar teaser teaser-small teaser-matchbuttons">
                    <div class="teaser-image-wrap" style="">
                        <img class="webinar-image podinar-image teaser-img" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $speaker_image['sizes']['350-180'];?>"/>
                        <img alt="OMT Podinare" title="OMT Podinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" style="">
                    </div>
                    <?php //if ($webcount == 1 AND $highlight_next != true AND "zukunft" == $podinar_status) { print "<h4 class='teaser-cat'>Nächstes Webinar</h4>"; } ?>
                    <h2 class="h4 no-ihv"><a data-podinar-<?php print $podinar_status;?>-count="<?php print $podinar_count_id;?>" href="<?php print get_the_permalink()?>">
                            <?php print $podinar_vorschautitel; ?>
                        </a>
                    </h2>
                    <div class="webinar-meta podinar-meta">
                        <div class="teaser-expert">
                            <?php
                            $i=0;
                            foreach ($podinar_speaker_helper as $helper) {
                                $i++;
                                if ($i>1) { print ", "; }
                                ?>
                                <?php if ( get_the_permalink($helper->ID) == get_the_permalink($currentID)) { ?>
                                    <span><?php print get_the_title($helper->ID); ?></span>
                                <?php } else { ?>
                                    <a target="_self" href="<?php print get_the_permalink($helper->ID);?>"><?php print get_the_title($helper->ID); ?></a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php //showBeforeMore(get_field('podinar_beschreibung')); ?>
                    <a data-podinar-<?php print $podinar_status;?>-count="<?php print $podinar_count_id;?>" class="button" href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>">Jetzt reinhören</a>
                </div>
            <?php } ?>
        <?php } ?>
    <?php endwhile; ?>
    <?php endif;
    // END OF SPEEDTEST, SCRIPT COMES BEFORE THIS
    /*  $ru = getrusage();
      echo "This process used " . rutime($ru, $rustart, "utime") .
          " ms for its computations\n";
      echo "It spent " . rutime($ru, $rustart, "stime") .
          " ms in system calls\n";
      // END OF SPEEDTEST, SCRIPT COMES BEFORE THIS*/
    wp_reset_postdata();
    if ($webcount == 1 AND $countonly == false ) { print "<p class='text-center'>Derzeit keine anstehenden Podinare.</p>"; }

    ?>
    <?php //*******************WEBINARE LOGIK VOM ALTEN OMT ENDE**********************//

    return $webcount;
}