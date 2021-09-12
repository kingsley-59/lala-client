
function create_map(){
    let map_container = document.getElementById('map-container');

    const map_props = {
        center:new google.maps.LatLng(5.389583, 6.999333),
        zoom:5,
    }

    var map = new google.maps.Map(map_container, map_props);
}


