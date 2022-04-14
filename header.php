<?php
if (getPost()->post_type == "product") {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://www.omt.de");
    header("Connection: close");
}

if (getPost()->ID == 21990) {
    header("HTTP/1.0 404 Not Found");
}
?>
    <!doctype html>
    <!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
    <!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
    <!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
    <head>
        <meta charsetre="utf-8">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <?php header('Content-type: text/html; charset=utf-8'); ?>
        <meta name="HandheldFriendly" content="true">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/library/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/library/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/library/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/library/favicon/site.webmanifest">
        <link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/library/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/library/favicon/favicon.ico">
        <meta name="msapplication-TileColor" content="#2b5797">
        <meta name="msapplication-config" content="<?php echo get_template_directory_uri(); ?>/library/favicon/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php wp_head(); ?>
        <?php // drop Google Analytics Here ?>
        <?php // Pinterest verifiy ?>
        <meta name="p:domain_verify" content="fe51bb993eb8842c42cc3c9ddcc703c7"/>

        <?php if (getPost()->field('ist_themenwelt', 'bool')) : ?>
            <script>
                dataLayer.push({
                    "internal_post_type": "themenwelt",
                });
            </script>
        <?php endif ?>

        <?php
        $internal_post_type = null;
        switch (getPost()->post_type) {
            case "affiliate":
                $internal_post_type = "magazinartikel";
                break;
            case "amazon":
                $internal_post_type = "magazinartikel";
                break;
            case "content":
                $internal_post_type = "magazinartikel";
                break;
            case "covnersion":
                $internal_post_type = "magazinartikel";
                break;
            case "facebook":
                $internal_post_type = "magazinartikel";
                break;
            case "ga":
                $internal_post_type = "magazinartikel";
                break;
            case "growthhack":
                $internal_post_type = "magazinartikel";
                break;
            case "links":
                $internal_post_type = "magazinartikel";
                break;
            case "magazin":
                $internal_post_type = "magazinartikel";
                break;
            case "sea":
                $internal_post_type = "magazinartikel";
                break;
            case "seo":
                $internal_post_type = "magazinartikel";
                break;
            case "social":
                $internal_post_type = "magazinartikel";
                break;
            case "onlinemarketing":
                $internal_post_type = "magazinartikel";
                break;
            case "webanalyse":
                $internal_post_type = "magazinartikel";
                break;
        }
        ?>
        <?php if ($internal_post_type) : ?>
            <script>
                dataLayer.push ({
                    "internal_post_type": "<?php echo $internal_post_type ?>",
                    "magazin_author": "<?php echo expertsNames(getPost()->field('autor', 'array')) ?>",
                });
            </script>
        <?php endif ?>

        <?php if (getPost()->post_type == "webinare") : ?>
            <script>
                dataLayer.push ({
                    "internal_post_type": "webinar-detail",
                    "webinarID": "<?php echo getPost()->field('webinarID', 'int') ?>",
                    "speaker": "<?php echo expertsNames(getPost()->field('webinar_speaker', 'array')) ?>",
                    "webinarDatum": "<?php echo getPost()->field('webinar_datum') ?>",
                    "webinarKategorie": "<?php echo get_the_terms(getPost()->ID, "kategorie")[0]->name ?>",
                });
            </script>
        <?php endif ?>

        <?php if (getPost()->post_type == "jobs") : ?>
            <script>
                dataLayer.push ({
                    "internal_post_type": "job",
                    "jobDatum": "<?php echo get_the_date('Y-m-d') ?>",
                });
            </script>
        <?php endif ?>

        <?php if (getPost()->post_type == "podcasts") : ?>
            <link rel="alternate" type="application/rss+xml" title="OMT Podcast" href="https://omt-podcast.podigee.io/feed/mp3"/>
        <?php endif ?>

        <?php if (getPost()->post_type == "tool") : ?>
            <?php if (getPost()->field('anzahl_bewertungen', 'float') > 0) : ?>
            <script type="application/ld+json">
                {
                    "@context": "http://schema.org",
                    "@type": "SoftwareApplication",
                    "name": "<?php echo get_the_title() ?>",
                    "applicationCategory": "Online Marketing Tool",
                    "operatingSystem": "Online",
                    "aggregateRating": {
                        "@type": "AggregateRating",
                        "ratingValue": "<?php echo getPost()->field('gesamt', 'float') ?>",
                        "reviewCount": "<?php echo getPost()->field('anzahl_bewertungen', 'float') ?>"
                    }
                }
            </script>
        <?php endif ?>

            <script>
                dataLayer.push ({
                    "seitentyp": "<?php echo (
                        getPost()->field('neue_ansicht_auch_ohne_content_verwenden', 'bool') ||
                        !empty(getPost()->field('produktubersicht', 'content')) ||
                        !empty(getPost()->field('wer_verwendet', 'content'))
                    ) ? 'tool-einzelseite' : 'tool-ubersichtsseite' ?>",
                });
            </script>
        <?php endif ?>

        <?php
        // Optional, Custom Markup on each page
        echo getPost()->field('schema_editor') ?? '';

        // Optional FAQ Schema on Pages, "OMT Magazin / Themenwelten" and Tools post types
        $faq_fur_schema = getPost()->field('faq_fur_schema', 'repeater');
        $icon_fur_faq = getPost()->field('icon_fur_faq') . " ";

        if (strlen($icon_fur_faq) < 3 || $icon_fur_faq == "kein ") {
            $icon_fur_faq = "";
        }
        ?>

        <?php if (isset($faq_fur_schema[0]) && strlen($faq_fur_schema[0]['frage']) > 0) : ?>
            <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "FAQPage",

                "mainEntity": [<?php $faqcount=0;foreach($faq_fur_schema as $faq) { $faqcount++;?>{
                    "@type": "Question",
                    "name": "<?php echo $icon_fur_faq . str_replace('"', "'", $faq['frage']) ?>",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "<?php echo str_replace('"', "'", $faq['antwort']) ?>"
                    }
                }<?php if ($faqcount!=count($faq_fur_schema)) {echo ",";}}?>]
            }
        </script>
        <?php endif ?>

        <link rel="preload" href="/wp-content/themes/omt/library/fonts/5423072/01a0b817-cc89-4107-9d55-d7b627f1b2d4.woff2" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="/wp-content/themes/omt/library/fonts/5423028/53ea8854-2735-4f20-af6a-1854b25980ff.woff2" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="/wp-content/themes/omt/library/fonts/5423054/40c56829-3667-4106-8dd1-bf05f062f5d0.woff2" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="/wp-content/themes/omt/library/fonts/5423149/0d8a47c9-0ec5-4294-8ddf-f1f10472718b.woff2" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="/wp-content/themes/omt/library/font-awesome-4.6.3/fonts/fontawesome-webfont.woff2?v=4.6.3" as="font" type="font/woff2" crossorigin>
        <link rel="preconnect" href="https://stats.omt.de">
        <meta name="google-site-verification" content="Thhfh9ho_kN0Mb_kgbq0EMVyTQCyNiQMudQfgmReoIM" />

        <?php if (is_page(36355)) : ?>
            <link rel="alternate" type="application/rss+xml" title="OMT Podcast" href="https://omt-podcast.podigee.io/feed/mp3"/>
        <?php endif ?>

        <meta name="apple-itunes-app" content="app-id=1478126817">

        <!-- Matomo Tag Manager -->
        <script type="text/javascript">
            var _mtm = window._mtm = window._mtm || [];
            _mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'});
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.src='https://stats.omt.de/js/container_FuycfniI.js'; s.parentNode.insertBefore(g,s);
        </script>
        <!-- End Matomo Tag Manager -->
        <!--jquery UI-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!--jquery UI end-->
    </head>
