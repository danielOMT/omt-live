<?php
//https://www.omt.de/wp-content/themes/omt/library/json/json_artikel.php/

use OMT\Enum\Magazines;

function json_artikel() {
    $args = array( //next seminare 1st
        'posts_per_page'    => -1,
        'posts_status'      => "publish",
        'post_type'         => Magazines::keys(),
        'order'				=> 'DESC',
        'orderby'			=> 'date'
    );
    $webcount=0;
    $myFile = ABSPATH . "wp-content/themes/omt/library/json/artikel.json";

    $arr_data = array(); // create empty array
    $loop = new WP_Query( $args );

        while ( $loop->have_posts() ) : $loop->the_post();
            if ( ( get_post_status () != 'draft' ) AND ( get_post_status() != 'private' ) AND ( get_post_status() != 'future' ) AND ( get_post_status() != 'pending' ) ) {
                $artikel_autor = get_field("autor");
                if (strlen($artikel_autor) > 0) {
                    $artikel_autor = $artikel_autor->ID;
                }
                $artikel_autor_1 = $artikel_autor[0]->ID;
                $artikel_autor_2 = $artikel_autor[1]->ID;
                $artikel_autor_3 = $artikel_autor[2]->ID;
                $artikel_autor_4 = $artikel_autor[3]->ID;
                $artikel_autor_5 = $artikel_autor[4]->ID;

                $speaker1_name = get_the_title($artikel_autor_1);
                $speaker1_url = get_the_permalink($artikel_autor_1);

                if (strlen($artikel_autor_2) > 0) {
                    $speaker2_name = get_the_title($artikel_autor_2);
                    $speaker2_url = get_the_permalink($artikel_autor_2);
                } else {
                    $speaker2_name = "";
                    $speaker2_url = "";
                }

                if (strlen($artikel_autor_3) > 0) {
                    $speaker3_name = get_the_title($artikel_autor_3);
                    $speaker3_url = get_the_permalink($artikel_autor_3);
                } else {
                    $speaker3_name = "";
                    $speaker3_url = "";
                }

                if (strlen($artikel_autor_4) > 0) {
                    $speaker4_name = get_the_title($artikel_autor_4);
                    $speaker4_url = get_the_permalink($artikel_autor_4);
                } else {
                    $speaker4_name = "";
                    $speaker4_url = "";
                }

                if (strlen($artikel_autor_5) > 0) {
                    $speaker5_name = get_the_title($artikel_autor_5);
                    $speaker5_url = get_the_permalink($artikel_autor_5);
                } else {
                    $speaker5_name = "";
                    $speaker5_url = "";
                }

                $speaker_count = count (get_field('autor'));

                $id = get_the_ID();
                $recap = get_field('recap');
                $featured_image_teaser = wp_get_attachment_image_src( get_post_thumbnail_id($id), '350-180' );
                $featured_image_highlight = wp_get_attachment_image_src( get_post_thumbnail_id($id), '550-290' );
                $image_teaser = $featured_image_teaser[0];
                $image_highlight = $featured_image_highlight[0];
                $vorschau_350 = get_field('vorschau-350x180', $id);
                if (strlen($vorschau_350['url'])>0) { $image_teaser = $vorschau_350['url']; }
                $vorschau_550 = get_field('vorschau-550-290', $id);
                if (strlen($vorschau_550['url'])>0) { $image_highlight = $vorschau_550['url']; }
                $artikel_vorschautitel = get_field("artikel_vorschautitel");
                $title = get_the_title();
                $link = get_the_permalink();
                if (strlen($artikel_vorschautitel) < 1) {
                    $artikel_vorschautitel = $title;
                }
                if (strlen($artikel_vorschautitel) > 60) {
                    $artikel_vorschautitel = substr($artikel_vorschautitel, 0, 60) . "...";
                };

                if (strlen($artikel_vorschautitel) < 1) {
                    $artikel_vorschautitel = $title;
                }
                $webcount++;
                $post_type = get_post_type();
                $artikel_id = get_the_ID();
                $reading_time = reading_time($artikel_id);
                $agenturfinder_artikel = get_field('im_agenturfinder_anzeigen');
                $post_type_data = get_post_type_object($post_type);
                $post_type_slug = $post_type_data->rewrite['slug'];

                if (has_excerpt()) { $vorschautext = get_the_excerpt(); }
                $vorschautext = get_field('vorschautext',$id);

                if (strlen($vorschautext)<1) {
                    $fullText = get_the_content();
                    if (strpos($fullText, '<!--more-->')) {
                        $morePos = strpos($fullText, '<!--more-->');
                        $vorschautext = substr($fullText, 0, $morePos);
                    } else {
                        $string = strip_tags(substr($fullText, 0, 200));
                        if (strpos($string, "]") > 0) { //if theres a shortcode in the beginning of the article string, we position ourselves behind the closing ]
                            $string = strip_tags(substr($fullText, 0, 400));
                            $string = trim(substr($string, strpos($string, ']')));
                            $vorschautext = substr($string, 1, 200);
                        } else {
                            $vorschautext = $string;
                        }
                    }
                }

                $mp4_vorschauanimation = get_field('mp4_vorschauanimation', $id);

                $artikel_data = array(
                    'number' => $webcount,
                    'ID' => get_the_ID(),
                    '$title' => $title,
                    '$link' => $link,
                    '$post_type_slug' => $post_type_slug,
                    '$post_type' => $post_type,
                    '$speaker1_name' => $speaker1_name,
                    '$speaker2_name' => $speaker2_name,
                    '$speaker3_name' => $speaker3_name,
                    '$speaker4_name' => $speaker4_name,
                    '$speaker5_name' => $speaker5_name,
                    '$speaker1_id' => $artikel_autor_1,
                    '$speaker2_id' => $artikel_autor_2,
                    '$speaker3_id' => $artikel_autor_3,
                    '$speaker4_id' => $artikel_autor_4,
                    '$speaker5_id' => $artikel_autor_5,
                    '$speaker1_url' => $speaker1_url,
                    '$speaker2_url' => $speaker2_url,
                    '$speaker3_url' => $speaker3_url,
                    '$speaker4_url' => $speaker4_url,
                    '$speaker5_url' => $speaker5_url,
                    '$speaker_count' => $speaker_count,
                    '$image_teaser' => $image_teaser,
                    '$image_highlight' => $image_highlight,
                    '$recap' => $recap,
                    '$reading_time' => $reading_time,
                    '$agenturfinder_artikel' => $agenturfinder_artikel,
                    '$vorschautext' => $vorschautext,
                    '$mp4_vorschauanimation' => $mp4_vorschauanimation ? $mp4_vorschauanimation['url'] : null
                );
                array_push($arr_data, $artikel_data);
            }
        endwhile;
        $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_INVALID_UTF8_IGNORE);
        //write json data into data.json file
        file_put_contents($myFile, $jsondata);

    wp_reset_postdata();
} ?>