<?php

namespace OMT\Ajax;

use OMT\Enum\Branch;
use OMT\Enum\JobChangeReason;
use OMT\Enum\Magazines;
use OMT\Model\Datahost\JobProfile;
use OMT\Services\Response;

class GetJobProfile extends Ajax
{
    public function handle()
    {
        if (!is_user_logged_in()) {
            Response::jsonError('Access denied', [], 403);
        }

        Response::json([
            'item' => JobProfile::init()->item(['user' => get_current_user_id()]),
            'enums' => [
                'marketing' => Magazines::all(),
                'branch' => Branch::all(),
                'job_change_reason' => JobChangeReason::all()
            ]
        ]);
    }

    public function enqueueScripts()
    {
        wp_localize_script('alpine-app', $this->getAction(), [
            'nonce' => wp_create_nonce($this->getAction()),
            'url' => admin_url('admin-ajax.php')
        ]);
    }

    protected function getAction()
    {
        return 'omt_get_job_profile';
    }
}
