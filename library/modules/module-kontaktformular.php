<?php
switch ($zeile['inhaltstyp'][0]['formular_effekt']) {
    case "normal":
        echo do_shortcode( '[gravityform id="' . $zeile['inhaltstyp'][0]['gravity_forms_id'] . '" title="true" description="true" tabindex="0"]' );
        break;
    case "lightbox": ?>
        <div class="x-flex omt-gravity-forms-container">
            <div class="x-flex-auto">
                <a data-effect="<?php print $zeile['inhaltstyp'][0]['formular_effekt'];?>" data-id="form-<?php print $zeile['inhaltstyp'][0]['gravity_forms_id'];?>" class="activate-form button button-red" href="#">
                    <?php echo !empty($zeile['inhaltstyp'][0]['formular_button_text']) ? $zeile['inhaltstyp'][0]['formular_button_text'] : "Jetzt Formular ausfüllen!" ?>
                </a>
                <div id="form-<?php print $zeile['inhaltstyp'][0]['gravity_forms_id'];?>" class="contact-lightbox hidden">
                    <?php echo do_shortcode( '[gravityform ajax=true id="' . $zeile['inhaltstyp'][0]['gravity_forms_id'] . '" title="true" description="true" tabindex="0"]' ); ?>
                </div>
            </div>

            <?php if ($zeile['inhaltstyp'][0]['gravity_forms_id_2']) : ?>
                <div class="x-flex-auto">
                    <a data-effect="<?php print $zeile['inhaltstyp'][0]['formular_effekt'];?>" data-id="form-<?php print $zeile['inhaltstyp'][0]['gravity_forms_id_2'];?>" class="activate-form button button-red" href="#">
                        <?php echo !empty($zeile['inhaltstyp'][0]['formular_button_text_2']) ? $zeile['inhaltstyp'][0]['formular_button_text_2'] : "Jetzt Formular ausfüllen!" ?>
                    </a>
                    <div id="form-<?php print $zeile['inhaltstyp'][0]['gravity_forms_id_2'];?>" class="contact-lightbox hidden">
                        <?php echo do_shortcode( '[gravityform ajax=true id="' . $zeile['inhaltstyp'][0]['gravity_forms_id_2'] . '" title="true" description="true" tabindex="0"]' ); ?>
                    </div>
                </div>
            <?php endif ?>

            <?php if ($zeile['inhaltstyp'][0]['gravity_forms_id_3']) : ?>
                <div class="x-flex-auto">
                    <a data-effect="<?php print $zeile['inhaltstyp'][0]['formular_effekt'];?>" data-id="form-<?php print $zeile['inhaltstyp'][0]['gravity_forms_id_3'];?>" class="activate-form button button-red" href="#">
                        <?php echo !empty($zeile['inhaltstyp'][0]['formular_button_text_3']) ? $zeile['inhaltstyp'][0]['formular_button_text_3'] : "Jetzt Formular ausfüllen!" ?>
                    </a>
                    <div id="form-<?php print $zeile['inhaltstyp'][0]['gravity_forms_id_3'];?>" class="contact-lightbox hidden">
                        <?php echo do_shortcode( '[gravityform ajax=true id="' . $zeile['inhaltstyp'][0]['gravity_forms_id_3'] . '" title="true" description="true" tabindex="0"]' ); ?>
                    </div>
                </div>
            <?php endif ?>
        </div>

        <?php break;
    case "fadein": ?>
        <a data-effect="<?php print $zeile['inhaltstyp'][0]['formular_effekt'];?>" class="activate-form button button-red" href="#">
            <?php echo !empty($zeile['inhaltstyp'][0]['formular_button_text']) ? $zeile['inhaltstyp'][0]['formular_button_text'] : "Jetzt Formular ausfüllen!" ?>
        </a>
        <div class="contact-fade">
            <?php echo do_shortcode( '[gravityform id="' . $zeile['inhaltstyp'][0]['gravity_forms_id'] . '" title="true" description="true" tabindex="0"]' ); ?>
        </div>
        <?php break;
}
?>
