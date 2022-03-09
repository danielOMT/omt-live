<?php

namespace OMT\Job\Admin;

use League\Csv\Writer;
use OMT\Enum\AnnualSalary;
use OMT\Enum\Branch;
use OMT\Enum\Experience;
use OMT\Enum\JobStatus;
use OMT\Enum\Magazines;
use OMT\Job\Job;
use OMT\Model\Datahost\JobProfile;
use OMT\Services\Roles;

class ExportUserProfiles extends Job
{
    public function __construct()
    {
        add_action('init', [$this, 'catchAdminJobProfilesExport']);
    }

    public function catchAdminJobProfilesExport()
    {
        if ($_SERVER['REQUEST_URI'] === '/admin/job-profiles/export/') {
            $this->export();
        }
    }

    protected function export()
    {
        if (!Roles::isAdministrator()) {
            die('Access denied');
        }

        $jobProfiles = JobProfile::init()->items();
        $csv = Writer::createFromString();

        // Insert the header
        $csv->insertOne([
            '#',
            'Anrede',
            'Vorname',
            'Nachname',
            'E-Mail',
            'Telefonnummer',
            'Aktuelle Position',
            'Aktueller Bereich',
            'Aktuelle Branche',
            'Berufserfahrung Online Marketing',
            'Aktueller Job-Status',
            'Aktuelles Jahresgehalt',
            'Straße + HausNr.',
            'Postleitzahl',
            'Stadt',
            'Geburtsdatum'
        ]);

        // Insert all job profiles
        $csv->insertAll($this->prepareExportData($jobProfiles));

        ob_clean();

        $csv->output('Job-Profile.csv');
        exit();
    }

    protected function prepareExportData(array $jobProfiles)
    {
        $enums = [
            'marketing' => Magazines::all(),
            'branch' => Branch::all(),
            'experience' => Experience::all(),
            'job_status' => JobStatus::all(),
            'annual_salary' => AnnualSalary::all()
        ];

        $data = [];

        foreach ($jobProfiles as $key => $jobProfile) {
            array_push($data, [
                $key + 1,
                $jobProfile->salutation,
                $jobProfile->firstname,
                $jobProfile->lastname,
                $jobProfile->email,
                $jobProfile->phone,
                $jobProfile->position,
                $jobProfile->marketing_area ? $enums['marketing'][$jobProfile->marketing_area] : '',
                $jobProfile->branch ? $enums['branch'][$jobProfile->branch] : '',
                $jobProfile->experience ? $enums['experience'][$jobProfile->experience] : '',
                $jobProfile->job_status ? $enums['job_status'][$jobProfile->job_status] : '',
                $jobProfile->annual_salary ? $enums['annual_salary'][$jobProfile->annual_salary] : '',
                $jobProfile->address,
                $jobProfile->zip,
                $jobProfile->city,
                $jobProfile->birthdate ? formatDate($jobProfile->birthdate, 'd.m.Y') : ''
            ]);
        }

        return $data;
    }
}
