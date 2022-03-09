<?php
$umfrage =  $zeile['inhaltstyp'][0]['umfrage_auswahlen'];
$umfrageID = $umfrage->ID;
$vortrage = get_field('vortrage', $umfrageID);
$berechtigte_user = get_field('berechtigte_user', $umfrageID);
$kann_abgestimmt_werden_ab = get_field('kann_abgestimmt_werden_ab', $umfrageID);
$kann_abgestimmt_werden_bis = get_field('kann_abgestimmt_werden_bis', $umfrageID);
$reihenfolge_der_kategorien_festlegen = get_field('reihenfolge_der_kategorien_festlegen', $umfrageID);
//kategorie
//der_kategorie_vorangestellter_text
?>
<div class="umfrage-category-menu">
    <span class="category-menu-label">Direkt zur Kategorie:</span>
    <?php foreach ($reihenfolge_der_kategorien_festlegen as $kategorie) {
        $category = get_the_category_by_ID($kategorie['kategorie']);
        $anchor = strtolower(str_replace(" ", "-", $category)); ?>
    <a class="menu-link" href="#<?php print $anchor;?>"><?php print $category;?></a>
    <?php } ?>
<div class="legend">

    <div class="table-cats legende-wrap">
        <div class="legend-left">
            <b>Legende:</b>
        <i class="cat1 fa fa-circle"></i> Anfänger
        <i class="cat2 fa fa-circle"></i> Fortgeschrittene
        <i class="cat3 fa fa-circle"></i> Experten
        </div>
        <div class="legend-right">
        <a class="to-vote" href="#umfrage-submit">Stimmen abgeben</a>
        </div>
    </div>
</div>
</div>

<?php foreach ($reihenfolge_der_kategorien_festlegen as $kategorie) { ?>
    <div class="umfrage-kategorie">
        <?php
        $category = get_the_category_by_ID($kategorie['kategorie']);
        $anchor = strtolower(str_replace(" ", "-", $category));
       ?>
        <h3 class="kategorie-header">Vorträge aus der Kategorie <?php print $category;?></h3>
        <span class="anchor" id="<?php print $anchor;?>"></span>
        <?php if (strlen($kategorie['der_kategorie_vorangestellter_text'])>0) { print "<div class='category-text'>" . $kategorie['der_kategorie_vorangestellter_text'] . "</div>"; } ?>
        <?php foreach ($vortrage as $vortrag) {
            $vortragID = $vortrag['vortrag']->ID;
            $beschreibung = get_field('beschreibung_des_vortrags', $vortragID);
            $speaker = get_field('speaker', $vortragID);
            $terms = get_the_terms($vortragID, 'vortragkategorie');
            $term = $terms[0]->name;
            $schwierigkeitsgrad = get_field('schwierigkeitsgrad', $vortragID);
            if ($term == $category) { ?>
                <div class="vortrag vortrag-collapsed" data-id="<?php print $vortragID;?>">
                    <div class="vortrag-header">
                        <div class="title">
                            <h3><?php print str_replace("Privat: ","", get_the_title($vortragID)); ?></h3>
                            <p class="speaker">
                                <?php
                                $i = 0;
                                foreach($speaker as $vortrags_speaker) {
                                    $i++; ?>
                                    <?php
                                    $speakerID  = $vortrags_speaker->ID;
                                    $speakerName = get_the_title($speakerID);
                                    $speakerURL = get_the_permalink($speakerID);
                                    ?>
                                    <a target="_blank" href="<?php print $speakerURL;?>"><?php print $speakerName;?></a><?php if (count($speaker)>1 AND $i != count($speaker)) { print ", "; } ?>
                                <?php } ?>
                            </p>
                            <div class="collapse-button">
                                <div class="collapse-button-inner">
                                    <i class="fa fa-chevron-down"></i>
                                    <p>mehr Infos</p>
                                </div>
                            </div>
                        </div>
                        <div class="voting-wrap">
                            <p>Für diesen Vortrag abstimmen</p>
                            <div class="vortrag-voting">
                                <i class="fa fa-square-o"></i>
                            </div>
                        </div>
                    </div>
                    <div class="vortrag-content">
                        <div class="table-cats">Zielgruppe / Schwierigkeitsgrad:
                            <?php if (in_array(1, $schwierigkeitsgrad)) { ?><i class="cat1 fa fa-circle"></i><?php } ?>
                            <?php if (in_array(2, $schwierigkeitsgrad)) { ?><i class="cat2 fa fa-circle"></i><?php } ?>
                            <?php if (in_array(3, $schwierigkeitsgrad)) { ?><i class="cat3 fa fa-circle"></i><?php } ?>
                        </div>
                        <?php print $beschreibung;?></div>
                </div>
            <?php }
        } ?>
    </div>
<?php } ?>
<div class="early-bird-submit" class="" data-umfrageid="<?php print $umfrageID;?>">
    <span class="anchor" id="umfrage-submit"></span>
    <h3>Stimmen abgeben</h3>
    <input id="email" placeholder="Deine E-Mail-Adresse*">
    <input id="code" placeholder="Dein Early Bird Code*">
    <p class="results-label">Abgegebene Stimmen:</p>
    <div id="results"></div>
    <a class="submit umfrage-submit button button-red">Jetzt Stimmen abgeben</a>
    <div class="umfrage-submit-status status"><i class="fa fa-cog fa-spin"></i> Prüfe Daten...</div>
    <div class="results"></div>
</div>
</div>
