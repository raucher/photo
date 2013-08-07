var geocoder; var map;
function initialize()
{
    // Create Geocoder instance
    geocoder= new google.maps.Geocoder();

    // Specify map options
    var mapOptions = {
        'zoom': 15,
        'center': new google.maps.LatLng(-34.397, 150.644),
        'mapTypeId': google.maps.MapTypeId.ROADMAP
    }

    // Create Map instance
    map = new google.maps.Map(document.getElementById('gmap-widget-content'), mapOptions);

    // Set map center and marker to desirable address
    geocoder.geocode({'address': jQuery.gmapWidgetNS.address}, function(results, status){
        if( status == google.maps.GeocoderStatus.OK )
        {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                'map': map,
                'position': results[0].geometry.location
            });
        }
        else
            console.log('Some Geocode troubles appears!' + status);
    });
}
google.maps.event.addDomListener(window, 'load', initialize);