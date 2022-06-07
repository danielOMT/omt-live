<?php
/***************************
 * OMT HEADER DESIGN 09/2020
 ***************************/

use OMT\Model\Ebook;
use OMT\View\ArticleView;

$hero_background = get_field('standardseite', 'options');
$header_hero_hintergrundbild = get_field('header_hero_hintergrundbild');
$header_hero_h1 = get_field('header_hero_h1');
$countdown_im_header = get_field('countdown_im_header');
$countdown_bg = get_field('countdown_bg');
$countdown_bg_style = '';
if($countdown_bg){
    $countdown_bg_style = 'style="background: url(\''. $countdown_bg['url'].'\') no-repeat 50% 0; background-size:cover;"';
}
$countdown_headline = get_field('countdown_headline');
$countdown_button_text = get_field('countdown_button_text');
$countdown_button_link = get_field('countdown_button_link');
$countdown_zieldatum = get_field('countdown_zieldatum');
$magazin_filter = get_field('magazin_filter');
$ebooks_filter = get_field('ebooks_filter');
$webinare_filter = get_field('webinare_filter');
$sidebar_welche = get_field('sidebar_welche');
$has_sidebar = get_field('has_sidebar');

if (is_array($header_hero_hintergrundbild)) { if (strlen($header_hero_hintergrundbild['url'])>0) { $hero_background = $header_hero_hintergrundbild;} }
if (strlen($header_hero_h1)>0) { $h1 = $header_hero_h1;} else { $h1 = get_the_title(); }
$currentyear = date("Y");
$h1 = str_replace("%%currentyear%%", $currentyear, $h1);

if ($countdown_im_header) {
    $countdown_download_button_url = getPost()->field('countdown_download_button_url');
    $countdown_download_button_label = getPost()->field('countdown_download_button_label');
}
?>
    <div 
        class="omt-row hero-header header-flat <?php if (1 == $countdown_im_header || 1 == $magazin_filter || $ebooks_filter == 1) { print "no-margin-bottom"; } if (getPost()->field('ist_themenwelt', 'bool')) { print "themenwelt-layout"; } ?>" 
        style="background: url('<?php print $hero_background['url'];?>') no-repeat 50% 0;"
    >
        <div class="wrap <?php echo getPost()->field('center_headline', 'bool') ? 'x-text-center' : '' ?>">
            <h1><?php print $h1;?></h1>
            <?php if (true == $has_sidebar AND "jobs" == $sidebar_welche) { ?>
                <a class="activate-form button button-red header-jobs-button" href="#" data-effect="lightbox" data-id="form-24">Jobangebot erstellen!</a>
            <?php }?>
        </div>
    </div>

<?php ////MAGAZIN FILTER ?>
<?php if (1 == $magazin_filter) : ?>
    <?php if (USE_JSON_POSTS_SYNC) : ?>
        <div class="header-omt-filter">
            <div class="header-omt-filter-inner">
                <div class="omt-filter">
                    <select name="s" class="magazin-filter-dropdown omt-filter-dropdown">
                        <option selected disabled>Zu welchen Themen suchst Du Artikel?</option>
                        <option value="affiliate">Affiliate Marketing</option>
                        <option value="amazon">Amazon SEO</option>
                        <option value="amazon_marketing">Amazon Marketing</option>
                        <option value="content">Content Marketing</option>
                        <option value="conversion">Conversion Optimierung</option>
                        <option value="digitalesmarketing">Digitales Marketing</option>
                        <option value="direktmarketing">Direktmarketing</option>
                        <option value="emailmarketing">E-Mail Marketing</option>
                        <option value="e-commerce">E-Commerce</option>
                        <option value="facebook">Facebook Ads</option>
                        <option value="sea">Google Ads</option>
                        <option value="ga">Google Analytics</option>
                        <option value="gmb">Google My Business</option>
                        <option value="growthhack">Growth Hacking</option>
                        <option value="inbound">Inbound Marketing</option>
                        <option value="internetmarketing">Internet Marketing</option>
                        <option value="influencer">Influencer Marketing</option>
                        <option value="links">Linkbuilding</option>
                        <option value="local">Local SEO</option>
                        <option value="marketing">Marketing</option>
                        <option value="onlinemarketing">Online Marketing</option>
                        <option value="performance">Performance Marketing</option>
                        <option value="pinterest">Pinterest Marketing</option>
                        <option value="p_r">Public Relations (PR)</option>
                        <option value="social">Social Media Marketing</option>
                        <option value="seo">Suchmaschinenoptimierung</option>
                        <option value="tiktok-marketing">TikTok-Marketing</option>
                        <option value="videomarketing">Video Marketing</option>
                        <option value="webanalyse">Webanalyse</option>
                        <option value="webdesign">Webdesign</option>
                        <option value="wordpress">Wordpress</option>
                    </select>
                </div>
            </div>
        </div>
    <?php else : ?>
        <?php echo ArticleView::loadTemplate('filter') ?>
    <?php endif ?>
