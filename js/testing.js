//$('#test').click(
//	function(event){
//		test_access_inc_php(event);
//	});
var test_add_part =
  function (event){
		event.preventDefault();
		//$html = $('<div id="addPartDiv>')
		update_page('<p>add part has been called</p>');
		};
var test_access_inc_php =
  function(event){
		event.preventDefault();
		$.ajaxSetup({async: false});
		var url = 'include/access.inc.php';
		// logout
		var action = 'action=logout';
		$.post(url, action,
			function (data) {
				//update_page(data);
				console.log(data);
			});
		// check status
		var action = 'action=status';
		$.post(url, action,
			function (data) {
				//update_page(data);
				console.log(data);
			});
		// login
		var action = 'action=login&username=neas&password=password';
		$.post(url, action,
			function (data) {
				if (data.authorized) {
					console.log('bool worked');
				}
				//update_page(data);
				console.log(data);
			});
		// check status again
		var action = 'action=status';
		$.post(url, action,
			function (data) {
				//update_page(data);
				console.log(data);
			});
  };
$('#login_status').click(
	function(event){
		event.preventDefault();
		var url = 'include/access.inc.php';
		var action = 'action=status';
		$.post(url, action,
			function (data) {
				//update_page(data);
				console.log(data);
			});
	});

var init =
  function () {
		var url = 'include/access.inc.php';
		var action = 'action=status';
		var _status;
		var _name;
		$.post(url, action,
			function (data) {
				console.log(data);
				_status = data.authorized;
			});

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