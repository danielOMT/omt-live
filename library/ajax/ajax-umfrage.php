<?php
function vb_check_umfrage() {
    /* if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'webjamz' ) )
         die('Permission denied');*/
    /**
     * Default response
     */
    $response = [
        'status'  => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false,
        'found'   => 0
    ];
    /**
     * Setup query
     */
    $votes = "votes: " . $_POST['votes'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $code = $_POST['code'];
    $umfrageid = $_POST['umfrageid'];
    /*   if ($kategorie_id != NULL) {
           $tax_query[] =  array(
               'taxonomy' => 'kategorie',
               'field' => 'id',
               'terms' => $category_id
           );
       }*/
    $key_vortrage = "field_5f0c6107bfcb5";
    $key_vortragsstimmen = "field_5f0c6300bfcbd";
    $key_users = "field_5f0c6269bfcb7";
    $key_hatabgestimmt = "field_5f2c164ad60a3";
    $key_stimmen = "field_5f2c166d37d71";

    $users = get_field('berechtigte_user', $umfrageid);
    $vortrage = get_field('vortrage', $umfrageid);

    $validcode = 0;
    $u = 0;
    $message = "Leider hast Du eine ungültige Kombination aus Email und Code eingegeben. <br>
    Bitte beachte, dass Du für Deinen Code die E-Mail Adresse an welchen wir diesen versendet haben verwenden musst.<br>
    Bitte versuche es erneut. Falls Du Fragen haben solltest, wende Dich bitte an <a href='mailto:mario@omt.de'>mario@omt.de</a>";


    foreach ($users as $user) {
        $u++;
        if ( ( $user['code'] == $code ) AND ( $user['e-mail_adresse'] == $email ) ) {
            $validcode=1;
            $message = "Deine Stimmen wurden erfolgreich abgegeben, vielen Dank!";
            $codeused = $user['hat_abgestimmt'];
            if (1 != $codeused) {
                if (is_array($vortrage)) {
                    $i = 0;
                    $namedvotes = "";
                    foreach ($vortrage as $vortrag) {
                        $i++;
                        $vortragsid = $vortrag['vortrag']->ID;
                        $pos = strpos($votes, "$vortragsid");
                        if ($pos != false) {
                            $namedvotes .= "<p>" . get_the_title($vortragsid) . "</p>";
                            $votecount = $vortrag['anzahl_stimmen'];
                            $votecount++;
                            update_sub_field(array($key_vortrage, $i, $key_vortragsstimmen), $votecount, $umfrageid);
                        }
                    }
                }
                $codeused = 1;
                update_sub_field(array($key_users, $u, $key_hatabgestimmt), true, $umfrageid);
                update_sub_field(array($key_users, $u, $key_stimmen), "$namedvotes", $umfrageid);
            } else {
                $validcode = 0;
                $message = "Du hast Deinen Code bereits verwendet und kannst nur einmal an der Abstimmung teilnehmen. Falls Du denkst, dass hier ein Fehler vorliegt wende Dich bitte an <a href='mailto:mario@omt.de'>mario@omt.de</a>";
            }
        }
    }
    ob_start();
    if (1 == $validcode) { ?>
        <div class="status-message status-success"><?php print $message;?></div>
    <?php } else { ?>
        <div class="status-message status-failure"><?php print $message;?></div>
    <?php }
    $response = [
        'status'=> 200,
        'found' => $qry->found_posts
    ];
    $response['content'] = ob_get_clean();
    die(json_encode($response));

}
add_action('wp_ajax_do_check_umfrage', 'vb_check_umfrage');
add_action('wp_ajax_nopriv_do_check_umfrage', 'vb_check_umfrage');