<?php

namespace OMT\API;

use stdClass;

class Salesviewer extends API
{
    protected $endpointBase = 'https://www.salesviewer.com/api';
    protected $key = 'c285b046a65fe22f5b9538331c09ecd6';

    public function urlInfo($url, int $page = 1)
    {
        if ($url instanceof stdClass) {
            $data = [
                'apiKey' => $this->key,
                'query' => $this->urlInfoFilter($url),
                'page' => $page,
                'from' => '-90 days'
            ];
//salesviewer API endpoints: https://salesviewer.github.io/salesviewer-api/definition#!/sessions/getSessionsJSON

            $request = wp_remote_request($this->endpointBase . '/sessions?' . http_build_query($data));

            if ($request['response']['code'] && $request['response']['code'] == 200) {
                return json_decode($request['body']);
            }
        }

        return null;
    }

    protected function urlInfoFilter(stdClass $url)
    {
        $queries = ["count(like(session.visits.url, '%" . $url->url . "')) > 0"];

        if ($url->date_added) {
            array_push($queries, "count(ge(session.visits.startedAt, '" . $url->date_added . "')) > 0");
        }

        return implode(" & ", $queries);
    }
}
