<?php
$optionen_hintergrundfarbe          = get_field('kontakt_hintergrundfarbe', 'options');
$optionen_kontaktbild               = get_field('kontaktbild', 'options');
$optionen_name                      = get_field('kontakt_name', 'options');
$optionen_headline                  = get_field('kontakt_headline', 'options');
$optionen_email                     = get_field('kontakt_email', 'options');
$optionen_telefon                   = get_field('kontakt_telefon', 'options');
$optionen_telefon_darstellungstext  = get_field('kontakt_telefon_darstellungstext', 'options');

$hintergrundfarbe = $zeile['inhaltstyp'][0]['hintergrundfarbe'];
$kontaktbild = $zeile['inhaltstyp'][0]['kontaktbild'];
$name = $zeile['inhaltstyp'][0]['name'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$email = $zeile['inhaltstyp'][0]['email'];
$telefon = $zeile['inhaltstyp'][0]['telefon'];
$telefon_darstellungstext = $zeile['inhaltstyp'][0]['telefon_darstellungstext'];

if (strlen($hintergrundfarbe)<1) { $hintergrundfarbe = $optionen_hintergrundfarbe; }
if (strlen($kontaktbild['url'])<1) { $kontaktbild = $optionen_kontaktbild; }
if (strlen($name)<1) { $name = $optionen_name; }
if (strlen($headline)<1) { $headline = $optionen_headline; }
if (strlen($email)<1) { $email = $optionen_email; }
if (strlen($telefon)<1) { $telefon = $optionen_telefon; }
if (strlen($telefon_darstellungstext)<1) { $telefon_darstellungstext = $optionen_telefon_darstellungstext; }


?>
<div class="kontakt-outer background-<?php print $hintergrundfarbe;?>">
    <div class="kontakt-inner wrap">
        <div class="kontakt-left">
            <img class="kontakt-img" src="<?php print $kontaktbild['url'];?>" alt="<?php print $kontaktbild['alt'];?>" title="<?php print $kontaktbild['alt'];?>"/>
        </div>
        <div class="kontakt-right">
            <h3><?php print $headline;?></h3>
            <p><span class="strong"><?php print $name;?></span></p>
            <p><span class="strong">Telefon: </span><a href="tel:+49<?php print $telefon;?>"><?php print $telefon_darstellungstext;?></a></p>
            <p><span class="strong">Email: </span><a href="mailto:<?php print $email;?>"><?php print $email;?></a></p>
        </div>
    </div>
</div>