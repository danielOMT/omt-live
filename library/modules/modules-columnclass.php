<?php switch ($zeile['inhaltstyp'][0]['acf_fc_layout']) {
    case "header_hero_modul":
        $columnclass = "header-hero-modul";
        break;
    case "hero_modul":
        $columnclass = "hero-modul";
        break;
    case "inhaltseditor":
        $columnclass = "inhaltseditor";
        break;
    case "kapitelmodul":
        $columnclass = "inhaltseditor kapitelmodul";
        break;
    case "inhaltseditor_3er":
        $columnclass = "teaser-modul inhaltseditor_3er";
        break;
    case "inhaltseditor_2er":
        $columnclass = "teaser-modul inhaltseditor_2er";
        break;
    case "jquery_skript":
        $columnclass = "script";
        break;
    case "headline":
        $columnclass = "headline";
        break;
    case "accordion":
        $columnclass = "accordion";
        break;
    case "tabs":
        $columnclass = "module-tabs inhaltseditor";
        break;
    case "galerie":
        $columnclass = "galerie teaser-modul";
        break;
    case "slider":
        $columnclass = "slider";
        break;
    case "paragraph_image":
        $columnclass = "paragraph-image teaser-modul";
        break;
    case "teaser_modul":
        $columnclass = "teaser-modul";
        break;
    case "buchempfehlungen":
        $columnclass = "teaser-modul buchempfehlungen";
        break;
    case "testimonial":
        $testimonial_count = count($zeile['inhaltstyp'][0]['testimonials']);
        $columnclass = "testimonial-wrap";
        if ($testimonial_count>1) { $columnclass .= " testimonial-slider"; }
        break;

    case "tabelle":
        $columnclass = "tabelle overflow-auto";
        break;
    case "timetable":
        $columnclass = "tabelle overflow-auto";
        break;
    case "vergleichstabelle_tools":
        $columnclass = "tabelle overflow-auto";
        break;
    case "vergleichstabelle_tools_cpt":
        $columnclass = "tabelle overflow-auto";
        break;
    case "instagram":
        $columnclass = "instagram";
        break;
    case "call_to_action":
        $columnclass = "call-to-action";
        break;
    case "blog_grid":
        $columnclass = "blog-grid";
        break;
    case "google_map":
        $columnclass = "google-map";
        break;
    case "kontaktformular":
        $columnclass = "kontaktformular";
        break;
    case "video":
        $columnclass = "video_wrap";
        break;
    case "video_wistia":
        $columnclass = "video_wrap";
        break;
    case "banner_bg":
        $columnclass = "banner-bg-inner";
        break;
    case "teaser_modul_highlight":
        $columnclass = "teaser_modul_highlight";
        break;
    case "webinare_anzeigen":
        $columnclass = "webinare-wrap teaser-modul";
        break;
    case "webinare_anzeigen_json":
        $columnclass = "webinare-wrap teaser-modul";
        break;
    case "podcasts_anzeigen":
        $columnclass = "webinare-wrap podcast-wrap teaser-modul";
        break;
    case "podcasts_anzeigen_json":
        $columnclass = "webinare-wrap podcast-wrap teaser-modul";
        break;
    case "podcast_abonnieren":
        $columnclass = "podcast-abonnieren teaser-modul";
        break;
    case "vortrage_anzeigen":
        $columnclass = "webinare-wrap vortraege-wrap teaser-modul";
        break;
    case "artikel_anzeigen":
        $columnclass  = "artikel-wrap teaser-modul";
        break;
    case "artikel_anzeigen_json":
        $columnclass  = "artikel-wrap teaser-modul";
        break;
    case "lexikon_anzeigen":
        $columnclass  = "artikel-wrap teaser-modul";
        break;
    case "artikel_auswahlen":
        $columnclass  = "artikel-wrap teaser-modul";
        break;
    case "featured_artikel":
        $columnclass  = "artikel-wrap teaser-modul";
        break;
    case "seminare_anzeigen":
        $columnclass = "seminare-wrap teaser-modul";
        break;
    case "seminare_anzeigen_json";
        $columnclass = "seminare-wrap teaser-modul";
        break;
    case "seminartypen_anzeigen":
        $columnclass = "seminare-wrap teaser-modul";
        break;
    case "jobs_anzeigen":
        $columnclass = "jobs-wrap";
        break;
    case "teaser_highlight":
        $columnclass = "teaser-highlight ";
        $columnclass .= $zeile['inhaltstyp'][0]['farbschema'];
        break;
    case "clubtreffen_anzeigen":
        $columnclass = "clubtreffen-wrap teaser-modul";
        break;
    case "branchenbuch_agentursuche":
        $columnclass = "branchenbuch branchenbuch-suche";
        break;
    case "branchenbuch_premium":
        $columnclass = "branchenbuch branchenbuch-agenturen";
        break;
    case "branchenbuch_liste":
        $columnclass = "branchenbuch branchenbuch-liste";
        break;
    case "trends_anzeigen":
        $columnclass = "trends-wrap";
        break;
    case "tools_anzeigen":
        $columnclass = "tools-wrap";
        break;
    case "webinare_teaser_wiederholungsfeld":
        $columnclass = "webinare_ctas";
        break;
    case "webinar_zusammenfassungen":
        $columnclass = "webinar-zusammenfassungen";
        break;
    case "konferenzticket":
        $columnclass = "teaser-modul konferenzticket";
        break;
    case "partner":
        $columnclass = "teaser-modul omt-partner";
        break;
    case "toolindex":
        $columnclass = "toolindex-column-wrap";
        break;

    case "speakerprofil":
        $columnclass = "";
        break;

    case "alle_botschafter_anzeigen":
        $columnclass  = "artikel-wrap teaser-modul";
        break;

    /*agenturfinder columnklassen agenturfinder classes*/
    case "agenturfinder_artikel_anzeigen_magazin":
        $columnclass  = "artikel-wrap teaser-modul";
        break;
    case "agenturfinder_artikel_anzeigen_magazin_json":
        $columnclass  = "artikel-wrap teaser-modul";
        break;
    case "agenturfinder_artikel_auswahlen_magazin":
        $columnclass  = "artikel-wrap teaser-modul";
        break;
    case "introbuttons":
        $columnclass = "introbuttons-wrap";
        break;
    case "agenturfinder_testimonial_slider":
        $testimonial_count = count($zeile['inhaltstyp'][0]['testimonials']);
        if ((strlen($zeile['inhaltstyp'][0]['testimonials'][0]['name']<1))) { $zeilen = get_field('agenturfinder_testimonial_slider', 'options'); $testimonial_count = count($zeilen); }
        $columnclass = "testimonial-wrap";
        if ($testimonial_count>1) { $columnclass .= " testimonial-slider"; }
        break;
    case "agenturfinder_logos_anzeigen":
        $columnclass = "teaser-modul omt-partner agenturen-wrap";
        break;
    case "agenturfinder_wie_es_funktioniert":
        $columnclass = "teaser-modul howto-wrap";
        break;
    case "agenturfinder_artikel_anzeigen":
        $columnclass = "ag-artikel-wrap";
        break;
    case "agenturfinder_artikel_anzeigen_json":
        $columnclass = "ag-artikel-wrap";
        break;
    case "agenturfinder_kontakt":
        $columnclass = "agenturfinder-kontakt";
        break;
    case "magazin_teaser":
        $columnclass = "teaser-modul magazin-teaser";
        break;
    case "webinare_teaser":
        $columnclass = "teaser-modul webinare-teaser";
        break;
    case "tools_teaser_mit_suche":
        $columnclass = "teaser-modul tools-suche-teaser";
        break;
    case "tools_teaser_nach_kategorien":
        $columnclass = "teaser-modul tools-kategorien-teaser";
        break;
    case "podcast_teaser":
        $columnclass = "podcast-teaser";
        break;
    case "omt_podcast_teaser":
        $columnclass = "omt-podcast-teaser";
        break;
    case "themenwelten_uebersicht":
        $columnclass = "teaser-modul themenwelten-modul";
        break;
    case "club_teaser":
        $columnclass = "club-teaser";
        break;
    case "suche_teaser":
        $columnclass = "suche-teaser";
        break;
    case "iconlinks":
        $columnclass = "icon-links-2-column";
        break;
    case "full-width-promo":
        $columnclass = "full-width-promo";
        break;
    case "download-items":
        $columnclass = "teaser-modul";
        break;
    case "quicktipps":
        $columnclass = "artikel-wrap teaser-modul";
        break;
    case "ebooks":
        $columnclass = "artikel-wrap teaser-modul";
        break;
    case "featured_ebooks":
        $columnclass = "artikel-wrap teaser-modul";
        break;
    case "team_member":
        $columnclass = "teaser-modul team-member";
        break;
    
    case "christmas_uebersicht":
        $columnclass = "teaser-modul christmas-modul";
        break;    
    
    case "profile":
        $columnclass = "profile-section";
        break;  

    case "three_column_layout":
        $columnclass = "three-column";
        break; 
        
    case "vertical_tabs":
        $columnclass = "module-tabs inhaltseditor";
        break; 
    
    case "partner_full_width":
        $columnclass = "partner-full-width";
        break;
    
    case "autojobs":
        $columnclass = "autojobs";
        break;  
    default:
        $columnclass = "";
        break;
}