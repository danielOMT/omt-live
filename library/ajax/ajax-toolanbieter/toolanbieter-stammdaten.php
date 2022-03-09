<?php
acf_form_head();
acf_enqueue_uploader();
$current_user_id = get_current_user_id();
um_fetch_user($current_user_id);
$display_name = um_user('display_name');
$zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);
?>
<h3>Stammdaten bearbeiten</h3>
<p><b>Aktueller Benutzer: </b><?php print $display_name;?></p>
<div class="tool-form">

    <?php
    $fields = array(
        'field_5f5a2735f059b', //Firma
        'field_5f5a2740f059c', //Umsatzsteuernummer
        'field_5f085613dece4', //Anrede
        'field_5eeb713498047', //Ansprechpartner Vorname
        'field_5f08563fdece5', //Ansprechpartner Nachname
        'field_5eeb713e98048', //Strasse
        'field_5eeb715498049', //Hausnummer
        'field_5eeb76d1216b3', //Postleitzahl
        'field_5eeb715c9804a' //Ort
    );
    acf_form(array(
        'id'		    	=> 'toolanbieter-backend-editor',
        'post_id'	    	=> $current_user_id,
        'post_title'		=> false,
        'post_content'  	=> false,
        //   'uploader'      	=> 'basic',
        'return'			=> '?updated=true&area=stammdaten',
        'updated_message' => __("Stammdaten wurden gespeichert", 'acf'),
        'fields'				=> $fields,
        'submit_value'		=> 'Stammdaten aktualisieren'
    ));
    // Load the form

    ?></div>