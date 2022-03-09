<?php

use OMT\Model\Datahost\Bid;
?>
<div class="module module-backend-area">
    <h2>Aktuellen Gebote pro Tool im Toolanbieter Ads Portal</h2>

    <?php foreach (Bid::init()->currentToolsBids() as $toolId => $tool) : ?>
        <?php if (count($tool->bids)) : ?>
            <h3><?php echo $tool->name ?></h3>

            <div class="toolanbieter-main-content-wrap fullwidth">
                <table>
                    <thead>
                        <th style="width: 50px;">#</th>
                        <th>Kategorie</th>
                        <th>Aktuelles Gebot</th>
                    </thead>
                    <tbody>
                        <?php foreach ($tool->bids as $key => $bid) : ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td>
                                    <?php echo $bid->category->name ?? '- - - ' ?>
                                </td>
                                <td>
                                    <?php echo $bid->bid_kosten ?> € / Klick
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endif ?>
    <?php endforeach ?>
</div>
