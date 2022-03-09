<?php
/***************************
* AGENTURFINDER FOOTER
**************************
$kontakt_hintergrundfarbe = get_field('kontakt_hintergrundfarbe', 'options');
$kontaktbild = get_field('kontaktbild', 'options');
$kontakt_name = get_field('kontakt_name', 'options');
$kontakt_headline = get_field('kontakt_headline', 'options');
$kontakt_email = get_field('kontakt_email', 'options');
$kontakt_telefon = get_field('kontakt_telefon', 'options');
$kontakt_telefon_darstellungstext = get_field('kontakt_telefon_darstellungstext', 'options');

$kontakt_hintergrundfarbe_local = get_field('kontakt_hintergrundfarbe');
$kontaktbild_local = get_field('kontaktbild');
$kontakt_name_local = get_field('kontakt_name');
$kontakt_headline_local = get_field('kontakt_headline');
$kontakt_email_local = get_field('kontakt_email');
$kontakt_telefon_local = get_field('kontakt_telefon');
$kontakt_telefon_darstellungstext_local = get_field('kontakt_telefon_darstellungstext');

if (strlen($kontakt_hintergrundfarbe_local['url'])>0) { $kontaktbild = $kontaktbild_local;}
if (strlen($kontakt_hintergrundfarbe_local)>0) { $kontakt_hintergrundfarbe = $kontakt_hintergrundfarbe_local;}
if (strlen($kontakt_name_local)>0) { $kontakt_name = $kontakt_name_local;}
if (strlen($kontakt_headline_local)>0) { $kontakt_headline = $kontakt_headline_local;}
if (strlen($kontakt_email_local)>0) { $kontakt_email = $kontakt_email_local;}
if (strlen($kontakt_telefon_local)>0) { $kontakt_telefon = $kontakt_telefon_local;}
if (strlen($kontakt_telefon_darstellungstext_local)>0) { $kontakt_telefon_darstellungstext = $kontakt_telefon_darstellungstext_local;}

?>
<div class="omt-row ag-kontakt-wrap">
    <div class="agenturfinder-kontakt">
        <div class="kontakt-outer background-<?php print $kontakt_hintergrundfarbe;?>">
            <div class="kontakt-inner wrap">
                <div class="kontakt-left">
                    <img class="kontakt-img" src="<?php print $kontaktbild['sizes']['square-300x300'];?>" alt="<?php print $kontaktbild['alt'];?>" title="<?php print $kontaktbild['alt'];?>"/>
                </div>
                <div class="kontakt-right">
                    <h3><?php print $kontakt_headline;?></h3>
                    <p><span class="strong"><?php print $kontakt_name;?></span></p>
                    <p><span class="strong">Telefon: </span><a href="tel:+49<?php print $kontakt_telefon;?>"><?php print $kontakt_telefon_darstellungstext;?></a></p>
                    <p><span class="strong">Email: </span><a href="mailto:<?php print $kontakt_email;?>"><?php print $kontakt_email;?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>*/