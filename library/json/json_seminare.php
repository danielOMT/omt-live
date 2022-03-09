<?php
//https://www.omt.de/wp-content/themes/omt/library/json/json_seminare.php/
function json_seminare()
{
////*****code to get seminar entries including repeater date fields****/
    $args = array(
        'posts_status' => "publish",
        'posts_per_page' => -1,
        'post_type' => 'seminare',
    );
    $anzahl = 3;
    $seminar_id = 0;
    $myFile = ABSPATH . "wp-content/themes/omt/library/json/seminare.json";

    file_put_contents($myFile, "asdf");
    $arr_data = array(); // create empty array
    $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
    $loop = new WP_Query($args); //*args and query all "seminare" posts, then go into the repeater field within each seminar item
    while ($loop->have_posts()) : $loop->the_post();
        if ((get_post_status() != 'draft') AND (get_post_status() != "private")) {
            $seminar_title = get_the_title();
            $seminar_url = get_the_permalink();
            $seminar_wp_id = get_the_ID();
            $seminar_vorschau_headline = get_field('seminar_vorschau-headline');
            $kostenloses_seminar = get_field('kostenloses_seminar');
            if (strlen($seminar_vorschau_headline) < 1) {
                $seminar_vorschau_headline = $seminar_title;
            }
            if (strlen($seminar_vorschau_headline) > 60) {
                $seminar_vorschau_headline = substr($seminar_vorschau_headline, 0, 60) . "...";
            };
            $seminar_vorschautext = get_field('seminar_introtext');
            if (strlen($seminar_vorschautext)<1) {
                $seminar_vorschautext = get_field('seminar_beschreibung');
            }

            $seminar_speaker = get_field("seminar_speaker");

            $seminar_speaker_1 = $seminar_speaker[0]->ID;
            $seminar_speaker_2 = $seminar_speaker[1]->ID;
            $seminar_speaker_3 = $seminar_speaker[2]->ID;

            $speaker_1_name = get_the_title($seminar_speaker_1);
            $speaker_2_name = get_the_title($seminar_speaker_2);
            $speaker_3_name = get_the_title($seminar_speaker_3);
            $speaker_1_link = get_the_permalink($seminar_speaker_1);
            $speaker_2_link = get_the_permalink($seminar_speaker_2);
            $speaker_3_link = get_the_permalink($seminar_speaker_3);

            $speaker_1_image = get_field("profilbild", $seminar_speaker_1);
            $speaker_2_image = get_field("profilbild", $seminar_speaker_2);
            $speaker_3_image = get_field("profilbild", $seminar_speaker_3);


            $seminar_woocommerce = get_field('seminar_woocommerce');
            $handle = new WC_Product_Variable($seminar_woocommerce->ID);
            $available_variations = $handle->get_available_variations();
            $variations1 = $handle->get_children();
            $product_id = $seminar_woocommerce->ID;
            $product_featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), '550-290');
            $product_image_url = $product_featured_image[0];

            foreach ($variations1 as $seminar_termin) {   /*build array with all seminars and all repeater date fields*/
                //collecting data
                $single_variation = new WC_Product_Variation($seminar_termin);

                $seminar_day = $single_variation->attributes['pa_startdatum'];
                $seminar_day_unix = strtotime($seminar_day);
                $seminar_time = $single_variation->attributes['pa_startuhrzeit'];
                $seminar_time_end = $single_variation->attributes['pa_enduhrzeit'];
                $seminar_day_end = $single_variation->attributes['pa_enddatum'];

                $location = $single_variation->attributes['pa_location'];
                $location_name = get_field('location_stadtname', $location);
                $location_street = get_field('location_street', $location);
                $location_plz = get_field('location_plz', $location);
                $location_link = get_the_permalink($location);

                $termin_image = $single_variation->get_image_id();
                $img_atts = wp_get_attachment_image_src($termin_image, '550-290');
                $img_src = $img_atts[0];

                $terms = get_the_terms(get_the_ID(), 'seminartyp');
                $category_1_name = $terms[0]->name;
                $category_2_name = $terms[1]->name;
                $category_3_name = $terms[2]->name;
                $category_1_slug = $terms[0]->slug;
                $category_2_slug = $terms[1]->slug;
                $category_3_slug = $terms[2]->slug;

                if ($today_date <= $seminar_day_unix) {
                    ///array build starts here
                    $seminare[$seminar_id]['id'] = $seminar_wp_id;
                    $seminare[$seminar_id]['name'] = $seminar_title;
                    $seminare[$seminar_id]['featured_image'] = $product_image_url;
                    $seminare[$seminar_id]['vorschau'] = $seminar_vorschau_headline;
                    $seminare[$seminar_id]['vorschautext'] = $seminar_vorschautext;
                    $seminare[$seminar_id]['url'] = $seminar_url;
                    $seminare[$seminar_id]['date'] = $seminar_day;
                    $seminare[$seminar_id]['date_unix'] = $seminar_day_unix;
                    $seminare[$seminar_id]['day_start'] = str_replace('-', '.', $seminar_day);
                    $seminare[$seminar_id]['time_start'] = str_replace('-', ':', $seminar_time);
                    $seminare[$seminar_id]['day_end'] = str_replace('-', '.', $seminar_day_end);
                    $seminare[$seminar_id]['time_end'] = str_replace('-', ':', $seminar_time_end);
                    $seminare[$seminar_id]['price'] = $single_variation->price;
                    $seminare[$seminar_id]['regularprice'] = $single_variation->regular_price;
                    $seminare[$seminar_id]['location_name'] = $location_name;
                    $seminare[$seminar_id]['location_street'] = $location_street;
                    $seminare[$seminar_id]['location_plz'] = $location_plz;
                    $seminare[$seminar_id]['location_link'] = $location_link;
                    $seminare[$seminar_id]['location_image'] = $img_src;
                    $seminare[$seminar_id]['speaker_1_id'] = $seminar_speaker_1;
                    $seminare[$seminar_id]['speaker_2_id'] = $seminar_speaker_2;
                    $seminare[$seminar_id]['speaker_3_id'] = $seminar_speaker_3;
                    $seminare[$seminar_id]['speaker_1_name'] = $speaker_1_name;
                    $seminare[$seminar_id]['speaker_2_name'] = $speaker_2_name;
                    $seminare[$seminar_id]['speaker_3_name'] = $speaker_3_name;
                    $seminare[$seminar_id]['speaker_1_link'] = $speaker_1_link;
                    $seminare[$seminar_id]['speaker_2_link'] = $speaker_2_link;
                    $seminare[$seminar_id]['speaker_3_link'] = $speaker_3_link;
                    $seminare[$seminar_id]['speaker_1_image'] = $speaker_1_image['sizes']['550-290'];
                    $seminare[$seminar_id]['speaker_2_image'] = $speaker_2_image['sizes']['550-290'];
                    $seminare[$seminar_id]['speaker_3_image'] = $speaker_3_image['sizes']['550-290'];
                    $seminare[$seminar_id]['category_1_name'] = $category_1_name;
                    $seminare[$seminar_id]['category_2_name'] = $category_2_name;
                    $seminare[$seminar_id]['category_3_name'] = $category_3_name;
                    $seminare[$seminar_id]['category_1_slug'] = $category_1_slug;
                    $seminare[$seminar_id]['category_2_slug'] = $category_2_slug;
                    $seminare[$seminar_id]['category_3_slug'] = $category_3_slug;
                    $seminare[$seminar_id]['vid'] = $single_variation->get_variation_id();
                    $seminare[$seminar_id]['product_id'] = $product_id;
                    $seminare[$seminar_id]['kostenloses_seminar'] = $kostenloses_seminar;
                    $seminare[$seminar_id]['speaker'] = $seminar_speaker;
                    $seminare[$seminar_id]['seminar_terms'] = $terms;
                    $seminar_id++;
                }
            }
        }
    endwhile; //*****now we have array full with all seminar entries including all repeater field dates
    wp_reset_postdata();
    usort($seminare, 'date_compare'); //***sorting the array by date*******/

        $webcount = 0;
        foreach ($seminare as $seminar) {
            $webcount++;

            $seminar_data = array(
                'number' => $webcount,
                'id' => $seminar['id'],
                'name' => $seminar['name'],
                'featured_image' => $seminar['featured_image'],
                'vorschau' => $seminar['vorschau'],
                'vorschautext' => $seminar['vorschautext'],
                'url' => $seminar['url'],
                'date' => $seminar['date'],
                'date_unix' => $seminar['date_unix'],
                'day_start' => $seminar['day_start'],
                'time_start' => $seminar['time_start'],
                'day_end' => $seminar['day_end'],
                'time_end' => $seminar['time_end'],
                'price' => $seminar['price'],
                'regularprice' => $seminar['regularprice'],
                'location_name' => $seminar['location_name'],
                'location_street' => $seminar['location_street'],
                'location_plz' => $seminar['location_plz'],
                'location_link' => $seminar['location_link'],
                'location_image' => $seminar['location_image'],
                'speaker_1_id' => $seminar['speaker_1_id'],
                'speaker_2_id' => $seminar['speaker_2_id'],
                'speaker_3_id' => $seminar['speaker_3_id'],
                'speaker_1_name' => $seminar['speaker_1_name'],
                'speaker_2_name' => $seminar['speaker_2_name'],
                'speaker_3_name' => $seminar['speaker_3_name'],
                'speaker_1_link' => $seminar['speaker_1_link'],
                'speaker_2_link' => $seminar['speaker_2_link'],
                'speaker_3_link' => $seminar['speaker_3_link'],
                'speaker_1_image' => $seminar['speaker_1_image'],
                'speaker_2_image' => $seminar['speaker_2_image'],
                'speaker_3_image' => $seminar['speaker_3_image'],
                'category_1_name' => $seminar['category_1_name'],
                'category_2_name' => $seminar['category_2_name'],
                'category_3_name' => $seminar['category_3_name'],
                'category_1_slug' => $seminar['category_1_slug'],
                'category_2_slug' => $seminar['category_2_slug'],
                'category_3_slug' => $seminar['category_3_slug'],
                'vid' => $seminar['vid'],
                'product_id' => $seminar['product_id'],
                'kostenloses_seminar' => $seminar['kostenloses_seminar'],
                'speaker' => $seminar['speaker'],
                'seminar_terms' => $seminar['seminar_terms']
            );
            array_push($arr_data, $seminar_data);
        }

    $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    //write json data into data.json file
    file_put_contents($myFile, $jsondata);
}
?>
