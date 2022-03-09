<?php

namespace OMT\Ajax;

use Exception;
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
use OMT\Model\Datahost\JobProfile;
use OMT\Services\Response;
use Rakit\Validation\Validator;

class UpdateJobProfile extends Ajax
{
    public function handle()
    {
        if (!is_user_logged_in()) {
            Response::jsonError('Access denied', [], 403);
        }

        $model = JobProfile::init();
        $jobProfile = $model->item(['user' => get_current_user_id()]);
        $validator = new Validator;

        $requestData = $_POST;
        $requestData['experience_industries'] = array_filter(explode(',', $requestData['experience_industries']));
        $requestData['job_change_reason'] = array_filter(explode(',', $requestData['job_change_reason']));
        $requestData['marketing_area_interest'] = array_filter(explode(',', $requestData['marketing_area_interest']));

        $validation = $validator->make($requestData + $_FILES, [
            'salutation' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'birthdate' => 'required|date',
            'address' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'degree' => ['required', $validator('in', Degree::keys())],
            'specialty' => ['required', $validator('in', Specialty::keys())],
            'linkedin_url' => 'url',
            'resume' => 'uploaded_file:0,5M,pdf,doc,docx',
            'marketing_area' => [$validator('in', [0, ...Magazines::keys()])],
            'branch' => [$validator('in', [0, ...Branch::keys()])],
            'experience' => [$validator('in', [0, ...Experience::keys()])],
            'experience_am' => [$validator('in', ExperienceDetailed::keys())],
            'experience_cm' => [$validator('in', ExperienceDetailed::keys())],
            'experience_em' => [$validator('in', ExperienceDetailed::keys())],
            'experience_ga' => [$validator('in', ExperienceDetailed::keys())],
            'experience_im' => [$validator('in', ExperienceDetailed::keys())],
            'experience_pr' => [$validator('in', ExperienceDetailed::keys())],
            'experience_seo' => [$validator('in', ExperienceDetailed::keys())],
            'experience_smm' => [$validator('in', ExperienceDetailed::keys())],
            'experience_vm' => [$validator('in', ExperienceDetailed::keys())],
            'experience_wd' => [$validator('in', ExperienceDetailed::keys())],
            'leadership_experience' => [$validator('in', [0, ...LeadershipExperience::keys()])],
            'experience_industries' => 'array',
            'experience_industries.*' => [$validator('in', Branch::keys())],
            'german_level' => [$validator('in', [0, ...LanguageLevel::keys()])],
            'english_level' => [$validator('in', [0, ...LanguageLevel::keys()])],
            'french_level' => [$validator('in', [0, ...LanguageLevel::keys()])],
            'spanish_level' => [$validator('in', [0, ...LanguageLevel::keys()])],
            'job_status' => [$validator('in', [0, ...JobStatus::keys()])],
            'job_change_reason' => 'array',
            'job_change_reason.*' => [$validator('in', JobChangeReason::keys())],
            'marketing_area_interest' => 'array',
            'marketing_area_interest.*' => [$validator('in', Magazines::keys())],
            'annual_salary' => [$validator('in', [0, ...AnnualSalary::keys()])]
        ]);

        $validation->setMessages([
            'required' => 'Bitte füllen Sie dieses Pflichtfeld aus',
            'email' => 'E-Mail muss korrekt formatiert sein',
            'url' => 'Die URL ist keine gültige URL',
            'in' => 'Bitte wählen Sie eine Option im Dropdown-Menü aus',
            'resume:uploaded_file' => 'Lebenslauf muss PDF/Word-Format sein'
        ]);

        $validation->validate();

        if ($validation->fails()) {
            Response::jsonError('Bitte füllen Sie alle erforderlichen Felder aus', $validation->errors()->firstOfAll());
        }

        $data = $validation->getValidData();

        if (isset($data['resume']) && is_array($data['resume'])) {
            $upload = $this->uploadFile($data['resume']);

            if ($upload) {
                $this->deleteOldFile($jobProfile);

                $data['resume_filename'] = $data['resume']['name'];
                $data['resume_file'] = $upload;
            } else {
                Response::jsonError('Fehler beim Hochladen der Lebenslaufdatei. Bitte versuche es erneut');
            }
        }

        unset($data['resume']);

        try {
            $itemId = $model->store(array_merge(
                $data,
                [
                    'id' => $jobProfile ? $jobProfile->id : null,
                    'user_id' => get_current_user_id(),
                    'position' => $requestData['position'],
                    'tools_knowledge' => $requestData['tools_knowledge'],
                    'comment' => $requestData['comment']
                ]
            ));
        } catch (Exception $th) {
            $itemId = false;
        }

        if (!$itemId) {
            Response::jsonError('Etwas ist schief gelaufen. Bitte versuche es erneut');
        }

        Response::json(
            ['item' => $model->item(['id' => $itemId])],
            'Job-Profil wurde erfolgreich aktualisiert'
        );
    }

    public function enqueueScripts()
    {
        wp_localize_script('alpine-app', $this->getAction(), [
            'nonce' => wp_create_nonce($this->getAction()),
            'url' => admin_url('admin-ajax.php')
        ]);
    }

    protected function uploadFile(array $file)
    {
        $directory = JobProfile::init()->getUploadDir();
        $fileName = md5(time()) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

        if (move_uploaded_file($file['tmp_name'], $directory . $fileName)) {
            return $fileName;
        }

        return false;
    }

    protected function deleteOldFile($jobProfile)
    {
        if ($jobProfile && !empty($jobProfile->resume_file)) {
            $directory = JobProfile::init()->getUploadDir();

            if (file_exists($directory . $jobProfile->resume_file)) {
                unlink($directory . $jobProfile->resume_file);
            }
        }
    }

    protected function getAction()
    {
        return 'omt_update_job_profile';
    }
}
