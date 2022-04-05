<?php

namespace OMT\Model;

use OMT\Model\Datahost\Webinar as DatahostWebinar;
use WP_Post;

class Webinar extends PostModel
{
    protected $postType = 'webinare';

    public function sync(WP_Post $post)
    {
        $model = DatahostWebinar::init();
        $video_dur = '0';
        $previewImage = get_field('webinar_optional_preview_image', $post->ID);
        $day = date('Y-m-d', strtotime(get_field('webinar_datum', $post->ID)));
        $timeFrom = get_field('webinar_uhrzeit_start', $post->ID);
        $timeTo = get_field('webinar_uhrzeit_ende', $post->ID);
        $date = $day . ' ' . $timeFrom;

        $authors = array_filter((array) get_field('webinar_speaker', $post->ID));

        if (!$previewImage && count($authors)) {
            $previewImage = get_field('profilbild', $authors[0]->ID);
        }
        
        if (get_field('webinar_video_duration', $post->ID) != null ) {
            $video_dur = get_field('webinar_video_duration', $post->ID);
        }

        $difficulty = get_field('webinar_schwierigkeitsgrad', $post->ID);
        $difficulty_1 = 0;
        $difficulty_2 = 0;
        $difficulty_3 = 0;
        $difficulty_4 = 0;
        if (in_array(1, $difficulty)) { $difficulty_1 = 1; }
        if (in_array(2, $difficulty)) { $difficulty_2 = 1; }
        if (in_array(3, $difficulty)) { $difficulty_3 = 1; }
        if (in_array(4, $difficulty)) { $difficulty_4 = 1; }

        $itemId = $model->store([
            'id' => $post->ID,
            'title' => get_the_title($post),
            'status' => get_post_status($post),
            'url' => get_the_permalink($post),
            'preview_title' => get_field('webinar_vorschautitel', $post->ID) ?: get_the_title($post),
            'date' => $date,
            'day' => $day,
            'time_from' => $timeFrom,
            'time_to' => $timeTo,
            'preview_text' => get_field('webinar_vorschautext', $post->ID) ?: null,
            'description' => get_field('webinar_beschreibung', $post->ID) ?: null,
            'image_350' => $previewImage ? $previewImage['sizes']['350-180'] : null,
            'image_550' => $previewImage ? $previewImage['sizes']['550-290'] : null,
            'youtube_code' => get_field('webinar_youtube_embed_code', $post->ID) ?: null,
            'wistia_code' => get_field('webinar_wistia_embed_code', $post->ID) ?: null,
            'wistia_member_code' => get_field('webinar_wistia_embed_code_mitglieder', $post->ID) ?: null,
            'hidden' => get_field('webinar_in_ubersicht_ausblenden', $post->ID) == 1 ? 1 : 0,
            'post_date' => get_the_date('Y-m-d H:i:s', $post),
            'video_duration' => $video_dur,
            'difficulty_1' => $difficulty_1,
            'difficulty_2' => $difficulty_2,
            'difficulty_3' => $difficulty_3,
            'difficulty_4' => $difficulty_4
        ]);

        if ($itemId) {
            $model->storeCategories($itemId, array_filter((array) get_the_terms($post->ID, 'kategorie')));
            $model->storeExperts($itemId, $authors);

            return true;
        }

        return false;
    }
}
