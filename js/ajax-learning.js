				$.getJSON('json_encoded_array.php',
					function(data) {
						/* data will hold the php array as a javascript object */
						$.each(data,
							function(key, val) {
								$('#table').append('<p class="new_list" id="' + key + '">' + val.first_name + ' ' + val.last_name + ' ' + val.email + ' ' + val.age + '</p>');
							} // end anonymous function
						); // end each
					} // end anonymous function
				); // end getJSON