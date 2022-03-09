<?php

namespace OMT\Services;

use Exception;
use Google_Service_Sheets;
use Google_Service_Sheets_BatchUpdateValuesRequest;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_ValueRange;
use OMT\Crons\ActivateToolAlternativeOption;
use OMT\Model\Tool;
use OMT\Services\Google\OAuth2;

class ToolAlternatives
{
    public function readLogs()
    {
        $model = Tool::init();
        $handle = fopen((new ActivateToolAlternativeOption)->logFile(), "r");

        if (!$handle) {
            throw new Exception("Error reading log file");
        }

        $logs = [];
        while (($line = fgets($handle)) !== false) {
            $log = trim($line);

            if (!empty($log) && preg_match('/\s(\d)+$/', $log, $matches)) {
                $toolId = trim($matches[0]);

                array_push($logs, [
                    'tool_id' => $toolId,
                    'action' => strpos($log, 'Enabled') !== false ? 'enable' : 'disable',
                    'title' => get_the_title($toolId),
                    'date' => substr($log, 0, 19),
                    'url' => get_the_permalink($toolId),
                    'edit_url' => site_url() . '/wp-admin/post.php?post=' . $toolId . '&action=edit',
                    'alternatives_url' => get_the_permalink($toolId) . 'alternativen/',
                    'alternatives' => $model->alternatives($toolId)
                ]);
            }
        }

        return $logs;
    }

    public function export(array $logs)
    {
        try {
            $client = (new OAuth2)->getClient(
                Google_Service_Sheets::SPREADSHEETS,
                get_permalink() . '?export=1'
            );

            $service = new Google_Service_Sheets($client);
            $spreadsheet = $this->createSpreadsheet($service);

            $this->writeHeader($service, $spreadsheet);
            $this->writeLogs($logs, $service, $spreadsheet);

            FlashMessages::queue("Die Tabelle wurde in Ihr Google-Konto exportiert");

            return true;
        } catch (Exception $ex) {
            FlashMessages::queue($ex->getMessage(), FlashMessages::ERROR);

            return false;
        }
    }

    public function countOfAllTools()
    {
        return count(Tool::init()->items([
            'isToolPage' => false
        ]));
    }

    public function countOfToolsWithEnabledAlternatives()
    {
        return count(Tool::init()->items([
            'isToolPage' => false,
            'alternatives' => true
        ]));
    }

    public function countOfToolsWithDisabledAlternatives()
    {
        return count(Tool::init()->items([
            'isToolPage' => false,
            'alternatives' => false
        ]));
    }

    protected function createSpreadsheet($service)
    {
        $spreadsheet = new Google_Service_Sheets_Spreadsheet(['properties' => [
            'title' => 'Toolalternativseite: ' . Date::get()->format('d.m.Y H:i:s')
        ]]);

        return $service->spreadsheets->create($spreadsheet, [
            'fields' => 'spreadsheetId'
        ]);
    }

    protected function writeHeader($service, $spreadsheet)
    {
        $body = new Google_Service_Sheets_ValueRange([
            'values' => [["Datum", "Tool", "Tool Alternativseite URL", "Editor URL", "Anzahl Alternativen"]]
        ]);

        $service->spreadsheets_values->update($spreadsheet->spreadsheetId, 'A1:E1', $body, ['valueInputOption' => 'RAW']);
    }

    protected function writeLogs(array $logs, $service, $spreadsheet)
    {
        $data = [];
        $range = 'A2:E' . (count($logs) + 1);

        $data[] = new Google_Service_Sheets_ValueRange([
            'range' => $range,
            'values' => $this->prepareLogs($logs)
        ]);

        // Additional ranges to update ...
        $body = new Google_Service_Sheets_BatchUpdateValuesRequest([
            'valueInputOption' => 'RAW',
            'data' => $data
        ]);

        $service->spreadsheets_values->batchUpdate($spreadsheet->spreadsheetId, $body);
    }

    protected function prepareLogs(array $logs)
    {
        $values = [];

        foreach ($logs as $log) {
            array_push($values, [
                $log['date'],
                $log['title'],
                $log['alternatives_url'],
                $log['edit_url'],
                count($log['alternatives'])
            ]);
        }

        return $values;
    }
}
