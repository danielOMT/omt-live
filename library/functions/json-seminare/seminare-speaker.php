<?php if ($seminar['speaker_1_id'] == $current_page_id) { ?>
    <span><?php print $seminar['speaker_1_name']; ?></span>
<?php } else { ?>
    <a target="_self"
       href="<?php print $seminar['speaker_1_link']; ?>"><?php print $seminar['speaker_1_name']; ?></a>
<?php }
if (($seminar['speaker_2_id'])!=NULL) {
    print ", ";
    if ($seminar['speaker_2_id'] == $current_page_id) { ?>
        <span><?php print $seminar['speaker_2_name']; ?></span>
    <?php } else { ?>
        <a target="_self"
           href="<?php print $seminar['speaker_2_link']; ?>"><?php print $seminar['speaker_2_name']; ?></a>
    <?php }
}
if (($seminar['speaker_3_id'])!=NULL) {
    print "& ";
    if ($seminar['speaker_3_id'] == $current_page_id) { ?>
        <span><?php print $seminar['speaker_3_name']; ?></span>
    <?php } else { ?>
        <a target="_self"
           href="<?php print $seminar['speaker_3_link']; ?>"><?php print $seminar['speaker_3_name']; ?></a>
    <?php }
} ?>
