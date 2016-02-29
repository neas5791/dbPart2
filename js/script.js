$('document').ready(
	function() {
		// get functions library
		$.getScript('js/functions.js');
		// Insert home page into content div
		$('#content').prepend($('<div id="home">').load('include/home.inc.html'));
		// hide the login message
		$('.message').hide();
		// Add smartmenu to navigation bar
		$('.sm').smartmenus({
		    showFunction: function($ul, complete) {
		      $ul.slideDown(250, complete);
		    },
		    hideFunction: function($ul, complete) {
		     $ul.slideUp(250, complete); 
		    }
		  }); // end smartmenu
		// logout click
		$('#logout').click(
			function (event) {
        event.preventDefault();
				//console.log('menu logout pressed');
				logout();
      });
		// menu item 'Part' click event
		$('#part').click(
			function(event) {
				event.preventDefault();
				console.log('#part clicked');
				var url = 'part/part.php'
				var action = 'action=list';
				
				$.getJSON( 	url,
										action,
										part_table_data
									); // end getJSON anonymous function

				return false;
			}); // end click
		// remove any image that is opened by clicking the background
		$('html').on('click',
			function(event) {
				var $overlay = $('#overlay');
				if (event.target == $overlay.get(0)) {
					$overlay.remove();
				}	
			});
		// show login form
		$('#open').click(
			function (event) {
				console.log('#open clicked');
        event.preventDefault();
				// if logged in do a logout
				if ($(this).hasClass('logout')) {
					logout();
        }
				// click to show login form
				else if ($('#login-form').is(':hidden')) {
					// add slideDown effect show login form
          $('#login-form').slideDown(300);
					$(this).addClass('close');
        }
				// click to hide form
				else {
					// add slideUp effect hide form
					$('#login-form').slideUp(300);
					$('.message').fadeOut('slow',
						function() {
							$('.message').empty();
						});
					$(this).removeClass('close');
				}
      });
		// login submitt hijack
		$('.button #login-button').click(
			function(event) {
				event.preventDefault();
				login();
			});
		
		var update_page =
			function (html_input){
				$('#content').empty();
				$('#content').html(html_input);
			};

		$.getScript('js/testing.js');
		$('#addPart').click(
			function(event) {
				test_add_part(event);
				});
		var init =
  function () {
		var url = 'include/access.inc.php';
		var action = 'action=status';
		var _status = false;
		var _name;
		$.post(url, action,
			function (data) {
				console.log(data.authorized);
				_status = data.authorized;
			});
		console.log('_status=');console.log(_status);
		if (_status) {
			$('#open').text('Logout, ').append('<strong>' + data.name + '</strong>');
      $('#login-form').slideUp(300);
			$('.message').fadeOut('slow',
				function() {
					$('.message').empty();
				});
			$('#open').removeClass('close');
			$('#open').addClass('logout');
		}
	};
		init();

}); // end ready