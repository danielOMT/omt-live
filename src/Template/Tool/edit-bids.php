<?php if (count($this->trackingLinks)) : ?>
    <table class="gebote-wrap">
        <tr>
            <th>Kategorie</th>
            <th>Aktuelles Gebot</th>
        </tr>
        <?php foreach ($this->trackingLinks as $link) : ?>
            <tr>
                <td><?php echo $link->category_name ?></td>
                <td data-bidprice="<?php echo $link->bid_costs ?>" data-bid="<?php echo $link->bid_id ?>" data-cat="<?php echo $link->category_id ?>">
                    <?php echo $link->bid_costs ?> € / Klick
                    <span class="change-bid">(ändern)</span>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
<?php else : ?>
    <strong>Keine Tracking-Links gefunden</strong>
<?php endif ?>