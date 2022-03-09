<?php
/*
 * Template Name: Toolanbieter Backend
 */

use OMT\Ajax\DeleteToolTrackingLink;
use OMT\Ajax\UpdateToolTrackingLink;

gravity_form_enqueue_scripts(56, true);
get_header();
acf_form_head();
acf_enqueue_uploader();

wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js');
UpdateToolTrackingLink::getInstance()->enqueueScripts();
DeleteToolTrackingLink::getInstance()->enqueueScripts();

/////NOTIZ: DIE RESSOURCEN MÜSSEN DYNAMISCH GECALLED WERDEN DA ES SONST EINEN FEHLER IN ANDEREN TEMPLATES GIBT! ABFRAGE GEHT SCHEINBAR ABER NOCH NICHT RICHTIG
$hero_background = get_field('standardseite', 'options');
?>
    <div id="content" xmlns:background="http://www.w3.org/1999/xhtml">
        <?php if (!is_user_logged_in() ) { ?>
            <div class="omt-row wrap">
                <div class="module module-toolanbieter-login">
                    <div style="margin-top: 120px;" class="partnerform partner-login">
                        <h2>TOOLANBIETER LOGIN</h2>
                        <?php echo do_shortcode('[ultimatemember form_id="4278"]');?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ( is_user_logged_in() ) {
            $current_user_id = get_current_user_id();
            um_fetch_user($current_user_id);
            $display_name = um_user('display_name');
            $user_roles = um_user('roles');
            $updated = $_GET['updated'];
            $toolid = $_GET['toolid'];

            switch ($_GET['area']) {
                case "bearbeiten":
                    $backend = 'toolanbieter-tools-bearbeiten';
                    break;

                case "stammdaten":
                    $backend = "toolanbieter-stammdaten";
                    break;

                case "url-insights":
                    $backend = "toolanbieter-url-insights";
                    break;

                case "statistik":
                    $backend = "toolanbieter-statistik";
                    break;

                default:
                    $backend = 'toolanbieter-dashboard';
                    break;
            }

            if ($user_roles == "um_toolanbieter" || $user_roles == "administrator" || $user_roles == "um_admin" || in_array('um_toolanbieter', $user_roles) || in_array('um_admin', $user_roles) || in_array('administrator', $user_roles)) {
                $zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);
            }
            ?>
            <div class="header-toolanbieter-backend">
                <div class="header-themenwelt-inner">
                    <h3 class="header-themenwelt-title sticky-title">Toolanbieter-Backend</h3>
                    <?php
                    $themenwelt_autor = get_field('themenwelt_autor');
                    $autor_id = $themenwelt_autor->ID;
                    $themenwelt_titel_in_buttons = get_field('themenwelt_titel_in_buttons');
                    if (strlen($themenwelt_titel_in_buttons)<1) { $themenwelt_titel_in_buttons = "..."; } ?>
                    <p class="title-span header-themenwelt-autor">von
                        <span class="seminar-speakers"><?php print $display_name;?></span>
                    </p>
                    <div class="sticky-buttons toolanbieter-backend-navigation">
                        <a href="#" class="backend-nav-button <?php echo $backend == 'toolanbieter-dashboard' ? 'active' : '' ?>" data-backend="toolanbieter-dashboard">Dashboard</a>
                        <a href="#" class="backend-nav-button nav-tools <?php echo $backend == 'toolanbieter-tools-bearbeiten' ? 'active' : '' ?>" data-backend="toolanbieter-tools-bearbeiten">Tools bearbeiten</a>
                        <a href="#" class="backend-nav-button" data-backend="toolanbieter-bids">Budgets/Gebote</a>
                        <a href="#" class="backend-nav-button" data-backend="links">Links</a>
                        <a href="#" class="backend-nav-button" data-backend="toolanbieter-statistik">Statistik</a>
                        <a href="#" class="backend-nav-button <?php echo $backend == 'toolanbieter-url-insights' ? 'active' : '' ?>" data-backend="toolanbieter-url-insights">URL Insights</a>
                        <a href="#" class="backend-nav-button nav-stammdaten <?php echo $backend == 'toolanbieter-stammdaten' ? 'active' : '' ?>" data-backend="toolanbieter-stammdaten">Stammdaten</a>
                        <span data-effect="lightbox" data-id="form-56" href="#" data-backend="toolanbieter-support" class="activate-form">Support</span>
                        <div id="form-56" class="contact-lightbox hidden">
                            <?php echo do_shortcode( '[gravityform ajax=true id="56" title="true" description="true" tabindex="0"]' ); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="omt-row wrap toolanbieter-backend">
                <div class="module module-backend-area">
                    <h2 id="toolarea-headline">
                        <?php 
                            switch ($backend) {
                                case "toolanbieter-tools-bearbeiten":
                                    echo "Deine Tools";
                                    break;
                
                                case "toolanbieter-stammdaten":
                                    echo "Deine Stammdaten";
                                    break;
                
                                case "toolanbieter-url-insights":
                                    echo "Deine URL Insights";
                                    break;
                
                                case "toolanbieter-statistik":
                                    echo "Deine Statistiken";
                                    break;
                
                                default:
                                    echo "Dein Dashboard";
                                    break;
                            }
                        ?>
                    </h2>

                    <div class="toolanbieter-subnav-wrap">
                        <div class="backend-area-subnav">
                            <?php include get_template_directory() . "/library/tools/toolanbieter/toolanbieter-subnav.php"; ?>
                        </div>
                    </div>

                    <div class="toolanbieter-main-content-wrap fullwidth">
                        <?php include get_template_directory() . "/library/tools/toolanbieter/toolanbieter-main-content.php"; ?>
                    </div>
                </div>
                <div class="status toolindex-ajax-status"></div>
            </div>
        <?php } ?>
    </div>
<?php get_footer(); ?>