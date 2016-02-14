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
		<script type="text/javascript" src="js/script.js"></script>

	</head>
	<body>
		<div id="wrapper">
			<!-- include the navigation bar -->
			<div id="nav"><?php include 'include/navigation.inc.html'; ?></div>
			<div id="content">
				<p>Welcome to the Transcrete Production database.<br>Please login to access.</p>
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
			<form>
				<p>
					<label for="username">Username:</label>
					<input type="text" name="username" id="username">
				</p>
				<p>
					<label for="password">Password: </label>
					<input type="text" name="password" id="password">
				</p>
				<p class="button">
					<input type="submit" name="button" id="button" value="Submit" >
				</p>
			</form>
			</div>
		</div>
	</body>
</html>