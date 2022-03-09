<?php
function vb_perform_budget() {
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
    $bid = $_POST['bid'];
    $toolid = $_POST['toolid'];
    $current_user_id = get_current_user_id();
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);

    ob_start();
    if (strlen($bid)>0) :
        //////////SQL CONNECTION TO DATAHOST
        $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $date = new DateTime(null, new DateTimeZone('Europe/Amsterdam'));
        $time = $date->getTimestamp();

        if (0 == $toolid) {
            //CREATE NEW BID WITH is_active=1 AND VALIDFROM = CURRENT TIMESTAMP
            $sqlbids = "INSERT INTO omt_budgets (unix_timestamp, user_id, user_ip, tool_id, toolkategorie_id, budget)
                            VALUES ('$time', '$current_user_id', '$user_ip', '0', '0', '$bid')";
            if (strlen($sqlbids) > 0) {
                if ($conn->query($sqlbids) === TRUE) {
                    //   echo "New BIDDING record created or updated successfully";
                } else {
                    echo "Error: " . $sqlbids . "<br>" . $conn->error;
                    echo "Bitte mache einen Screenshot von der Seite und schicke den Fehler + Info (Eingaben und alles was Dir einfällt) an <a href='mailto:daniel.voelskow@reachx.de'>daniel.voelskow@reachx.de</a>";
                }
            }
        } else {
            $valid = 0;
            foreach ($zugewiesenes_tool as $tool) {
                $user_tool_id = $tool->ID;
                if ($user_tool_id == $toolid) { $valid=1; }
            }
            if (1 == $valid) {
                $sqlbids = "INSERT INTO omt_budgets (unix_timestamp, user_id, user_ip, tool_id, toolkategorie_id, budget)
                            VALUES ('$time', '$current_user_id', '$user_ip', '$toolid', '0', '$bid')";
                if (strlen($sqlbids) > 0) {
                    if ($conn->query($sqlbids) === TRUE) {
                        //   echo "New BIDDING record created or updated successfully";
                    } else {
                        echo "Error: " . $sqlbids . "<br>" . $conn->error;
                        echo "Bitte mache einen Screenshot von der Seite und schicke den Fehler + Info (Eingaben und alles was Dir einfällt) an <a href='mailto:daniel.voelskow@reachx.de'>daniel.voelskow@reachx.de</a>";
                    }
                }
            }
        }

            ////OUTPUT FOR THE AJAX REQUEST; WE REPLACE THE FORMER TD WITH A NEW CURRENT TD CONTAINING BIDDING ID OF THE MOST RECENT ACTIVE BID
            print '<td class="" data-tool="' . $toolid . '" data-budget="' . $bid . '">' . $bid . '€ <span class="change-budget">(ändern)</span></td>';
        ?>
        <?php
        $response = [ //save output for my response in ajax content container here
            'status'=> 200,
            'found' => $qry->found_posts
        ];
    else :
        $response = [
            'status' => 201,
            'message' => 'Leider keine Inhalte gefunden. Bitte wenden Sie sich an unseren Support.'
        ];
    endif;
    $response['content'] = ob_get_clean();
    die(json_encode($response));
}

add_action('wp_ajax_do_perform_budget', 'vb_perform_budget');
add_action('wp_ajax_nopriv_perform_budget', 'vb_perform_budget');