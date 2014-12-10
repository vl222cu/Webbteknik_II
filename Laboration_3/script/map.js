"use strict";

// Mapconstructor
var Map = function(latitude, longitude) {

	this.latitude = latitude;
	this.longitude = longitude;
	this.infoWindow = undefined;
	this.markers = [];
	var mapOptions = {
		center: new google.maps.LatLng (this.latitude, this.longitude),
        zoom: 4
	}

	this.map = new google.maps.Map (document.getElementById('map-canvas'), mapOptions);
};

Map.prototype.setMarker = function(location) {

	var that = this;
	var latLng = new google.maps.LatLng (location.latitude, location.longitude);
	var marker = new google.maps.Marker ({
        position: latLng,
        map: this.map,
    });

	this.markers.push(marker);

    google.maps.event.addListener(marker, 'click', function () {

        that.getInfoWindow(location, marker);
    });
};

Map.prototype.deleteMarkers = function() {

	for (var i = 0; i < markers.length; i++) {
    
    	markers[i].setMap(null);
  	}
  	
	this.markers = [];
}

Map.prototype.getInfoWindow = function(location, marker) {

	if (this.infoWindow !== undefined) {

		this.infoWindow.close();
	}

	var contentString = "<div class='infoWinContent'>" +
		"<h3>" + location.title + "</h3>" +
		"<p>Skapad: " + location.createddate + "</p>" +
		"<p>Trafikinformation: " + location.description + "</p>" +
		"<p>Plats: " + location.exactlocation + "</p>" +
		"</div";

	this.infoWindow = new google.maps.InfoWindow({

        content: contentString,
    });

    this.infoWindow.open(this.map, marker);
} 

/*function initialize() {
  var myLatlng = new google.maps.LatLng(63.0987472, 16.5279964);
  var mapOptions = {
    zoom: 4,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Hello World!'
  });
}

google.maps.event.addDomListener(window, 'load', initialize); */