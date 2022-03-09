<?php
$headline = $zeile['inhaltstyp'][0]['headline'];
$introtext_optional = $zeile['inhaltstyp'][0]['introtext_optional'];
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];
$kategorien_auswahlen = $zeile['inhaltstyp'][0]['kategorien_auswahlen'];
$kat_i=0;
if (strlen($headline)>0) { ?><h2><?php print $headline;?></h2><?php } ?>
<?php print $introtext_optional;?>
<?php
if ( 1 != $zeile['inhaltstyp'][0]['als_teaser_modul_anzeigen']) { ?>
    <ul class="tool-kategorien">
        <?php foreach($kategorien_auswahlen as $kat) {
            $kat_i++;
            $term = get_term_by('id', $kat['kategorie'][0], 'tooltyp');
            $slug = $term->slug;
            $name = $term->name
            ?>
            <li <?php if (1 == $kat_i) { ?>class="active" <?php } ?> data-cat="<?php print $kat['kategorie'][0];?>" data-link="<?php print url_to_postid($kat['toolseite_dieser_kategorie']);?>"><?php print $name;?></li>
        <?php } ?>
        <li class="button-wrap"><a class="button button-blue" style="width: auto;" href="#alle-toolkategorien">Alle Kategorien öffnen</a></li>
    </ul>
    <div id="toolkategorie-results" class="tool-kategorie-content">
        <div class="link-wrap has-margin-bottom-30" style="padding-left:30px;">
            <a target="_blank" href="<?php print $kategorien_auswahlen[0]['toolseite_dieser_kategorie'];?>">Alle Tools der Kategorie anzeigen</a>
        </div>
        <?php
        $kategorie=$kategorien_auswahlen[0]['kategorie'][0];
        include('module-toolindex-toolsfromdb.php');
        $tabelle_kategorie = "kategorie";
        $tools_style = "teasertabelle";
        include('module-toolindex-part-queries-wpdb.php');
        $i = 0;
        foreach($json as $tool) {
            $i++;
            if ($i <= 6) {
                //print_r($tool);
                include('module-toolindex-part-tools-item.php');
            }
        }
        ?>
    </div>
    <div id="tools-status"></div>
<?php } else { ?>
    <div class="omt-row tool-abschnitt tool-alternativen wrap grid-wrap">
    <?php
    $counter=0;
    foreach ($kategorien_auswahlen as $kat) {
        $term = get_term_by('id', $kat['kategorie'][0], 'tooltyp');
        $slug = $term->slug;
        $name = $term->name
        ?>
        <h3><?php print $name;?></h3>
        <div class="omt-module teaser-modul">
            <?php
            $kategorie=$kategorien_auswahlen[0]['kategorie'][$counter];
            include('module-toolindex-toolsfromdb.php');
            $tabelle_kategorie = "kategorie";
            $tools_style = "teaser-small";
            include('module-toolindex-part-queries-wpdb.php');
            $i = 0;
            foreach($json as $tool) {
                    //print_r($tool);
                    include('module-toolindex-part-tools-item.php');
            }
            ?>
        </div>
    <?php
    $counter++;
    } ?>
    </div>
<?php } ?>