<?php

namespace OMT\Job;

use OMT\Ajax\GetJobProfile;
use OMT\Ajax\UpdateJobProfile;
use OMT\Model\Datahost\JobProfile;
use OMT\Services\Response;
use OMT\View\UserView;

class ManageUserProfile extends Job
{
    const RESUME_TAB_ID = 'resume';

    public function __construct()
    {
        $this->registerFilters();
    }

    protected function registerFilters()
    {
        add_action('init', [$this, 'catchJobProfileFileReading']);
        add_filter('um_get_core_page_filter', [$this, 'getRedirectUrlForGuests'], 10, 3);
        add_filter('um_account_page_default_tabs_hook', [$this, 'addJobProfileTab']);
        add_filter('um_account_content_hook_' . self::RESUME_TAB_ID, [$this, 'getJobProfileTabEmptyContent'], 10, 2);
        add_filter('um_after_account_page_load', [$this, 'getJobProfileTabContent']);
    }

    public function getRedirectUrlForGuests($url, $slug, $updated)
    {
        if (!is_user_logged_in() && $slug == 'account' && $_SERVER['REQUEST_URI'] == '/account/resume/') {
            $url = $url . 'resume/';
        }

        return $url;
    }

    /**
     * Add resume tab to the /account page
     */
    public function addJobProfileTab($tabs)
    {
        array_push($tabs, [
            self::RESUME_TAB_ID => [
                'custom' => true,
                'icon' => 'um-faicon-file-text',
                'title' => 'Lebenslauf',
                'submit_title' => null,
            ]
        ]);

        return $tabs;
    }

    public function getJobProfileTabEmptyContent($output, $shortcode_args)
    {
        return '<div id="profile-resume-placeholder"></div>';
    }

    public function getJobProfileTabContent()
    {
        wp_enqueue_script('alpine-app', get_template_directory_uri() . '/library/js/app.js', [], 'c.1.0.4', true);
        UpdateJobProfile::getInstance()->enqueueScripts();
        GetJobProfile::getInstance()->enqueueScripts();

        echo UserView::loadTemplate('job-profile');
    }

    public function catchJobProfileFileReading()
    {
        if ($_SERVER['REQUEST_URI'] == '/account/resume/?open-file') {
            $this->getResumeFile();
        }
    }

    protected function getResumeFile()
    {
        if (!is_user_logged_in()) {
            die('Access denied');
        }

        $model = JobProfile::init();
        $jobProfile = $model->item(['user' => get_current_user_id()]);

        if ($jobProfile && !empty($jobProfile->resume_file)) {
            Response::file($model->getUploadDir() . $jobProfile->resume_file, $jobProfile->resume_filename);
        }
    }
}
