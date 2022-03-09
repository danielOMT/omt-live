<?php

namespace OMT\Job\Admin;

use OMT\Job\Job;
use OMT\Model\Datahost\JobProfile;
use OMT\Services\Response;
use OMT\Services\Roles;

class OpenUserProfileResume extends Job
{
    public function __construct()
    {
        add_action('init', [$this, 'catchAdminJobProfileFileReading']);
    }

    public function catchAdminJobProfileFileReading()
    {
        if (strpos($_SERVER['REQUEST_URI'], '/admin/job-profiles/open-resume') === 0) {
            $this->getResumeFile();
        }
    }

    protected function getResumeFile()
    {
        if (!Roles::isAdministrator()) {
            die('Access denied');
        }

        $model = JobProfile::init();
        $jobProfile = $model->item(['id' => (int) $_GET['id']]);

        if ($jobProfile && !empty($jobProfile->resume_file)) {
            Response::file($model->getUploadDir() . $jobProfile->resume_file, $jobProfile->resume_filename);
        }
    }
}
