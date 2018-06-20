<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("История заказов");
    $orders_count = UserOrdersCount($USER -> GetID());
    ?>
<?if (!$USER->IsAuthorized() || ($USER -> IsAuthorized() && intval($orders_count) <= 0)) {
   // header("location: profile/");
} else {?>
    <section class="l-section-wrap top-section color_1 full">
        <div class="container">
            <?/* $APPLICATION->IncludeComponent("bitrix:main.profile", "user_profile_sailplay", array(
                    "SET_TITLE" => "Y",
                    "AJAX_MODE" => "Y"
                    ),
                    false,
                    array(
                        "ACTIVE_COMPONENT" => "Y"
                    )
                );*/?>
        </div>
    </section>
    <?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order",
	"orders",
	array(
		"SEF_MODE" => "N",
		"ORDERS_PER_PAGE" => "100",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PATH_TO_BASKET" => "/personal/cart/",
		"SET_TITLE" => "N",
		"PROP_3" => array(
		),
		"PROP_1" => array(
		),
		"PROP_2" => array(
		),
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SEF_FOLDER" => "/personal/order/",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "N",
		"SAVE_IN_SESSION" => "N",
		"NAV_TEMPLATE" => "",
		"CUSTOM_SELECT_PROPS" => array(
		),
		"HISTORIC_STATUSES" => array(""),
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_C" => "gray",
		"STATUS_COLOR_E" => "gray",
		"STATUS_COLOR_P" => "yellow",
		"STATUS_COLOR_W" => "gray",
		"STATUS_COLOR_A" => "gray",
		"STATUS_COLOR_I" => "gray",
		"STATUS_COLOR_F" => "gray",
		"STATUS_COLOR_B" => "gray",
		"STATUS_COLOR_R" => "gray",
		"STATUS_COLOR_O" => "gray",
		"STATUS_COLOR_z" => "gray",
		"STATUS_COLOR_D" => "gray",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
		"COMPONENT_TEMPLATE" => "list",
		"STATUS_COLOR_K" => "gray"
	),
	false
);?>

<?}?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
