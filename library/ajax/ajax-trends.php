<?php
/*function vb_ajax_pager( $query = null, $paged = 1 ) {
    if (!$query)
        return;
    $paginate = paginate_links([
        'base'      => '%_%',
        'type'      => 'array',
        'total'     => $query->max_num_pages,
        'format'    => '#page=%#%',
        'current'   => max( 1, $paged ),
        'prev_text' => 'Prev',
        'next_text' => 'Next'
    ]);
    if ($query->max_num_pages > 1) : ?>
        <ul class="pagination">
            <?php foreach ( $paginate as $page ) :?>
                <li><?php echo $page; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif;
}*/

function vb_filter_trends() {
 /*   if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'jamz' ) )
        die('Permission denied');*/
    /**
     * Default response
     */
    $response = [
        'status'  => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false,
        'found'   => 0
    ];
    $tax  = sanitize_text_field($_POST['params']['tax']);
    $term = sanitize_text_field($_POST['params']['term']);
    //$page = intval($_POST['params']['page']);
    $qty  = intval($_POST['params']['qty']);
    //array aus dem Jquery abholen:
    $all_terms = $_POST['params']['all_terms'];
    $dataset = $_POST['params']['dataset'];
    /**
     * Check if term exists
     */
    if (!term_exists( $term, $tax) && $term != 'all-terms') :
        $response = [
            'status'  => 501,
            'message' => 'Term doesn\'t exist',
            'content' => 0
        ];
        die(json_encode($response));
    endif;
    /**
     * Tax query
     */
    if ('all-terms' != $term) {
        /*$tax_qry[] = [
             'taxonomy' => $tax,
             'field' => 'slug',
             'terms' => $term,
             'operator' => 'NOT IN',
         ];
     } else {*/
        $tax_qry[] = [
            'taxonomy' => $tax,
            'field' => 'slug',
            'terms' => $term,
        ];
    }
    /**
     * Setup query
     */
    $args = [
        'post_type'      => 'trend',
        'post_status'    => array( 'publish', 'private' ),
        'posts_per_page' => -1,
        'tax_query'      => $tax_qry
    ];
    $qry = new WP_Query($args);
    ob_start();
    if ($qry->have_posts()) :
        while ($qry->have_posts()) : $qry->the_post();
            $post_ID = get_the_ID();
            if (strpos("$dataset", "$post_ID") !== false) { // check if post ID is available in the dataset of original posts so we have output from these only ?>
                <?php
                $trend_id = $post_ID;
                $experte = get_field('experte', $trend_id);
                $externer_experte_name = get_field('externer_experte_name', $trend_id);
                $externer_experte_profilbild = get_field('externer_experte_profilbild', $trend_id);
                $kurzbeschreibung_des_experten = get_field('kurzbeschreibung_des_experten', $trend_id);
                $trendeinschatzung_des_experten = get_field('trendeinschatzung_des_experten', $trend_id);
                if (!isset($experte->ID)) {
                    $speaker_name = $externer_experte_name;
                    $speaker_image = $externer_experte_profilbild;
                    $speaker_link = "";
                }
                else {
                    $speaker_image = get_field("profilbild", $experte->ID);
                    $speaker_name = $experte->post_title;
                    $speaker_link = get_the_permalink($experte->ID);
                }
                $p_tags = array("<p>", "</p>");
                $speaker_kurzprofil = str_replace($p_tags, "", $kurzbeschreibung_des_experten);
                ?>
                <div class="testimonial card clearfix expertenstimme">
                    <div class="testimonial-img">
                        <h3 class="experte"><a target="_self" href="<?php print $speaker_link;?>"><?php print $speaker_name;?></a></h3>
                        <h4 class="teaser-cat experte-info"><?php print $speaker_kurzprofil;?></h4>
                        <a target="_self" href="<?php print $speaker_link;?>">
                            <img class="teaser-img" alt="<?php print $speaker_name; ?>" title="<?php print $speaker_name; ?>" src="<?php print $speaker_image['url'];?>">
                        </a>
                    </div>
                    <div class="testimonial-text">
                        <?php print $trendeinschatzung_des_experten;?>
                    </div>
                </div>
                <?php
                //cta_text
                //cta_link
                //cta_hintergrundfarbe
                //cta_vordergrundfarbe
                $cta_text = get_field('cta_text');
                $cta_link = get_field('cta_link');
                $cta_hintergrundfarbe = get_field('cta_hintergrundfarbe');
                $cta_vordergrundfarbe = get_field('cta_vordergrundfarbe');
                if (strlen($cta_text)>0) {
                    $shortcode = sprintf(
                        '[button link-target="%1$s" background="%2$s" color="%3$s"]%4$s[/button]',
                        $cta_link,
                        $cta_hintergrundfarbe,
                        $cta_vordergrundfarbe,
                        $cta_text
                    );
                    echo do_shortcode( $shortcode );
                }
                ?>
            <?php } ?>
        <?php endwhile;
        /**
         * Pagination
         */
        // vb_ajax_pager($qry,$page);
        $response = [
            'status'=> 200,
            'found' => $qry->found_posts
        ];

    else :
        $response = [
            'status'  => 201,
            'message' => 'Leider keine Trends gefunden.'
        ];
    endif;
    $response['content'] = ob_get_clean();
    die(json_encode($response));
}
add_action('wp_ajax_do_filter_trends', 'vb_filter_trends');
add_action('wp_ajax_nopriv_do_filter_trends', 'vb_filter_trends');