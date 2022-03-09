<?php

namespace OMT\Enum;

class Magazines extends Enum
{
    public static function all()
    {
        return [
            'affiliate' => 'Affiliate Marketing',
            'amazon_marketing' => 'Amazon Marketing',
            'amazon' => 'Amazon SEO',
            'content' => 'Content Marketing',
            'conversion' => 'Conversion Optimierung',
            'direktmarketing' => 'Direktmarketing',
            'emailmarketing' => 'E-Mail Marketing',
            'e-commerce' => 'E-Commerce',
            'facebook' => 'Facebook Ads',
            'ga' => 'Google Analytics',
            'gmb' => 'Google My Business',
            'growthhack' => 'Growth Hacking',
            'inbound' => 'Inbound Marketing',
            'influencer' => 'Influencer Marketing',
            'p_r' => 'Public Relations (PR)',
            'sea' => 'Google Ads',
            'seo' => 'Suchmaschinenoptimierung',
            'sma' => 'Suchmaschinenmarketing',
            'tiktok' => 'TikTok-Marketing',
            'links' => 'Linkbuilding',
            'local' => 'Local SEO',
            'marketing' => 'Marketing',
            'onlinemarketing' => 'Online Marketing',
            'social' => 'Social Media Marketing',
            'performance' => 'Performance Marketing',
            'pinterest' => 'Pinterest Marketing',
            'videomarketing' => 'Video Marketing',
            'webanalyse' => 'Webanalyse',
            'webdesign' => 'Webdesign',
            'wordpress' => 'WordPress'
        ];
    }

    public static function hubspotField($value)
    {
        $mapping = [
            'affiliate' => 'jobs_jobinteresse_online_marketing_bereiche_Affiliate_Marketing',
            'amazon_marketing' => 'jobs_jobinteresse_online_marketing_bereiche_Amazon_Marketing',
            'amazon' => 'jobs_jobinteresse_online_marketing_bereiche_Amazon_SEO',
            'content' => 'jobs_jobinteresse_online_marketing_bereiche_Content_Marketing',
            'conversion' => 'jobs_jobinteresse_online_marketing_bereiche_Conversion_Optimierung',
            'direktmarketing' => 'jobs_jobinteresse_online_marketing_bereiche_Direktmarketing',
            'emailmarketing' => 'jobs_jobinteresse_online_marketing_bereiche_E-Mail-Marketing',
            'e-commerce' => 'jobs_jobinteresse_online_marketing_bereiche_E-Commerce',
            'facebook' => 'jobs_jobinteresse_online_marketing_bereiche_Facebook_Ads',
            'ga' => 'jobs_jobinteresse_online_marketing_bereiche_Google_Analytics',
            'gmb' => 'jobs_jobinteresse_online_marketing_bereiche_Google_My_Business',
            'growthhack' => 'jobs_jobinteresse_online_marketing_bereiche_Growth_Hacking',
            'inbound' => 'jobs_jobinteresse_online_marketing_bereiche_Inbound_Marketing',
            'influencer' => 'jobs_jobinteresse_online_marketing_bereiche_Influencer_Marketing',
            'p_r' => 'jobs_jobinteresse_online_marketing_bereiche_Public_Relations',
            'sea' => 'jobs_jobinteresse_online_marketing_bereiche_Google_Ads_SEA',
            'seo' => 'jobs_jobinteresse_online_marketing_bereiche_Suchmaschinenoptimierung',
            'tiktok' => 'jobs_jobinteresse_online_marketing_bereiche_TikTok_Marketing',
            'links' => 'jobs_jobinteresse_online_marketing_bereiche_Linkbuilding',
            'local' => 'jobs_jobinteresse_online_marketing_bereiche_Local_SEO',
            'marketing' => 'jobs_jobinteresse_online_marketing_bereiche_Marketing',
            'onlinemarketing' => 'jobs_jobinteresse_online_marketing_bereiche_Online_Marketing',
            'social' => 'jobs_jobinteresse_online_marketing_bereiche_Social_Media_Marketing',
            'performance' => 'jobs_jobinteresse_online_marketing_bereiche_Performance_Marketing',
            'pinterest' => 'jobs_jobinteresse_online_marketing_bereiche_Pinterest_Marketing',
            'videomarketing' => 'jobs_jobinteresse_online_marketing_bereiche_Video-Marketing',
            'webanalyse' => 'jobs_jobinteresse_online_marketing_bereiche_Webanalyse',
            'webdesign' => 'jobs_jobinteresse_online_marketing_bereiche_Webdesign',
            'wordpress' => 'jobs_jobinteresse_online_marketing_bereiche_WordPress'
        ];

        return $mapping[$value];
    }

    public static function label(string $key)
    {
        return self::all()[$key] ?? '';
    }
}
