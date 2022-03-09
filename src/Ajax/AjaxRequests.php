<?php

namespace OMT\Ajax;

use OMT\Ajax\Admin\CreateToolProviderUser;
use OMT\Ajax\Admin\JobProfiles;

class AjaxRequests
{
    /**
     * @var array $requests List of ajax requests that have to be initialized
     */
    protected static $requests = [
        LoadWebinars::class,
        LoadTools::class,
        LoadArticles::class,
        FilterArticles::class,
        ToolsAlternativesStats::class,
        UpdateToolTrackingLink::class,
        DeleteToolTrackingLink::class,
        CreateToolProviderUser::class,
        UpdateJobProfile::class,
        GetJobProfile::class,
        JobProfiles::class,
    ];

    public static function init()
    {
        foreach (self::$requests as $request) {
            /**
             * @var Ajax $request
             */
            $request::init();
        }
    }
}
