<?php

namespace OMT\Model;

use stdClass;
use WP_Post;

class Ebook extends PostModel
{
    protected $postType = 'omt_ebook';

    protected $postTaxonomy = 'ebook-category';

    public function allCategories()
    {
        return get_categories([
            'taxonomy' => 'ebook-category'
        ]);
    }

    public function getCategory(WP_Post $ebook)
    {
        $category = null;
        $categoriesLinking = $this->getCategoriesLinking();
        $primaryCategoryId = get_post_meta($ebook->ID, '_yoast_wpseo_primary_ebook-category', true);

        if ($primaryCategoryId) {
            $category = get_term($primaryCategoryId);
            $category->associated_theme_page = $categoriesLinking[$category->term_id] ?? '';
        }

        return $category;
    }

    public function withExtraData(array $ebooks = [])
    {
        foreach ($ebooks as $ebook) {
            $ebook->extra ??= new stdClass;

            $ebook->extra->expert = get_field("experte", $ebook->ID);
            $ebook->extra->image = get_field("vorschaubild", $ebook->ID);
            $ebook->extra->original_description = get_field("vorschautext", $ebook->ID);
            $ebook->extra->description = truncateString(strip_tags($ebook->extra->original_description), 200);
            $ebook->extra->original_title = get_field("vorschautitel", $ebook->ID) ?: $ebook->post_title;
            $ebook->extra->title = truncateString($ebook->extra->original_title);
            $ebook->extra->category = $this->getCategory($ebook);
        }

        return $ebooks;
    }

    protected function getCategoriesLinking()
    {
        static $categoriesLinking = null;

        if (is_null($categoriesLinking)) {
            $categoriesLinking = [];

            foreach ((array) get_field("ebook_categories_linking", "options") as $value) {
                $categoriesLinking[$value['category']] = $value['associated_theme_page'];
            }
        }

        return $categoriesLinking;
    }
}
