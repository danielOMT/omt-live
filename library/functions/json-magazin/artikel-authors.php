<?php if ($artikel['$speaker1_id'] == $current_page_id) { ?>
    <span><?php print $artikel['$speaker1_name']; ?></span>
<?php } else { ?>
    <a target="_self" href="<?php print $artikel['$speaker1_url']; ?>"><?php print $artikel['$speaker1_name']; ?></a>
<?php } ?>

<?php if (strlen($artikel['$speaker2_name'])>0) {
    print ", ";
    if ($artikel['$speaker2_id'] == $current_page_id) { ?>
        <span><?php print $artikel['$speaker2_name']; ?></span>
    <?php } else { ?>
        <a target="_self" href="<?php print $artikel['$speaker2_url']; ?>"><?php print $artikel['$speaker2_name']; ?></a>
    <?php }
} ?>

<?php if (strlen($artikel['$speaker3_name'])>0) {
    print ", ";
    if ($artikel['$speaker3_id'] == $current_page_id) { ?>
        <span><?php print $artikel['$speaker3_name']; ?></span>
    <?php } else { ?>
        <a target="_self" href="<?php print $artikel['$speaker3_url']; ?>"><?php print $artikel['$speaker3_name']; ?></a>
    <?php }
} ?>

<?php if (strlen($artikel['$speaker4_name'])>0) {
    print ", ";
    if ($artikel['$speaker4_id'] == $current_page_id) { ?>
        <span><?php print $artikel['$speaker4_name']; ?></span>
    <?php } else { ?>
        <a target="_self" href="<?php print $artikel['$speaker4_url']; ?>"><?php print $artikel['$speaker4_name']; ?></a>
    <?php }
} ?>

<?php if (strlen($artikel['$speaker5_name'])>0) {
    print "& ";
    if ($artikel['$speaker5_id'] == $current_page_id) { ?>
        <span><?php print $artikel['$speaker5_name']; ?></span>
    <?php } else { ?>
        <a target="_self" href="<?php print $artikel['$speaker5_url']; ?>"><?php print $artikel['$speaker5_name']; ?></a>
    <?php }
} ?>

<span style="float:right;"><i class="fa fa-clock-o" style="vertical-align:middle;"></i> <?php print $artikel['$reading_time']; ?></span>