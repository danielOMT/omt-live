<?php

namespace OMT\Services;

use Exception;
use Google_Service_Sheets;
use Google_Service_Sheets_BatchUpdateValuesRequest;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_ValueRange;
use OMT\Services\Google\OAuth2;

class SalesViewerExport
{
    public function handle(string $url, int $page, $urlInfo)
    {
        try {
            $this->setCookies($url, $page);

            $client = (new OAuth2)->getClient(
                Google_Service_Sheets::SPREADSHEETS,
                site_url() . '/toolanbieter/?updated=true&area=url-insights&export=1'
            );

            $service = new Google_Service_Sheets($client);
            $spreadsheet = $this->createSpreadsheet($service, $url);

            $this->writeHeader($service, $spreadsheet);
            $this->writeData((array) $urlInfo->result, $service, $spreadsheet);

            $this->deleteCookies();

            FlashMessages::queue("Die Tabelle wurde in Ihr Google-Konto exportiert");

            return true;
        } catch (Exception $ex) {
            FlashMessages::queue($ex->getMessage(), FlashMessages::ERROR);

            return false;
        }
    }

    protected function createSpreadsheet($service, string $url)
    {
        $spreadsheet = new Google_Service_Sheets_Spreadsheet(['properties' => [
            'title' => 'URL Insights für ' . $url . ': ' . Date::get()->format('d.m.Y H:i:s')
        ]]);

        return $service->spreadsheets->create($spreadsheet, [
            'fields' => 'spreadsheetId'
        ]);
    }

    protected function writeHeader($service, $spreadsheet)
    {
        $body = new Google_Service_Sheets_ValueRange([
            'values' => [[
                "Unternehmen",
                "Datum",
                "Stadt",
                "Dauer",
                "Interesse",
                "Quelle",
                "Adresse",
                "Telefonnummer",
                "Branche",
                "Website",
                "Linkedin",
                "Xing",
                "Anzahl Besuche",
                "Seiten pro Sitzung",
                "Durchschnittsdauer",
                "Letzter Besuch"
            ]]
        ]);

        $service->spreadsheets_values->update($spreadsheet->spreadsheetId, 'A1:P1', $body, ['valueInputOption' => 'RAW']);
    }

    protected function writeData(array $results, $service, $spreadsheet)
    {
        $data = [];
        $range = 'A2:P' . (count($results) + 1);

        $data[] = new Google_Service_Sheets_ValueRange([
            'range' => $range,
            'values' => $this->prepareData($results)
        ]);

        // Additional ranges to update ...
        $body = new Google_Service_Sheets_BatchUpdateValuesRequest([
            'valueInputOption' => 'RAW',
            'data' => $data
        ]);

        $service->spreadsheets_values->batchUpdate($spreadsheet->spreadsheetId, $body);
    }

    protected function prepareData(array $results)
    {
        $values = [];

        foreach ($results as $result) {
            array_push($values, $this->fixNullValues([
                $result->company->name,
                Date::get($result->startedAt)->format('d.m.Y H:i'),
                $result->company->city,
                Date::secondsToMinutes($result->duration_secs),
                implode(",", array_map(fn ($interest) => $interest->name, $result->interests)),
                $result->referer->url,
                $result->company->street . ' ' . $result->company->zip . ' ' . $result->company->city,
                $result->company->phone ?: '',
                $result->company->sector->name,
                $result->company->url,
                $result->company->linkedinUrl,
                $result->company->xingUrl,
                $result->company->overview->session_count,
                number_format(floatval($result->company->overview->page_per_session_avg), 1, ',', '.'),
                Date::secondsToMinutes($result->company->overview->session_duration_avg),
                date('d.m.Y H:i:s', strtotime($result->company->overview->last_session))
            ]));
        }

        return $values;
    }

    protected function fixNullValues(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_null($value) || empty($value)) {
                $data[$key] = "";
            }
        }

        return $data;
    }

    protected function setCookies(string $url, int $page)
    {
        setcookie('toolanbieter-url-insights-url', $url, time() + 3600);
        setcookie('toolanbieter-url-insights-page', $page, time() + 3600);
    }

    protected function deleteCookies()
    {
        setcookie('toolanbieter-url-insights-url', null, -1);
        setcookie('toolanbieter-url-insights-page', null, -1);
    }
}
