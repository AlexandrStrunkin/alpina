<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

$result = null;
if (!CModule::IncludeModule('kealabs.search')) {
    $result = array("error" => "Kealabs search module is not available");
}
if ($result == null && !(CModule::IncludeModule("catalog") && CModule::IncludeModule("iblock"))) {
    $result = array("error" => "Required modules are not available");
}
if ($result == null) {
    $result = \KeaLabs\Search\KeaController::execute();
}
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($result);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';
