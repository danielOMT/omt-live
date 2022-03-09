<?php

namespace OMT\API;

use Exception;
use OMT\Enum\TrackingLinkType;
use OMT\Traits\ErrorsHandling;

class ClickMeter extends API
{
    use ErrorsHandling;

    const DATAPOINTS_REDIRECT_TYPE = 307;
    const DATAPOINTS_DOMAIN_ID = 71723;
    const DATAPOINTS_PAUSED_STATUS = 1;

    const CAMPAIGN_ACTIVE_STATUS = 'active';

    protected $endpointBase = 'https://apiv2.clickmeter.com';
    protected $key = '64436DDF-D094-4E33-B2B1-9CD1E50EA4EB';
    protected $envPrefix = '';

    public function __construct()
    {
        $this->envPrefix = WP_ENV === 'development' ? 'STAGING: ' : '';
    }

    /**
     * Fetch ACTIVE tracking link from ClickMeter by Id
     */
    public function item(int $id)
    {
        $request = wp_remote_get($this->endpointBase . '/datapoints/' . $id, [
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => ['Content-Type' => 'application/json', 'X-Clickmeter-Authkey' => $this->key]
        ]);

        if ($request['response']['code'] == 200) {
            $item = json_decode($request['body'], true);

            if (!isset($item['status']) || $item['status'] == self::DATAPOINTS_PAUSED_STATUS) {
                return $item;
            }
        }

        return null;
    }

    public function update(int $id, string $url, int $campaignId)
    {
        $link = $this->item($id);

        // Skip updating if tracking link doesn't exist in ClickMeter or campaigns are different (Staging/Live solution to not update Live URL's from Staging website)
        if (!$link || $link['groupId'] != $campaignId) {
            return false;
        }

        $request = wp_remote_post($this->endpointBase . '/datapoints/' . $link['id'], [
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => ['Content-Type' => 'application/json', 'X-Clickmeter-Authkey' => $this->key],
            'body' => json_encode([
                'title' => $link['title'],
                'name' => $link['name'],
                'groupId' => $link['groupId'],
                'typeTL' => [
                    'url' => $url,
                    'redirectType' => $link['typeTL']['redirectType'],
                    'domainId' => $link['typeTL']['domainId']
                ]
            ])
        ]);

        if ($request['response']['code'] == 200) {
            return json_decode($request['body'], true);
        }

        throw new Exception(
            implode(', ', array_map(fn ($error) => $error['errorMessage'], json_decode($request['body'], true)['errors'])),
            422
        );
    }

    public function create(int $campaignId, string $url, string $type, string $toolName, string $categoryName = '', $cycle = 1)
    {
        $request = wp_remote_post($this->endpointBase . '/datapoints', [
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => ['Content-Type' => 'application/json', 'X-Clickmeter-Authkey' => $this->key],
            'body' => json_encode([
                'title' => $this->generateLinkTitle($type, $toolName, $categoryName),
                'name' => $this->generateLinkName(),
                'groupId' => $campaignId,
                'typeTL' => [
                    'url' => $url,
                    'redirectType' => self::DATAPOINTS_REDIRECT_TYPE,
                    'domainId' => self::DATAPOINTS_DOMAIN_ID
                ]
            ])
        ]);

        if ($request['response']['code'] == 200) {
            return json_decode($request['body'], true);
        }

        // Try to create a new link if 'Name' is already used
        $errors = json_decode($request['body'], true)['errors'];
        if (count($errors) == 1 && $errors[0]['code'] == '0013' && $cycle <= 10) {
            return $this->create($campaignId, $url, $toolName, $categoryName, ++$cycle);
        }

        throw new Exception(
            implode(', ', array_map(fn ($error) => $error['errorMessage'], $errors)),
            422
        );
    }

    public function delete(int $id)
    {
        $request = wp_remote_post($this->endpointBase . '/datapoints/' . $id, [
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => ['Content-Type' => 'application/json', 'X-Clickmeter-Authkey' => $this->key],
            'method' => 'DELETE'
        ]);

        if ($request['response']['code'] == 200) {
            return json_decode($request['body'], true);
        }

        $this->addErrors(json_decode($request['body'], true)['errors']);

        return false;
    }

    public function campaigns(array $filter = [])
    {
        $query = [];

        if (array_key_exists('search', $filter)) {
            $query[] = 'textSearch=' . urlencode(strip_tags($this->envPrefix . $filter['search']));
        }

        if (array_key_exists('status', $filter)) {
            $query[] = 'status=' . $filter['status'];
        }

        $request = wp_remote_get($this->endpointBase . '/groups' . (count($query) ? '?' . implode('&', $query) : ''), [
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => ['Content-Type' => 'application/json', 'X-Clickmeter-Authkey' => $this->key]
        ]);

        if ($request['response']['code'] == 200) {
            $response = json_decode($request['body'], true);

            return $response['entities'];
        }

        return [];
    }

    public function createCampaign(string $toolName)
    {
        $request = wp_remote_post($this->endpointBase . '/groups', [
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => ['Content-Type' => 'application/json', 'X-Clickmeter-Authkey' => $this->key],
            'body' => json_encode([
                'name' => $this->getEnvToolName($toolName),
                'notes' => 'Automatically created campaign for all ' . $this->getEnvToolName($toolName) . ' tracking links'
            ])
        ]);

        if ($request['response']['code'] == 200) {
            return json_decode($request['body'], true);
        }

        throw new Exception('Error while creating new campaign', 422);
    }

    protected function getEnvToolName(string $toolName)
    {
        return $this->envPrefix . ucfirst($toolName);
    }

    protected function generateLinkTitle(string $type, string $toolName, string $categoryName = '')
    {
        $typeTitle = 'Zum Anbieter';

        switch ($type) {
            case TrackingLinkType::PRICE_OVERVIEW:
                $typeTitle = 'Preisübersicht';
                break;

            case TrackingLinkType::TEST:
                $typeTitle = 'Tool Testen';
                break;
        }

        return $this->getEnvToolName($toolName) . ' Link ' . $typeTitle . (strlen($categoryName) ? ' Kategorie ' . $categoryName : '');
    }

    protected function generateLinkName()
    {
        $chars = str_split('abcdefghjkmnpqrstuvwxyz');
        $numbers = str_split('123456789');

        $name = $chars[array_rand($chars)];
        $name .= $chars[array_rand($chars)];
        $name .= $chars[array_rand($chars)];
        $name .= $chars[array_rand($chars)];
        $name .= $numbers[array_rand($numbers)];

        return WP_ENV === 'development'
            ? 'staging-' . str_shuffle($name)
            : str_shuffle($name);
    }
}
