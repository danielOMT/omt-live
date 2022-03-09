<?php

use OMT\Model\Datahost\Click;
use OMT\Services\Date;
use OMT\Services\ToolCategoryClicks;

$months = array_reverse(Date::monthsPeriodUntilNow('2020-08-01'));
$clicks = Click::init()->items(['categoryAssigned' => true]);

wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js', ['alpine-sorting']);
wp_enqueue_script('alpine-sorting', get_template_directory_uri() . '/library/js/core/sorting.js');
?>
<div class="module module-backend-area">
    <h2>Klicks nach Kategorie im Toolanbieter Ads Portal</h2>

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
                    <td class="x-whitespace-nowrap">Alle Kategorien</td>
                    <td class="x-text-center">
                        <?php echo count($clicks) ?>
                    </td>
                    <?php foreach ($months as $month) : ?>
                        <td class="x-text-center">
                            <?php echo ToolCategoryClicks::totalByMonth($month, $clicks) ?>
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
                <th>Kategorie</th>
                <th @click="sortByColumn" class="sorting-column">Gesamt</th>
                <?php foreach ($months as $month) : ?>
                    <th @click="sortByColumn" class="sorting-column">
                        <?php echo $month->name ?> / <?php echo $month->year ?>
                    </th>
                <?php endforeach ?>
            </thead>
            <tbody x-ref="tbody">
                <?php foreach (ToolCategoryClicks::grabToolsCategories($clicks) as $key => $categoryId) : ?>
                    <tr>
                        <td><?php echo $key + 1 ?></td>
                        <td>
                            <strong><?php echo get_term_by('id', $categoryId, 'tooltyp')->name ?></strong>
                        </td>
                        <td class="x-text-center">
                            <?php echo ToolCategoryClicks::totalByCategory($categoryId, $clicks) ?>
                        </td>
                        <?php foreach ($months as $month) : ?>
                            <td class="x-text-center">
                                <?php echo ToolCategoryClicks::byMonth($categoryId, $month, $clicks) ?>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
