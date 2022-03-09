<?php

namespace OMT\Ajax;

use Exception;
use OMT\Services\Roles;
use OMT\Services\ToolAlternatives;

class ToolsAlternativesStats extends Ajax
{
    public function handle()
    {
        if (!Roles::isAdministrator()) {
            throw new Exception("Access denied", 403);
        }

        $service = new ToolAlternatives;
        $enabled = $service->countOfToolsWithEnabledAlternatives();

        die(json_encode([
            'enabled' => $enabled,
            'disabled' =>  $service->countOfAllTools() - $enabled
        ]));
    }

    protected function getAction()
    {
        return 'omt_tools_alternatives_stats';
    }
}
