<?php
/*
 * Template Name: Toolanbieter Admin Backend
 */

use OMT\View\Admin\UserView;

?>
<?php
get_header();
$hero_background = get_field('standardseite', 'options');
?>
    <div id="content" xmlns:background="http://www.w3.org/1999/xhtml">
        <div class="header-toolanbieter-backend header-toolads-admin">
            <div class="header-themenwelt-inner">
                <h3 class="header-themenwelt-title sticky-title">Tool Ads Admin Backend</h3>
                <div class="sticky-buttons tool-ads-backend-navigation">
                    <a href="/toolads/?toolpage=toolanbieter" class="<?php echo (!$_GET['toolpage'] || $_GET['toolpage'] == 'toolanbieter') ? 'active' : '' ?>">Toolanbieter</a>
                    <a href="/toolads/?toolpage=clickpertool" class="<?php echo ($_GET['toolpage'] == 'clickpertool') ? 'active' : '' ?>">Klicks pro Tool</a>
                    <a href="/toolads/?toolpage=clickpercat" class="<?php echo ($_GET['toolpage'] == 'clickpercat') ? 'active' : '' ?>">Klicks pro Kategorie</a>
                    <a href="/toolads/?toolpage=total" class="<?php echo ($_GET['toolpage'] == 'total') ? 'active' : '' ?>">Gesamt</a>
                    <a href="/toolads/?toolpage=current-bids" class="<?php echo ($_GET['toolpage'] == 'current-bids') ? 'active' : '' ?>">Aktuellen Gebote pro Tool</a>
                </div>
            </div>
        </div>
    </div>

    <div class="omt-row wrap toolanbieter-backend toolads-admin">
        <?php
            switch ($_GET['toolpage']) {
                case "clickpertool":
                    include('library/templates/toolads-backend/toolads-clickpertool.php');
                    break;

                case "clickpercat":
                    include('library/templates/toolads-backend/toolads-clickpercat.php');
                    break;

                case "total":
                    include('library/templates/toolads-backend/toolads-total.php');
                    break;

                case "current-bids":
                    include('library/templates/toolads-backend/toolads-current-bids.php');
                    break;

                case "create-user":
                    echo UserView::loadTemplate('create-tool-provider-user');
                    break;

                default:
                    include('library/templates/toolads-backend/toolads-toolanbieter.php');
                    break;
            }
        ?>
    </div>

<?php get_footer(); ?>