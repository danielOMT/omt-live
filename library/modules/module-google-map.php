<?php
$map_marker_text = $zeile["inhaltstyp"][0]["marker_text"];
$map_marker_image = $zeile["inhaltstyp"][0]["marker_icon"];
$zoom = $zeile["inhaltstyp"][0]["zoomlevel_der_karte"];
$lat=$zeile['inhaltstyp'][0]['karte']['lat'];
$lng=$zeile['inhaltstyp'][0]['karte']['lng'];
?>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDFmVEWDZOoE8GtOglBut7XSID-OSC6hK0&v=3.exp'></script>
<div 
    id='gmap_canvas' 
    style='height: <?php print $zeile["inhaltstyp"][0]["hohe_der_karte"];?>px;width:100%;'
    class="x-mb-8"
></div>
<style>#gmap_canvas img{max-width:none!important;background:none!important}</style>
<script type='text/javascript'>
    function init_map(){
        var myOptions = {
            zoom: <?php print $zoom;?>,
            draggable: false,
            scrollwheel: false,
            center:new google.maps.LatLng(<?php print ($lat);?>,<?php print $lng;?>),
            //styles: [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}],
            mapTypeId: google.maps.MapTypeId.ROADMAP};
        map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
        marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(<?php print $lat;?>,<?php print $lng;?>)});
        <?php if (strlen($map_marker_text)>0) { ?>infowindow = new google.maps.InfoWindow({content:'<p class="marker-content"><img src="<?php print $map_marker_image['url'];?>"/><?php print $map_marker_text;?></p>'});<?php } ?>
        google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});
        <?php if (strlen($map_marker_text)>0) { ?>infowindow.open(map,marker);<?php } ?>
    }
    google.maps.event.addDomListener(window, 'load', init_map);
</script>