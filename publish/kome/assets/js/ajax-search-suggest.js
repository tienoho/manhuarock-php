/*
Demo: AJAX Search Suggest (WeAreHunted.com Style)
Version 1.0
Author: Ian Lunn
Author URL: http://www.ianlunn.co.uk/
Demo URL: http://www.ianlunn.co.uk/demos/ajax-search-suggest-wearehunted/
Tutorial URL: http://www.ianlunn.co.uk/blog/code-tutorials/ajax-search-suggest-wearehunted/
GitHub: https://github.com/IanLunn/AJAX-Search-Suggest--WeAreHunted.com-Style-/

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/

jQuery(window).bind("load", function() {
	
	//save selectors we'll be using more than once into variables for better performance
	var $hiddenSearch = jQuery("#hidden-search"),
		$displaySearch = jQuery("#display-search"),
		$searchOverlay = jQuery("#search-overlay"),
		$artistsList = jQuery("#artists");

	jQuery("#search").on('click',function(){ //when the search link is clicked...
		$searchOverlay.show(); //show the search overlay
		$hiddenSearch.focus(); //give the hidden input box focus
	});
	
	$searchOverlay.on('click',function(event){ //when the search overlay is clicked...
		$hiddenSearch.focus(); //give the hidden input box focus
		if(event.target.id == "search-overlay" || event.target.id == "close"){ //...only if the user is clicking the empty areas of the overlay (and not child elements)...
			$hiddenSearch.blur(); //remove focus from the hidden input
			jQuery(this).animate({"opacity": 0}, 500, function(){ //...animate it's opacity to 0...
				jQuery(this).hide().css("opacity", 1); //...hide it (so the user can click the elements behind it again) and reset its opacity
			});
		}
	});
		
	//when the user pushes a key whilst the input box has focus...
	$hiddenSearch.keydown(function(e){
		let currentQuery = $displaySearch.val(); //get the current value of the search input
		let latestQuery;
		if (e.keyCode == 8) { //if the user hits backspace...

			latestQuery = currentQuery.substring(0, currentQuery.length - 1); //...remove the last character
			$displaySearch.val(latestQuery); //...update the search input box
			updateResults(latestQuery); //...update the results

		} else if (e.keyCode == 32 || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 48 && e.keyCode <= 57)) { //if the user hits spacebar (32), characters a - z (65 - 90) or numeric keys(0 - 9)...
			latestQuery = currentQuery + String.fromCharCode(e.keyCode); //...add the newly entered key onto the current query
			$displaySearch.val(latestQuery); //...update the search input value with the latest query
			updateResults(latestQuery); //...update the results
		}
	});
	
	function updateResults(latestQuery){
		if(latestQuery.length > 0){ //if there is a query to process...
			jQuery.post("controllers/auto-suggest.php", {latestQuery: latestQuery}, function(data){ //..send that query to the php script "auto-suggest.php" via ajax

				let previousTerms;
				let keepTerms;
				let url;
				if (data.length > 0) { //if the php script returns a result...
					data = jQuery.parseJSON(data); //turn the string from the PHP script into a JavaScript object
					jQuery("#artists li").remove(":contains('No results')"); //remove the "No results" text if it's being displayed
					jQuery("#results").show(); //show the results container

					previousTerms = []; //set up an array that will hold the terms currently being displayed
					jQuery("#artists li").each(function () { //for each result currently being displayed...
						previousTerms.push(jQuery(this).text()); //add it to the previousTerms array
					});

					keepTerms = [];

					for (let term in data) { //for each matched term in the returned data...
						url = data[term]; //get the url for the matched term;
						if (jQuery.inArray(term, previousTerms) === -1) { //if this term isn't in the previous list of terms (and isn't already being displayed)...
							$artistsList.prepend('<li><a href="' + url + '" title="' + term + '">' + term + '</a></li>');
						} else { //if it is in the previous list...
							keepTerms.push(term); //add the term we want to keep to an array
						}
					}

					if (data == "" || (keepTerms.length == 0 && (previousTerms.length != 0 || $displaySearch.val() == ""))) {
						$artistsList.html("<li>No results</li>");
					} else {
						for (let term in previousTerms) { //for each term in the displayed list...
							if (jQuery.inArray(previousTerms[term], keepTerms) === -1) {
								jQuery("#artists li").filter(function () {
									return jQuery(this).text() == previousTerms[term]
								}).remove();
							}
						}
					}
				}
			});
		}else{
			$artistsList.html("<li>No results</li>");
		}
	}
});