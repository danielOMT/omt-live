<?php

use OMT\Model\Datahost\Article;
use OMT\Model\Datahost\Webinar;
use OMT\Services\WebinarsFilter;
use OMT\Services\ArraySort;
use OMT\View\ArticleView;
use OMT\View\WebinarView;

?>
<?php get_header(); ?>

<?php
require_once('library/functions/show-readmore-acf.php');
//require_once ('library/functions/function-seminare.php');
require_once ('library/functions/json-seminare/json-seminare-alle.php');
require_once ('library/functions/json-webinare/json-webinare-zukunft.php');
require_once ('library/functions/json-webinare/json-webinare-vergangenheit.php');
//require_once ('library/functions/function-magazin.php');
require_once ('library/functions/json-magazin/json-magazin-alle.php');
//require_once ('library/functions/function-podcasts.php');
require_once ('library/functions/json-podcasts/json-podcasts-alle.php');

$expertenprofil = get_field('expertenprofil');
$botschafter_story = get_field('botschafter_story');
$botschafter_video = get_field('botschafter_video');
$experte_ID = $expertenprofil->ID;
$titel = get_field('titel', $experte_ID);
$profilbild = get_field('profilbild', $experte_ID);
$firma = get_field('firma', $experte_ID);
$speaker_galerie = get_field('speaker_galerie', $experte_ID);
$beschreibung = get_field('beschreibung', $experte_ID);
$social_media = get_field('social_media', $experte_ID);
$interview = get_field('interview', $experte_ID);
$speaker_name = get_the_title();
$speaker_id = $experte_ID;
$header_hero_hintergrundbild = get_field('speaker_einzelansicht', 'options');
$header_hero_h1 = get_field('speaker_einzelansicht_text', 'options');
if (strlen($header_hero_hintergrundbild['url'])>0) { $hero_background = $header_hero_hintergrundbild;}
if (strlen($header_hero_h1)>0) { $h1 = $header_hero_h1;} else { $h1 = get_the_title(); }

