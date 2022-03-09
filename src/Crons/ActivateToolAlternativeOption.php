<?php

namespace OMT\Crons;

use OMT\Model\Tool;

/**
 * Run every night at ~00:30
 * Disable alternatives for "Tool Pages"
 * Get 10 tools where "Alternativseite Anzeigen" is disabled and enable this option
 */
class ActivateToolAlternativeOption extends Cron
{
    protected function handle()
    {
        $model = Tool::init();

        // Disable alternatives for "Tool Pages"
        foreach ($model->items(['isToolPage' => true, 'alternatives' => true]) as $tool) {
            update_field('alternativseite_anzeigen', 0, $tool->ID);
            $this->log('Disabled "Alternativseite Anzeigen". Tool Page ID: ' . $tool->ID);
        }

        // Enable alternatives for 10 "Tools"
        foreach ($model->toolsWithDisabledAlternatives() as $tool) {
            update_field('alternativseite_anzeigen', 1, $tool->ID);
            $this->log('Enabled "Alternativseite Anzeigen". Tool ID: ' . $tool->ID);
        }
    }

    protected function getHook()
    {
        return 'activate-tool-alternative-option';
    }

    protected function getInterval()
    {
        return 'daily';
    }

    protected function getTimestamp()
    {
        $ve = get_option('gmt_offset') > 0 ? '-' : '+';

        return strtotime('00:30 ' . $ve . absint(get_option('gmt_offset')) . ' HOURS');
    }
}
