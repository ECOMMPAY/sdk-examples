<?php

const URL = 'https://terminal-sandbox.ecommpay.com/';

// Интеграция через терминал

// Генератор подписей брать здесь: https://github.com/com-devcookies/signgen
require_once(dirname(__FILE__) . '/devcookies/SignatureGenerator.php'); //Подключение библиотеки генерации подписи
use devcookies\SignatureGenerator;

$salt = 'askdfjlaIAuhahsk9891823912'; //Salt ("соль") сайта
$signer = new SignatureGenerator($salt); // Инициализация генератора подписи

$params = array( //Массив с передаваемыми параметрами
	'site_id' => '1',
	'amount' => '1000',
	'currency' => 'RUB',
	'external_id' => 'TEST_12345677',
//	'success_url' => 'http://www.example.com/success',
//	'decline_url' => 'http://www.example.com/decline',
//	'callback_method' => 2,

);
$params['signature'] = $signer->assemble($params); //Добавление подписи

//Если у вас настроены какие-либо из перечисленных ниже неподписываемых параметров,
//их добавлять здесь

$unsigned = array(
//	'email' => 'sherlock@example.com',
//	'billing_country' => 'GB',
//	'billing_region' => 'GB-LND',
//	'billing_city' => 'London',
//	'billing_address' => '221B Baker street',
//	'billing_postal' => 'NW1NW1',
//	'billing_phone' => '+7-100-200-30-40',
);

$params = array_merge($params, $unsigned);

//Вариант с GET-запросом
$url = URL .'?'. http_build_query($params);
echo "<button onclick=\"location.href='{$url}';\">Отправить</button>";

//Вариант с POST-запросом, если количество передаваемых данных больше 2kb, GET-запрос может не рабоать в IE
?>
<form method="post" action="<?=URL;?>">
<?php foreach ($params as $name => $value): ?>
	<input type="hidden" name="<?=$name; ?>" value="<?=$value;?>">
<?php endforeach;?>
	<button type="submit">Отправить</button>
</form>