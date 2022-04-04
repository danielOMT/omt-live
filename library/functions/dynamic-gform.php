<?php /////dynamic GFORM Populating SELECT Fields for TOol Umfrage
//add_filter( 'gform_pre_render_104', 'populate_posts' );
add_filter( 'gform_pre_validation_104', 'populate_posts' );
add_filter( 'gform_pre_submission_filter_104', 'populate_posts' );
//add_filter( 'gform_admin_pre_render_104', 'populate_posts' );
function populate_posts( $form ) {
    $toolkategorien = array(
        array( "class" => "populate-ab-tools", "id" => 739, "include-children" => false ),
        array( "class" => "populate-agentursoftware-tools", "id" => 332 , "include-children" => false),
        array( "class" => "populate-bewerbungsmanagement-tools", "id" => 929, "include-children" => false ),
        array( "class" => "populate-bid-management-tools", "id" => 989, "include-children" => false ),
        array( "class" => "populate-cookie-consent-tools", "id" => 687, "include-children" => false ),
        array( "class" => "populate-crm-tools", "id" => 330, "include-children" => false),
        array( "class" => "populate-newsletter-tools", "id" => 349, "include-children" => false),
        array( "class" => "populate-erp-tools", "id" => 467 , "include-children" => false),
        array( "class" => "populate-event-management-tools", "id" => 787 , "include-children" => false),
        array( "class" => "populate-fulfillment-tools", "id" => 841 , "include-children" => false),
        array( "class" => "populate-hr-tools", "id" => 693 , "include-children" => false),
        array( "class" => "populate-linkedin-tools", "id" => 566 , "include-children" => false),
        array( "class" => "populate-marketing-automation-tools", "id" => 192 , "include-children" => false),
        array( "class" => "populate-mockup-tools", "id" => 460 , "include-children" => false),
        array( "class" => "populate-payment-tools", "id" => 523 , "include-children" => false),
        array( "class" => "populate-projektmanagement-tools", "id" => 324 , "include-children" => false),
        array( "class" => "populate-rechnungsprogramme-tools", "id" => 333 , "include-children" => false),
        array( "class" => "populate-reporting-tools", "id" => 515 , "include-children" => false),
        array( "class" => "populate-seo-tools", "id" => 185 , "include-children" => false),
        array( "class" => "populate-shopsysteme-tools", "id" => 461 , "include-children" => false),
        array( "class" => "populate-usability-testing-tools", "id" => 582 , "include-children" => false),
        array( "class" => "populate-webanalyse-tools", "id" => 438 , "include-children" => false),
        array( "class" => "populate-webkonferenz-tools", "id" => 535 , "include-children" => false),
        array( "class" => "populate-website-monitoring-tools", "id" => 458 , "include-children" => false),
        array( "class" => "populate-zeiterfassungs-tools", "id" => 504 , "include-children" => false),
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