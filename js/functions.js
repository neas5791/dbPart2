	var init = function () {};
  // construct table using JSON data returned from server
  var part_table_data =
    function (data) {
      part_table_header(data);
      // remove contents of table body
      $('tbody').empty();
      // add new data contents to table
      $.each( data,
        function(key, value) {
          //console.log(key);
          //console.log(value);
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
      part_image_click();
  };// end table_data
  // construct table header (columns) based on name of JSON keys
  var part_table_header =
    function (data) {
			if (data.length == 0) {
				return false;
			}
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
  }
  // add image to table click content
  var part_image_click =
    function () {
      $('.img-click').click(
        function (event) {
					console.log('.img-click tr clicked');
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
      //console.log('running display image');
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
	// logout function
	var logout =
		function () {
			var url = ('include/access.inc.php');
			var action = 'action=logout';
			$.post(url, action,
				function (data) {
					//update_page(data);
					console.log(data);
					// change the text back to login and remove
					// logout class. AJAX content window with home template html
					$('#open').text('Login').removeClass('logout');
					// Insert home page into content div
					
					$('#content')
						.empty()
						.prepend(
							$('<div id="home">').load('include/home.inc.html')
						);
				});
      //$.get('include/access.inc.php', 'action=logout');
    };
	// execute the login process
	// changes state
	var login =
		function () {
			var url = 'include/access.inc.php'
			var action = 'action=login&' + $('#login-form').serialize();
			
			$.post( url, action,
        function (data) {
					// check login resulted successfully
					if ( data.authorized === true ) {
            $('#open').text('Logout, ').append('<strong>' + data.name + '</strong>');
            $('#login-form').slideUp(300);
            $('.message').fadeOut('slow',
              function() {
                $('.message').empty();
              });
            $('#open').removeClass('close');
            $('#open').addClass('logout');
          }
          else {
            // output error message to login form
            $('.message').text(data.message).slideDown();
          }
        });
		};
	// checks status of current session
	// and sets out page stae
	var status =
		function () {
      $.getjson('include/access.inc.php', 'action=status',
        function(data) {
          if (data['authorized'] == 'true') {
            $('#open').text('Logout '+ data['firstname']);
            $('#open').removeClass('close');
            $('#open').addClass('logout');
          }
        });
    };    