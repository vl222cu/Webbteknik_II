"use strict";

var TrafficInfo = {

	map : undefined,
	categoryType : 4,
	msgId : 0,
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

		$("#trafficListing").on("click", "a", function(){
   			var msgIndex = parseInt($(this).data('message-id'));
   			google.maps.event.trigger(that.map.markers[msgIndex], 'click');
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
			TrafficInfo.map.setMarker(location);
			this.locations.push(location);
		}
	},

	renderCategoryTypeToList : function() {

		var that = this;
		var trafficListing = "";

		for(var i = 0; i < this.locations.length; i++) {

			var locationByCategory = this.locations[i];			

			if(this.categoryType === 4 || this.categoryType === locationByCategory.category) {

				TrafficInfo.map.setMarker(locationByCategory);
				var msgId = TrafficInfo.map.markers.length - 1;
				trafficListing += '<li>' + '<a href="#" data-message-id="'+ msgId +'">' +  locationByCategory.title + '</a>' + '</li>';
			}
		}
		$('#trafficListing').html(trafficListing);
	},
};

google.maps.event.addDomListener(window, 'load', function() {

	TrafficInfo.init();
});
