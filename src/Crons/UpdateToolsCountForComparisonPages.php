<?php

namespace OMT\Crons;

use OMT\Model\Tool;
use WP_Term;

/**
 * Run every night at ~03:00
 * Update tools pages title with the count of relevant tools from category
 */
class UpdateToolsCountForComparisonPages extends Cron
{
    protected function handle()
    {
        // Run as admin because get_the_title() in function json_tools() append "Private: " to the title of private tools
        $this->runAsAdmin();

        $tools = Tool::init()->toolsPages();

        foreach ($tools as $tool) {
            $relevantCategory = $this->getCategoryFromToolIndexModule($tool->ID);

            if ($relevantCategory && $relevantCategory instanceof WP_Term) {
                $toolsCount = count(get_posts([
                    'numberposts' => -1,
                    'post_status' => ['publish', 'private'],
                    'post_type' => 'tool',
                    'tax_query' => [[
                        'taxonomy' => 'tooltyp',
                        'field' => 'term_id',
                        'terms' => $relevantCategory->term_id
                    ]]
                ]));

                $this->updateToolTitle($tool, $toolsCount);

                $this->updateToolWpSeoTitle($tool, $toolsCount);
                $this->updateToolWpSeoFacebookTitle($tool, $toolsCount);
                $this->updateToolWpSeoTwitterTitle($tool, $toolsCount);
            }
        }
    }

    protected function updateToolTitle($tool, $count)
    {
        $originalTitle = $tool->post_title;
        $tool->post_title = preg_replace(['/(\s(\d)+\s)/', '/(^(\d)+\s)/', '/(\s(\d)+$)/'], [' ' . $count . ' ', $count . ' ', ' ' . $count], $tool->post_title, 1);

        if ($originalTitle !== $tool->post_title) {
            if (wp_update_post($tool)) {
                $this->log('Updated tool page title. Tools count: ' . $count . '. Tool ID: ' . $tool->ID);
            } else {
                $this->log('Error update tool page title. Tools count: ' . $count . '. Tool ID: ' . $tool->ID);
            }
        }
    }

    protected function updateToolWpSeoTitle($tool, $count)
    {
        $this->updateToolWpSeoMeta($tool, $count, '_yoast_wpseo_title');
    }

    protected function updateToolWpSeoFacebookTitle($tool, $count)
    {
        $this->updateToolWpSeoMeta($tool, $count, '_yoast_wpseo_opengraph-title');
    }

    protected function updateToolWpSeoTwitterTitle($tool, $count)
    {
        $this->updateToolWpSeoMeta($tool, $count, '_yoast_wpseo_twitter-title');
    }

    protected function updateToolWpSeoMeta($tool, $count, $key)
    {
        $title = get_post_meta($tool->ID, $key, true);

        $value = !empty($title)
                ? preg_replace(['/(\s(\d)+\s)/', '/(^(\d)+\s)/', '/(\s(\d)+$)/'], [' ' . $count . ' ', $count . ' ', ' ' . $count], $title, 1)
                : $tool->post_title;

        if (update_post_meta($tool->ID, $key, $value)) {
            $this->log('Updated tool page WP SEO ' . ucfirst(str_replace('_', ' ', str_replace('_yoast_wpseo_', '', $key))) . '. Tools count: ' . $count . '. Tool ID: ' . $tool->ID);
        }
    }

    protected function runAsAdmin()
    {
        if (!defined('WP_ADMIN')) {
            define('WP_ADMIN', true);
        }
    }

    protected function getCategoryFromToolIndexModule(int $toolId)
    {
        foreach (get_field('zeilen', $toolId) as $value) {
            if (isset($value['inhaltstyp'])) {
                foreach ($value['inhaltstyp'] as $contentType) {
                    if (isset($contentType['acf_fc_layout']) && $contentType['acf_fc_layout'] == 'toolindex' && $contentType['tabelle_kategorie'] == 'kategorie') {
                        return $contentType['kategorie_auswahlen'];
                    }
                }
            }
        }

        return null;
    }

    protected function getHook()
    {
        return 'update-tools-count-for-comparison-pages';
    }

    protected function getInterval()
    {
        return 'daily';
    }

    protected function getTimestamp()
    {
        $ve = get_option('gmt_offset') > 0 ? '-' : '+';

        return strtotime('03:00 ' . $ve . absint(get_option('gmt_offset')) . ' HOURS');
    }
}
