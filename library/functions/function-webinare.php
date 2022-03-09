<?php
/**
Function to Display Webinare by Parameters given from user.
 * Params:
 * Anzahl
 * Title_only?
 * Kategorie
 * Autor
 * Status (zukünftige, vergangene, alle)
 */

function display_webinare(int $anzahl = 9, string $reihenfolge = "ASC", int $kategorie_id=NULL, int $autor_id=NULL, string $status="vergangenheit", bool $highlight_next = false, bool $countonly = false, string $multiautor = "" ) {
    //*******************WEBINARE LOGIK VOM ALTEN OMT START*********************// ?>
    <?php
    if ($kategorie_id != NULL) {
        $tax_query[] =  array(
            'taxonomy' => 'kategorie',
            'field' => 'id',
            'terms' => $kategorie_id
        );
    }
    $currentID = get_the_ID();

    if (strpos($multiautor, "|" )>0) {
        $manyauthors = 1;
        $multiautor = substr($multiautor, 0, -1);
        $multiautor = explode("|", $multiautor);
    } else { $manyauthors = 0; }

    $args = array( //next seminare 1st
        'posts_per_page'    => -1,
        'posts_status'    => "publish",
        'post_type'         => 'webinare',
        'order'				=> $reihenfolge,
        'orderby'			=> 'meta_value',
        'meta_key'	        => 'webinar_datum',
        'meta_type'			=> 'DATETIME',
        'tax_query'         => $tax_query,
        'post__not_in' => array($currentID)

    );
    $today = date("Y-m-d", strtotime("today"));
    $date1 = date_create($today);

    if (!isset($webinar_count_id)) { $webinar_count_id = 0; }

    $user_firstname = "";
    $user_lastname = "";
    $user_email = "";
    if ( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $user_firstname = $user->first_name;
        $user_lastname = $user->last_name;
        $user_email = $user->user_email;
    }
    // Get any existing copy of our transient data FROM PAST WEBINARE
    /*  if ( false === ( $webinare_query = get_transient( 'webinare_query' ) ) ) {
          // It wasn't there, so regenerate the data and save the transient
          $webinare_query = new WP_Query($args);
          set_transient( 'webinare_query', $webinare_query, 60*60*12 );
      }*/
// Use the data like you would have normally...

    //$loop = get_transient( 'webinare_query' );

    $loop = new WP_Query( $args );
    $webcount=1;
    //$webtotal = $loop->post_count;
    //$count = 0;
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    //  $rustart = getrusage();//start measuring php workload time
    if ( is_user_logged_in() ) {
        $user = wp_get_current_user();
        if ($user && isset($user->user_login) && 'Daniel Voelskow' == $user->user_login) { ?>
            <div class="webinare-filter-bubble">
                <?php
                $args_filter = array(
                    'posts_status'    => "publish",
                    'post_type'         => 'webinare',
                    'taxonomy' => 'kategorie',
                    'orderby' => 'name',
                    'order'   => 'ASC',
                    'post__not_in' => array($currentID)
                );

                $cats = get_categories($args_filter);?>
                <div class="trends-filter">
                    <div class="nav-filter">
                        <div class="alle-anzeigen active" style="">
                            <a class="button button-red" href="#" data-filter="all-terms" data-term="all-terms"
                               data-page="1">
                                Alle Trends anzeigen (Filter zurücksetzen)
                            </a>
                        </div>
                        <div>
                            <?php foreach ($cats as $category) {
                                ?>
                                <a class="button button-350px" href="<?php print get_category_link( $category->term_id ); ?>" data-filter="kategorie" data-term="<?php print $category->name; ?>"><?php print $category->name; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    }
    while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <?php

        $webinar_day = get_field("webinar_datum");
        $webinar_time = get_field("webinar_uhrzeit_start");
        //$webinar_day = substr($webinar_datum,0,10);
        //$webinar_time = substr($webinar_datum,11,16);
        $webinar_time_ende = get_field("webinar_uhrzeit_ende");
        $webinar_speaker = get_field("webinar_speaker");
        $webinar_speaker_helper = get_field("webinar_speaker");
        $webinar_speaker = $webinar_speaker[0];
        $webinar_vorschautitel = get_field("webinar_vorschautitel");
        $title = get_the_title();
        //$webinar_shorttitle = implode(' ', array_slice(explode(' ', $webinar_vorschautitel), 0, 9));
        //$wordcount = str_word_count($webinar_vorschautitel);
        //if ($wordcount > 9) { $webinar_vorschautitel = $webinar_shorttitle . "..."; }
        if (strlen($webinar_vorschautitel)<1) { $webinar_vorschautitel = $title; }
        if (strlen($webinar_vorschautitel)>60) { $webinar_vorschautitel = substr($webinar_vorschautitel, 0, 60) . "..."; } ;
        $webinar_vorschautext = get_field("webinar_vorschautext");
        if (strlen($webinar_vorschautitel)<1) { $webinar_vorschautitel = $title; }



        if (1 == $manyauthors) {
            $autor_id = $multiautor[0];
            $webinar_speaker_id = 0000;
            foreach ($multiautor as $helper) {
                $multiautor_id = $helper;
                foreach ($webinar_speaker_helper as $helper2) {
                    if ( $helper2->ID == $multiautor_id ) {
                        $webinar_speaker_id = $autor_id;
                    } else {  }
                }
            }
        } else {
            if ($autor_id != NULL) {
                $webinar_speaker_id = $webinar_speaker->ID;
                foreach ($webinar_speaker_helper as $helper) {
                    if ($helper->ID == $autor_id) {
                        $webinar_speaker_id = $helper->ID;
                    }
                }
            } else {
                $webinar_speaker_id = NULL;
            }
        }

        $webinar_compare = $webinar_day . " " . $webinar_time;
        $webinar_compare = $webinar_day . " " . $webinar_time;
        $webinar_date_compare = strtotime($webinar_compare); //convert seminar date to unix string for future-check the entries

        ?>
        <?php if ($today_date <= $webinar_date_compare) {$webinar_status = "zukunft"; } else { $webinar_status = "vergangenheit"; } //set webinar status?>
        <?php if ( ($webcount <= $anzahl ) AND ( $webinar_speaker_id == $autor_id ) AND( $webinar_status == $status OR $status == "alle") ) { ?>
            <?php if ( $countonly == false) {
                $date = DateTime::createFromFormat('d.m.Y', $webinar_day);
                $date2 = date_create($webinar_day);
                $intervall = date_diff($date1, $date2);
                $difference = $intervall ->format('%a');
                //$webinar_date = $date->format('Y-m-d');
                //Convert it into a timestamp.
                $timestamp = strtotime($webinar_day);
                //Convert it to DD-MM-YYYY
                $webinar_day = date("d.m.Y", $timestamp);

                if ($webcount == 1 AND $highlight_next == true) {
                    /////////////////////////////////////////********************************************************************************///////////////////////////////////
                    /////////////////////////////////////////********************************************************************************///////////////////////////////////
                    /////////////////////////////////////////********************************************************************************///////////////////////////////////
                    /////////////////////////////////////////********************************************************************************///////////////////////////////////
                    ///SCHEMA FOR THE NEXT WEBINAR!
                    $speakername = "";
                    $i=0;
                    foreach ($webinar_speaker_helper as $helper) {
                        $i++;
                        if ($i>1) { $speakername .= ", "; }
                        $speakername .= get_the_title($helper->ID);
                    }
                    if ($webinar_status != "vergangenheit") {
                        ?>
                        <script type="application/ld+json">{
                      "@context": "http://schema.org",
                        "@type": "EducationEvent",
                        "name": "&#x1F6A9;<?php print get_the_title();?>",
                        "description": "<?php print str_replace('"', "'", get_field('webinar_beschreibung')); ?>",
                        "startDate": "<?php print date("Y-m-d", strtotime($webinar_day));?>T<?php print $webinar_time; ?>",
                        "endDate": "<?php print date("Y-m-d", strtotime($webinar_day));?>T<?php print $webinar_time_ende; ?>",
                        "offers": {
                              "@type":"Offer",
                              "url":"<?php print get_the_permalink();?>",
                              "availability":"http://schema.org/InStock",
                              "price":"0",
                              "priceCurrency":"EUR",
                              "validFrom":"<?php print get_the_date('Y-m-d');?>"
                        },
                        "image": {
                                "@type": "ImageObject",
                            "url": "https://www.omt.de/uploads/logo-sd.png",
                            "height": 183,
                            "width": 460
                        },
                        "performer": {
                                "@type": "Person",
                            "name": "<?php print $speakername;?>"
                        },
                        "location": {
                                "@type": "Place",
                            "name": "www.omt.de",
                            "address": "www.omt.de"
                        },
                        "url": "<?php print get_the_permalink();?>"
                    }</script>

                    <?php }
                    /////////////////////////////////////////********************************************************************************///////////////////////////////////
                    /////////////////////////////////////////********************************************************************************///////////////////////////////////
                    /////////////////////////////////////////********************************************************************************///////////////////////////////////
                    /////////////////////////////////////////********************************************************************************///////////////////////////////////
                    /////////////////////////////////////////********************************************************************************///////////////////////////////////
                    $speaker_image = get_field("profilbild", $webinar_speaker->ID);
                    ?>
                    <div class="teaser-modul-highlight webinare-highlight">
                        <div class="teaser-image-wrap" style="">
                            <img class="webinar-image teaser-img" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $speaker_image['sizes']['550-290'];?>"/>
                            <img alt="OMT Webinare" title="OMT Webinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-550.png" style="">
                        </div>
                        <div class="textarea"><?php
                            $webinar_count_id++;
                            ?>
                            <h2 class="h4 no-ihv">
                                <?php if ($webinar_status != "vergangenheit") { ?><span>
                                    <?php if ($difference == 0) { print "HEUTE"; } elseif ($difference == 1 ) { print "MORGEN"; } else { print "IN " . $difference . " TAGEN:"; } ?>
                                    </span>
                                    <div class="teaser-date teaser-cat"><?php if ($difference>1) { ?><i class="fa fa-calendar" style="vertical-align:middle;margin-right: 5px;"> </i><?php print $webinar_day; ?> <?php } ?><i class="fa fa-clock-o" style="vertical-align:middle; margin-right:5px;<?php if ($difference>1) { ?>margin-left:20px;<?php } ?>"> </i><?php print $webinar_time . " bis " . $webinar_time_ende . " Uhr";?></div>
                                <?php } ?>
                                <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" href="<?php print get_the_permalink()?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>">
                                    <?php print $webinar_vorschautitel; ?>
                                </a>
                            </h2>
                            <p class="">
                                <?php
                                $i=0;
                                foreach ($webinar_speaker_helper as $helper) {
                                    $i++;
                                    if ($i>1) { print ", "; }
                                    ?>
                                    <?php if ( get_the_permalink($helper->ID) == get_the_permalink($currentID)) { ?>
                                        <span><?php print get_the_title($helper->ID); ?></span>
                                    <?php } else { ?>
                                        <a target="_self" href="<?php print get_the_permalink($helper->ID);?>"><b><?php print get_the_title($helper->ID); ?></b></a>
                                    <?php } ?>
                                <?php } ?>
                                <br/>
                                <?php showBeforeMore(get_field('webinar_beschreibung')); ?>
                            </p>
                            <?php print $webinar_vorschautext?>
                            <?php $webinarbuttontext = "Details und Anmeldung"; if ($webinar_status != "zukunft") { $webinarbuttontext = "Gratis anschauen"; } ?>
                            <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" class="button" href="<?php print get_the_permalink()?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>" title="<?php the_title_attribute(); ?>"><?php print $webinarbuttontext;?></a>
                        </div>
                    </div>
                    <?php
                } ?>
                <?php if ( "zukunft" != $webinar_status AND "alle" != $status ) { //then status is vergangenheit!
                    if (($webcount != 1 AND $highlight_next == true) OR $highlight_next != true AND $webinar_count_id<9) {
                        $speaker_image = get_field("profilbild", $webinar_speaker->ID);
                        $webinar_count_id++; ?>
                        <div class="omt-webinar teaser teaser-small teaser-matchbuttons <?php if ($webcount == 1 AND $highlight_next != true AND "zukunft" == $webinar_status) { print "highlight-small"; } ?>">
                            <div class="teaser-image-wrap" style="">
                                <img class="webinar-image teaser-img" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $speaker_image['sizes']['350-180'];?>"/>
                                <img alt="OMT Webinare" title="OMT Webinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" style="">
                            </div>
                            <?php //if ($webcount == 1 AND $highlight_next != true AND "zukunft" == $webinar_status) { print "<h4 class='teaser-cat'>Nächstes Webinar</h4>"; } ?>
                            <h2 class="h4 no-ihv"><a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" href="<?php print get_the_permalink()?>">
                                    <?php print $webinar_vorschautitel; ?>
                                </a>
                            </h2>
                            <div class="webinar-meta">
                                <?php if ("zukunft" == $webinar_status) {?>
                                    <div class="teaser-date teaser-cat"><?php if ($difference>1) { ?><i class="fa fa-calendar" style="vertical-align:middle;margin-right: 5px;"> </i><?php print $webinar_day; ?> <?php } ?><i class="fa fa-clock-o" style="vertical-align:middle; margin-right:5px;<?php if ($difference>1) { ?>margin-left:20px;<?php } ?>"> </i><?php print $webinar_time . " bis " . $webinar_time_ende . " Uhr";?></div>
                                <?php } ?>
                                <div class="teaser-expert">
                                    <?php
                                    $i=0;
                                    foreach ($webinar_speaker_helper as $helper) {
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
                            <?php //showBeforeMore(get_field('webinar_beschreibung')); ?>
                            <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" class="button" href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>"><?php if ("zukunft" == $webinar_status) { print "Details und Anmeldung"; } else { print "Gratis anschauen"; } ?></a>
                        </div>
                        <?php

                        ?>
                    <?php } ?>
                    <?php if ($webinar_count_id == 9) {
                        $webinar_count_id++;
                        ?>
                        <div style="display:block;width:100%;"><a data-cat="<?php print $kategorie_id;?>" class="button button-gradient button-730px button-center button-loadmore webinare-loadmore" href="#">Mehr laden</a></div>
                        <div class="status webinare-ajax-status"><i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Webinare werden geladen</div>
                        <div class="teaser-loadmore webinare-results"></div>
                    <?php } ?>
                <?php } ?>
                <?php if ( "zukunft" == $webinar_status ) { ?>
                    <?php if (($webcount != 1 AND $highlight_next == true) OR $highlight_next != true) {
                        /////////////////////////////////////////********************************************************************************///////////////////////////////////
                        /////////////////////////////////////////********************************************************************************///////////////////////////////////
                        /////////////////////////////////////////********************************************************************************///////////////////////////////////
                        /////////////////////////////////////////********************************************************************************///////////////////////////////////
                        ///SCHEMA FOR THE NEXT WEBINAR!
                        $speakername = "";
                        $i=0;
                        foreach ($webinar_speaker_helper as $helper) {
                            $i++;
                            if ($i>1) { $speakername .= ", "; }
                            $speakername .= get_the_title($helper->ID);
                        } ?>
                        <script type="application/ld+json">{
                      "@context": "http://schema.org",
                        "@type": "EducationEvent",
                        "name": "&#x1F6A9;<?php print get_the_title();?>",
                        "description": "<?php print str_replace('"', "'", get_field('webinar_beschreibung')); ?>",
                        "startDate": "<?php print date("Y-m-d", strtotime($webinar_day));?>T<?php print $webinar_time; ?>",
                        "endDate": "<?php print date("Y-m-d", strtotime($webinar_day));?>T<?php print $webinar_time_ende; ?>",
                        "offers": {
                              "@type":"Offer",
                              "url":"<?php print get_the_permalink();?>",
                              "availability":"http://schema.org/InStock",
                              "price":"0",
                              "priceCurrency":"EUR",
                              "validFrom":"<?php print get_the_date('Y-m-d');?>"
                        },
                        "image": {
                                "@type": "ImageObject",
                            "url": "https://www.omt.de/uploads/logo-sd.png",
                            "height": 183,
                            "width": 460
                        },
                        "performer": {
                                "@type": "Person",
                            "name": "<?php print $speakername;?>"
                        },
                        "location": {
                                "@type": "Place",
                            "name": "www.omt.de",
                            "address": "www.omt.de"
                        },
                        "url": "<?php print get_the_permalink();?>"
                    }</script>

                        <?php
                        /////////////////////////////////////////********************************************************************************///////////////////////////////////
                        /////////////////////////////////////////********************************************************************************///////////////////////////////////
                        /////////////////////////////////////////********************************************************************************///////////////////////////////////
                        /////////////////////////////////////////********************************************************************************///////////////////////////////////
                        /////////////////////////////////////////********************************************************************************///////////////////////////////////
                        ///
                        $speaker_image = get_field("profilbild", $webinar_speaker->ID);
                        $webinar_count_id++; ?>
                        <div class="omt-webinar teaser teaser-small teaser-matchbuttons <?php if ($webcount == 1 AND $highlight_next != true AND "zukunft" == $webinar_status) { print "highlight-small"; } ?>">
                            <div class="teaser-image-wrap" style="">
                                <img class="webinar-image teaser-img" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $speaker_image['sizes']['350-180'];?>"/>
                                <img alt="OMT Webinare" title="OMT Webinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" style="">
                            </div>
                            <?php //if ($webcount == 1 AND $highlight_next != true AND "zukunft" == $webinar_status) { print "<h4 class='teaser-cat'>Nächstes Webinar</h4>"; } ?>
                            <h2 class="h4 no-ihv"><a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" href="<?php print get_the_permalink()?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>">
                                    <?php print $webinar_vorschautitel; ?>
                                </a>
                            </h2>
                            <div class="webinar-meta">
                                <?php if ("zukunft" == $webinar_status) { ?>
                                    <div class="teaser-date teaser-cat"><i class="fa fa-calendar" style="vertical-align:middle;margin-right: 5px;"> </i><?php print $webinar_day; ?> <i class="fa fa-clock-o" style="vertical-align:middle; margin-right:5px;margin-left:20px;<?php if ($difference>1) { ?>margin-left:20px;<?php } ?>"> </i><?php print $webinar_time . " bis " . $webinar_time_ende . " Uhr";?></div>
                                <?php } ?>
                                <div class="teaser-expert">
                                    <?php
                                    $i=0;
                                    foreach ($webinar_speaker_helper as $helper) {
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
                            <?php //showBeforeMore(get_field('webinar_beschreibung')); ?>
                            <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" class="button" href="<?php the_permalink()?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>" title="<?php the_title_attribute(); ?>"><?php if ("zukunft" == $webinar_status) { print "Details und Anmeldung"; } else { print "Gratis anschauen"; } ?></a>
                        </div>
                        <?php

                        ?>
                    <?php } ?>
                <?php } ?>
                <?php if ( "zukunft" != $webinar_status AND "alle" == $status) {
                    if ("true" == $highlight_next AND $webcount = 1) { $skip = true; } else { $skip = false; }
                    if ($skip != true) { //need this last 2 lines to prevent outputting the first webinar 2x if highlight_next is on
                        $speaker_image = get_field("profilbild", $webinar_speaker->ID);
                        $webinar_count_id++; ?>
                        <div class="omt-webinar teaser teaser-small teaser-matchbuttons <?php if ($webcount == 1 AND $highlight_next != true AND "zukunft" == $webinar_status) { print "highlight-small"; } ?>">
                            <div class="teaser-image-wrap" style="">
                                <img class="webinar-image teaser-img" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $speaker_image['sizes']['350-180'];?>"/>
                                <img alt="OMT Webinare" title="OMT Webinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" style="">
                            </div>
                            <?php //if ($webcount == 1 AND $highlight_next != true AND "zukunft" == $webinar_status) { print "<h4 class='teaser-cat'>Nächstes Webinar</h4>"; } ?>
                            <h2 class="h4 no-ihv"><a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" href="<?php print get_the_permalink()?>">
                                    <?php print $webinar_vorschautitel; ?>
                                </a>
                            </h2>
                            <div class="webinar-meta">
                                <?php if ("zukunft" == $webinar_status) { ?>
                                    <div class="teaser-date teaser-cat"><?php if ($difference>1) { ?><i class="fa fa-calendar" style="vertical-align:middle;margin-right: 5px;"> </i><?php print $webinar_day; ?> <?php } ?><i class="fa fa-clock-o" style="vertical-align:middle; margin-right:5px;<?php if ($difference>1) { ?>margin-left:20px;<?php } ?>"> </i><?php print $webinar_time . " bis " . $webinar_time_ende . " Uhr";?></div>
                                <?php } ?>
                                <div class="teaser-expert">
                                    <?php
                                    $i=0;
                                    foreach ($webinar_speaker_helper as $helper) {
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
                            <?php //showBeforeMore(get_field('webinar_beschreibung')); ?>
                            <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" class="button" href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>"><?php if ("zukunft" == $webinar_status) { print "Details und Anmeldung"; } else { print "Gratis anschauen"; } ?></a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php  } //if countonly is false so we dont create output if true and just count up the numbers?>
            <?php $webcount++;?>
        <?php } ?>
    <?php endwhile;
    // END OF SPEEDTEST, SCRIPT COMES BEFORE THIS
    /*  $ru = getrusage();
      echo "This process used " . rutime($ru, $rustart, "utime") .
          " ms for its computations\n";
      echo "It spent " . rutime($ru, $rustart, "stime") .
          " ms in system calls\n";
      // END OF SPEEDTEST, SCRIPT COMES BEFORE THIS*/
    wp_reset_postdata();
    if ($webcount == 1 AND $countonly == false ) { print "<p class='text-center'>Derzeit keine anstehenden Webinare.</p>"; }

    ?>
    <?php //*******************WEBINARE LOGIK VOM ALTEN OMT ENDE**********************//

    return $webcount-1;


}