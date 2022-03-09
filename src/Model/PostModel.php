<?php

namespace OMT\Model;

use Exception;
use OMT\Services\AdvancedCustomFields\ACF;

class PostModel extends Model
{
    const POST_STATUS_PUBLISH = 'publish';
    const POST_STATUS_DRAFT = 'draft';
    const POST_STATUS_PRIVATE = 'private';

    /** @var \WP_Post $post Instance of a post object */
    protected $post = null;

    protected $postType = null;

    protected $postTaxonomy = null;

    protected static $instances = [];

    /**
     * Retrieve post data given a post ID.
     * Returns empty PostModel object if the WP_Post is not found
     *
     * @return PostModel|\WP_Post
     */
    public static function getInstance(int $postId = null)
    {
        $postId ??= 0;

        if (!array_key_exists($postId, self::$instances)) {
            self::$instances[$postId] = new static;
            self::$instances[$postId]->post = $postId ? get_post($postId) : null;
        }

        return self::$instances[$postId];
    }

    public function items(array $filter = [], array $options = [])
    {
        return get_posts($this->itemsArgs($filter, $options));
    }

    /**
     * Get ACF field data for a post using native WP function get_post_meta()
     *
     * @param string $type format of the field in ACF (bool, int, float, array, content, repeater, image_url, image_array, file_url, date_object)
     */
    final public function field(string $key, string $type = null)
    {
        if ($this->post) {
            return ACF::getInstance()->getPostField($this->post->ID, $key, $type);
        }

        return null;
    }

    protected function itemsArgs(array $filter = [], array $options = [])
    {
        $options['count'] ??= -1;

        if (is_null($this->postType)) {
            throw new Exception("Undefined query post type");
        }

        $args = [
            'numberposts' => $options['count'],
            'post_type' => $this->postType
        ];

        if (array_key_exists('updateMetaCache', $options)) {
            $args['update_post_meta_cache'] = $options['updateMetaCache'];
        }

        if (array_key_exists('updateTermCache', $options)) {
            $args['update_post_term_cache'] = $options['updateTermCache'];
        }

        return array_merge($args, $this->filter($filter));
    }

    protected function filter(array $filter = [])
    {
        $query = [
            'tax_query' => [],
            'meta_query' => []
        ];

        if (array_key_exists('id', $filter)) {
            $query['include'] = (array) $filter['id'];
        }

        if (array_key_exists('status', $filter)) {
            $query['post_status'] = $filter['status'];
        }

        if (array_key_exists('category', $filter)) {
            if (is_null($this->postTaxonomy)) {
                throw new Exception("Undefined query post taxonomy");
            }

            array_push($query['tax_query'], [
                'taxonomy' => $this->postTaxonomy,
                'field' => 'term_id',
                'terms' => $filter['category']
            ]);
        }

        if (array_key_exists('expert', $filter)) {
            array_push($query['meta_query'], [
                'key' => 'experte',
                'value' => $filter['expert']
            ]);
        }

        return $query;
    }

    public function getPostTypeName()
    {
        return $this->postType;
    }

    public function __get(string $name)
    {
        if ($this->post) {
            return $this->post->{$name};
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property in __get(): ' . $name . ' in file ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'],
            E_USER_NOTICE
        );

        return null;
    }
}
