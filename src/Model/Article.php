<?php

namespace OMT\Model;

use OMT\Enum\Magazines;
use OMT\Model\Datahost\Article as DatahostArticle;
use OMT\Model\Datahost\ArticleExpert;
use OMT\Model\Datahost\Expert;
use WP_Post;

class Article extends PostModel
{
    protected $postType = null;

    public function __construct()
    {
        parent::__construct();

        $this->postType = Magazines::keys();
    }

    public function sync(WP_Post $post)
    {
        $model = DatahostArticle::init();

        $postType = get_post_type($post);
        $previewAnimation = get_field('mp4_vorschauanimation', $post->ID);

        $itemId = $model->store([
            'id' => $post->ID,
            'title' => get_the_title($post),
            'status' => get_post_status($post),
            'url' => get_the_permalink($post),
            'post_type' => $postType,
            'post_type_slug' => get_post_type_object($postType)->rewrite['slug'],
            'teaser_image' => $this->extractTeaserImage($post->ID),
            'highlighted_image' => $this->extractHighlightedImage($post->ID),
            'recap' => get_field('recap', $post->ID) ? 1 : 0,
            'reading_time' => reading_time($post->ID),
            'show_in_agency_finder' => get_field('im_agenturfinder_anzeigen', $post->ID) ? 1 : 0,
            'preview_text' => $this->extractPreviewText($post->ID),
            'preview_animation' => $previewAnimation ? $previewAnimation['url'] : null,
            'post_date' => get_the_date('Y-m-d H:i:s', $post)
        ]);

        if ($itemId) {
            $this->syncExperts($itemId, (array) get_field('autor', $post->ID));

            return true;
        }

        return false;
    }

    protected function syncExperts(int $id, array $experts = [])
    {
        $model = Expert::init();
        $relationshipModel = ArticleExpert::init();

        // Delete old "article_expert" relationship
        $relationshipModel->delete(['article_id' => $id]);

        // Save or update new experts and create new "article_expert" relationship
        foreach (array_filter($experts) as $expert) {
            $expertId = $model->store([
                'id' => $expert->ID,
                'name' => get_the_title($expert),
                'url' => get_the_permalink($expert)
            ]);

            if ($expertId) {
                $relationshipModel->store(
                    [
                        'article_id' => $id,
                        'expert_id' => $expertId
                    ],
                    ['timestamps' => false]
                );
            }
        }

        return true;
    }

    protected function extractTeaserImage($postId)
    {
        $previewImage350 = get_field('vorschau-350x180', $postId);

        if ($previewImage350 && !empty($previewImage350['url'])) {
            return $previewImage350['url'];
        }

        $featuredImages = wp_get_attachment_image_src(get_post_thumbnail_id($postId), '350-180');

        if ($featuredImages) {
            return $featuredImages[0];
        }

        return null;
    }

    protected function extractHighlightedImage($postId)
    {
        $previewImage550 = get_field('vorschau-550-290', $postId);

        if ($previewImage550 && !empty($previewImage550['url'])) {
            return $previewImage550['url'];
        }

        $featuredImages = wp_get_attachment_image_src(get_post_thumbnail_id($postId), '550-290');

        if ($featuredImages) {
            return $featuredImages[0];
        }

        return null;
    }

    protected function extractPreviewText($postId)
    {
        $previewText = get_field('vorschautext', $postId);

        if (strlen($previewText) < 1) {
            $fullText = get_the_content();

            if (strpos($fullText, '<!--more-->')) {
                $morePos = strpos($fullText, '<!--more-->');
                $previewText = substr($fullText, 0, $morePos);
            } else {
                $string = strip_tags(substr($fullText, 0, 200));

                // If theres a shortcode in the beginning of the article string, we position ourselves behind the closing ]
                if (strpos($string, ']') > 0) {
                    $string = strip_tags(substr($fullText, 0, 400));
                    $string = trim(substr($string, strpos($string, ']')));
                    $previewText = substr($string, 1, 200);
                } else {
                    $previewText = $string;
                }
            }
        }

        return $previewText;
    }
}
