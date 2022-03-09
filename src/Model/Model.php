<?php

namespace OMT\Model;

class Model
{
    /**
     * WordPress database abstraction object
     *
     * @var \wpdb
     */
    protected $db = null;

    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
    }

    public static function init()
    {
        return new static();
    }

    /**
     * Return value if fields are not provided (all) or field exist in listed fields
     * Otherwise null
     */
    protected function getExtraFieldValue(array $fields = [], $field, $selector, int $postId)
    {
        return count($fields) === 0 || in_array($field, $fields)
            ? get_field($selector, $postId)
            : null;
    }
}
