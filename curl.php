<?php
session_start();


class paypal_connect{

	public static  $clientId = "Your-client-id";
	public static  $secret = "Your-secret";
	public static  $return_url = "your return url";

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///  get access token
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function get_access_token(){
		$requestData = '?grant_type=authorization_code&code='.$_GET['code'].'&return_url='.self::$return_url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/identity/openidconnect/tokenservice".$requestData);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, self::$clientId.":".self::$secret);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=grant_type=authorization_code");
		$result = curl_exec($ch);
		if(empty($result))die("Error: No response.");
		else
		{
			$json = json_decode($result);
			curl_close($ch);
			$token = $json->access_token;
			$_SESSION['token'] = $token;
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///  get users information, and put it into session
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function get_user_info(){
		$url = "https://api.sandbox.paypal.com/v1/identity/openidconnect/userinfo/?schema=openid";
		$headers = array('Authorization: Bearer '. $_SESSION['token']);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$output = curl_exec($ch);
		curl_close($ch);
		$info = json_decode($output, true);

		$_SESSION['user'] = array (
			"email"                 => $info['email'],
			"name"            		=> $info['name'],
			"language"              => $info['language'],
			"phone_number"          => $info['phone_number'],
			"street_address"        => $info['address']['street_address'],
			"locality"              => $info['address']['locality'],
			"region"                => $info['address']['region'],
			"postal_code"           => $info['address']['postal_code'],
			"country"               => $info['address']['country'],
			"account_type"          => $info['account_type'],
			"verified_account"      => $info['verified_account'],
			"account_creation_date" => $info['account_creation_date'],
			"age_range"             => $info['age_range'],
			"birthdate"             => $info['birthdate'],
			"zoneinfo"              => $info['zoneinfo'],
		);

//		return $info;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///  uncoment from get_user_info() - retunr $info, and manage this data
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function manage_user_info(){
		// self::get_user_info();
		// insert data into db or another actions
	}

}

paypal_connect::get_access_token();
paypal_connect::get_user_info();
//paypal_connect::manage_user_info();






?>

<!DOCTYPE html>
<html>
<head>
	<title>logged</title>
</head>
<body>

<p>Welcome:  <?php echo $_SESSION['user']['name']; ?>  <a href="<?php echo "logout.php"?>">logout</a> </p>

<hr>
<h3>Your profile:</h3>
<p>Name: <b><?php echo $_SESSION['user']['name']; ?></b></p>
<p>Email: <b><?php echo $_SESSION['user']['email']; ?></b></p>
<p>Language: <b><?php echo $_SESSION['user']['language']; ?></b></p>
<p>Phone: <b><?php echo $_SESSION['user']['phone_number']; ?></b></p>
<p>Street address: <b><?php echo $_SESSION['user']['street_address']; ?></b></p>
<p>Locality: <b><?php echo $_SESSION['user']['locality']; ?></b></p>
<p>Region: <b><?php echo $_SESSION['user']['region']; ?></b></p>
<p>Postal code: <b><?php echo $_SESSION['user']['postal_code']; ?></b></p>
<p>Country: <b><?php echo $_SESSION['user']['country']; ?></b></p>
<p>Acc type: <b><?php echo $_SESSION['user']['account_type']; ?></b></p>
<p>Verified_account: <b><?php echo $_SESSION['user']['verified_account']; ?></b></p>
<p>Account_creation_date: <b><?php echo $_SESSION['user']['account_creation_date']; ?></b></p>
<p>Age_range: <b><?php echo $_SESSION['user']['age_range']; ?></b></p>
<p>Birthdate: <b><?php echo $_SESSION['user']['birthdate']; ?></b></p>
<p>Zoneinfo: <b><?php echo $_SESSION['user']['zoneinfo']; ?></b></p>
<p></p>
</body>
</html>

