<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Transcrete dbPart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="smartmenus/sm-core-css.css">
		<link rel="stylesheet" href="smartmenus/sm-simple.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="smartmenus/jquery.smartmenus.min.js"></script>
		<!--<script type="text/javascript" src="include/functions.js"></script>-->
		<script type="text/javascript" src="js/script.js"></script>

	</head>
	<body>
		<div id="wrapper">
			<!-- include the navigation bar -->
			<div id="nav"><?php include 'include/navigation.inc.html'; ?></div>
			<div id="content">
<!--				<h2>Welcome to the Transcrete Production Database.<br></h2>
				<p><br>Please <strong>login</strong> to access.</p>-->
				<div id="filter"></div>
				<div id="table">
					<div id="data-table">
						<table>
							<thead></thead>
							<tbody></tbody>
						</table>
					</div>
					<div id="image-panel"></div>
				</div>
			</div>
			<div id="footer"></div>
			<div id="login">
			<a href="form.html"><p id="open">Login</p></a>
			<form id='login-form'>
				<p>
					<label for="username">Username:</label>
					<input type="text" name="username" id="username" value="neas">
				</p>
				<p>
					<label for="password">Password: </label>
					<input type="password" name="password" id="password" value="password">
				</p>
				<p class="message"></p>
				<p class="button">
					<input type="submit" name="action" id="button" value="login" >
				</p>
			</form>
			</div>
		</div>
	</body>
</html>