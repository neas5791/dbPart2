$('document').ready(
	function() {
		// Add smartmenu to navigation bar
		$('.sm').smartmenus({
		    showFunction: function($ul, complete) {
		      $ul.slideDown(250, complete);
		    },
		    hideFunction: function($ul, complete) {
		     $ul.slideUp(250, complete); 
		    }
		  }); // end smartmenu
		// menu item 'Part' click event
		$('#part').click(
			function(event) {
				event.preventDefault();
				console.log('part menu selected');
				var url = 'part/part.php'
				var action = { action: 'list' };
				//$.getJSON( url,
				//					 action,
				//					 function (data) {
				//						 $.each( data,
				//							 function(key, val) {
				//								 //console.log(key);
				//								 //console.log(val);
				//								 $('#table').append('<p id="' + key + '">' + val.PID + ' ' + val.DESCRIPTION + ' ' + val.IMAGE + ' ' + '</p>');
				//						 }); // end each
				//					 }
				//					); // end getJSON anonymous function
				$.getJSON( url,
									 action,
									 table_data
									);
				return false;
			}); // end click
		// construct table using JSON data returned from server
		var table_data =
			function (data) {
				table_header(data);
				// remove contents of table body
				$('tbody').empty();
				// add new data contents to table
				$.each( data,
					function(key, value) {
						console.log(key);
						console.log(value);
						var row = '<tr class="clickable-row" value="'+ value.PID +'" data-href="/img/'+ value.PID +'.jpg" >';
						row += '<td class="edit"><input type="radio" value="' + value.PID + '" name="edit"></input></td>';
						row += '<td>' + value.PID + '</td>';
						row += '<td class="img-click">' + value.DESCRIPTION + '</td>';
						row += '<td class="img-click">' + value.DRAWING + '</td>';
						row += '<input type="hidden" value="'+value.IMAGE +'"></input></tr>';
						$('tbody').append(row);
					} // end anonymous function
				); // end each
				table_format();
		};// end table_data
		// construct table header (columns) based on name of JSON keys
		var table_header =
			function (data) {
				var keys =[];
				var obj = data[0];
				// extract all of the objects keys
				for (var k in obj) {
					keys.push(k);
				}
				// slice off the integer key values
				keys = keys.slice( keys.length/2, keys.length);
				var row = '<tr id="head">';
				row += '<th class= "edit" id="clickme"></th>';
				row += '<th>'+ keys[0] +'</th>';
				row += '<th>'+ keys[1] +'</th>';
				row += '<th>'+ keys[3] +'</th>';
				row += '</tr>';
				$('thead').replaceWith(row);
			}; // end table_header
		// add various css and events to data table
		var table_format =
			function () {
				// add alternating backgound colour to table
				$('tr:even').addClass('zebra');
				// add hover effect
				$('tr:not(#head)').hover( 
					function() {
						$(this).addClass("zebrahover");
					}, // end function mouse over
					function() {
						$(this).removeClass("zebrahover");
					} // end function mouse out
				); // end hover
				
				$('.img-click').click(
					function (event) {
						var $tr_parent = $(this).parent('tr');
						var value = $tr_parent.attr('value'); // works gives me the value only
				
						// Jquery: Missing Manual edition 3 Chapter 7 Basic Light-box
						var imgPath, newImage;
						// create HTML for new image, set opacity
						// also callback for when image loads
						$img = $('<img src="/img/' + $(this).siblings('input').val() +'">').css('opacity',0).load(displayImage);
						//don't follow link
						event.preventDefault();
						//don't let event go up page
						event.stopPropagation();
					}
				); // end click
      }
		// display image in floating div (foreground)
		var displayImage =
			function () {
				console.log('running display image');
				// add overlay
				$('<div id="overlay"><div id="photo"></div></div>').prependTo('body');
				// select photo div
				$photoDiv = $('#photo');
				//add to the #photo div
				$photoDiv.append($img);	
				
				// position image
					$photoDiv.css({marginLeft : ($img.outerWidth()/2) * -1, marginTop : ($img.outerHeight()/2) * -1});
					//fade in new image
				$img.animate({opacity: 1}, 1000);
			}
		// remove any image that is opened by clicking the background
		$('html').on('click',
			function(event) {
				var $overlay = $('#overlay');
					if (event.target == $overlay.get(0)) {
						$overlay.remove();
					}	
			}
		);
	}
); // end ready