<?php

use OMT\Module\Articles;
use OMT\Module\Characteristics;
use OMT\Module\FacebookShare;
use OMT\Module\MagazineTeaser;
use OMT\Module\Profile;
use OMT\Module\Reviews;
use OMT\Module\TeamMember;
use OMT\Module\Tools;
use OMT\Module\Webinars;
use OMT\Module\WebinarsTeaser;

switch ($zeile['inhaltstyp'][0]['acf_fc_layout']) {
    case "header_hero_modul":
        include ('module-header-hero-modul.php');
        break;
    case "hero_modul":
        include('module-hero-modul.php');
        break;
    case "hero_slider":
        include('module-hero-slider.php');
        break;

    case "inhaltseditor":
        include('module-inhaltseditor.php');
        break;

    case "inhaltsverzeichnis_anzeigen":
        include ( 'module-inhaltsverzeichnis.php');
        break;

    case "toolindex":
        //if (USE_JSON_POSTS_SYNC) {
            include ('module-toolindex.php');
       // } else {
       //     echo (new Tools($zeile['inhaltstyp'][0]))->render();
       // }

        break;

    case "kapitelmodul":
        include ( 'module-kapitelmodul.php');
        break;

    case "jquery_skript":
        include ( 'module-jquery-skript.php');
        break;

    case "inhaltseditor_3er":
        include ( 'module-inhaltseditor-3er.php');
        break;

    case "inhaltseditor_2er":
        include ( 'module-inhaltseditor-2er.php');
        break;

    case "accordion":
        include('module-accordion.php');
        break;

    case "headline":
        include('module-headline.php');
        break;

    case "tabs":
        include('module-tabs.php');
        break;

    case "call_to_action":
        include('module-call-to-action.php');
        break;

    case "galerie":
        include('module-galerie.php');
        break;

    case "slider":
        include('module-slider.php');
        break;

    case "teaser_modul":
        include('module-teaser-modul.php');
        break;

    case "clubtreffen_anzeigen":
        include('module-clubtreffen-anzeigen.php');
        break;

    case "buchempfehlungen":
        include('module-buchempfehlungen.php');
        break;

    case "teaser_modul_highlight":
        include('module-teaser-modul-highlight.php');
        break;

    case "testimonial":
        include('module-testimonial.php');
        break;

    case "content_cta":
        include('module-content-cta.php');
        break;

    case "paragraph_image":
        include('module-paragraph-image.php');
        break;

    case "teaser_highlight":
        include('module-teaser-highlight.php');
        break;

    case "banner_bg":
        include('module-banner-bg.php');
        break;

    case "tabelle":
        include('module-tabelle.php');
        break;

    case "timetable":
        include('module-timetable.php');
        break;

    case "kontaktformular":
        include('module-kontaktformular.php');
        break;

    case "blog_grid":
        include('module-blog-grid.php');
        break;

    case "google_map":
        include ('module-google-map.php');
        break;

    case "video":
        include('module-video.php');
        break;

    case "video_wistia":
        include('module-video-wistia.php');
        break;

    case "webinare_anzeigen":
        if (defined('USE_JSON_POSTS_SYNC') && USE_JSON_POSTS_SYNC) {
            include('module-webinare-anzeigen.php');
        } else {
            echo (new Webinars($zeile['inhaltstyp'][0]))->render();
        }

        break;

    case "webinare_anzeigen_json":
        if (defined('USE_JSON_POSTS_SYNC') && USE_JSON_POSTS_SYNC) {
            include('module-webinare-anzeigen.php');
        } else {
            echo (new Webinars($zeile['inhaltstyp'][0]))->render();
        }
        
        break;

    case "podcasts_anzeigen":
        include('module-podcasts-anzeigen.php');
        break;

    case "podcasts_anzeigen_json":
        include('module-podcasts-anzeigen.php');
        break;

    case "podcast_abonnieren":
        include('module-podcast-abonnieren.php');
        break;

    case "vortrage_anzeigen":
        include('module-vortrage-anzeigen.php');
        break;

    case "seminare_anzeigen":
        include('module-seminare-anzeigen.php');
        break;

    case "seminare_anzeigen_json":
        include('module-seminare-anzeigen.php');
        break;

    case "seminartypen_anzeigen":
        include('module-seminartypen-anzeigen.php');
        break;

    case "lexikon_anzeigen":
        include('module-lexikon-anzeigen.php');
        break;

    case "artikel_anzeigen":
        if (USE_JSON_POSTS_SYNC) {
            include('module-artikel-anzeigen.php');
        } else {
            echo (new Articles($zeile['inhaltstyp'][0]))->render();
        }

        break;

    case "artikel_anzeigen_json":
        if (USE_JSON_POSTS_SYNC) {
            include('module-artikel-anzeigen.php');
        } else {
            echo (new Articles($zeile['inhaltstyp'][0]))->render();
        }

        break;

    case "featured_artikel":
        include('module-artikel-featured.php');
        break;

    case "artikel_auswahlen":
        include('module-artikel-auswahlen.php');
        break;

    case "jobs_anzeigen":
        include('module-jobs-anzeigen.php');
        break;

    case "omt_jobs_anzeigen":
        include('module-jobs-omt-anzeigen.php');
        break;

    case "trends_anzeigen":
        include('module-trends-anzeigen.php');
        break;

    case "tools_anzeigen":
        include('module-tools-anzeigen.php');
        break;


    case "umfrage_anzeigen":
        include('module-umfrage.php');
        break;

    case "vip_produkt":
        include('module-vip-produkt.php');
        break;

    case "vergleichstabelle_tools":
        include('module-vergleichstabelle-tools.php');
        break;

    case "vergleichstabelle_tools_cpt":
        include( get_template_directory() . '/library/modules/module-tooltabelle.php');
        break;

    case "tooltests_anzeigen":
        include ('module-tooltests-anzeigen.php');
        break;

    case "branchenbuch_agentursuche":
        include('module-branchenbuch-agentursuche.php');
        break;

    case "branchenbuch_premium":
        include('module-branchenbuch-premium.php');
        break;

    case "branchenbuch_liste":
        include('module-branchenbuch-liste.php');
        break;

    case "webinar_zusammenfassungen":
        include('module-webinar-zusammenfassungen.php');
        break;

    case "webinare_teaser_wiederholungsfeld":
        include ("module-webinare-teaser-wiederholungsfeld.php");
        break;

    case "expertenstimmen":
        include('module-expertenstimmen.php');
        break;

    case "konferenzticket":
        include('module-konferenzticket.php');
        break;
        
    case "three_column_layout":
        include('module-three-column-layout.php');
        break;

    case "vertical_tabs":
        include('module-vertical-tabs.php');
        break;
    
    case "partner_full_width":
        include('module-partner-full-width.php');
        break;
        
    case "autojobs":
        include('module-autopublishing-jobs.php');
        break;

    case "highlighted-jobs":
        include('module-highlighted-jobs.php');
        break;
        
    case "partner":
        include('module-partner.php');
        break;

    case "countdown":
        include('module-countdown.php');
        break;

    case "speakerprofil":
        include ('module-speakerprofil.php');
        break;

    case "alle_speaker_anzeigen":
        include('module-alle-speaker-anzeigen.php');
        break;

    case "alle_botschafter_anzeigen":
        include('module-alle-botschafter-anzeigen.php');
        break;

    case "magazin_teaser":
        if (USE_JSON_POSTS_SYNC) {
            include('module-teaser-magazin.php');
        } else {
            echo (new MagazineTeaser($zeile['inhaltstyp'][0]))->render();
        }

        break;

    case "webinare_teaser":
        if (defined('USE_JSON_POSTS_SYNC') && USE_JSON_POSTS_SYNC) {
            include('module-teaser-webinare.php');
        } else {
            echo (new WebinarsTeaser($zeile['inhaltstyp'][0]))->render();
        }
        
        break;

    case "podcast_teaser":
        include('module-teaser-podcast.php');
        break;

    case "podcast_teaser":
        include('module-teaser-podcast.php');
        break;
        
    case "themenwelten_uebersicht":
        include('module-themenwelten.php');
        break;

    case "club_teaser":
        include('module-teaser-club.php');
        break;

    case "suche_teaser":
        include('module-teaser-suche.php');
        break;

    case "tools_teaser_mit_suche":
        include('module-teaser-tools-mit-suche.php');
        break;

    case "tools_teaser_nach_kategorien":
        include('module-teaser-tools-nach-kategorie.php');
        break;

    case "iconlinks":
        include('module-iconlinks.php');
        break;

    case "full-width-promo":
        include('module-full-width-promo.php');
        break;

    case "download-items":
        include('module-download-items.php');
        break;

    case "quicktipps":
        include('module-quicktipps.php');
        break;
    
    case "ebooks":
        include('module-ebooks.php');
        break;

    case "featured_ebooks":
        include('module-featured-ebooks.php');
        break;

    case "team_member":
        echo (new TeamMember($zeile['inhaltstyp'][0]))->render();
        break;

    case "profile":
        echo (new Profile($zeile['inhaltstyp'][0]))->render();
        break;

    case "characteristics":
        echo (new Characteristics($zeile['inhaltstyp'][0]))->render();
        break;

    case "facebook_share":
        echo (new FacebookShare($zeile['inhaltstyp'][0]))->render();
        break;

    case "reviews":
        echo (new Reviews($zeile['inhaltstyp'][0]))->render();
        break;

    case "download_template":
        include('module-newdownloadtemplate.php');
        break;

    /***********************************
    /***********************************
    /*******************AGENTURFINDER MODULE START********************************/
    /***********************************
    /************************************/
    case "introbuttons":
        include('module-introbuttons.php');
        break;

    case "agenturfinder_testimonial_slider":
        include('module-agenturfinder-testimonial-slider.php');
        break;

    case "agenturfinder_logos_anzeigen":
        include('module-agenturfinder-logos-anzeigen.php');
        break;

    case "agenturfinder_wie_es_funktioniert":
        include('module-agenturfinder-wie-es-funktioniert.php');
        break;

    case "agenturfinder_artikel_anzeigen_magazin":
        include('module-agenturfinder-artikel-anzeigen-magazin.php');
        break;

    case "agenturfinder_artikel_anzeigen":
        include('module-agenturfinder-artikel-anzeigen.php');
        break;

    case "agenturfinder_kontakt":
        include('module-agenturfinder-kontakt.php');
        break;

    case "agenturfinder_prozess":
        include('module-agenturfinder-prozess.php');
        break;
    
    case "christmas_uebersicht":
        include('module-christmas.php');
        break;
    /***********************************
    /***********************************
    /*******************AGENTURFINDER MODULE ENDE********************************/
    /***********************************
    /************************************/
} //end of switch case ?>