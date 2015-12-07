<?php

// Пример PHP кода, формирующего url запроса на терминал с выводом его в html button

const URL = 'https://terminal-sandbox.ipsp.tld/'; // URL, на который шлём запрос
const SALT = 'askdfjlaIAuhahsk9891823912'; // Salt ("соль") сайта

// Подключение библиотеки генерации подписи
// воспользуйтесь командой composer install
require_once 'vendor/autoload.php';
use devcookies\SignatureGenerator;

$signer = new SignatureGenerator(SALT); // Инициализация генератора подписи

// Массив с передаваемыми параметрами, за исключением неподписываемых
$params = array(
	'site_id' => '1',
	'amount' => '1000',
	'currency' => 'RUB',
	'external_id' => 'TEST_12345677',
);
$params['signature'] = $signer->assemble($params); // Добавление подписи

// Если у вас в настройках сайта исключены из подписи какие-либо из перечисленных ниже параметров,
// их добавлять здесь. Уточните этот момент у технической поддержки
$unsigned = array(
//	'email' => 'sherlock@example.com',
//	'billing_country' => 'GB',
//	'billing_region' => 'GB-LND',
//	'billing_city' => 'London',
//	'billing_address' => '221B Baker street',
//	'billing_postal' => 'NW1NW1',
//	'billing_phone' => '4952003040'
);

$result = array_merge($params, $unsigned);

// Выберите один из двух приведенных ниже вариантов

// Вариант с GET-запросом
$url = URL .'?'. http_build_query($result);
echo "<button onclick=\"location.href='{$url}';\">Отправить</button>";

// Вариант с POST-запросом,
// если количество передаваемых данных >2kb, GET-запрос может не работать в IE
?>
<form method="post" action="<?=URL;?>">
<?php foreach ($result as $name => $value): ?>
	<input type="hidden" name="<?=$name; ?>" value="<?=$value;?>">
<?php endforeach;?>
	<button type="submit">Отправить</button>
</form>