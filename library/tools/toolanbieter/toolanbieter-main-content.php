<div class="backend-area-content">
    <?php
        if ($updated == true && $backend == "toolanbieter-tools-bearbeiten") {
            require_once (get_template_directory() . '/library/ajax/ajax-toolanbieter/function-toolform.php');
            edit_tool($toolid);
        } elseif ($updated == true && $backend == "toolanbieter-stammdaten")  {
            include(get_template_directory() . '/library/ajax/ajax-toolanbieter/toolanbieter-stammdaten.php');
        } elseif ($updated == true && $backend == "toolanbieter-url-insights")  {
            include(get_template_directory() . '/library/ajax/ajax-toolanbieter/toolanbieter-url-insights.php');
        } elseif ($updated == true && $backend == "toolanbieter-statistik")  {
            include(get_template_directory() . '/library/ajax/ajax-toolanbieter/toolanbieter-statistik.php');
        } else {
            include(get_template_directory() . '/library/ajax/ajax-toolanbieter/toolanbieter-dashboard.php');
        }
    ?>
</div>