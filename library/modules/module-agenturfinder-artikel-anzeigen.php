<?php
$anzahl_angezeigter_artikel = $zeile['inhaltstyp'][0]['anzahl_angezeigter_artikel'];
$kategorie = $zeile['inhaltstyp'][0]['kategorie'];
$nur_headline__kategorie_link_ausgeben = $zeile['inhaltstyp'][0]['nur_headline__kategorie_link_ausgeben'];

if ($kategorie[0] == "alle") {
    $agenturfinder_post_types = array('affiliateagentur', 'contentagentur', 'cmagentur', 'digitalagentur', 'gaagentur', 'internetagentur', 'linkbuildingagentur', 'omagentur', 'seaagentur', 'seoagentur', 'smagentur', 'webagentur', 'webanalyseagentur', 'webdesignagentur', 'wpagentur');
}  else { $agenturfinder_post_types = $kategorie; }  ?>
<?php foreach ( $agenturfinder_post_types as $post_type) {
    switch ($post_type) {
        case "affiliateagentur":
            $headline = "Affiliate Marketing Agenturen";
            break;
        case "contentagentur":
            $headline = "Content Agenturen";
            break;
        case "cmagentur":
            $headline = "Content Marketing Agenturen";
            break;
        case "digitalagentur":
            $headline = "Digitalagenturen";
            break;
        case "gaagentur":
            $headline = "Google Ads Agenturen";
            break;
        case "internetagentur":
            $headline = "Internetagenturen";
            break;
        case "linkbuildingagentur":
            $headline = "Linkbuilding Agenturen";
            break;
        case "omagentur":
            $headline = "Online Marketing Agenturen";
            break;
        case "seaagentur":
            $headline = "SEA Agenturen";
            break;
        case "seoagentur":
            $headline = "SEO Agenturen";
            break;
        case "smagentur":
            $headline = "Social Media Agenturen";
            break;
        case "webagentur":
            $headline = "Web-Agenturen";
            break;
        case "webanalyseagentur":
            $headline = "Webanalyse-Agenturen";
            break;
        case "webdesignagentur":
            $headline = "Webdesign-Agenturen";
            break;
        case "wpagentur":
            $headline = "Wordpress-Agenturen";
            break;
    }

    if ($post_type) {
        $post_type_data = get_post_type_object($post_type);
        $post_type_slug = $post_type_data->rewrite['slug'];
        $post_slug = get_post_field('post_name');

        $compareslug = "agentur-finden/" . $post_slug;
    }

    if (1 == $nur_headline__kategorie_link_ausgeben) { ?>
        <h4 style="min-height:0px;" class="agenturfinder-headline-only">
            <?php if ($compareslug != $post_type_slug) { ?>
                <a class="button" target="_blank" href="<?php print "/" . $post_type_slug . "/"; ?>"><?php print $headline; ?></a>
            <?php } else { ?><?php print $headline; ?><?php } ?>
        </h4>
    <?php } else {

        ?>
        <?php
        $currentID = get_the_ID();
        $artikelcount = 0;
        $args = array( //next
            'posts_per_page' => $anzahl_angezeigter_artikel,
            'post_type' => $post_type,
            'posts_status' => "publish",
            'order' => 'ASC',
            'orderby' => 'title',
            'post__not_in' => array($currentID)
        );
        $loop = new WP_Query($args);

        if ($loop->posts[0]->ID > 0) { ?>
            <div class="ag-artikel-wrap">
                <h4 style="min-height:0px;">
                    <?php if ($compareslug != $post_type_slug) { ?>
                        <a target="_blank"
                           href="<?php print "/" . $post_type_slug; ?>"><?php print $headline; ?></a>
                    <?php } else { ?><?php print $headline; ?><?php } ?>
                </h4>
                <div class="teaser-modul">
                    <div class="grid-wrap">
                        <?php
                        while ($loop->have_posts()) {
                            $loop->the_post() ?>
                            <a class="button teaser teaser-small"
                               href="<?php print str_replace("www.omt.de", "agenturfinder.omt.de", get_the_permalink()); ?>"><?php print $headline . "&nbsp;" . get_the_title(); ?></a>
                            <?php $artikelcount++;
                        }; //from the loop
                        ?>
                    </div>
                </div>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php } ?>
    <?php }
}
if ($artikelcount<1) { ?><span class="hidethis"></span><?php } ?>
