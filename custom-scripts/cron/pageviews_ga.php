<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

define('LOG_FILENAME', $_SERVER["DOCUMENT_ROOT"]."/custom-scripts/log.txt");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

AddMessage2Log('Скрипт выполнен cron', 'pageviews_ga.php');

CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");
CModule::IncludeModule("main");

// Загрузка клиентской библиотеки PHP для Google API.
$analytics = initializeAnalytics();
$response1 = getLastTwoDays($analytics, '21409934');
$response2 = getLastMonth($analytics, '21409934');
printResultsTwoDays($response1);
printResultsMonth($response2);

function initializeAnalytics()
{
    // Creates and returns the Analytics Reporting service object.

    // Use the developers console and download your service account
    // credentials in JSON format. Place them in this directory or
    // change the key file location if necessary.
    $KEY_FILE_LOCATION = $_SERVER["DOCUMENT_ROOT"].'/bitrix/php_interface/include/service-account-credentials.json';

    // Create and configure a new client object.
    $client = new Google_Client();
    $client->setApplicationName("Hello Analytics Reporting");
    $client->setAuthConfig($KEY_FILE_LOCATION);
    $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
    $analytics = new Google_Service_Analytics($client);

    return $analytics;
}

function getLastTwoDays($analytics, $profileId) {
	// Вызов Core Reporting API и отправка запроса о количестве сессий
	// за последние семь дней.
	return $analytics->data_ga->get(
		'ga:' . $profileId,
		'yesterday',
		'today',
		'ga:pageViews',
		array(
			'dimensions'=>'ga:pagePath',
			'sort'=>'-ga:pageviews',
			'filters'=>'ga:pagePath=~^/catalog/([a-zA-Z0-9]+)/([0-9]+)/index.php$',
			'max-results'=>'20000'

		)
	);
}

function getLastMonth($analytics, $profileId) {
	// Вызов Core Reporting API и отправка запроса о количестве сессий
	// за последние семь дней.
	return $analytics->data_ga->get(
		'ga:' . $profileId,
		'15daysAgo',
		'today',
		'ga:pageViews',
		array(
			'dimensions'=>'ga:pagePath',
			'sort'=>'-ga:pageviews',
			'filters'=>'ga:pagePath=~^/catalog/([a-zA-Z0-9]+)/([0-9]+)/index.php$',
			'max-results'=>'20000'

		)
	);
}

function printResultsTwoDays($results) {

	$arFilter = Array('PROPERTY_best_seller' => 285, "IBLOCK_ID"=>4);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), array("ID"));
	$addViews[] = 1;

	while ($ob = $res->GetNext()) {
		$addViews[] = $ob["ID"];
	}

  // Синтаксический анализ ответа Core Reporting API с выводом
  // имени профиля и общего количества сессий.
  if (count($results->getRows()) > 0) {

    // Получение имени профиля.
    $profileName = $results->getProfileInfo()->getProfileName();

    // Получение значения первой записи в первом ряду.
    $rows = $results->getRows();
    //$result = $rows[0][0];
    // Вывод результатов.
    //print "<p>First view (profile) found: $profileName</p>";
    //print "<p>Total sessions: $result</p>";
	$table = array();
	$already = array();
	$already[] = 'start';
	foreach ($rows as $row) {
		$subject = $row[0];
		$pattern = '/([0-9]{3,7})/';
		preg_match($pattern, $subject, $matches);
		if (!array_search($matches[0], $already)) {
			$table[$matches[0]]['url'] = $row[0];
			$table[$matches[0]]['views'] = $row[1];
			$table[$matches[0]]['id'] = $matches[0];
			$already[] = $matches[0];
		} else {
			$table[$matches[0]]['views'] += $row[1];
		}
	}

	foreach ($table as $book) {
		if ($book['id'] > 0) {
			$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "ID" => $book['id']);

			$props = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
			while ($oneb = $props->GetNext()) {
				if(array_search($oneb["ID"], $addViews))
					$views = round($book['views']*2.4);
				else
					$views = round($book['views']*1.8);


				/*if ($oneb["ID"] == 384889) //Книге Overview поднимаем рейтинг
					$views += 302;*/


				echo $book['id'].' '.$oneb["ID"].' '.$book['url'].' '.$book['views'].'<br />';
				CIBlockElement::SetPropertyValuesEx($oneb["ID"], 4, array('page_views_ga' => $views));
			}
		}
	}
  }
}

function printResultsMonth($results) {
  // Синтаксический анализ ответа Core Reporting API с выводом
  // имени профиля и общего количества сессий.
  if (count($results->getRows()) > 0) {

    // Получение имени профиля.
    $profileName = $results->getProfileInfo()->getProfileName();

    // Получение значения первой записи в первом ряду.
    $rows = $results->getRows();
    //$result = $rows[0][0];
    // Вывод результатов.
    //print "<p>First view (profile) found: $profileName</p>";
    //print "<p>Total sessions: $result</p>";
	$table = array();
	$already = array();
	$already[] = 'start';
	foreach ($rows as $row) {
		$subject = $row[0];
		$pattern = '/([0-9]{3,7})/';
		preg_match($pattern, $subject, $matches);
		if (!array_search($matches[0], $already)) {
			$table[$matches[0]]['url'] = $row[0];
			$table[$matches[0]]['views'] = $row[1];
			$table[$matches[0]]['id'] = $matches[0];
			$already[] = $matches[0];
		} else {
			$table[$matches[0]]['views'] += $row[1];
		}
	}

	foreach ($table as $book) {
		if ($book['id'] > 0) {
			$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "ID" => $book['id']);

			$props = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
			while ($oneb = $props->GetNext()) {
				$views = $book['views'];
				echo $book['id'].' '.$oneb["ID"].' '.$book['url'].' '.$book['views'].'<br />';
				CIBlockElement::SetPropertyValuesEx($oneb["ID"], 4, array('shows_a_day' => $views));
			}
		}
	}
  }
}

//Обновляем свойство "Desirability"
$arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "!PROPERTY_STATE"=>23);
$res = CIBlockElement::GetList(Array("PROPERTY_page_views_ga" => "DESC"), $arFilter, false, Array("nPageSize"=>700));

while ($ob = $res->GetNext()){
	CIBlockElement::SetPropertyValuesEx($ob[ID], CATALOG_IBLOCK_ID, array('DESIRABILITY' => 0));
	$desirability = 0;
	$countMax = CSaleOrder::GetList(['ID' => 'ASC'], array("BASKET_PRODUCT_ID" => $ob["ID"],">=DATE_INSERT" => date('d.m.Y', strtotime("-7 days"))), [], false, ['ID']) + 1;

	if ($countMax < 3)
		continue;

	$countMax = $countMax*$countMax*$countMax*$countMax;
	$desirability = round($countMax/($ob['PROPERTY_PAGE_VIEWS_GA_VALUE']*2)*1000);

	if ($oneb["ID"] == 384889) //Книге Overview поднимаем рейтинг
		$desirability += 10000;

	//echo $countMax.' - '.$ob['PROPERTY_PAGE_VIEWS_GA_VALUE'].' - '.$ob["ID"].' - '.$desirability.'<br />';
	CIBlockElement::SetPropertyValuesEx($ob[ID], CATALOG_IBLOCK_ID, array('DESIRABILITY' => $desirability));
}
?>