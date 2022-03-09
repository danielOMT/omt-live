<?php

use OMT\Model\Datahost\Click;
use OMT\Services\ToolProviderStats;

$current_user_id = get_current_user_id();
um_fetch_user($current_user_id);
$display_name = um_user('display_name');
$zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);

if (!isset($toolid)) {
    $toolid = $zugewiesenes_tool[0]->ID;
}
$date_from = $_REQUEST['date_from'];
$date_to = $_REQUEST['date_to'];
if (strlen($date_from)<1) { $date_from = "01.01.2020"; }
if (strlen($date_to)<1) { $date_to = "31.12.2021"; }

$toolanbieter_website_clickmeter_link_id = get_field('toolanbieter_website_clickmeter_link_id', $toolid);
$tool_preisubersicht = get_field('tool_preisubersicht', $toolid);
$tool_preisubersicht_clickmeter_link_id = get_field('tool_preisubersicht_clickmeter_link_id', $toolid);
$tool_gratis_testen_link = get_field('tool_gratis_testen_link', $toolid);
$tool_gratis_testen_link_clickmeter_link_id = get_field('tool_gratis_testen_link_clickmeter_link_id', $toolid);
$tool_kategorien_content = get_field('tool_kategorien', $toolid);

$sqlfrom = strtotime($date_from . " 00:00:01");
$sqlbis = strtotime($date_to . " 23:59:59");

$clicks = Click::init()->statsItems($toolid, $sqlfrom, $sqlbis);

if (isset($_GET['export'])) {
    (new ToolProviderStats)->export(get_the_title($toolid), $clicks);
}
?>
<div class="history">
    <h4>Klick Historie für das Tool <?php echo get_the_title($toolid) ?></h4>

    <div class="x-flex x-justify-between x-items-baseline">
        <div class="datefilter-wrap">
            <script>
                $(function() {
                    var dateFormat = "dd.mm.yy",
                        from = $( "#rangefrom" )
                            .datepicker({
                                defaultDate: "+1w",
                                changeMonth: true,
                                numberOfMonths: 3,
                                dateFormat: "dd.mm.yy"
                            })
                            .on( "change", function() {
                                to.datepicker( "option", "minDate", getDate( this ) );
                            }),
                            to = $( "#rangeto" ).datepicker({
                                defaultDate: "+1w",
                                changeMonth: true,
                                numberOfMonths: 3,
                                dateFormat: "dd.mm.yy"
                            })
                            .on( "change", function() {
                                from.datepicker( "option", "maxDate", getDate( this ) );
                            });

                    function getDate( element ) {
                        var date;
                        try {
                            date = $.datepicker.parseDate( dateFormat, element.value );
                        } catch( error ) {
                            date = null;
                        }

                        return date;
                    }
                });
            </script>

            <label for="from">Von</label>
            <input type="text" autocomplete="off" value="<?php if(isset($_REQUEST['date_from'])) { echo $date_from; }?>" id="rangefrom" name="from">
            <label for="to">Bis</label>
            <input type="text" autocomplete="off" value="<?php if(isset($_REQUEST['date_to'])) { print $date_to; }?>" id="rangeto" name="to">
            <a id="filter-daterange" class="button button-blue button-350px" data-backend="<?php print $backend;?>" data-toolid="<?php print $toolid;?>">Eingrenzen</a>
        </div>

        <a href="<?php echo site_url() ?>/toolanbieter/?updated=true&area=statistik&toolid=<?php echo $toolid ?>&date_from=<?php echo $date_from ?>&date_to=<?php echo $date_to ?>&export=1" class="button button-red x-whitespace-nowrap">
            Daten exportieren
        </a>
    </div>

    <table class="bid-history">
        <tr>
            <th style="width: 30px;">#</th>
            <th>Kategorie</th>
            <th>Kosten</th>
            <th style="width: 170px;">Zeitpunkt</th>
            <th style="width: 170px;">IP</th>
            <th>Browser</th>
            <th>OS</th>
        </tr>
        <?php foreach ($clicks as $key => $click) : ?>
            <tr>
                <td title="Interne ID: <?php echo $click->ID ?>"><?php echo $key + 1 ?></td>
                <td><?php echo $click->extra->category ?></td>
                <td><?php echo $click->bid_kosten ?> €</td>
                <td><?php echo $click->extra->date->format('d.m.Y H:i') ?></td>
                <td style="word-break: break-all;"><?php echo $click->ip ?></td>
                <td><?php echo $click->browser ?></td>
                <td><?php echo $click->os ?></td>
            </tr>
        <?php endforeach ?>
    </table>
</div>