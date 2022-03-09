<?php
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
//FILTER THE TOOLS ACCORDING TO SELECTION!
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
switch ($filter_price) {
    case "preis-alle":
        break;
    case "preis-kostenlos":
        $filter = 0;
        foreach ($jsontool['$filter_preis'] as $preisfilter) {
            if ("kostenlos" == $preisfilter) {
                $filter = 1;
            }
        }
        if (1 != $filter) {
            unset ($json[$j]);
        }
        break;
    case "preis-nicht-kostenlos":
        $filter = 0;
        foreach ($jsontool['$filter_preis'] as $preisfilter) {
            if ("nicht-kostenlos" == $preisfilter) {
                $filter = 1;
            }
        }
        if (1 != $filter) {
            unset ($json[$j]);
        }
        break;
    case "preis-trial":
        $filter = 0;
        foreach ($jsontool['$filter_preis'] as $preisfilter) {
            if ("trial" == $preisfilter) {
                $filter = 1;
            }
        }
        if (1 != $filter) {
            unset ($json[$j]);
        }
        break;
    case "preis-testversion":
        $filter = 0;
        foreach ($jsontool['$filter_preis'] as $preisfilter) {
            if ("testversion" == $preisfilter) {
                $filter = 1;
            }
        }
        if (1 != $filter) {
            unset ($json[$j]);
        }
        break;
}
if ( ("mit-testbericht" == $filter_testbericht) AND (1 != $jsontool['$filter_testbericht']) ) {
    unset ($json[$j]);
}