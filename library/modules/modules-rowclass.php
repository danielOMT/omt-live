<?php
switch ($zeile['inhaltstyp'][0]['acf_fc_layout']) {
    case "header_hero_modul":
        $rowclass = "hero-header";
        break;
    case "banner_bg":
        //$farbschema = $zeile['inhaltstyp'][0]['farbschema'];
        //$rowclass = $farbschema;
        $rowclass .= "wrap banner-bg";
        //$color_area = false;
        break;
    case "teaser_highlight":
        $rowclass = "wrap container-small";
        break;
    case "webinare_anzeigen":
        $rowclass = "wrap grid-wrap";
        break;
    case "webinare_anzeigen_json":
        $rowclass = "wrap grid-wrap";
        break;
    case "podcasts_anzeigen":
        $rowclass = "wrap grid-wrap";
        break;
    case "podcasts_anzeigen_json":
        $rowclass = "wrap grid-wrap";
        break;
    case "vortrage_anzeigen":
        $rowclass = "wrap grid-wrap";
        break;
    case "artikel_anzeigen":
        $rowclass = "wrap grid-wrap";
        break;
    case "magazin_teaser":
        $rowclass = "wrap grid-wrap";
        break;
    case "webinare_teaser":
        $rowclass = "wrap grid-wrap";
        break;
    case "podcast_teaser":
        $rowclass = "wrap podcast-teaser-wrap";
        break;
    case "omt_podcast_teaser":
        $rowclass = "wrap podcast-teaser-wrap";
        break;
    case "club_teaser":
        $rowclass = "wrap club-teaser-wrap";
    break;
    case "suche_teaser":
        $rowclass = "wrap suche-teaser-wrap";
    break;
    case "tools_teaser_mit_suche":
        $rowclass = "wrap tools-suche-teaser-wrap";
        break;
    case "tools_teaser_nach_kategorien":
        $rowclass = "wrap tools-kategorien-teaser-wrap";
        break;
    case "themenwelten_uebersicht":
        $rowclass = "wrap grid-wrap";
    break;
    case "artikel_anzeigen_json":
        $rowclass = "wrap grid-wrap";
        break;
    case "lexikon_anzeigen":
        $rowclass = "wrap grid-wrap";
        break;
    case "seminare_anzeigen":
        $rowclass = "wrap grid-wrap";
        break;
    case "seminare_anzeigen_json":
        $rowclass = "wrap grid-wrap";
        break;
    case "seminartypen_anzeigen":
        $rowclass = "wrap grid-wrap";
        break;
    case "artikel_auswahlen":
        $rowclass = "wrap grid-wrap";
        break;
    case "featured_artikel":
        $rowclass = "wrap grid-wrap featured-articles-row";
        break;
    case "buchempfehlungen":
        $rowclass = "wrap grid-wrap";
        break;
    case "jobs_anzeigen":
        $rowclass = "wrap grid-wrap jobs-section";
        break;
    case "clubtreffen_anzeigen":
        $rowclass = "wrap grid-wrap";
        break;
    case "omt_jobs_anzeigen":
        $rowclass = "wrap grid-wrap";
        break;
    case "alle_botschafter_anzeigen":
        $rowclass = "wrap grid-wrap";
        break;
    case "inhaltseditor":
        $rowclass = "wrap inhaltseditor";
        if ($zeile['inhaltstyp'][0]['highlight_text'] != false) { $rowclass .= " text-highlight"; }
        if ($zeile['inhaltstyp'][0]['intro_text'] != false) { $rowclass .= " omt-intro"; }
        break;
    case "kapitelmodul":
        $rowclass = "wrap inhaltseditor row-kapitelmodul";
        break;
    case "webinar_zusammenfassungen":
        $rowclass = "webinar-zusammenfassungen wrap";
        break;
    case "slider":
        $rowclass = "slider-wrap";
        break;
    case "speakerprofil":
        $rowclass = "wrap autor-wrap";
        break;
    case "agenturfinder_kontakt":
        $rowclass="ag-kontakt-wrap";
        break;
    case "agenturfinder_artikel_anzeigen":
        $rowclass = "wrap grid-wrap";
        break;
    case "agenturfinder_artikel_anzeigen_json":
        $rowclass = "wrap grid-wrap";
        break;
    case "agenturfinder_wie_es_funktioniert":
        $rowclass = "wrap grid-wrap";
        break;
    case "agenturfinder_artikel_auswahlen_magazin":
        $rowclass = "wrap grid-wrap";
        break;
    case "toolindex":
        $rowclass = "wrap toolindex-row-wrap";
        break;
    case "iconlinks":
        $rowclass = "icon-links-2-column-wrap";
        break;
    case "full-width-promo":
        $rowclass = "full-width-promo-wrap";
        break;
    case "download-items":
        $rowclass = "grid-wrap download-items-wrap";
        break;
    case "quicktipps":
        $rowclass = "wrap grid-wrap";
        break;
    case "ebooks":
        $rowclass = "wrap grid-wrap";
        break;
    case "featured_ebooks":
        $rowclass = "wrap grid-wrap featured-articles-row";
        break;

    case "christmas_uebersicht":
        $rowclass = "wrap grid-wrap x-overflow-hidden";
        break;

    case "profile":
        $rowclass = "profile-section-wrap";
        break;
    
    case "characteristics":
        $rowclass = "characteristics-section-wrap x-z-999";
        break;

    case "download_template":
        $rowclass = "omt-downloads-content";
        break;
    
    default:
        if (($has_sidebar != false)) {
            $rowclass = ""; } else { $rowclass="wrap"; }
        break;
}