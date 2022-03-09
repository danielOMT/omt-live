<?php /////dynamic GFORM Populating SELECT Fields for TOol Umfrage
add_filter( 'gform_pre_render_26', 'populate_posts' );
add_filter( 'gform_pre_validation_26', 'populate_posts' );
add_filter( 'gform_pre_submission_filter_26', 'populate_posts' );
add_filter( 'gform_admin_pre_render_26', 'populate_posts' );
function populate_posts( $form ) {
    $toolkategorien = array(
        array( "class" => "populate-affiliate-tools", "id" => 475, "include-children" => false ),
        array( "class" => "populate-agentursteuerung-tools", "id" => 332 , "include-children" => false),
        array( "class" => "populate-amazon-seo-tools", "id" => 497, "include-children" => false ),
        array( "class" => "populate-content-marketing-tools", "id" => 378, "include-children" => true ),
        array( "class" => "populate-content-management-systeme-tools", "id" => 466, "include-children" => true ),
        array( "class" => "populate-conversion-optimierung-tools", "id" => 189, "include-children" => false),
        array( "class" => "populate-crm-systeme-tools", "id" => 330, "include-children" => false),
        array( "class" => "populate-email-marketing-tools", "id" => 349 , "include-children" => false),
        array( "class" => "populate-erp-tools", "id" => 467 , "include-children" => false),
        array( "class" => "populate-facebook-ads-tools", "id" => 513 , "include-children" => false),
        array( "class" => "populate-google-ads-tools", "id" => 496 , "include-children" => false),
        array( "class" => "populate-google-analytics", "id" => 196 , "include-children" => false),
        array( "class" => "populate-growth-hacking-tools", "id" => 563 , "include-children" => false),
        array( "class" => "populate-marketing-automation-tools", "id" => 192 , "include-children" => false),
        array( "class" => "populate-influencer-marketing-tools", "id" => 386 , "include-children" => false),
        array( "class" => "populate-linkbuilding-tools", "id" => 197 , "include-children" => false),
        array( "class" => "populate-online-marketing-tools", "id" => 186 , "include-children" => false),
        array( "class" => "populate-payment-anbieter-tools", "id" => 523 , "include-children" => false),
        array( "class" => "populate-pinterest-marketing-tools", "id" => 564 , "include-children" => false),
        array( "class" => "populate-projektmanagement-tools", "id" => 324, "include-children" => false),
        array( "class" => "populate-rechnungsprogramme-tools", "id" => 333 , "include-children" => false),
        array( "class" => "populate-sales-tools", "id" => 565 , "include-children" => false),
        array( "class" => "populate-shopsysteme-tools", "id" => 461 , "include-children" => false),
        array( "class" => "populate-social-media-marketing-tools", "id" => 188 , "include-children" => false),
        array( "class" => "populate-suchmaschinenoptimierung-tools", "id" => 185 , "include-children" => false),
        array( "class" => "populate-video-marketing-tools", "id" => 398 , "include-children" => false),
        array( "class" => "populate-webanalyse-tools", "id" => 438 , "include-children" => false),
        array( "class" => "populate-webkonferenz-anbieter-tools", "id" => 535 , "include-children" => false),
        array( "class" => "populate-zeiterfassung-tools", "id" => 504 , "include-children" => false),
        //array( "class" => "populate-webdesign-tools", "id" => 475 , "include-children" => false),
        //array( "class" => "populate-wordpress-tools", "id" => 475 , "include-children" => false),
    );
    foreach ($toolkategorien as $kategorie) {
        foreach ( $form['fields'] as $field ) {
            if (strpos($field->cssClass, $kategorie['class']) === false) {
                continue;
            }
            // you can add additional parameters here to alter the posts that are retrieved
            // more info: http://codex.wordpress.org/Template_Tags/get_posts
            $args = [
                'posts_per_page' => -1,
                'post_status' => array('publish', 'private'),
                'post_type' => 'tool',
                'order' => 'ASC',
                'orderby' => 'title',
                'tax_query' => [
                    [
                        'taxonomy' => 'tooltyp',
                        'terms' => $kategorie['id'],
                        'include_children' => $kategorie['include-children'] // Remove if you need posts from term 7 child terms
                    ],
                ],
                // Rest of your arguments
            ];
            $posts = get_posts($args);

            $choices = array();

            foreach ($posts as $post) {
                $choices[] = array('text' => $post->post_title, 'value' => $post->post_title);
            }

            // update 'Select a Post' to whatever you'd like the instructive option to be
            $field->placeholder = 'Select a Post';
            $field->choices = $choices;
        }
    }
    return $form;
}