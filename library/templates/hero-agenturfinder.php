<?php
/***************************
* AGENTURFINDER HEADER MIT SUCHE
***************************/
$agenturfinder_hero_background = get_field('suchschlitz_hintergrundbild', 'options');
$suchschlitz_headline = get_field('suchschlitz_headline', 'options');
$suchschlitz_text_oben = get_field('suchschlitz_text_oben', 'options');
$suchschlitz_platzhaltertext = get_field('suchschlitz_platzhaltertext', 'options');
$suchschlitz_text_unten = get_field('suchschlitz_text_unten', 'options');
$suchschlitz_text_button = get_field('suchschlitz_text_button', 'options');

$agenturfinder_hero_background_local = "";
$suchschlitz_headline_local = "";
$suchschlitz_text_oben_local = "";
$suchschlitz_platzhaltertext_local = "";
$suchschlitz_text_unten_local = "";
$suchschlitz_text_button_local = "";

$hero_post_type = get_post_type();
if ("agenturen" != $hero_post_type) {
    $agenturfinder_hero_background_local = get_field('suchschlitz_hintergrundbild');
    $suchschlitz_headline_local = get_field('suchschlitz_headline');
    $suchschlitz_text_oben_local = get_field('suchschlitz_text_oben');
    $suchschlitz_platzhaltertext_local = get_field('suchschlitz_platzhaltertext');
    $suchschlitz_text_unten_local = get_field('suchschlitz_text_unten');
    $suchschlitz_text_button_local = get_field('suchschlitz_text_button');
if (strlen($agenturfinder_hero_background_local['url'])>0) { $agenturfinder_hero_background = $agenturfinder_hero_background_local;}
if (strlen($suchschlitz_headline_local)>0) { $suchschlitz_headline = $suchschlitz_headline_local;}
if (strlen($suchschlitz_text_oben_local)>0) { $suchschlitz_text_oben = $suchschlitz_text_oben_local;}
if (strlen($suchschlitz_platzhaltertext_local)>0) { $suchschlitz_platzhaltertext = $suchschlitz_platzhaltertext_local;}
if (strlen($suchschlitz_text_unten_local)>0) { $suchschlitz_text_unten = $suchschlitz_text_unten_local;}
if (strlen($suchschlitz_text_button_local)>0) { $suchschlitz_text_button = $suchschlitz_text_button_local;}
}
?>
<div class="omt-row search-header" style="background: url('<?php print $agenturfinder_hero_background['url'];?>') no-repeat 50% 0;">
    <div class="wrap">
        <p class="agenturfinder-headline h3"><?php print $suchschlitz_headline;?></p>
        <p class="agenturfinder-subheading"><?php print $suchschlitz_text_oben;?></p>
        <div class="agenturfinder-search contact-modal">
                <?php /*<input type="text" value="" name="s" id="s" placeholder="<?php print $suchschlitz_platzhaltertext;?>" />*/?>
            <select name="s" class="agenturfinder-dropdown">
                <option selected disabled><?php print $suchschlitz_platzhaltertext;?></option>
                <option value="affiliate-marketing">Affiliate Marketing</option>
                <option value="amazon-marketing">Amazon Marketing</option>
                <option value="amazon-seo">Amazon SEO</option>
                <option value="contenterstellung">Contenterstellung</option>
                <option value="content-marketing">Content Marketing</option>
                <option value="cro">Conversion Optimierung (CRO)</option>
                <option value="direktmarketing">Direktmarketing</option>
                <option value="e-mail-marketing">E-Mail-Marketing</option>
                <option value="facebook-ads">Facebook Ads</option>
                <option value="google-analytics">Google Analytics</option>
                <option value="google-ads">Google Ads</option>
                <option value="gmb">Google My Business</option>
                <option value="growthhacking">Growth Hacking</option>
                <option value="inbound">Inbound Marketing</option>
                <option value="linkbuilding">Linkbuilding</option>
                <option value="local-seo">Local SEO</option>
                <option value="marketing">Marketing</option>
                <option value="online-marketing">Online Marketing</option>
                <option value="performance-marketing">Performance Marketing</option>
                <option value="pinterest-marketing">Pinterest Marketing</option>
                <option value="public-relations">Public Relations (PR)</option>
                <option value="social-media">Social Media</option>
                <option value="sem">Suchmaschinenmarketing (SEM)</option>
                <option value="seo">Suchmaschinenoptimierung (SEO)</option>
                <option value="tiktok">TikTok Marketing</option>
                <option value="videoerstellung">Videoerstellung / -produktion</option>
                <option value="webanalyse">Webanalyse (Google Analytics / Tag Manager)</option>
                <option value="webdesign">Webdesign</option>
                <option value="website-entwicklung">Website Entwicklung</option>
                <option value="website-relaunch">Website Relaunch</option>
            </select>
                <a href="#kontakt-header" class="agentursuche-button"><?php print $suchschlitz_text_button;?></a>
        </div>
        <?php if (strlen($suchschlitz_text_unten)>0) { ?><p class="agenturfinder-subtext"><?php print $suchschlitz_text_unten;?></p><?php } ?>
    </div>
</div>
<div id="kontakt-header" class="mfp-hide" data-effect="mfp-zoom-out">
    <?php //echo do_shortcode( '[contact-form-7 id="128" title="Kontaktformular 1"]' ); ?>
    <?php echo do_shortcode( '[gravityform id="35" title="true" description="true" tabindex="0" ajax=true ]' ); ?>
</div>