<?php

use OMT\Model\Expert;
use OMT\Model\PostModel;
use OMT\Services\AdvancedCustomFields\ACF;
use OMT\Services\Date;
use OMT\View\AuthorView;

function truncateString(string $str, int $chars = 30)
{
    return mb_strlen($str) > $chars ? mb_substr($str, 0, $chars) . '...' : $str;
}

/**
 * @param array $experts List of experts from "omt_datahost"
 */
function schemaExperts(array $experts)
{
    return implode(', ', array_map(fn ($expert) => $expert->name, $experts));
}

/**
 * @param array $seminar
 * @param bool $grouped Set true if 2 seminars are grouped in one schema (for mixed seminars, online and offline variation)
 */
function schemaEventAttendanceMode(array $seminar, bool $grouped = false)
{
    // If seminars are grouped in one schema and the current seminar has his online or offline variation attached then it's a Mixed seminar
    if ($grouped && ($seminar['online_id'] || $seminar['offline_id'])) {
        return 'https://schema.org/MixedEventAttendanceMode';
    }

    // If the seminar has his offline variation attached then it's an Online seminar
    if ($seminar['offline_id']) {
        return 'https://schema.org/OnlineEventAttendanceMode';
    }

    return 'https://schema.org/OfflineEventAttendanceMode';
}

/**
 * @param array $experts List of experts from "omt_datahost"
 */
function postExperts(array $experts, $layout = 'names-list')
{
    return AuthorView::loadTemplate($layout, [
        'currentPageId' => get_the_ID(),
        'experts' => $experts
    ]);
}

function formatDate(string $date, string $format = 'Y-m-d H:i:s')
{
    $dateTime = Date::get($date);

    return !is_null($dateTime) ? $dateTime->format($format) : '';
}

/**
 * Retrieve post data given a post ID. Defaults to global $post.
 * Returns empty PostModel object if the WP_Post is not found
 */
function getPost(int $postId = null)
{
    if (is_null($postId) && isset($GLOBALS['post'])) {
        return PostModel::getInstance($GLOBALS['post']->ID);
    }

    return PostModel::getInstance($postId);
}

/**
 * Get ACF option stored at /wp-admin/admin.php?page=acf-options-optionen
 *
 * @param string $type format of the field in ACF (bool, int, float, array, content, repeater, image_url, image_array, file_url)
 */
function getOption(string $key, string $type = null)
{
    return ACF::getInstance()->getOption($key, $type);
}

/**
 * Get "speaker" post type list of names
 *
 * @param array $expertsId
 */
function expertsNames(array $expertsId)
{
    $experts = Expert::init()->items(['id' => $expertsId], [
        'updateMetaCache' => false,
        'updateTermCache' => false
    ]);

    return implode(', ', array_map(fn ($expert) => $expert->post_title, $experts));
}

function getYoutubeThumb(string $id)
{
    if (file_get_contents('https://i.ytimg.com/vi_webp/' . $id . '/sddefault.webp', false, null, 0, 1) !== false) {
        return 'https://i.ytimg.com/vi_webp/' . $id . '/sddefault.webp';
    }

    return 'https://i.ytimg.com/vi_webp/' . $id . '/hqdefault.webp';
}

function placeholderImage()
{
    return get_site_url() . '/uploads/woocommerce-placeholder.png';
}

/**
 * Return first 3 elements of current category "Tool details"
 */
function getToolDetails(array $tool, $category)
{
    $details = $tool['$tool_details'];

    foreach ((array) $tool['$tool_details_by_categories'] as $value) {
        if ($value['category'] == $category) {
            $details = $value['details'];
            break;
        }
    }

    return array_slice($details, 0, 3);
}

/**
 * The webinar will be treated as available even one hour after the start
 */
function isWebinarAvailable(stdClass $webinar)
{
    return Date::greaterEqualsThanNow(
        Date::get($webinar->date)->modify('+1 hour')
    );
}

function getToolTitle($toolName, $h1, $inhalt, $testbericht_zeilen, $buttons_anzeigen)
{
    $parts = ['Erfahrungen'];

    if ((strlen($h1) > 0 && strlen($inhalt) > 0) || is_array($testbericht_zeilen)) {
        $parts[] = 'Testbericht';
    }

    if ($buttons_anzeigen == 1) {
        $parts[] = 'Preise';
    }

    return $toolName . ' ➡ ' . implode(', ', $parts) . ' und Bewertungen';
}
