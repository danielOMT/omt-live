<?php

use OMT\Model\Datahost\TrackingLinksHistory;
use OMT\Model\User;
use OMT\Services\Date;
use OMT\Services\ToolTrackingLinks;
use OMT\View\Components\ModalView;
use OMT\View\ToolView;

$service = new ToolTrackingLinks;
$tool = $_POST['toolid']
    ? get_post($_POST['toolid'])
    : reset(User::init()->tools(get_current_user_id()));

$trackingLinks = $service->groupAndFetchClickMeterData($service->links($tool->ID, false));

$trackingLinksHistory = TrackingLinksHistory::init()->items(
    ['tool' => $tool->ID], 
    ['order' => 'created', 'order_dir' => 'DESC', 'with' => 'category']
);
?>

<?php foreach ($trackingLinks as $categoryId => $item) : ?>
    <h4><?php echo $categoryId ? $item->category_name : 'Profilseite' ?> aktuelle Tracking-Links</h4>

    <table>
        <tr>
            <th style="width: 250px;">Typ</th>
            <th>URL</th>
            <th class="x-w-24"></th>
        </tr>

        <?php foreach ($item->links as $link) : ?>
            <tr>
                <td><?php echo $link->typeLabel ?> Link</td>
                <td>
                    <span data-type="<?php echo $link->type ?>" data-category="<?php echo (int) $link->category_id ?>">
                        <?php if ($link->clickMeter) : ?>
                            <?php echo $link->clickMeter['typeTL']['url'] ?>
                        <?php else : ?>
                            <span class="x-text-gray x-text-sm">Nicht definiert</span>
                        <?php endif ?>
                    </span>
                </td>
                <td>
                    <?php echo ModalView::loadTemplate('default', [
                        'title' => $tool->post_title . ' ' . $link->typeLabel . ' Tracking-Link bearbeiten',
                        'buttonTitle' => '<i class="fa fa-edit" title="Bearbeiten"></i>',
                        'buttonClass' => 'x-bg-transparent x-border-0',
                        'content' => ToolView::loadTemplate('edit-tracking-link', [
                            'tool' => $tool,
                            'link' => $link
                        ])
                    ]) ?>

                    <?php if ($link->clickMeter) : ?>
                        <span class="delete-tracking-link-container">
                            <?php echo ModalView::loadTemplate('default', [
                                'title' => $tool->post_title . ' ' . $link->typeLabel . ' Tracking-Link löschen',
                                'buttonTitle' => '<i class="fa fa-trash-o x-text-red-600" title="Löschen"></i>',
                                'buttonClass' => 'x-bg-transparent x-border-0',
                                'content' => ToolView::loadTemplate('delete-tracking-link', [
                                    'tool' => $tool,
                                    'link' => $link
                                ])
                            ]) ?>
                        </span>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endforeach ?>

<?php if (count($trackingLinksHistory)) : ?>
    <h4 class="x-pt-10">Tracking-Links Historie für das Tool <?php echo $tool->post_title ?></h4>
    <table>
        <thead>
            <tr>
                <th>Kategorie</th>
                <th>URL</th>
                <th class="x-w-48">Datum</th>
                <th>User</th>
                <th class="x-w-40">IP</th>
                <th class="x-w-20">Aktion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trackingLinksHistory as $linkHistory) : ?>
                <tr>
                    <td>
                        <?php echo $linkHistory->category ? $linkHistory->category->name : 'Profilseite' ?>
                    </td>
                    <td>
                        <?php echo $linkHistory->url ?>
                    </td>
                    <td>
                        <?php echo Date::get($linkHistory->created)->format('d.m.Y H:i:s') ?>
                    </td>
                    <td>
                        <?php if ($linkHistory->user_id) : ?>
                            <?php um_fetch_user($linkHistory->user_id); ?>
                            <?php echo um_user('display_name'); ?>
                        <?php endif ?>                     
                    </td>
                    <td>
                        <?php echo $linkHistory->user_ip ?>
                    </td>
                    <td>
                        <div class="x-text-2xl x-text-center">
                            <?php if ($linkHistory->action == TrackingLinksHistory::ACTION_DELETED) : ?>
                                <i class="fa fa-times-circle-o x-text-red-600" title="Der Tracking-Link wurde gelöscht"></i>
                            <?php else : ?>
                                <i class="fa fa-check-circle-o x-text-green-600" title="Der Tracking-Link wurde aktualisiert"></i>
                            <?php endif ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>