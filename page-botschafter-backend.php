<?php/*
Template Name: Botschafter Backend
*/
?>
<?php get_header();
?>
    <div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
        <?php if (!is_user_logged_in() ) { ?>
            <div class="omt-row wrap">
                <div class="module module-toolanbieter-login">
                    <div style="margin-top: 120px;" class="partnerform partner-login">
                        <h2>OMT-Botschafter LOGIN</h2>
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
            $area = $_GET['area'];
            $tooldashboardclass = "active";
            if ($user_roles == "um_botschafter" || $user_roles == "administrator" || $user_roles == "um_admin" || in_array('um_botschafter', $user_roles) || in_array('um_admin', $user_roles) || in_array('administrator', $user_roles)) {
                ?>
                <div class="header-toolanbieter-backend">
                    <div class="header-themenwelt-inner">
                        <h3 class="header-themenwelt-title sticky-title">Botschafter-Backend</h3>
                        <?php
                        $themenwelt_autor = get_field('themenwelt_autor');
                        $autor_id = $themenwelt_autor->ID;
                        $themenwelt_titel_in_buttons = get_field('themenwelt_titel_in_buttons');
                        if (strlen($themenwelt_titel_in_buttons)<1) { $themenwelt_titel_in_buttons = "..."; } ?>
                        <p class="title-span header-themenwelt-autor">von
                            <span class="seminar-speakers"><?php print $display_name;?></span>
                        </p>
                        <div class="sticky-buttons botschafter-backend-navigation">
                            <a class="botschafter-nav-button <?php print $tooldashboardclass;?>" href="#" data-backend="botschafter-dashboard">Dashboard</a>
                            <a class="botschafter-nav-button" href="#" data-backend="botschafter-marketing">Downloads</a>
                            <?php /*<span data-effect="lightbox" data-id="form-56" href="#" data-backend="botschafter-support" class="activate-form">Support</span>
                            <div id="form-56" class="contact-lightbox hidden">
                                <?php echo do_shortcode( '[gravityform ajax=true id="56" title="true" description="true" tabindex="0"]' ); ?>
                            </div>*/?>
                        </div>
                    </div>
                </div>
                <?php  //check if a template with Sidebar will be loaded
                ?>
                <div class="omt-row wrap toolanbieter-backend botschafter-backend">
                    <div class="module module-backend-area wrap">
                        <h2 id="botschafter-headline">Dein Dashboard</h2>

                        <div class="toolanbieter-main-content-wrap fullwidth">
                            <div class="backend-area-content">
                                <?php include(get_template_directory() . '/library/ajax/ajax-botschafter/botschafter-dashboard.php'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="status botschafter-ajax-status"></div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php get_footer(); ?>