<?php

namespace OMT\Services;

use League\Csv\Writer;

class ToolProviderStats
{
    public function export(string $toolName, array $clicks = [])
    {
        $csv = Writer::createFromString();

        // Insert the header
        $csv->insertOne([
            '#',
            'Kategorie',
            'Kosten',
            'Zeitpunkt',
            'IP',
            'Browser',
            'OS'
        ]);

        // Insert all clicks
        $csv->insertAll($this->prepareExportData($clicks));

        ob_clean();

        $csv->output($toolName . '-Statistiken.csv');
        exit();
    }

    protected function prepareExportData(array $clicks)
    {
        $data = [];

        foreach ($clicks as $key => $click) {
            array_push($data, [
                $key + 1,
                $click->extra->category,
                $click->bid_kosten . ' €',
                $click->extra->date->format('d.m.Y H:i'),
                $click->ip,
                $click->browser,
                $click->os
            ]);
        }

        return $data;
    }
}
