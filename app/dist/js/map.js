var markers = [];
var country=[];
var map;
var mapObject = {
  createMap: function(identifier,country,code,i,country_code) {
    var mapinput=document.createElement('input');
    mapinput.setAttribute('type','text');
    mapinput.setAttribute('id',identifier+'-input');
    mapinput.setAttribute('class','map-search-input');

    var colelement=document.createElement('div');
    colelement.setAttribute("class",'col-md-3');
    colelement.setAttribute("class",'col-md-3 map-'+country_code);
    colelement.setAttribute("id",country_code.toLowerCase());

    var countryelement=document.createElement('div');
    countryelement.setAttribute("class",'country-name');
    countryelement.innerHTML='Location for : <strong>'+country+'</strong>';
    colelement.appendChild(countryelement);

    var latinput=document.createElement('input');
    latinput.setAttribute('type','hidden');
    latinput.setAttribute('class','lat');
    latinput.setAttribute('name','location['+code+'][lat]');
    latinput.setAttribute('id',identifier+'lat');
    colelement.appendChild(latinput);

    var lnginput=document.createElement('input');
    lnginput.setAttribute('type','hidden');
    lnginput.setAttribute('class','lat');
    lnginput.setAttribute('name','location['+code+'][lng]');
    lnginput.setAttribute('id',identifier+'lng');
    colelement.appendChild(lnginput);

    var mapelement=document.createElement('div');
    mapelement.setAttribute("class",'map-element ');
    mapelement.setAttribute("id",identifier);
    colelement.appendChild(mapinput);
    colelement.appendChild(mapelement);
    document.getElementById("map-section").appendChild(colelement);
    
    var radiusinput=document.createElement('input');
    radiusinput.setAttribute('type','number');
    radiusinput.setAttribute('min',0);
    radiusinput.setAttribute('class','radius');
    radiusinput.setAttribute('name','location['+code+'][radius]');
    radiusinput.setAttribute('placeholder','Radius');
    radiusinput.setAttribute('required','required');
    colelement.appendChild(radiusinput);

    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
      zoom: 4,
      center: latlng
    }
    map = new google.maps.Map(document.getElementById(identifier), mapOptions);
    this.getLatLong(country,map,identifier);

    var input = document.getElementById(identifier+'-input');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.setComponentRestrictions({
      'country': code
    });
    autocomplete.addListener('place_changed',function() {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
          window.alert("No details available for input: '" + place.name + "'");
          return;
        }
        document.getElementById(identifier+'lat').value = place.geometry.location.lat();
        document.getElementById(identifier+'lng').value = place.geometry.location.lng();
        var icon = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25)
        };
        // Create a marker for each place.
        var latlng = new google.maps.LatLng(-34.397, 150.644);
        var mapOptions = {
          zoom: 4,
          center: latlng
        }
        map = new google.maps.Map(document.getElementById(identifier), mapOptions);
        new google.maps.Marker({
          map: map,
          title: place.name,
          position: place.geometry.location
        });
        console.log(markers);

        if (place.geometry.viewport) {
          map.fitBounds(place.geometry.viewport);
        } else {
          map.setCenter(place.geometry.location);
          map.setZoom(2);  // Why 17? Because it looks good.
        }
    });
  },
  editMap: function(identifier,country,code,i,lat,lng,radius,country_code) {
    var mapinput=document.createElement('input');
    mapinput.setAttribute('type','text');
    mapinput.setAttribute('id',identifier+'-input');
    mapinput.setAttribute('class','map-search-input');

    var colelement=document.createElement('div');
    colelement.setAttribute("class",'col-md-3 map-'+country_code);
    colelement.setAttribute("id",country_code.toLowerCase());

    var countryelement=document.createElement('div');
    countryelement.setAttribute("class",'country-name');
    countryelement.innerHTML='Location for : <strong>'+country+'</strong>';
    colelement.appendChild(countryelement);

    var latinput=document.createElement('input');
    latinput.setAttribute('type','hidden');
    latinput.setAttribute('class','lat');
    latinput.setAttribute('name','location['+code+'][lat]');
    latinput.setAttribute('id',identifier+'lat');
    colelement.appendChild(latinput);

    var lnginput=document.createElement('input');
    lnginput.setAttribute('type','hidden');
    lnginput.setAttribute('class','lat');
    lnginput.setAttribute('name','location['+code+'][lng]');
    lnginput.setAttribute('id',identifier+'lng');
    colelement.appendChild(lnginput);

    var mapelement=document.createElement('div');
    mapelement.setAttribute("class",'map-element ');
    mapelement.setAttribute("id",identifier);
    colelement.appendChild(mapinput);
    colelement.appendChild(mapelement);
    document.getElementById("map-section").appendChild(colelement);
    
    var radiusinput=document.createElement('input');
    radiusinput.setAttribute('type','number');
    radiusinput.setAttribute('min',0);
    radiusinput.setAttribute('class','radius');
    radiusinput.setAttribute('name','location['+code+'][radius]');
    radiusinput.setAttribute('placeholder','Radius');
    radiusinput.setAttribute('required','required');
    radiusinput.value=radius;
    colelement.appendChild(radiusinput);

    document.getElementById(identifier+'lat').value = lat;
    document.getElementById(identifier+'lng').value = lng;
    var uluru = {lat: lat, lng: lng};
    map = new google.maps.Map(document.getElementById(identifier), {zoom: 15, center: uluru});
    var marker = new google.maps.Marker({position: uluru, map: map});

    var input = document.getElementById(identifier+'-input');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.setComponentRestrictions({
      'country': code
    });
    autocomplete.addListener('place_changed',function() {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
          window.alert("No details available for input: '" + place.name + "'");
          return;
        }
        document.getElementById(identifier+'lat').value = place.geometry.location.lat();
        document.getElementById(identifier+'lng').value = place.geometry.location.lng();
        var icon = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25)
        };
        // Create a marker for each place.
        var latlng = new google.maps.LatLng(-34.397, 150.644);
        var mapOptions = {
          zoom: 4,
          center: latlng
        }
        map = new google.maps.Map(document.getElementById(identifier), mapOptions);
        new google.maps.Marker({
          map: map,
          title: place.name,
          position: place.geometry.location
        });

        if (place.geometry.viewport) {
          map.fitBounds(place.geometry.viewport);
        } else {
          map.setCenter(place.geometry.location);
          map.setZoom(2);  // Why 17? Because it looks good.
        }
    });
  },
  getLatLong: function(country,map,identifier) {
    geocoder.geocode( { 'address': country}, function(results, status) {
      if (status == 'OK') {
        document.getElementById(identifier+'lat').value = results[0].geometry.location.lat();
        document.getElementById(identifier+'lng').value = results[0].geometry.location.lng();
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
    return location;
  }
}