<body <?php if (is_page()) { body_class('body-flat'); } else { body_class(); } ?>>
<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
<?php if (!is_page()) { ?><div class="wrapper">
    <div id="container"><?php } ?>
    <header class="header" role="banner">
        <section id="login-area" class="lightbox">
            <div class="lightbox-close"><i class="fa fa-times"></i></div>
            <div class="lightbox-content">
                <div id="login-cnt">
                    <form id="login" class="ajax-auth" action="login" method="post">
                        <p class="status"></p>
                        <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
                        <input id="username" type="text" class="required" placeholder="Benutzername" name="username">
                        <input id="password" type="password" class="required" placeholder="Passwort" name="password">
                        <input class="submit_button button" type="submit" value="Anmelden">
                    </form>
                    <div class="login-meta">
                        <div><a id="keep-logged-in" href="#"><span><i class="fa fa-check has-gradient"></i></span> Angemeldet bleiben</a></div>
                        <div><a href="/passwort-vergessen/">Passwort vergessen?</a></div>
                        <div><a href="/club/#anmeldung" class="text-red"><b>Jetzt registrieren!</b></a></div>
                    </div>
                </div>
            </div>
        </section>
        <section id="lightbox-area" class="lightbox">
            <div class="lightbox-close"><i class="fa fa-times"></i></div>
            <div class="lightbox-content">
                <div id="login-cnt">
                </div>
            </div>
        </section>
        <div id="inner-header" class="wrap clearfix">
            <a class="logo" href="<?php echo home_url(); ?>"><img width="96" height="55"  class="logo" alt="logo" src="<?php echo getOption('logo', 'image_url') ?>"/></a>
            <nav class="nav" id="navigation">
                <?php bones_main_nav(); ?>
                <ul class="visible-on-mobile">
                    <li class="mega toggle-mobile-nav">
                        <button type="button" class="x-bg-transparent x-border-0 x-pl-0 x-pr-0">
                            <i class="fa fa-bars"></i>
                        </button>
                    </li>
                </ul>
            </nav>
            <?php /*<a href="/agentur-finden" class="button-agenturfinder button-red"><span class="">Agenturfinder</span></a>*/?>
            <?php if (is_user_logged_in()) { ?>
                <a href="/logout" class="button-logout header-button header-button-offset"><span>Logout</span></a>
            <?php } else { ?>
                <a href="#" class="button-login header-button header-button-offset"><span>Club-Login</span></a>
            <?php } ?>

            <i class="fa fa-search header-search-icon" aria-hidden="true"></i>
            <div class="omt-suche header-search-input">
                <form role="search" method="get" id="searchform" action="https://www.omt.de/"> <input type="text" class="searchphrase" value="" name="s" id="s" placeholder="Finde die Inhalte beim OMT..." id=""/></form>
            </div>
        </div>
        <?php if (is_single() || getPost()->field('ist_themenwelt', 'bool')) : ?>
            <progress value="0"></progress>
        <?php endif ?>
    </header>
    <div id="mega-dropnav" class="hidden">
        <div class="container wrap">
            <?php bones_main_nav(); ?>
        </div>
    </div>
<?php if (is_page()) {
    if (is_page(311677) OR $post->post_parent == 311677){
        get_template_part('library/templates/hero-freelancervermittlung', 'page');
        ?>
        <div class="wrapper">
        <div id="container">
    <?php } else {
        get_template_part('library/templates/hero-flat', 'page');
        ?><div class="wrapper">
        <div id="container">
    <?php } ?>
<?php } ?>