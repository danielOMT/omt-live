<?php
function edit_tool(int $edit_id = 0) {
    acf_form_head();
    acf_enqueue_uploader();
    ?>
    <div class="tool-form">

    <?php
    $fields = array(
         'field_58ffcee42b2da', //tab Tool-index
         'field_5eaaa1ca19efc', //Tool Vorschautext nach Kategorie
         'field_5e834c3bbc1a3', //Tab Einzelseiten Felder
        'field_58ffcef02b2db', //Logo
        'field_5e9ed7f41fd4c', //"Wer verwendet..."
         'field_5e834eb17937d', //"Was ist..."
         'field_5f7f2d61bb694', //"Tab "Slider..."
         'field_5e834c59bc1a4', //"Info Slider..."
         'field_5f7f2dfff7743', //"Tab Funktionen..."
         'field_5e863ead5b890', //"Funktionen..."
         'field_5ec239417475d', //"Anwendungstipps Tab..."
         'field_5ec2396f7475f' //"Anwendungstipps..."
    );
    $itsmine = false;
    $current_user_id = get_current_user_id();
    $zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);
    foreach ($zugewiesenes_tool as $mytool) {
        if ($mytool->ID == $edit_id) { $itsmine = true; }
    }
    if (true != $itsmine) { $edit_id = 0; }
    if (0 != $edit_id) {
        acf_form(array(
            'id' => 'toolanbieter-backend-editor',
            'post_id' => $edit_id,
            'post_title' => false,
            'post_content' => false,
            //   'uploader'      	=> 'basic',
            'return' => '?updated=true&area=bearbeiten&toolid=' . $edit_id,
            'updated_message' => __("Tool aktualisiert", 'acf'),
            'fields' => $fields,
            'submit_value' => 'Tool aktualisieren'
        ));
// Load the form
    } else {
        print "Bitte verhalte Dich fair gegenüber den anderen Toolanbietern und dem OMT. Missbrauchsversuche werden geloggt";
    }

    ?></div><?php
}