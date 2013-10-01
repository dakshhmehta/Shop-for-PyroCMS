/*
 * Copyright 2013 Inspiredgroup.com.au
 * 
 * Description:  	This file contains thefunctions that are required
 *					to load the Bing Maps widget in the Admin area.
 *
 *
 *
 *
 */

		function ClickGeocode(credentials)
		 {
			map.getCredentials(MakeGeocodeRequest);
		 }

		 function MakeGeocodeRequest(credentials)
		 {

			var geocodeRequest = "http://dev.virtualearth.net/REST/v1/Locations?query=" + encodeURI(document.getElementById('txtQuery').value) + "&output=json&jsonp=GeocodeCallback&key=" + credentials;

			CallRestService(geocodeRequest);
		 }

		 function GeocodeCallback(result) 
		 {
			//alert("Found location: " + result.resourceSets[0].resources[0].name);

			if (result &&
				   result.resourceSets &&
				   result.resourceSets.length > 0 &&
				   result.resourceSets[0].resources &&
				   result.resourceSets[0].resources.length > 0) 
			{
			   // Set the map view using the returned bounding box
			   var bbox = result.resourceSets[0].resources[0].bbox;
			   var viewBoundaries = Microsoft.Maps.LocationRect.fromLocations(new Microsoft.Maps.Location(bbox[0], bbox[1]), new Microsoft.Maps.Location(bbox[2], bbox[3]));
			   map.setView({ bounds: viewBoundaries});

			   // Add a pushpin at the found location
			   var location = new Microsoft.Maps.Location(result.resourceSets[0].resources[0].point.coordinates[0], result.resourceSets[0].resources[0].point.coordinates[1]);
			   var pushpin = new Microsoft.Maps.Pushpin(location);
			   map.entities.push(pushpin);
			}
		 }

		 function CallRestService(request) 
		 {
			var script = document.createElement("script");
			script.setAttribute("type", "text/javascript");
			script.setAttribute("src", request);
			document.body.appendChild(script);
		 }
				 
		 function createSearchManager() 
		  {
			  map.addComponent('searchManager', new Microsoft.Maps.Search.SearchManager(map)); 
			  searchManager = map.getComponent('searchManager'); 
		  }
		  function LoadSearchModule()
		  {
			Microsoft.Maps.loadModule('Microsoft.Maps.Search', { callback: searchRequest })
		  }
		  function searchRequest() 
		  { 
			createSearchManager(); 
			var userData = { name: 'sal', id: 'XYZ' }; 
			var query = 'hotels in melbourne australia'; 
			var request = 
				{ 
					query: query, 
					count: 10, 
					startIndex: 0, 
					bounds: map.getBounds(), 
					callback: search_onSearchSuccess, 
					errorCallback: search_onSearchFailure, 
					userData: userData 
				}; 
			searchManager.search(request); 
		  } 
		  function search_onSearchSuccess(result, userData) 
		  { 
			map.entities.clear(); 
			var searchResults = result && result.searchResults; 
			if (searchResults) { 
				for (var i = 0; i < searchResults.length; i++) { 
					search_createMapPin(searchResults[i]); 
				} 
				if (result.searchRegion && result.searchRegion.mapBounds) { 
					map.setView({ bounds: result.searchRegion.mapBounds.locationRect }); 
				} 
				else 
				{ 
					alert('No results returned, Please try after sometime.'); 
				} 
			} 
		  } 
		  function search_createMapPin(result) 
		  { 
			if (result) { 
				var pin = new Microsoft.Maps.Pushpin(result.location, null); 
				Microsoft.Maps.Events.addHandler(pin, 'click', function () { search_showInfoBox(result) }); 
				map.entities.push(pin); 
			} 
		  } 
		  function search_showInfoBox(result) 
		  { 
			if (currInfobox) { 
				currInfobox.setOptions({ visible: true }); 
				map.entities.remove(currInfobox); 
			} 
			currInfobox = new Microsoft.Maps.Infobox( 
				result.location, 
				{ 
					title: result.name, 
					description: [result.address, result.city, result.state, result.country, result.phone].join(' '), 
					showPointer: true, 
					titleAction: null, 
					titleClickHandler: null 
				}); 
			currInfobox.setOptions({ visible: true }); 
			map.entities.push(currInfobox); 
		  } 
		  function search_onSearchFailure(result, userData) 
		  { 
			alert('Search failed'); 
		  } 