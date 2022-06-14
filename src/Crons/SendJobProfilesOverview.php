<?php

namespace OMT\Crons;

use OMT\Model\Datahost\JobProfile;
use OMT\Services\Date;
use OMT\Services\Email;
use OMT\View\EmailView;

/**
 * Run in the evening at ~23:30
 *
 * At the end of the day, send an overview with all users who have added or changed their profiles on that given day to mario@omt.de
 */
class SendJobProfilesOverview extends Cron
{
    protected function handle()
    {
        $items = JobProfile::init()->items(['updated' => Date::get()]);

        if (count($items)) {
            Email::send(
                'william.henry@omt.de',
                'Job-Profile Übersicht',
                EmailView::loadTemplate('job-profiles-overview', [
                    'date' => Date::get()->format('d.m.Y'),
                    'items' => $items
                ])
            );
        }
    }

    protected function getHook()
    {
        return 'send-job-profiles-overview';
    }

    protected function getInterval()
    {
        return 'daily';
    }

    protected function getTimestamp()
    {
        return Date::get()->setTime(23, 30)->getTimestamp();
    }
}
