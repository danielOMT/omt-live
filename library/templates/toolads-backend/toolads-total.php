<?php

use OMT\Model\Datahost\Click;
use OMT\Services\Date;
use OMT\Services\ToolCosts;

$months = array_reverse(Date::monthsPeriodUntilNow('2020-08-01'));
$clicks = Click::init()->items();

wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js', ['alpine-sorting']);
wp_enqueue_script('alpine-sorting', get_template_directory_uri() . '/library/js/core/sorting.js');
?>
<div class="module module-backend-area">
    <h2>Gesamt nach Tool im Toolanbieter Ads Portal</h2>

    <h3>Gesamt: <?php echo ToolCosts::cost($clicks) ?> €</h3>
    <div x-data="xSorting()" class="toolanbieter-main-content-wrap fullwidth x-overflow-x-auto">
        <table class="omt-sorting-table x-w-auto">
            <thead>
                <th style="width: 50px;">#</th>
                <th>Tool</th>
                <th @click="sortByColumn" class="sorting-column">Gesamt</th>
                <?php foreach ($months as $month) : ?>
                    <th @click="sortByColumn" class="sorting-column">
                        <?php echo $month->name ?> / <?php echo $month->year ?>
                    </th>
                <?php endforeach ?>
            </thead>
            <tbody x-ref="tbody">
                <?php foreach (ToolCosts::grabTools($clicks) as $key => $toolId) : ?>
                    <tr>
                        <td><?php echo $key + 1 ?></td>
                        <td>
                            <a target="_blank" href="<?php echo get_the_permalink($toolId);?>"><b><?php echo get_the_title($toolId);?></b></a>
                        </td>
                        <td
                            data-alpine-sort="<?php echo $total = ToolCosts::total($toolId, $clicks) ?>"
                            class="x-text-center" 
                        >
                            <?php echo $total ? $total . ' €' : '-' ?>
                        </td>
                        <?php foreach ($months as $month) : ?>
                            <td
                                data-alpine-sort="<?php echo $totalByMonth = ToolCosts::byMonth($toolId, $month, $clicks) ?>"
                                class="x-text-center"
                            >
                                <?php echo $totalByMonth ? $totalByMonth . ' €' : '-' ?>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
