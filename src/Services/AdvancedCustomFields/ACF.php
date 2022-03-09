<?php

namespace OMT\Services\AdvancedCustomFields;

use Exception;

/**
 * @todo Use cache for already fetched fields
 * @todo Get rid of ACF entirely on frontend when get_field() and other native ACF functions will not be used
 * @see https://www.billerickson.net/code/disable-acf-frontend/
 */
class ACF
{
    /**
     * Stores the singleton instance of ACF
     *
     * @var $this
     */
    protected static $instance = null;

    /**
     * Initialize connection to the datahost database only once
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    /**
     * Get ACF field data for a post using native WP function get_post_meta()
     *
     * Native WP function will be faster because we already have metadata cached for a post
     * We skip any additional database calls as in function get_field()
     *
     * @param string $type format of the field in ACF (bool, int, float, array, content, repeater, image_url, image_array, file_url, date_object)
     */
    public function getPostField(int $postId, string $key, string $type = null)
    {
        if (empty($postId)) {
            throw new Exception("No post id found", 500);
        }

        return $this->format(
            $this->getFieldValue(get_post_meta($postId, $key, true), $key, $type, $postId),
            $type
        );
    }

    /**
     * Get ACF option stored at /wp-admin/admin.php?page=acf-options-optionen
     *
     * @param string $type format of the field in ACF (bool, int, float, array, content, repeater, image_url, image_array, file_url, date_object)
     */
    public function getOption(string $key, string $type = null)
    {
        return $this->format(
            $this->getFieldValue(get_option('options_' . $key), $key, $type),
            $type
        );
    }

    protected function getFieldValue($rawValue, string $key, string $type = null, int $postId = null)
    {
        $fieldClass = $this->fieldClass($type);

        return $fieldClass ? $fieldClass->getValue($postId, $key, $rawValue) : $rawValue;
    }

    protected function format($value, string $type = null)
    {
        $fieldClass = $this->fieldClass($type);

        if ($fieldClass) {
            return $fieldClass->format($value, $type);
        }

        if ($type === 'bool') {
            return (bool) $value;
        }

        if ($type === 'int') {
            return (int) $value;
        }

        if ($type === 'float') {
            return (float) $value;
        }

        if ($type === 'array') {
            return (array) $value;
        }

        return $value;
    }

    /**
     * @return null|\OMT\Services\AdvancedCustomFields\Fields\Field
     */
    protected function fieldClass(string $type = null)
    {
        if (is_null($type)) {
            return null;
        }

        $className = 'OMT\\Services\\AdvancedCustomFields\\Fields\\' . implode('', array_map('ucfirst', explode('_', $type)));

        return class_exists($className) ? new $className : null;
    }
}
