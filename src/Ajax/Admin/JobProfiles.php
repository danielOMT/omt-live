<?php

namespace OMT\Ajax\Admin;

use OMT\Ajax\Ajax;
use OMT\Enum\AnnualSalary;
use OMT\Enum\Branch;
use OMT\Enum\Degree;
use OMT\Enum\Experience;
use OMT\Enum\ExperienceDetailed;
use OMT\Enum\JobChangeReason;
use OMT\Enum\JobStatus;
use OMT\Enum\LanguageLevel;
use OMT\Enum\LeadershipExperience;
use OMT\Enum\Magazines;
use OMT\Enum\Specialty;
use OMT\Filters\JobProfile as JobProfileFilters;
use OMT\Model\Datahost\JobProfile;
use OMT\Services\Response;
use OMT\Services\Roles;

class JobProfiles extends Ajax
{
    public function handle()
    {
        if (!Roles::isAdministrator()) {
            Response::jsonError('Access denied', [], 403);
        }
        
        $filters = $_GET['filters'] ?? [];
        $filters['zip'] = $_GET['zip'] ?? '';

        $response = [
            'items' => JobProfile::init()->items($filters)
        ];

        if (isset($_GET['initialization']) && $_GET['initialization']) {
            $response['filters'] = JobProfileFilters::public();
            $response['enums'] = [
                'degree' => Degree::all(),
                'specialty' => Specialty::all(),
                'marketing' => Magazines::all(),
                'branch' => Branch::all(),
                'experience' => Experience::all(),
                'experience_detailed' => ExperienceDetailed::all(),
                'leadership_experience' => LeadershipExperience::all(),
                'language_level' => LanguageLevel::all(),
                'job_status' => JobStatus::all(),
                'job_change_reason' => JobChangeReason::all(),
                'annual_salary' => AnnualSalary::all()
            ];
        }

        Response::json($response);
    }

    protected function getAction()
    {
        return 'omt_admin_job_profiles';
    }
}
