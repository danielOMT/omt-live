<?php/*
Template Name: JSON Testpage
//https://coderwall.com/p/mekopw/jsonc-compress-your-json-data-up-to-80
http://my.clickmeter.com/api-key
Base Url: http://apiv2.clickmeter.com
API KEY F99B2AC7-7A44-40FD-AFCE-B4E26F1ED67B
Throttle Factor: 10 requests/sec
//Toolbox: http://api.v2.clickmeter.com.s3-website-us-east-1.amazonaws.com/?apiKey=F99B2AC7-7A44-40FD-AFCE-B4E26F1ED67B
//how to create(!) a Tracking link automatically: https://support.clickmeter.com/hc/en-us/articles/211036826-How-to-create-a-tracking-link
*/
?>
<?php get_header();
//https://github.com/wp-plugins/clickmeter-link-shortener-and-analytics/blob/6534067778d82773827e3c3bcd7b317c82d1b96f/clickmeter.php
?>
<?php //api@clickmeter.com
$hero_background = get_field('standardseite', 'options');
?>
    <div id="content" class="<?php print "";?>" xmlns:background="http://www.w3.org/1999/xhtml">
        <div id="inner-content" class="wrap">
            <div class="omt-row hero-header" style="background: url('<?php print $hero_background['url'];?>') no-repeat 50% 0;">
                <div class="wrap">
                    <h1><?php print get_the_title();?></h1>
                </div>
            </div>
            <div class="omt-row">
                <?php
                require_once('library/tools/cronjobs/run-cronjob-toolfunctions.php');
                require_once('library/tools/tools-functions.php');
                run_cronjob_toolfunctions();
                ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>