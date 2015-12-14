<?php

// Generator of a terminal request URL as HTML button. PHP example.

const URL = 'https://terminal-sandbox.ipsp.tld/'; // Request target URL
const SALT = 'askdfjlaIAuhahsk9891823912'; // Your site salt

// Signature generator library setup
// Use 'composer install' cli command
require_once 'vendor/autoload.php';
use devcookies\SignatureGenerator;

$signer = new SignatureGenerator(SALT); // Signature generator initialization

// Array of input parameters
$params = array(
	'site_id' => '1',
	'amount' => '1000',
	'currency' => 'RUB',
	'external_id' => 'TEST_12345677',
);
$params['signature'] = $signer->assemble($params); // Signature adding

// Choose one of two options below

// GET-request option. May not work in IE with more than 2kb transfered data
$url = URL .'?'. http_build_query($params);
echo "<button onclick=\"location.href='{$url}';\">Send</button>";

// POST-request option
?>
<form method="post" action="<?=URL;?>">
<?php foreach ($params as $name => $value): ?>
	<input type="hidden" name="<?=$name; ?>" value="<?=$value;?>">
<?php endforeach;?>
	<button type="submit">Send</button>
</form>