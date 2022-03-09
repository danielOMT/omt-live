<?php
/*
Template Name: Admin Dashboard
*/

use OMT\View\Admin\Dashboard\JobProfilesView;

wp_enqueue_script('alpine-app', get_template_directory_uri() . '/library/js/app.js', [], 'c.1.0.4', true);
?>

<?php get_header(); ?>

<div id="content" xmlns:background="http://www.w3.org/1999/xhtml">
    <div class="x-bg-gray-200 x-pb-4 x-pt-4 x-mb-8">
        <div class="wrap">
            <a href="#job-profiles" class="x-mr-4">Job-Profile</a>
            <a href="#other">Other...</a>
        </div>
    </div>

    <div class="wrap">
        <div x-data="{ page: location.hash }" @hashchange.window="page = location.hash">
            <template x-if="page === '' || page === '#job-profiles'">
                <div x-data="xJobProfilesDashboard()">
                    <?php echo JobProfilesView::loadTemplate() ?>
                </div>
            </template>
            
            <template x-if="page === '#other'">
                <div>Other admin panel dashboard</div>
            </template>
        </div>
    </div>
</div>

<?php get_footer(); ?>