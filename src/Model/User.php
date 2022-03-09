<?php

namespace OMT\Model;

use OMT\Traits\ErrorsHandling;

class User extends Model
{
    use ErrorsHandling;

    protected $required = [
        'role',
        'user_login',
        'first_name',
        'last_name',
        'user_email',
        'user_pass',
        'firma'
    ];

    public function create(array $data)
    {
        foreach ($this->required as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $this->addError('Bitte alle erforderlich Felder ausfüllen');

                return false;
            }
        }

        $userId = wp_insert_user($data);

        if (is_wp_error($userId)) {
            $this->addError($userId->get_error_message());

            return false;
        }

        // Set ACF fields
        if (isset($data['firma'])) {
            update_field('firma', $data['firma'], 'user_' . $userId);
        }

        if (isset($data['assignedTools']) && is_array($data['assignedTools']) && count($data['assignedTools'])) {
            update_field('zugewiesenes_tool', $data['assignedTools'], 'user_' . $userId);
        }

        return $userId;
    }

    /**
     * Get user SalesViewer URLs
     *
     * @return array
     */
    public function salesViewerUrls(int $userId)
    {
        $urls = [];

        foreach ((array) get_field('salesviewer_urls', 'user_' . $userId) as $value) {
            if (!empty($value['url'])) {
                $urls[] = (object) [
                    'url' => parse_url($value['url'], PHP_URL_PATH),
                    'date_added' => $value['date_added']
                ];
            }
        }

        return $urls;
    }

    /**
     * Get "Toolanbieter" user tools
     *
     * @return array
     */
    public function tools(int $userId)
    {
        return (array) get_field('zugewiesenes_tool', 'user_' . $userId);
    }
}
