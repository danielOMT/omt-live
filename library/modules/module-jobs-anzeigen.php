<?php
require_once ( get_template_directory() . '/library/functions/function-jobs.php');
$anzahl = $zeile['inhaltstyp'][0]['anzahl_angezeigter_jobs'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$intro = $zeile['inhaltstyp'][0]['introtext'];
if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
if (strlen($intro)>0) { print $intro; }
/*?>
    <form class="clearfix" id="jobs-filter" action="./jobs.html" method="POST">
        <div>
            <div class="select">
                <select id="jobs-location" name="jobs_location">
                    <option value="">Alle Standorte</option>
                    <option value="Berlin">Berlin</option>
                    <option value="Hannover">Hannover</option>
                    <option value="Hamburg">Hamburg</option>
                    <option value="München">München</option>
                    <option value="Nürnberg">Nürnberg</option>
                    <option value="Stuttgart">Stuttgart</option>
                </select>
            </div>
        </div>
        <div>
            <div class="select">
                <select id="jobs-category" name="jobs_categories">
                    <option value="">Alle Kategorien</option>
                    <option value="Suchmaschinenoptimierung">Suchmaschinenoptimierung</option>
                    <option value="Google Adwords (SEA)">Google Adwords (SEA)</option>
                    <option value="Linkbuilding">Linkbuilding</option>
                    <option value="Google Analytics">Google Analytics</option>
                    <option value="Content Marketing">Content Marketing</option>
                    <option value="Social Media Marketing">Social Media Marketing</option>
                </select>
            </div>
        </div>
    </form>
    <div class="margin-bottom-75">
        <a href="#" class="button button-full button-gradient">Zum Job-Newsletter anmelden!</a>
    </div>
<?php*/
display_jobs($anzahl);
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];
if (strlen($button_text)>0) { ?>
    <a class="button after-grid" href="<?php print $button_link;?>"><?php print $button_text;?></a>
<?php }