function new_map( $el ) {
    // var
    var $markers = $el.find('.marker');
    // vars
    var args = {
        zoom : 7,
        center : new google.maps.LatLng(0, 0),
        mapTypeId : google.maps.MapTypeId.ROADMAP
    };
    // create map
    var map = new google.maps.Map( $el[0], args);
    // add a markers reference
    map.markers = [];
    // add markers
    $markers.each(function(){
        add_marker( $(this), map );
    });
    // center map
    center_map( map );
    // return
    return map;
}
/*
 *  add_marker
 *
 *  This function will add a marker to the selected Google Map
 *
 *  @type	function
 *  @date	8/11/2013
 *  @since	4.3.0
 *
 *  @param	$marker (jQuery element)
 *  @param	map (Google Map object)
 *  @return	n/a
 */
function add_marker( $marker, map ) {
    // var
    var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
    // create marker
    var marker = new google.maps.Marker({
        position : latlng,
        map : map
    });
    // add to array
    map.markers.push( marker );
    // if marker contains HTML, add it to an infoWindow
    if( $marker.html() )
    {
        // create info window
        var infowindow = new google.maps.InfoWindow({
            content : $marker.html()
        });
        // show info window when marker is clicked
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open( map, marker );
        });
    }
}
/*
 *  center_map
 *
 *  This function will center the map, showing all markers attached to this map
 *
 *  @type	function
 *  @date	8/11/2013
 *  @since	4.3.0
 *
 *  @param	map (Google Map object)
 *  @return	n/a
 */
function center_map( map ) {
    // vars
    var bounds = new google.maps.LatLngBounds();
    // loop through all markers and create bounds
    $.each( map.markers, function( i, marker ){
        var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
        bounds.extend( latlng );
    });
    // only 1 marker?
    if( map.markers.length == 1 )
    {
        // set center of map
        map.setCenter( bounds.getCenter() );
        map.setZoom( 11 );
    }
    else
    {
        // fit to bounds
        map.setCenter( bounds.getCenter() );
        map.setZoom( 10 ); // Change the zoom value as required
        map.fitBounds( bounds ); // This is the default setting which I have uncommented to stop the World Map being repeated
    }
}

jQuery(document).ready(function($) {
    $('.acf-map').each(function(){
        new_map($(this));
    });
});
