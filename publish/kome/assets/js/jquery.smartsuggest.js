/*
 * jQuery Smart Suggest plugin
 * Version 1.0 (10-JAN-2010)
 * @requires jQuery v1.2.3 or later
 *
 * Website: http://jamesskidmore.com
 */

(function($) {
	$.fn.smartSuggest	=	function(options) {
		
		// Define default options.
		var defaults = {
			boxId: '%-suggestions', // % is filled with the field's ID, allowing for multiple Smart Suggests per page
			classPrefix: 'ss-',
			timeoutLength: 300,
			src: '',

			showEmptyCategories: false,
			fillBox: false,
			executeCode: true,
			minChars: 2
		};
		
		// Merge defaults with user-defined options.
		var options = $.extend(defaults, options);
		
		// Get correct box ID
		options.boxId = options.boxId.replace('%', $(this).attr('id'));
		
		// Define other variables.
		var lastQuery = '';

		// Create the wrapper and the suggestion box.
		$(this).wrap('<div class="'+options.classPrefix+'wrap"></div>');
		$(this).attr('autocomplete', 'off');
		$('#footer').after('<ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="'+options.boxId+'" style="display: none;"></ul>');
		var inputObj = $(this);
		var boxObj = $('#'+options.boxId);

		
		// Refresh the suggestion box for every keyup event.
		var timeout = null;
		inputObj.keyup(function(event) {
			
			// If any key but the enter key or tab key was pressed, continue.
			if (event.keyCode != 13 && event.keyCode != 9)
			{
			
				// Get the query (the value of the input field).
				var q = inputObj.val();
				
				// If the query is empty or doesn't meet the minChar requirement, close the box. If not, keep going.
				if (q == '' || q.length < options.minChars)
				{
					boxObj.fadeOut();
					unsetTimeout(timeout);
				}
				else
				{
					// Check the timeout.
					if (timeout != null) {
						unsetTimeout(timeout);
					}
					
					timeout = setTimeout(function() {
												
						// Once the timeout length has passed, continue to refresh the box.
						// Change the input class to the "thinking" state.
						inputObj.addClass(options.classPrefix+'input-thinking');

						// Set the "last query" variable.
						lastQuery = q;

						// Get the JSON data.
						$.getJSON(options.src+"?q="+q, function(data, textStatus) {
							// Check to make sure that the JSON call was a success.
							if (textStatus == 'success') {
								// Create the suggestion HTML.
								var output = "";
								
								// Determine if there is any data in the categories.
								var has_data = false;
								$.each(data, function(i, group) {
									if (group['data'] && group['data'].length > 0)
									{
										has_data = true;
									}
								});
								
								if (has_data) {
									$.each(data, function(i, group) {
										
										if (group['data'].length != 0)
										{
											var limit = group['header']['limit'];
											var count = 0;

											// Run through each of the group items in this group and add them to the HTML.
											//   var fill_code = (options.fillBox) ? 'document.getElementById(\''+inputObj.attr('id')+'\').value = \'%\';' : '';
											$.each(group['data'], function (j, item) {
												if (count < limit)
												{
													// Build the link opening tab.
													// Open the item wrapper DIV and the anchor.
													output += '<li class="ui-menu-item">';
													output += '<a class="item_search" target="_blank" href="' + item['url'] + '">';
													// Create the various HTML elements, including the image, primary text, and secondary text.
													output += '<img width="50" height="60" src="'+item['cover']+'">';
													output += '<p class="colorinfo">';
													output += "<name>" + item['name'] + "</name><br/>";
													output += (item['last_chapter'] != undefined) ? 'Last Chapter: ' + item['last_chapter'] : 'Không Có Chap';
													output += '</p>';

													// Close the item wrapper DIV and the anchor.
													output += '</a></li>';
												}

												count++;
											});
										}
									});
								}

								// Display the new suggestion box.
								boxObj.html(output);
								
								boxObj.css('top', inputObj.offset().top+inputObj.outerHeight());
								boxObj.css('left', inputObj.offset().left);
								boxObj.css('width', inputObj.outerWidth());

								boxObj.fadeIn();
								
								// Change the input class back to the default state.
								inputObj.removeClass(options.classPrefix+'input-thinking');
							}
						});
						
					}, options.timeoutLength);
				}
				
			}
			
		});
		
		
		
		// Whenever the input field is blurred, close the suggestion box.
		inputObj.blur(function() {
			boxObj.fadeOut();
		});
		
		// If the lastQuery variable is equal to what's currently in the input field, show the box. This means that the results will still be valid for what's in the input field.
		inputObj.focus(function(){
			if (inputObj.val() == lastQuery && inputObj.val() != '')
			{
				boxObj.fadeIn();
			}
		});
	};
	
	
	
	function unsetTimeout(timeout)
	{
		clearTimeout(timeout);
		timeout = null;
	};
})(jQuery);