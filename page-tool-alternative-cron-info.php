<?php
/*
Template Name: Infoseite für Toolalternativseite
*/

use OMT\Ajax\ToolsAlternativesStats;
use OMT\Services\FlashMessages;
use OMT\Services\ToolAlternatives;

$service = new ToolAlternatives;
$logs = $service->readLogs();

if (isset($_GET['export'])) {
    $service->export($logs);
}

wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js', ['alpine-sorting', 'ajax-tools-alternatives-stats']);
wp_enqueue_script('alpine-sorting', get_template_directory_uri() . '/library/js/core/sorting.js');
wp_enqueue_script('ajax-tools-alternatives-stats', get_template_directory_uri() . '/library/js/custom/tools-alternatives-stats.js', ['jquery'], null, true);
wp_localize_script('ajax-tools-alternatives-stats', 'omt_tools_alternatives_stats', ['ajax_url' => admin_url('admin-ajax.php')]);
?>

<?php get_header(); ?>
<div id="content" xmlns:background="http://www.w3.org/1999/xhtml">
    <div 
        x-data="xSorting()" 
        class="omt-row wrap has-margin-top-30"
    >
        <?php echo FlashMessages::render() ?>

        <div class="x-flex x-justify-between x-w-full">
            <h2>Infoseite für Toolalternativseite</h2>

            <div>
                <!-- <a href="<?php echo get_permalink() ?>?export=1" class="button button-red">
                    Export
                </a> -->
            </div>
        </div>

        <span
            x-data="xToolsAlternativesStats()"
            x-init="getStats"
        >
            <h4>Anzahl aller bisher angepassten Tools: <span id="count-enabled-alternatives"><span class="x-text-gray x-text-xl">Initialisierung...</span></span></h4>
            <h4>Anzahl aller noch fehlenden Tools: <span id="count-disabled-alternatives"><span class="x-text-gray x-text-xl">Initialisierung...</span></span></h4>
        </span>
        <table class="omt-sorting-table">
            <thead>
                <tr>
                    <th class="x-w-20">Aktion</th>
                    <th @click="sortByColumn" class="sorting-column">Datum</th>
                    <th @click="sortByColumn" class="sorting-column">Tool</th>
                    <th>Tool Alternativseite URL</th>
                    <th>Editor URL</th>
                    <th @click="sortByColumn" class="sorting-column">Anzahl Alternativen</th>
                </tr>
            </thead>
            <tbody x-ref="tbody">
                <?php foreach ($logs as $log) : ?>
                    <tr>
                        <td>
                            <div class="x-text-2xl x-text-center">
                                <?php if ($log['action'] == 'enable') : ?>
                                    <i class="fa fa-check-circle-o x-text-green-600" title="Option -Alternativseite Anzeigen- wurde aktiviert"></i>
                                <?php else : ?>
                                    <i class="fa fa-times-circle-o x-text-red-600" title="Option -Alternativseite Anzeigen- wurde deaktiviert"></i>
                                <?php endif ?>
                            </div>
                        </td>
                        <td data-alpine-sort="<?php echo strtotime($log['date']) ?>">
                            <?php echo $log['date'] ?>
                        </td>
                        <td>
                            <a target="_blank" href="<?php echo $log['url'] ?>"><b><?php echo $log['title'] ?></b></a>
                        </td>
                        <td>
                            <div class="ellipsis-text">
                                <a target="_blank" href="<?php echo $log['alternatives_url'] ?>" title="<?php echo $log['alternatives_url'] ?>">
                                    <?php echo $log['alternatives_url'] ?>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="ellipsis-text">
                                <a target="_blank" href="<?php echo $log['edit_url'] ?>" title="<?php echo $log['edit_url'] ?>">
                                    <?php echo $log['edit_url'] ?>
                                </a>
                            </div>
                        </td>
                        <td class="text-center">
                            <?php echo count($log['alternatives']) ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php get_footer(); ?>