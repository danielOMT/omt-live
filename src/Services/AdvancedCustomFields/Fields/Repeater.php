<?php

namespace OMT\Services\AdvancedCustomFields\Fields;

use Exception;
use OMT\Services\AdvancedCustomFields\ACF;

class Repeater extends Field
{
    /**
     * @var array $repeaters types of fields inside the repeaters
     * */
    protected $repeaters = [
        'faq_fur_schema' => [
            'frage' => 'text',
            'antwort' => 'content'
        ],
        'footer_logos' => [
            'logo' => 'image_url',
            'link' => 'text'
        ],
        'footer_bewertungslogos' => [
            'logo' => 'image_url',
            'link' => 'text'
        ],
        'downloads_people' => [
            'person' => 'int',
            'avatar' => 'image_array'
        ],
        'downloads_reviews' => [
            'avatar' => 'image_array',
            'name' => 'text',
            'position' => 'text',
            'review' => 'content'
        ]
    ];

    public function getValue(int $postId = null, string $key, $rawValue)
    {
        if (!isset($this->repeaters[$key])) {
            throw new Exception("Repeater '" . $key . "' is not specified", 500);
        }

        $repeater = [];

        for ($index = 0; $index < $rawValue; $index++) {
            $repeater[$index] = [];

            foreach ($this->repeaters[$key] as $field => $fieldType) {
                $repeater[$index][$field] = [
                    'post_id' => $postId ?? 'options',
                    'key' => $key . '_' . $index . '_' . $field,
                    'type' => $fieldType
                ];
            }
        }

        return $repeater;
    }

    public function format($value)
    {
        $repeater = [];

        foreach ((array) $value as $index => $repeaterFields) {
            $repeater[$index] = [];

            foreach ($repeaterFields as $field => $fieldData) {
                $repeater[$index][$field] = $fieldData['post_id'] === 'options'
                    ? ACF::getInstance()->getOption($fieldData['key'], $fieldData['type'])
                    : ACF::getInstance()->getPostField($fieldData['post_id'], $fieldData['key'], $fieldData['type']);
            }
        }

        return $repeater;
    }
}
