<?php

namespace OMT\Model;

use OMT\Enum\ToolRating;
use OMT\Model\Datahost\MarketingTool;
use OMT\Model\Datahost\ToolReview as DatahostToolReview;
use WP_Post;

class ToolReview extends PostModel
{
    protected $postType = 'toolrezension';

    public function sync(WP_Post $post)
    {
        $toolId = get_field('tool_id', $post->ID);

        $ratingUserFriendliness = ToolRating::getKey(get_field('bewertung_benutzerfreundlichkeit', $post->ID));
        $ratingCustomerService = ToolRating::getKey(get_field('bewertung_support', $post->ID));
        $ratingFeatures = ToolRating::getKey(get_field('bewertung_funktionalitaten', $post->ID));
        $ratingPricePerformance = ToolRating::getKey(get_field('bewertung_preisleistung', $post->ID));
        $ratingRecommendation = ToolRating::getKey(get_field('bewertung_wahrscheinlichkeit_weiterempfehlung', $post->ID));

        $itemId = DatahostToolReview::init()->store([
            'id' => $post->ID,
            'tool_id' => $toolId,
            'title' => get_the_title($post),
            'status' => get_post_status($post),
            'url' => get_the_permalink($post),
            'firstname' => get_field('vorname', $post->ID),
            'lastname' => get_field('nachname', $post->ID),
            'company' => get_field('unternehmen', $post->ID),
            'position' => get_field('jobbezeichnung', $post->ID),
            'website' => $this->getWebsite($post),
            'linkedin' => get_field('linkedin', $post->ID),
            'xing' => get_field('xing', $post->ID),
            'facebook' => get_field('facebook', $post->ID),
            'twitter' => get_field('twitter', $post->ID),
            'instagram' => get_field('instagram', $post->ID),
            'tiktok' => get_field('tiktok', $post->ID),
            'pros' => get_field('vorteile_des_tools', $post->ID),
            'cons' => get_field('nachteile_des_tools', $post->ID),
            'conclusion' => get_field('allgemeines_fazit_zu_dem_tool', $post->ID),
            'description' => get_field('wenn_du_das_tool_beschreiben_musstest', $post->ID),
            'preferences' => get_field('welche_funktionen_des_tools_nutzt_du_am_liebsten', $post->ID),
            'rating' => ($ratingUserFriendliness + $ratingCustomerService + $ratingFeatures + $ratingPricePerformance + $ratingRecommendation) / 5,
            'rating_user_friendliness' => $ratingUserFriendliness,
            'rating_customer_service' => $ratingCustomerService,
            'rating_features' => $ratingFeatures,
            'rating_price_performance' => $ratingPricePerformance,
            'rating_recommendation' => $ratingRecommendation,
            'post_date' => get_the_date('Y-m-d H:i:s', $post)
        ]);

        if ($itemId) {
            MarketingTool::init()->recalculateRatings($toolId);

            return true;
        }

        return false;
    }

    protected function getWebsite(WP_Post $post)
    {
        $website = get_field('website', $post->ID);

        return !empty($website)
            ? 'https://' . trim(str_ireplace(['https://', 'http://'], '', $website))
            : '';
    }
}
