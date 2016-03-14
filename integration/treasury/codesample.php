<?php

// Generator of a treasury request URL as HTML button. PHP example.

const URL = 'https://treasury-sandbox.ipsp.tld/'; // Request target URL
const SALT = 'askdfjlaIAuhahsk9891823912'; // Your site salt

// Signature generator library setup
// Use 'composer install' cli command
require_once 'vendor/autoload.php';
use devcookies\SignatureGenerator;

$signer = new SignatureGenerator(SALT); // Signature generator initialization

// Array of input parameters
$params = array(
	'site_id' => 1,
	'site_login' => 'user',
	'customer_ip' => '127.0.0.1',
	'language' => 'en'
);
$params['signature'] = $signer->assemble($params); // Signature adding

$handle = curl_init(URL);
curl_setopt_array($handle, [
	CURLOPT_HTTPGET => true,
	CURLOPT_URL => URL . "authlink/obtain?" . http_build_query($params),
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_RETURNTRANSFER => true
]);

$response = curl_exec($handle);
$errDescription = curl_error($handle);
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
curl_close($handle);

if ($httpCode !== 200) {
	echo "Error: response code != 200 ($errDescription)";
	exit;
}

$decodedResponse = json_decode($response);
?>

Click this button
<form method="get" action="<?=URL;?>open">
	<input type="hidden" name="key" value="<?=$decodedResponse->key;?>">
	<button type="submit">Send</button>
</form>