<!DOCTYPE html>
<html>
<head>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<title>Login with PayPal - Demo App</title>

	<style type="text/css">
	body {
	text-align: center;
		}
	</style>
</head>
<body>
<h1>Login with PayPal </h1>


<hr/>

<span id='myContainer'></span>
<script src='https://www.paypalobjects.com/js/external/api.js'></script>
<script>
paypal.use( ['login'], function (login) {
	login.render ({
			"appid":"Your client id",
			"authend":"sandbox",
			"scopes":"openid profile email https://uri.paypal.com/services/paypalattributes address phone",
			"containerid":"myContainer",
			"locale":"en-us",
			"returnurl":"Your return url"
		});
	});
</script>
</body>
</html>