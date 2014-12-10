"use strict";

var TrafficInfo = {

	map : undefined,
	categoryType : 4,
	locations : [],

	init: function() {

		TrafficInfo.map = new Map(62.00, 15.00);
		TrafficInfo.categoryBinding();
		TrafficInfo.getAllMessages();
	},

	categoryBinding: function() {

		var that = this;

		$("#categoryType").on("click", "a", function() {

			TrafficInfo.map.deleteMarkers();
			that.categoryType = parseInt($(this).data("category-type"));
			that.renderCategoryTypeToList();
		});
	},

	getAllMessages: function() {

		$(document).ready(function () {

			$.ajax({

				type: "GET",
				url: "src/AjaxHandler.php",
				dataType : "json",
				data: { "action": "getAll"}

			}).done(function(data) {

				var messages = data["messages"];
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
	},

	renderCategoryTypeToList : function() {

		var that = this;
		var trafficListing = "";

		for(var i = 0; i < this.locations.length; i++) {

			var locationByCategory = this.locations[i];			

			if(this.categoryType === 4 || this.categoryType === locationByCategory.category) {

				trafficListing += "<li>" +  locationByCategory.title + "</li>";
;
				TrafficInfo.map.setMarker(locationByCategory);
				
			}
		}
		$('#trafficListing').html(trafficListing);
	},
}
window.onload = TrafficInfo.init;

