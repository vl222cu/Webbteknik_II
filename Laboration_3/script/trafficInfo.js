"use strict";

var TrafficInfo = {

	map : undefined,
	locations : [],
	allCategories : [],
	roadTraffic : [],
	publicTransport : [],
	plannedDisruption : [],
	otherCategories : [],

	init: function() {

		TrafficInfo.map = new Map(62.00, 15.00);

		$("#categoryType").on('click', 'a', function() {

			TrafficInfo.map.deleteMarkers();
		});

		TrafficInfo.getAllMessages();
	},

	getAllMessages: function() {

		$(document).ready(function () {
		$.ajax({
			type: "GET",
			url: "src/AjaxHandler.php",
			data: { "action": "getAll"}
			}).done(function(data) {
				var messages = $.parseJSON(data);
				TrafficInfo.renderMessages(messages);

			}).fail(function (jqXHR, textStatus) {

				console.log("Läsfel, status: " + textStatus);
			});
		});
	},

	renderMessages: function(messages) {

		for(var i = 0; i < messages.length; i++){

			var location = messages[i];
			location.marker = TrafficInfo.map.setMarker(location);
			this.locations.push(location);
		}
	}

}
window.onload = TrafficInfo.init;

