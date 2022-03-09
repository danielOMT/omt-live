<?php
function vb_filter_webinare() {
    $response = [
        'status'  => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false,
        'found'   => 0
    ];
    /**
     * Setup query
     */
    $kategorie_id = $_POST['category'];
    $anzahl = $_POST['anzahl'];

    $url = get_template_directory() . '/library/json/webinare.json';
    $content_json = file_get_contents($url);
    $json = json_decode($content_json, true);

    ob_start();
    if (count($json) > 0) {
        $webcount=1;
        $webinar_count_id=1;

        usort($json, 'timestamp_compare_desc');
        if ($kategorie_id != NULL) {
            $term = get_term( $kategorie_id, 'kategorie' );
            $slug = $term->slug;
        }

        foreach ($json as $webinar) {
            if (NULL == $kategorie_id) {
                $match = TRUE;
            } else {
                $match = FALSE;
                if (has_term($slug, 'kategorie', $webinar['ID'])) {
                    $match = TRUE;
                }
            }

            if (TRUE == $match) {
                $webinar_day = $webinar['$webinar_day'];
                $webinar_time = $webinar['$webinar_time'];
                $webinar_time_ende = $webinar['$webinar_time_ende'];
                $webinar_vorschautitel = $webinar['$webinar_vorschautitel'];
                $title = $webinar['$title'];

                if (strlen($webinar_vorschautitel)<1) { $webinar_vorschautitel = $title; }
                
                $webinar_vorschautext = $webinar['$webinar_vorschautext'];
                $webinar_status = $webinar['$webinar_status']; //set webinar status
                $post_ID = get_the_ID();
                ?>
                <?php if ( "vergangenheit" == $webinar['$webinar_status'] ) {
                    if ($webcount >= $anzahl+1) {
                        ?>
                        <div class="omt-webinar teaser teaser-small teaser-matchbuttons <?php if ($webcount == 1 AND $highlight_next != true AND "zukunft" == $webinar_status) { print "highlight-small"; } ?>">
                            <div class="teaser-image-wrap">
                                <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>"  href="<?php print $webinar['$link'];?><?php if (strlen($user_firstname)>0) { ?>?email=<?php print $user_email;?>&firstname=<?php print $user_firstname;?>&lastname=<?php print $user_lastname; }?>" title="<?php print $webinar['$title']; ?>">
                                    <img class="webinar-image teaser-img" alt="<?php  print $webinar['$title'];?>" title="<?php  print $webinar['$title'];?>" src="<?php print $webinar['$image_350'];?>"/>
                                    <img alt="OMT Webinare" title="OMT Webinare" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
                                </a>
                            </div>
                            <h2 class="h4 no-ihv teaser-two-lines-title">
                                <a 
                                    x-data="xLinesClamping()"
                                    x-init="clamp(2)"
                                    title="<?php echo htmlspecialchars($webinar_vorschautitel) ?>"
                                    data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" 
                                    href="<?php print $webinar['$link']?>"
                                >
                                    <?php echo truncateString($webinar_vorschautitel) ?>
                                </a>
                            </h2>
                            <div class="webinar-meta">
                                <?php if ("zukunft" == $webinar_status) { ?>
                                    <div class="teaser-date teaser-cat"><i class="fa fa-calendar" style="vertical-align:middle;margin-right: 5px;"> </i><?php print $webinar_day; ?> <i class="fa fa-clock-o" style="vertical-align:middle; margin-right:5px;margin-left:20px;<?php if ($difference>1) { ?>margin-left:20px;<?php } ?>"> </i><?php print $webinar_time . " bis " . $webinar_time_ende . " Uhr";?></div>
                                <?php } ?>
                                <div class="teaser-expert">
                                    <a href="<?php print $webinar['$speaker_url'];?>"><?php print $webinar['$speaker1_name']?></a>
                                    <?php if (strlen($webinar2_speaker_id)>0) {?>, <a href="<?php print $webinar['$speaker2_url'];?>"><?php print $webinar['$speaker2_name']?></a><?php } ?>
                                    <?php if (strlen($webinar3_speaker_id)>0) {?>, <a href="<?php print $webinar['$speaker3_url'];?>"><?php print $webinar['$speaker3_name']?></a><?php } ?>
                                </div>
                            </div>

                            <a data-webinar-<?php print $webinar_status;?>-count="<?php print $webinar_count_id;?>" class="button" href="<?php print $webinar['$link'];?>" title="<?php print $webinar['$title']; ?>"><?php if ("zukunft" == $webinar_status) { print "Details und Anmeldung"; } else { print "Gratis anschauen"; } ?></a>
                        </div>

                        <?php
                    } //if current webinar is >9?>
                    <?php $webcount++;?>
                    <?php $webinar_count_id++;?>
                <?php } ?>
            <?php } ?>
        <?php };

        $response = [
            'status'=> 200
        ];
    } else {
        $response = [
            'status'  => 201,
            'message' => 'Leider keine Webinare gefunden.'
        ];
    }

    $response['content'] = ob_get_clean();
    die(json_encode($response));
}

add_action('wp_ajax_do_filter_webinare', 'vb_filter_webinare');
add_action('wp_ajax_nopriv_do_filter_webinare', 'vb_filter_webinare');