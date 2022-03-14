<?php
///automatically populate the datahost => Tools Table with our Tools Data
/// Those tools will later on be linked with toolanbieter, tracking links and clicks
///https://www.omt.de/wp-content/themes/omt/library/tools/sql/sql-tools.php
function sql_tools()
{
    //require_once ( get_template_directory() . '/library/tools/tools-functions.php');

    // Create connection
    $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $args = array(
        'role' => 'um_toolanbieter',
        'orderby' => 'user_nicename',
        'order' => 'ASC'
    );
    $usertools = array();
    $users = get_users($args);
    foreach ($users as $user) {
        $current_user_id = $user->id;
        $zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);
        foreach($zugewiesenes_tool as $tool) {
            $tool_id = $tool->ID;
            $usertools[] = $tool_id;
        }
    }
    $args = array( //next tools 1st
        'posts_per_page' => -1,
        'posts_status' => "publish",
        'post_type' => 'tool',
        'post__in' => $usertools,
        'order' => 'DESC',
        'orderby' => 'date'
    );
    $webcount = 0;

    //////HELPER FUNCTION FOR TRACKERLINK SQL MOVEMENTS
    function tracking_link_sql(int $linkid =0, string $tracking_link="", int $tool_id = 0, string $tool_name="", int $toolkategorie_id = 0, string $toolkategorie_slug="", string $toolkategorie_name="" ) {
        $sql = "INSERT INTO omt_trackinglinks (id, tracking_link, tool_id, tool_name, toolkategorie_id, toolkategorie_slug, toolkategorie_name) 
            VALUES ('$linkid', '$tracking_link', '$tool_id', '$tool_name', '$toolkategorie_id', '$toolkategorie_slug', '$toolkategorie_name') 
            ON DUPLICATE KEY UPDATE tracking_link='$tracking_link', tool_id='$tool_id', tool_name='$tool_name', toolkategorie_id='$toolkategorie_id', toolkategorie_slug='$toolkategorie_slug', toolkategorie_name='$toolkategorie_name'";
        return $sql;
    }
    ////////////////////////////////////////////////////////

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        $ID = get_the_ID();
        if ((( get_post_status() != 'draft' ) AND ($ID != 191511) )/* AND (get_post_status() != "private")*/) {
            if (get_post_status() != "private") { $post_status = "publish"; } else { $post_status = "private"; }

            $title = get_the_title();
            $link = get_the_permalink();
            if ("publish" == $post_status) { $status = 1; } else { $status = 0; }
            $zur_website = get_field('zur_webseite');
            $toolanbieter_website_clickmeter_link_id = get_field('toolanbieter_website_clickmeter_link_id');
            $tool_preisubersicht = get_field('tool_preisubersicht');
            $tool_preisubersicht_clickmeter_link_id = get_field('tool_preisubersicht_clickmeter_link_id');
            $tool_gratis_testen_link = get_field('tool_gratis_testen_link');
            $tool_gratis_testen_link_clickmeter_link_id = get_field('tool_gratis_testen_link_clickmeter_link_id');
            $tool_kategorien_content = get_field('tool_kategorien');


            //////////CREATE AND FILL ARRAY MIT TRACKING LINKS
            $trackinglinks = array();
            ////Push Website Link into ARray if available
            if ( $toolanbieter_website_clickmeter_link_id>0 ) {
                $arr_data = array(
                    '$linkid' => $toolanbieter_website_clickmeter_link_id,
                    '$tracking_link' => $zur_website,
                    '$tool_id' => $ID,
                    '$tool_name' => $title,
                    '$toolkategorie_id' => 0,
                    '$toolkategorie_slug' => "",
                    '$toolkategorie_name' => ""
                );
                array_push($trackinglinks, $arr_data);
            }
            ////Push Price LInk into ARray if available
            if ( $tool_preisubersicht_clickmeter_link_id>0 ) {
                $arr_data = array(
                    '$linkid' => $tool_preisubersicht_clickmeter_link_id,
                    '$tracking_link' => $tool_preisubersicht,
                    '$tool_id' => $ID,
                    '$tool_name' => $title,
                    '$toolkategorie_id' => 0,
                    '$toolkategorie_slug' => "",
                    '$toolkategorie_name' => ""
                );
                array_push($trackinglinks, $arr_data);
            }
            ////Push Price LInk into ARray if available
            if ( $tool_gratis_testen_link_clickmeter_link_id>0 ) {
                $arr_data = array(
                    '$linkid' => $tool_gratis_testen_link_clickmeter_link_id,
                    '$tracking_link' => $tool_gratis_testen_link,
                    '$tool_id' => $ID,
                    '$tool_name' => $title,
                    '$toolkategorie_id' => 0,
                    '$toolkategorie_slug' => "",
                    '$toolkategorie_name' => ""
                );
                array_push($trackinglinks, $arr_data);
            }

            ///PUSH CATEGORY LINKS INTO ARRAY WHERE AVAILABLE
            if (is_array($tool_kategorien_content)) {
                foreach ($tool_kategorien_content as $kategorie) {
                    $link_website = $kategorie['kategorie_zur_website_link'];
                    $clickmeter_link_id_website = $kategorie['kategorie_zur_website_clickmeter_link_id'];
                    $link_preis = $kategorie['kategorie_preisubersicht_link'];
                    $clickmeter_link_id_preis = $kategorie['kategorie_preisubersicht_clickmeter_link_id'];
                    $link_testen = $kategorie['kategorie_tool_testen_link'];
                    $clickmeter_link_id_testen = $kategorie['kategorie_tool_testen_clickmeter_link_id'];
                    $catid = $kategorie['kategorie'];
                    $term = get_term_by('id', $catid, 'tooltyp');
                    $slug = $term->slug;
                    $name = $term->name;
                    if ( ( strlen( $link_website)>0 ) AND ( strlen($clickmeter_link_id_website)>0 ) ) {
                        $arr_data = array(
                            '$linkid' => $clickmeter_link_id_website,
                            '$tracking_link' => $link_website,
                            '$tool_id' => $ID,
                            '$tool_name' => $title,
                            '$toolkategorie_id' => $catid,
                            '$toolkategorie_slug' => $slug,
                            '$toolkategorie_name' => $name
                        );
                        array_push($trackinglinks, $arr_data);
                    }
                    if ( ( strlen( $link_preis)>0 ) AND ( strlen($clickmeter_link_id_preis)>0 ) ) {
                        $arr_data = array(
                            '$linkid' => $clickmeter_link_id_preis,
                            '$tracking_link' => $link_preis,
                            '$tool_id' => $ID,
                            '$tool_name' => $title,
                            '$toolkategorie_id' => $catid,
                            '$toolkategorie_slug' => $slug,
                            '$toolkategorie_name' => $name
                        );
                        array_push($trackinglinks, $arr_data);
                    }
                    if ( ( strlen( $link_testen)>0 ) AND ( strlen($clickmeter_link_id_testen)>0 ) ) {
                        $arr_data = array(
                            '$linkid' => $clickmeter_link_id_testen,
                            '$tracking_link' => $link_testen,
                            '$tool_id' => $ID,
                            '$tool_name' => $title,
                            '$toolkategorie_id' => $catid,
                            '$toolkategorie_slug' => $slug,
                            '$toolkategorie_name' => $name
                        );
                        array_push($trackinglinks, $arr_data);
                    }
                }
            }
            $sql = "INSERT INTO omt_tools (id, status, title, link) 
                VALUES ('$ID', '$status', '$title', '$link') 
                ON DUPLICATE KEY UPDATE status='$status', title='$title', link='$link'";
        }

        if ($conn->query($sql) === false) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        //////////////////////////////////////
        /// WRITE INTO SQL OMT_TRACKINGLINKS:
        /// //////////////////////////////////

        if ( count($trackinglinks)>0 ) {
            foreach ($trackinglinks as $link) {
                $sql2 = tracking_link_sql($link['$linkid'], $link['$tracking_link'], $link['$tool_id'], $link['$tool_name'], $link['$toolkategorie_id'], $link['$toolkategorie_slug'], $link['$toolkategorie_name']);
                $conn->query($sql2);

                ///create bids if tracking link is fresh:
                /// IF A BID WITH THE GIVEN TOOLID AND CATID EXISTS ALREADY, DO NOTHING BECAUSE WE HAVE ACTING BIDDING HERE ALREADY.
                /// ELSE: CREATE A STARTING ENTRY BID
                $tool_id = $link['$tool_id'];
                $toolkategorie_id = $link['$toolkategorie_id'];
                ////check if a bid with this toolid + catid already exists:
                $bidcheck = "SELECT * FROM `omt_bids` WHERE `tool_id`=$tool_id AND `toolkategorie_id`=$toolkategorie_id";
                $query = $conn->query($bidcheck);
                if(mysqli_num_rows($query) > 0){
                        while ($bidrow = mysqli_fetch_assoc($query)) {
                            $is_active = $bidrow['is_active'];
                            if (1 == $is_active) {
                                $bid = $bidrow['bid_kosten'];
                                update_tool_bids($tool_id, $toolkategorie_id, $bid);
                            }
                        }
                    // print "BID EXISTS ALREADY";
                } else {
                    // print "DOES NOT EXIST, CREATING...";
                    $sqlbids = "INSERT INTO omt_bids (tool_id, toolkategorie_id, bid_kosten, is_active)
                            VALUES ('$tool_id', '$toolkategorie_id', '0', '1')";

                    $conn->query($sqlbids);
                }
            }
        }
    endwhile;
        wp_reset_postdata();
    $conn->close();
}
