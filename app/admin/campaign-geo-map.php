<section class="content">
  <div class="white-wapper">
    <div class="white-layer">
      <h4 class="white-layer-title">Campaign Details</h4>
      <form method="post" class="theme-fields-form">
        <div class="row">
            <div class="col-md-6">
              <div class="white-box pl-5 pr-5">
                <h4 class="white-box-sub-titile">Geo:</h4>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Location Search: </label>
                    <div class="col-sm-8">
                      <input id="map-place-search-input" class="form-control" type="text" placeholder="Search">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Map: </label>
                    <div class="col-sm-8">
                      <div id="map"></div>                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="white-box pl-5 pr-5">
                <h4 class="white-box-sub-titile"></h4>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Latitude: </label>
                    <div class="col-sm-8">
                      <input type="text" name="coordinates[latitude]" id="latitude" class="magicsearch form-control" >
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Longitude: </label>
                    <div class="col-sm-8">
                      <input type="text" name="coordinates[longitude]" id="longitude" class="magicsearch form-control" >
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Radius : <small>(In Miles)</small></label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <input class="magicsearch form-control" name="coordinates[radius]" type="number" min="0">
                        <div class="input-group-addon bg-gray">
                          Miles
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <br/>
              <input type="hidden" name="step" value="3">
              <input type="submit" value="Next" name="save" class="btn btn-warning pull-right">
            </div>
        </div>            
      </form>
    </div>
  </div>
</section>
<script type="text/javascript">
function initAutocomplete() {
  var circleClusterremove = [];
        var buffer_circle = null;
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -33.8688, lng: 151.2195},
        zoom: 13,
        mapTypeId: 'roadmap'
    });
    // Create the search box and link it to the UI element.
    var input = document.getElementById('map-place-search-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });
    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }
        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];
        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            console.log(place);
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };
            // Create a marker for each place.
            markers.push(new google.maps.Marker({
                map: map,
                title: place.name,
                position: place.geometry.location
            }));

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYw1qIZUqAK4lfkB8dLIOK0XOVU9e66xE&libraries=places&callback=initAutocomplete" async defer></script>
<style type="text/css">
#map {
  height: 300px;
  margin: 20px 0 15px 0;
  overflow: unset !important;
}
.gm-style > div{
  position: relative;
  overflow: hidden;
}
input#map-place-search-input {
    top: -60px !important;
    left: 0 !important;
}
</style>