if (!defined('USE_JSON_POSTS_SYNC') || USE_JSON_POSTS_SYNC === false) {
    $expertWebinars = Webinar::init()->activeItems(['expert' => $speaker_id], ['with' => 'experts']);
    $expertArticles = Article::init()->activeItems(['expert' => $speaker_id], [
        'order' => 'post_date',
        'order_dir' => 'DESC',
        'with' => ['experts']
    ]);

    $expertUpcomingWebinars = ArraySort::byDateAsc(WebinarsFilter::upcoming($expertWebinars));
    $expertPastWebinars = ArraySort::byDateDesc(WebinarsFilter::past($expertWebinars));
}
?>
    <div class="socials-floatbar-left">
        <?php print do_shortcode('[shariff headline="<p>Expertenprofil teilen:</p>" borderradius="1" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="vertical"]');?>
    </div>
    <div id="content">
    <div class="omt-row hero-header header-flat" style="background: url('<?php print $hero_background['url'];?>') no-repeat 50% 0;">
        <div class="wrap">
            <h1><?php print $speaker_name;?> - OMT-Botschafter</h1>
        </div>
    </div>
    <div id="main" class="clearfix omt-speaker speaker-<?php print str_replace(' ', '-', $speaker_name);?> speaker-id-<?php print $speaker_id;?>" role="main">
        <div id="inner-content" class="wrap clearfix speaker-information <?php print str_replace(' ', '-', $speaker_name);?>"> <?php ///***SPEAKER BESCHREIBUNG***///?>
            <div class="omt-intro speaker-info botschafter-info">
                <?php /*<h2 class="speaker-titel"><?php print $titel;?></h2>*/?>
                <img class="speaker-profilbild" alt="<?php print $profilbild['alt'];?>" title="<?php print $profilbild['alt'];?>" src="<?php print $profilbild['sizes']['730-380'];?>"/>
                <div class="ribbon"><span>OMT-Botschafter</span></div>
                <div class="social-media">
                    <?php if (is_array($social_media)) {
                        foreach ($social_media as $social) { ?>
                            <?php $icon = "fa fa-home";?>
                            <?php if (strpos($social['link'], "facebook")>0) { $icon = "fa fa-facebook"; } ?>
                            <?php if (strpos($social['link'], "xing")>0) { $icon = "fa fa-xing"; } ?>
                            <?php if (strpos($social['link'], "linkedin")>0) { $icon = "fa fa-linkedin"; } ?>
                            <?php if (strpos($social['link'], "twitter")>0) { $icon = "fa fa-twitter"; } ?>
                            <?php if (strpos($social['link'], "instagram")>0) { $icon = "fa fa-instagram"; } ?>
                            <?php if (strpos($social['link'], "google")>0) { $icon = "fa fa-google-plus-g"; } ?>
                            <a target="_blank" class="social-icon" href="<?php print trim($social['link']) ?>"><i class="<?php print $icon;?>"></i></a>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?php $autor_id = get_the_ID();
                $args = array( //next
                    'posts_per_page'    => -1,
                    'post_type'         => "agenturen",
                    'posts_status'    => "publish",
                    'order'				=> 'DESC',
                    'orderby'			=> 'date',
                );
                $loop = new WP_Query( $args );
                $agentur_id = 0;
                while ( $loop->have_posts() ) : $loop->the_post();
                    $agentur_mitarbeiter = get_field('agentur_mitarbeiter');
                    if (is_array($agentur_mitarbeiter)) {
                        foreach ($agentur_mitarbeiter as $speaker) {
                            $agentur_speaker_id = $speaker->ID;
                            if ($autor_id == $agentur_speaker_id) {
                                $agentur_id = get_the_ID();
                            }
                        }
                    }
                endwhile; //end
                wp_reset_postdata();?>
                <div class="experte-agentur has-margin-bottom-30">
                    <?php if($agentur_id != 0 ) { ?>
                        <a class="button button-red centered button-730px" href="<?php print get_the_permalink($agentur_id);?>" target="_blank">
                            <?php print "Agentur: " . get_the_title($agentur_id);?>
                        </a>
                    <?php } ?>
                </div>
                <?php print $beschreibung;?>
                <?php if (strlen($speaker_galerie[0]['url'])>=1) { ?>
                    <div class="<?php if (count ($speaker_galerie) >=4) { print "center-galerie"; } else { print "center-galerie-noslide"; } ?>">
                        <?php foreach ($speaker_galerie as $image) { ?>
                            <img class="center-galerie-image" alt="<?php print $image['alt'];?>" src="<?php print $image['sizes']['350-180'];?>"/>
                        <?php } ?>
                    </div>
                <?php } //end of speaker galerie?>
            </div> <?php ///****END OF speaker BESCHFREIBUNG***//?>
            <h2 style="max-width:730px;margin-left: auto;margin-right: auto;display: block;">OMT-Story</h2>
            <?php
            if (strlen($botschafter_video) > 0) { ?>
                <div class="video_wrap">
                    <div class="webinar-video">
                        <div class="video-wrap">
                            <script src="//fast.wistia.com/embed/medias/<?php print $botschafter_video;?>.jsonp" async></script>
                            <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                            <div class="wistia_responsive_padding">
                                <div class="wistia_responsive_wrapper">
                                    <div class="wistia_embed wistia_async_<?php print $botschafter_video;?>">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            print $botschafter_story;
            ?>
            <?php //Botschafter Story ?>

            <?php //END OF Botschafter Story ?>

            <?php
            $seminar_counter = display_seminare_json (3, NULL, $speaker_id, 'small', true );

            if ($seminar_counter>0) {
                ?>
                <div class="omt-row">
                    <div class="omt-row color-area-grau">
                        <div class="color-area-inner"></div>
                        <h4>Die nächsten Seminare von <?php print get_the_title();?></h4>
                        <div class="seminare-wrap teaser-modul speaker-seminare">
                            <?php display_seminare_json (3, NULL, $speaker_id, 'small', false );?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php /////////////////////////// Upcoming Webinars GO HERE //////////////////////////?>
            <?php if (!defined('USE_JSON_POSTS_SYNC') || USE_JSON_POSTS_SYNC === false) : ?>
                <?php if (count($expertUpcomingWebinars)) : ?>
                    <div class="omt-row">
                        <h4>Die nächsten Webinare von <?php print get_the_title();?></h4>

                        <div class="webinare-wrap teaser-modul speaker-webinare">
                            <?php echo WebinarView::loadTemplate('items', ['webinars' => $expertUpcomingWebinars, 'highlightFirst' => true]) ?>
                        </div>
                    </div>
                <?php endif ?>
            <?php else : ?>
                <?php if (display_webinare_json_zukunft(3, 'ASC', NULL, $speaker_id, false, true, "") > 0) { ?>
                    <div class="omt-row">
                        <h4>Die nächsten Webinare von <?php print get_the_title();?></h4>

                        <div class="webinare-wrap teaser-modul speaker-webinare">
                            <?php display_webinare_json_zukunft(999, 'ASC', NULL, $speaker_id, true, false, "");?>
                        </div>
                    </div>
                <?php } ?>
            <?php endif ?>

            <?php /////////////////////////// WEBINARE FROM THE PAST GO HERE //////////////////////////?>
            <?php if (!defined('USE_JSON_POSTS_SYNC') || USE_JSON_POSTS_SYNC === false) : ?>
                <?php if (count($expertPastWebinars)) : ?>
                    <div class="omt-row">
                        <h4>Vergangene Webinare von <?php print get_the_title();?></h4>

                        <div class="webinare-wrap teaser-modul speaker-webinare">
                            <?php echo WebinarView::loadTemplate('items', ['webinars' => $expertPastWebinars, 'highlightFirst' => true]) ?>
                        </div>
                    </div>
                <?php endif ?>
            <?php else : ?>
                <?php if (display_webinare_json_vergangenheit(999, 'DESC', NULL, $speaker_id, false, true) > 0) { ?>
                    <div class="omt-row">
                        <h4>Vergangene Webinare von <?php print get_the_title();?></h4>

                        <div class="webinare-wrap teaser-modul speaker-webinare">
                            <?php display_webinare_json_vergangenheit(999, 'DESC', NULL, $speaker_id, true);?>
                        </div>
                    </div>
                <?php } ?>
            <?php endif ?>

            <?php ///////////////////////////PODINARE GO HERE//////////////////////////?>
            <?php $podcast_counter = display_podcasts_json(999, NULL, $speaker_id,true, NULL);
            if ($podcast_counter >0 ) { ?>
                <div class="omt-row">
                    <h4>Podcasts von <?php print get_the_title();?></h4>
                    <div class="webinare-wrap podinare-wrap teaser-modul speaker-webinare">
                        <?php display_podcasts_json(999, NULL, $speaker_id,false, NULL);?>
                    </div>
                </div>
            <?php } ?>

            <?php ///////////////////////////MAGAZIN ARTIKEL FROM SPEAKER GO HERE////////////////////////// ?>
            <?php if (USE_JSON_POSTS_SYNC) : ?>
                <?php if (display_magazinartikel_json(999, "alle", $speaker_id, true, 1, 'teaser-small') > 0) : ?>
                    <div class="omt-row">
                        <h4>Artikel von <?php print get_the_title();?></h4>
                        <div class="webinare-wrap teaser-modul speaker-webinare">
                            <?php display_magazinartikel_json(999, "alle", $speaker_id, false, 1, 'teaser-small') ?>
                        </div>
                        <?php /* <a class="button button-grey button-730px centered" href="/magazin/" title="zum OMT Magazin">zum OMT Magazin</a>*/?>
                    </div>
                <?php endif ?>
            <?php else : ?>
                <?php if (count($expertArticles)) : ?>
                    <div class="omt-row">
                        <h4>Artikel von <?php echo get_the_title() ?></h4>

                        <div class="webinare-wrap teaser-modul speaker-webinare">
                            <?php echo ArticleView::loadTemplate('items', [
                                'articles' => $expertArticles,
                                'format' => 'teaser-small',
                                'highlightFirst' => true
                            ]); ?>
                        </div>
                    </div>
                <?php endif ?> 
            <?php endif ?>

            <?php ///////////////////////////Schräge / Grauer Hintergrund//////////////////////////?>
            <?php if (strlen($interview[0]) >=1) { ?>
                <div class="omt-row speaker-interview-wrap">
                <h3 class="speaker-interview-headline">Interviews mit <?php print $speaker_name;?></h3>
                <hr>
                <?php foreach ($interview as $interview_id) {

                    $interview_titel = str_replace("Privat: ", "",get_the_title($interview_id));
                    $interview_link = get_the_permalink($interview_id);
                    $interview_content = get_post_field('post_content', $interview_id);
                    $interview_content = apply_filters('the_content', $interview_content);
                    ?>
                    <div class="interview">
                        <p class="speaker-interview"><?php print $interview_titel;?></p>
                        <div class=""><?php print $interview_content;?></div>
                    </div>
                    <hr>
                <?php } ?>
                </div><?php //**end of interviews **//?>
            <?php } ?>

            <?php //vorträge?>
            <div id="inner-content" class="wrap clearfix speaker-information omt-abschnitt">
                <div class="omt-row speaker-vortrag-wrap">
                    <?php
                    $args = array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'vortrag'
                    );
                    $loop = new WP_Query( $args ); //*args and query all "seminare" posts, then go into the repeater field within each seminar item
                    $vortracount = 0;
                    while ( $loop->have_posts() ) : $loop->the_post();
                        $vortrag_speaker = get_field('speaker');
                        $vortrag_speaker_ID = $vortrag_speaker[0]->ID;
                        if (is_array($vortrag_speaker)) {
                            foreach ($vortrag_speaker as $speaker) {
                                if ($speaker->ID == $speaker_id) {
                                    $vortrag_speaker_ID = $speaker_id;
                                }
                            }
                        }
                        $vortrag_titel = get_the_title();
                        $logo = get_field("veranstaltung");
                        if (strlen ($logo['url'])<1) { $logo = $profilbild; }
                        $vortrag_ID = get_the_ID();
                        $vimeo_link = get_field('vortrag_vimeo_link', $vortrag_ID);
                        $vortrag_link = get_the_permalink();
                        $target = "_self";
                        if (strlen($vimeo_link)>0) {
                            $vortrag_link = $vimeo_link;
                            $target="_blank";
                        }
                        if ($vortrag_speaker_ID == $speaker_id ) {
                            $vortracount++;
                            if ($vortracount == 1) { ?>
                                <div style="width:100%;"><h2 class="speaker-seminare-headline">Vorträge von <?php print $speaker_name;?></h2></div>
                            <?php } ?>
                            <div class="testimonial card clearfix expertenstimme">
                                <div class="testimonial-img">
                                    <img class="teaser-img" alt="<?php print $logo['alt'];?>" title="<?php print $logo['alt'];?>" src="<?php print $logo['sizes']['350-180'];?>"/>
                                </div>
                                <div class="testimonial-text">
                                    <h3 class="experte tool"><?php print $vortrag_titel;?></h3>
                                    <a class="button no-clear" target="<?php print $target;?>" href="<?php print $vortrag_link;?>">Zum Vortrag</a>
                                </div>
                            </div>
                        <?php }
                    endwhile; //*****now we have array full with all seminar entries including all repeater field dates
                    wp_reset_postdata(); ?>
                </div>
            </div> <?php //**end of vorträge**// ?>


            <?php /****trends new*****************/
            $args = array(
                'posts_per_page'    => -1,
                'post_type'         => 'trend'
            );
            $loop = new WP_Query( $args ); //*args and query all "seminare" posts, then go into the repeater field within each seminar item
            $trendcount = 0;
            while ( $loop->have_posts() ) : $loop->the_post();
            $experte = get_field('experte');
            $experte_ID = $experte->ID;
            $trend_titel = get_the_title();
            $trend_ID = get_the_ID();
            $trend_year = get_field('jahr_der_trendeinschatzung');
            $trendeinschatzung_des_experten = get_field('trendeinschatzung_des_experten');

            if ($experte_ID == $speaker_id ) {
            $trendcount++; ?>
        <?php if (1 == $trendcount) { ?>
            <div id="inner-content" class="wrap clearfix speaker-information omt-abschnitt speaker-trends-abschnitt color-area-grau">
                <div class="color-area-inner"></div>
                <?php } ?>
                <div class="twelvecol first speaker-trends-wrap">
                    <?php if (1 == $trendcount) { ?>
                        <h3 class="speaker-trends-headline">Die Online Marketing Trends von <?php print $speaker_name; ?></h3>
                    <?php }?>
                    <p class="trend-year text-red"><strong><?php print $trend_year;?></strong></p>
                    <p class="speaker-trend"><?php print $trendeinschatzung_des_experten; ?></p>
                </div>
                <?php } ?>
                <?php
                endwhile; //*****now we have array full with all seminar entries including all repeater field dates
                if ($trendcount > 0) { ?></div><?php }
        wp_reset_postdata();
        ///***end of trendeinschätzungen**/ ?>


        </div> <?php //end of main?>
    </div> <?php //end of #content//?>
    <div class="socials-floatbar-mobile">
        <?php echo do_shortcode('[shariff services="facebook|twitter|googleplus|linkedin|xing" backend="on" lang="de" theme="round" borderradius="1" buttonstretch="1"]'); ?>
    </div>
<?php get_footer(); ?>