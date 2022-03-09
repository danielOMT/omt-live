<?php
//note for later: this probably can be deleted when global index option is active!

function omt_index_shortcode_sidebar( $atts ) {
    $atts = shortcode_atts( array (
    ), $atts );

    ob_start();
    $inhaltsverzeichnis = get_field('inhaltsverzeichnis');
    if (strlen($inhaltsverzeichnis[0]['titel'])>0) {
        ?>
        <div class="widget widget_omt_index_widget">
            <h4 class="widgettitle">Inhaltsangabe</h4>
            <ul class="omt-icon">
                <?php foreach ($inhaltsverzeichnis as $inhaltspunkt) { ?>
                    <?php if ($inhaltspunkt['zwischenuberschrift']!=0) { ?>
                        <li class="<?php if($inhaltspunkt['listenpunkt_einrucken'] != 0) { print "indent"; } ?>">
                            <?php if (strlen ($inhaltspunkt['link'])>0) { ?>
                                <a class="inhalt-subheader" href="<?php print $inhaltspunkt['link'];?>" <?php if($inhaltspunkt['in_neuem_fenster_offnen']!=0) { print 'target="_blank"'; } ?>><?php print $inhaltspunkt['titel'];?></a>
                            <?php }
                            else { ?>
                                <span class="inhalt-subheader"><?php print $inhaltspunkt['titel'];?></span>
                            <?php } ?>
                        </li>
                    <?php }
                    else { ?>
                        <li class="<?php if($inhaltspunkt['listenpunkt_einrucken'] != 0) { print "indent"; } ?>"><a href="<?php print $inhaltspunkt['link'];?>" <?php if($inhaltspunkt['in_neuem_fenster_offnen']!=0) { print 'target="_blank"'; } ?>><?php print $inhaltspunkt['titel'];?></a></li>
                    <?php } } ?>
            </ul>
        </div>
    <?php } ?>
    <?php $result = ob_get_clean();


    return $result;
}
add_shortcode( 'inhaltsverzeichnis_sidebar', 'omt_index_shortcode_sidebar' );
?>