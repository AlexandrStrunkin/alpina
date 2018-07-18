<?
    include_once $_SERVER["DOCUMENT_ROOT"] . '/api/prolog.php';
    include_once $_SERVER["DOCUMENT_ROOT"] . '/api/classes/book.php';

    if (Validator::isTokenValid($_REQUEST['token'])) {
        $book = new BookAPI();
		if (method_exists($book, $_REQUEST['method'])) {
			$res = $book->{$_REQUEST['method']}($_REQUEST);
        	APIResponse::send($res['status_code'], $res['data']);	
		} else {
			APIResponse::send("error", APITools::getLangPhrase("method_does_not_exist"));
		}
    } else {
        APIResponse::send("error", APITools::getLangPhrase("token_invalid"));
    }
?>