<?php endif ?>
<?php //END OF MAGAZIN FILTER ?>

<?php // Ebooks filter ?>
<?php if ($ebooks_filter == 1) : ?>
    <div class="header-omt-filter">
        <div class="header-omt-filter-inner">
            <div class="omt-filter">
                <select class="ebooks-filter-dropdown omt-filter-dropdown">
                    <option selected disabled>Zu welchen Themen suchst Du eBooks?</option>

                    <?php foreach (Ebook::init()->allCategories() as $ebookCategory) : ?>
                        <option value="<?php echo $ebookCategory->term_id ?>"><?php echo $ebookCategory->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
    </div>
<?php endif ?>

<?php // Webinare filter ?>
<?php if ($webinare_filter == 1) :
    $webinare_categories = get_categories(['taxonomy' => 'kategorie']);
    ?>
    <div class="header-omt-filter">
        <div class="header-omt-filter-inner">
            <div class="omt-filter">
                <select class="webinare-filter-dropdown omt-filter-dropdown">
                    <option selected disabled>Zu welchen Themen suchst Du Webinare?</option>
                    <?php foreach ($webinare_categories as $webinarCategory) : ?>
                        <option value="<?php echo $webinarCategory->term_id ?>"><?php echo $webinarCategory->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if (1 == $countdown_im_header) { ?>
    <div <?php echo $countdown_bg_style?> class="omt-row hero-countdown-wrap">
        <div class="upto768 close-countdown">(X)</div>
        <div class="wrap hero-countdown">
            <div class="countdown-wrap x-flex-1">
                <?php if (strlen($countdown_headline)>0) {?><p class="countdown-headline"><?php print $countdown_headline;?></p><?php } ?>
                <?php if (strlen($countdown_zieldatum)>0) { ?>
                <p class="h3 no-margin-bottom"><span class="show600up">Countdown</span></p>
                <div class="countdown-grid-timer" data-time="<?php print $countdown_zieldatum;?>">
                </div>
                <?php } ?>
                <?php if (strlen($zeile['inhaltstyp'][0]['button_text'])>0) { ?><a class="button button-red" style="min-height:48px !important;" href="<?php print $zeile['inhaltstyp'][0]['button_link'];?>"><?php print $zeile['inhaltstyp'][0]['button_text'];?></a><?php } ?>
            </div>
            <div class="countdown-buttons x-flex">
                <?php if (!empty($countdown_download_button_url) && !empty($countdown_download_button_label)) : ?>
                    <a class="button button-red x-mr-4" href="<?php echo $countdown_download_button_url ?>" target="_blank"><?php echo $countdown_download_button_label ?></a>
                <?php endif ?>
                <?php if (strlen($countdown_button_link)>0) {?>
                    <a class="button button-red" href="<?php print $countdown_button_link;?>"><?php print $countdown_button_text;?></a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
