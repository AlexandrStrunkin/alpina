<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;
if ($_REQUEST["id"]) {
	CModule::IncludeModule("subscribe");

	$already = false;
	//$alpinaip = "81.23.1.228";

	if ($USER->IsAuthorized())
		$already = CSubscription::GetList(array(), array("USER_ID"=>$USER->GetID()), false)->Fetch();

	if (!$already
		&& $_SERVER['REMOTE_ADDR'] != $alpinaip
		&& !preg_match("/(.*)\/personal\/(.*)/i", $_SERVER['HTTP_REFERER'])
		&& strpos($_SERVER['HTTP_REFERER'],"yandex.market") === false) {

		$return = '<style>.outLink {text-decoration:underline} .outLink:hover {text-decoration:none;}.stopProp img {max-width:650px;height:auto;display:block;margin:0 auto;padding:0 50px 0 0;}.awayLink:hover {background-color: #cab796!important;color: #fff!important;} .addLink:hover {background-color: #c7a271!important;color: #fff!important;} .closeX:after{font-size:48px;position: absolute;content:"\00d7";color:#fff;width: 21px;height: 21px;right: 40px;cursor: pointer;display: block} .closeX:hover:after {content:"\00d7";color:#888}#subpop input[type=button]{background:transparent;color:#0dce00;margin-left:-50px;font-size:28px;}input:-webkit-autofill, textarea:-webkit-autofill, select:-webkit-autofill {background-color:transparent!important;color:#fff!important}</style>';

		$return .= '<script>
		$(document).ready(function() {
			$(".stopProp").click(function(e) { e.stopPropagation(); });
			$(".subscribeForm input[type=email]").keydown(function(event){
				if(event.keyCode == 13) {
                  var email = $(".subscribeForm input[type=email]").val();
                  (window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() { rrApi.setEmail(email); });
				  event.preventDefault();
				  $(this).siblings("input[type=button]").click();
				  return false;
				}
			});
		});';
		$return .= 'function subscribe() {var emailAddres = $(".subscribeForm input[type=email]").val();var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;if (regex.test(emailAddres)){$.post("/ajax/subscribe_actions.php", {email: $(".subscribeForm input[type=email]").val(), children: 1}, function(data){$(".errorinfo").hide();$("#subpop form").html(data);})}else{$(".errorinfo").show();$(".errorinfo").html("Кажется, вы ошиблись в написании своего адреса");}}function setCloseCookie() {$.post("/ajax/subscribe_actions.php", {close: "y"}, function(data){closeX();})}</script>';

		$return .= '<div style="position: fixed; width: 100%; height: 100%; top: 0; left: 0; z-index: 999999999998; background: rgba(0,0,0,.75);overflow-y:auto;" onclick="setCloseCookie();return false;" class="hideInfo no-mobile">';
		$return .= '<div style="max-width: 800px; width:100%;min-width:700px;margin-left: -410px; margin-top: 7%;margin-bottom:7%;top: 0; left: 50%; position: absolute; padding: 30px 40px; z-index: 999999999999;display: block;font-family: \'Walshein_regular\';color:#2F3839" class="stopProp">';
		$return .= '<div class="closeX" style="cursor:pointer;" onclick="setCloseCookie();"></div>';
		$return .= '<div style="color:#fff;line-height: 140%;font-size: 18px;" id="subpop">';


		$return .= '<img src="/img/5381fa8d7f50d1b6e469fc9f91de288b.png" style="width:100%;max-width:264px" align="left" /><h2 style="font-size:32px;">Бесплатный курс из 5 писем-гидов про детский сад!</h2><br />';

		$return .= '<b>«Мама в теме»</b><br />Вам больше не нужно тратить время на поиск лайфхаков и статей в интернете<br />';
		$return .=
			'
			<a target="_blank" onclick="setCloseCookie();" style="display:block;height: 60px;background: rgba(255, 124, 5, 0.8);font-size: 18px;margin: 35px 94px 0 0;line-height: 60px;text-align: center;font-weight: 400;color: #fff;border: 1px solid #fff;width: 390px;float:right;" href="http://xn--80aaxllk4g.xn--d1acj3b/">Участвовать</a>
			';
			/*<form action="/" method="post" style="padding-top:40px;" class="subscribeForm">

				<input type="email" style="height: 60px;background: transparent;padding:0 60px 0 20px;font-size: 18px;font-weight: 400;color: #fff;border: 1px solid #fff;width:310px;" placeholder="Ваш e-mail" name="email">
				<input type="button" onclick="subscribe();return false;" value="→" style="height: 60px;width: 40px;cursor: pointer;border: none;">
			</form>';*/

		$return .= '<br />';

		$return .= '</div><br />';

		$return .= '</div></div></div>';
		echo $return;
		print_r($_SERVER['HTTP_REFERER']);

	} else {
		return false;
	}
} else {
	echo '';
}
?>
