<?php

//////////SQL CONNECTION TO DATAHOST

use OMT\Services\ToolTrackingLinks;
use OMT\View\Components\ModalView;
use OMT\View\ToolView;

$conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//////////SQL CONNECTION TO DATAHOST

$usersql = "SELECT * FROM `omt_guthaben`";
$query = $conn->query($usersql);

wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js', ['alpine-sorting']);
wp_enqueue_script('alpine-sorting', get_template_directory_uri() . '/library/js/core/sorting.js');
?>

<div class="module module-backend-area">
    <h2>Registrierte Toolanbieter im Toolanbieter Ads Portal</h2>

    <div class="x-flex x-justify-end x-mb-4 x-w-full">
        <a href="/toolads/?toolpage=create-user" class="button button-dark-blue">Neue hinzufügen</a>
    </div>
    
    <div x-data="xSorting()" class="toolanbieter-main-content-wrap fullwidth">
        <table class="omt-sorting-table">
            <thead>
                <th class="x-w-16">#</th>
                <th @click="sortByColumn" class="sorting-column">Name</th>
                <th @click="sortByColumn" class="sorting-column">Tool(s)</th>
                <th @click="sortByColumn" class="sorting-column">Klicks (Gesamt)</th>
                <th @click="sortByColumn" class="sorting-column">Aktuelles Guthaben</th>
            </thead>
            <tbody x-ref="tbody">
                <?php
                $i = 0;
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        $i++;
                        $userid = $row['user_id'];
                        $user = get_user_by('id', $userid);
                        $zugewiesenes_tool = (array) get_field('zugewiesenes_tool', 'user_' . $userid);

                        foreach ($zugewiesenes_tool as $tool) {
                            $tool->clicks = 0;
                            $toolquery = $conn->query("SELECT * FROM `omt_clicks` WHERE `tool_id` = " . $tool->ID);
 
                            if (mysqli_num_rows($toolquery) > 0) {
                                while (mysqli_fetch_assoc($toolquery)) {
                                    $tool->clicks++;
                                }
                            }
                        }

                        $firstTool = reset($zugewiesenes_tool);
                        ?>
                        <tr>
                            <td><?php print "#" . $i;?></td>
                            <td><b><?php print $user->user_login; ?></b></td>
                            <td data-alpine-sort="<?php echo get_the_title($firstTool) ?>">
                                <?php foreach ($zugewiesenes_tool as $tool) : ?>
                                    <div>
                                        <a target="_blank" href="<?php echo get_the_permalink($tool) ?>"><?php echo get_the_title($tool) ?></a>

                                        <?php echo ModalView::loadTemplate('default', [
                                            'title' => 'Gebote ändern für das Tool ' . get_the_title($tool),
                                            'buttonTitle' => '(Gebot ändern)',
                                            'content' => ToolView::loadTemplate('edit-bids', [
                                                'trackingLinks' => (new ToolTrackingLinks)->categoriesLinks($tool->ID)
                                            ])
                                        ]) ?>
                                    </div>
                                <?php endforeach ?>
                            </td>
                            <td data-alpine-sort="<?php echo $firstTool->clicks ?>">
                                <?php foreach ($zugewiesenes_tool as $tool) : ?>
                                    <div><?php echo $tool->clicks ?></div>
                                <?php endforeach ?>
                            </td>
                            <td><?php print $row['guthaben'];?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
