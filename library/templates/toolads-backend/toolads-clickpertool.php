<?php

use OMT\Model\Datahost\Click;
use OMT\Services\Date;
use OMT\Services\ToolClicks;

$months = array_reverse(Date::monthsPeriodUntilNow('2020-08-01'));
$clicks = Click::init()->items();

wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js', ['alpine-sorting']);
wp_enqueue_script('alpine-sorting', get_template_directory_uri() . '/library/js/core/sorting.js');
?>
<div class="module module-backend-area">
    <h2>Klicks nach Tool im Toolanbieter Ads Portal</h2>

    <div class="x-overflow-x-auto x-mb-8">
        <table class="x-w-auto">
            <thead>
                <th>Klicks Gesamt</th>
                <th>All Time</th>
                <?php foreach ($months as $month) : ?>
                    <th>
                        <?php echo $month->name ?> / <?php echo $month->year ?>
                    </th>
                <?php endforeach ?>
            </thead>
            <tbody>
                <tr>
                    <td>Alle Tools</td>
                    <td class="x-text-center">
                        <?php echo count($clicks) ?>
                    </td>
                    <?php foreach ($months as $month) : ?>
                        <td class="x-text-center">
                            <?php echo ToolClicks::totalByMonth($month, $clicks) ?>
                        </td>
                    <?php endforeach ?>
                </tr>
            </tbody>
        </table>
    </div>

    <div x-data="xSorting()" class="toolanbieter-main-content-wrap fullwidth x-overflow-x-auto">
        <table class="omt-sorting-table x-w-auto">
            <thead>
                <th class="x-w-16">#</th>
                <th>Tool</th>
                <th @click="sortByColumn" class="sorting-column">Klicks</th>
                <?php foreach ($months as $month) : ?>
                    <th @click="sortByColumn" class="sorting-column">
                        <?php echo $month->name ?> / <?php echo $month->year ?>
                    </th>
                <?php endforeach ?>
            </thead>
            <tbody x-ref="tbody">
                <?php foreach (ToolClicks::grabTools($clicks) as $key => $toolId) : ?>
                    <tr>
                        <td><?php echo $key + 1 ?></td>
                        <td>
                            <p><a target="_blank" href="<?php echo get_the_permalink($toolId) ?>"><b><?php echo get_the_title($toolId) ?></b></a></p>
                        </td>
                        <td class="x-text-center">
                            <?php echo ToolClicks::totalByTool($toolId, $clicks) ?>
                        </td>
                        <?php foreach ($months as $month) : ?>
                            <td class="x-text-center">
                                <?php echo ToolClicks::byMonth($toolId, $month, $clicks) ?>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
