<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    if (!function_exists("showFilePropertyField")){
        function showFilePropertyField($name, $property_fields, $values, $max_file_size_show=50000){
            $res = "";

            if (!is_array($values) || empty($values))
                $values = array(
                    "n0" => 0,
                );

            if ($property_fields["MULTIPLE"] == "N") {
                $res = "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[0]\" id=\"".$name."[0]\"></label>";
            } else {
                $res = '
                <script type="text/javascript">
                function addControl(item)
                {
                var current_name = item.id.split("[")[0],
                current_id = item.id.split("[")[1].replace("[", "").replace("]", ""),
                next_id = parseInt(current_id) + 1;

                var newInput = document.createElement("input");
                newInput.type = "file";
                newInput.name = current_name + "[" + next_id + "]";
                newInput.id = current_name + "[" + next_id + "]";
                newInput.onchange = function() { addControl(this); };

                var br = document.createElement("br");
                var br2 = document.createElement("br");

                BX(item.id).parentNode.appendChild(br);
                BX(item.id).parentNode.appendChild(br2);
                BX(item.id).parentNode.appendChild(newInput);
                }
                </script>
                ';

                $res .= "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[0]\" id=\"".$name."[0]\"></label>";
                $res .= "<br/><br/>";
                $res .= "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[1]\" id=\"".$name."[1]\" onChange=\"javascript:addControl(this);\"></label>";
            }
            return $res;
        }
    }

    if (!function_exists("PrintPropsForm")){
        function PrintPropsForm($arSource = array(), $locationTemplate = ".default", $preorder = '') {
            if (!empty($arSource)){ ?>
            <? foreach ($arSource as $arProperties) {
                    if ($arProperties["TYPE"] != "LOCATION") {
                        $class =  "infoPunct";
                    }
                    else {
                        $class = "";
                }
                if($arProperties["CODE"] == "series_pasport" ){
                     $class .= ' pasport';
                } else if($arProperties["CODE"] == "number_pasport"){
                     $class .= ' pasport_number';
                } ?>
                <div data-property-id-row="<?=intval(intval($arProperties["ID"]))?>" class="<?=$class?> " <?if($preorder && ($arProperties["ID"] == DELIVERY_DATE_LEGAL_ORDER_PROP_ID || $arProperties["ID"] == DELIVERY_DATE_NATURAL_ORDER_PROP_ID)) { echo 'style="display:none"'; }?>>
                    <?if ($arProperties["TYPE"] != "LOCATION") {?>

                        <?if(($arProperties["CODE"] != "number_pasport")){?>
                            <p class="inputTitle <?=($arProperties["CODE"] == "certificate" || $arProperties["CODE"] == "CODE_COUPON")? 'certInput':''?>">
                                <?if($_SESSION["DATE_DELIVERY_STATE"] == "under_order" && $arProperties["CODE"] != "DELIVERY_DATE"){?>
                                    <?echo $arProperties["NAME"];?>
                                <?} else if($_SESSION["DATE_DELIVERY_STATE"] != "under_order"){?>
                                    <?echo $arProperties["NAME"];?>
                                <?}?>
                                <?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
                                    <span class="bx_sof_req">*</span>
                                    <?endif?>
                             <?if($arProperties["CODE"] == "series_pasport"){ ?>
                                    <br>
                                    <span>(необходимы для получения груза)</span>
                             <?} ?> 
                            </p> 
              
                         <?}?>
                        <?}?>

                        <?
                        if ($arProperties["TYPE"] == "CHECKBOX"){
                        ?>

                        <div class="bx_block r1x3 pt8" <?if($arProperties["ID"] == 62 || $arProperties["ID"] == 63){?> style="display:none;"<?}?>>
                            <input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">
                            <input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>>
                            <?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
                                <div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
                                <?endif?>
                        </div>
                        <?

                        } else if ($arProperties["TYPE"] == "TEXT"){
                            if ($arProperties["CODE"] == "INDEX") {
                                $field_size = 6;
                            } else {
                                $field_size = 250;
                            }
                            $window = strpos($_SERVER['HTTP_USER_AGENT'],"Windows");
                            if($arProperties["CODE"]!="certificate" && $arProperties["CODE"]!="CODE_COUPON") {
                            ?>

                            <?if(($arProperties["CODE"] == "series_pasport" || $arProperties["CODE"] == "number_pasport")){?>
                                <input class="clientInfo" placeholder="<?=$arProperties["DESCRIPTION"]?>" id="<?=$arProperties["FIELD_NAME"]?>" type="tel" 
                                       maxlength="<?=($arProperties['CODE'] == 'series_pasport')? 4: 6?>" 
                                       size="<?=$arProperties["SIZE1"]?>" 
                                       value="<?=($arProperties["VALUE"])?$arProperties["VALUE"]:$_POST["ORDER_PROP_".$arProperties["ID"]]?>" 
                                       name="<?=$arProperties["FIELD_NAME"]?>" />
                            
                            <?} else if(($arProperties["CODE"] == "PHONE" || $arProperties["CODE"] == "F_PHONE") && !$window){?>

                                <input class="clientInfo" placeholder="(___) ___ __ __" id="<?=$arProperties["FIELD_NAME"]?>" type="tel" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<?=($arProperties["VALUE"])?$arProperties["VALUE"]:$_POST["ORDER_PROP_".$arProperties["ID"]]?>" name="<?=$arProperties["FIELD_NAME"]?>" />
                            <?} else if($arProperties["CODE"] == "ADRESS_PICKPOINT"){?>
                                <div class="certInput">
                                    <input type="hide" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["CODE"]?>">
                                </div>
                            <?} else if($arProperties["CODE"] == "DELIVERY_DATE"){?>
                                <?if($_SESSION["DATE_DELIVERY_STATE"] != "under_order"){?>
                                    <input class="clientInfo" readonly type="text" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<?=($arProperties["VALUE"])?$arProperties["VALUE"]:$_POST["ORDER_PROP_".$arProperties["ID"]]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" />
                                <?}?>
                            <?} else {?>
                                <input class="clientInfo" type="text" maxlength="<?= $field_size ?>" size="<?=$arProperties["SIZE1"]?>" value="<?=($arProperties["VALUE"])?$arProperties["VALUE"]:$_POST["ORDER_PROP_".$arProperties["ID"]]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" />
                            <?}?>
                            <?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
                                <span class="warningMessage">Заполните поле <?=$arProperties["NAME"]?></span>
                            <?endif?>

                            <?if (strlen(trim($arProperties["DESCRIPTION"])) > 0 && $arProperties["CODE"] != "ADRESS_PICKPOINT" && ($arProperties["CODE"] != "series_pasport" && $arProperties["CODE"] != "number_pasport")):?>
                                <div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
                            <?endif?>     
                            <? } else if ($arProperties["CODE"]=="CODE_COUPON") {   ?>
                                <div class="certInput">
                                    <?=$arProperties["NAME"]?>
                                    <?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
                                        <span class="bx_sof_req">*</span>
                                        <?endif;?>
                                </div>
                                <div class="certInput">
                                    <input type="text" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<?=$_SESSION["CUSTOM_COUPON"]["COUPON_CODE"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>">
                                </div>
                            <? } else { ?>
                                <div class="certInput">
                                    <?=$arProperties["NAME"]?>
                                    <?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
                                        <span class="bx_sof_req">*</span>
                                        <?endif;?>
                                </div>
                                <div class="certInput">
                                    <input type="text" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<?=$_SESSION["CUSTOM_COUPON"]["COUPON_ID"].'-'.$_SESSION["CUSTOM_COUPON"]["DEFAULT_COUPON"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>">
                                </div>
                            <?}

                        } elseif ($arProperties["TYPE"] == "SELECT"){
                            uasort($arProperties["VARIANTS"], 'metroCmp');?>

                        <div class="bx_block r3x1" <?if($arProperties["CODE"] == 'RLAB_SENDPARCEL_CHECK_1' || $arProperties["CODE"] == 'RLAB_SENDPARCEL_CHECK_2'){?> style="display:none;"<?}?>>
                            <select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
                                <?
                                    if ($arProperties["ID"] == 29 && empty($arProperties["DEFAULT_VALUE"])){ //РјРµС‚СЂРѕ РґР»СЏ С„РёР·Р»РёС†
                                    ?>
                                    <option value="" selected="selected">Выберите станцию метро</option>
                                    <?
                                    }
                                ?>
                                <?foreach($arProperties["VARIANTS"] as $key_metro => $arVariants):?>
                                    <option data-count="<?=$key_metro?>" data-value="<?=preg_replace("/ \(.*\)/","",$arVariants["NAME"]);?>" value="<?=$arVariants["VALUE"]?>"<?=($arVariants["SELECTED"] == "Y" &&  $_POST["ORDER_PROP_29"] > 0) ? " selected" : ''?>
                                        <?if($arProperties["CODE"] == 'RLAB_SENDPARCEL_CHECK_1' || $arProperties["CODE"] == 'RLAB_SENDPARCEL_CHECK_2' and $arVariants["VALUE"] == 'N'){?> selected <?}?>><?=$arVariants["NAME"]?></option>
                                    <?endforeach?>
                            </select>
                            <?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
                                <div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
                                <?endif?>
                        </div>
                        <?
                        } elseif ($arProperties["TYPE"] == "MULTISELECT") {
                        ?>
                        <div class="bx_block r3x1" >
                            <select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
                                <?foreach($arProperties["VARIANTS"] as $arVariants):?>
                                    <option value="<?=$arVariants["VALUE"]?>"<?=$arVariants["SELECTED"] == "Y" ? " selected" : ''?>><?=$arVariants["NAME"]?></option>
                                    <?endforeach?>
                            </select>
                            <?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
                                <div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
                                <?endif?>
                        </div>
                        <?
                        } elseif ($arProperties["TYPE"] == "TEXTAREA") {
                            $rows = ($arProperties["SIZE2"] > 10) ? 4 : $arProperties["SIZE2"];
                        ?>
                        <?if($arProperties["FIELD_ID"] == "ORDER_PROP_ADDRESS"){
                           // $arProperties["VALUE"] = $_SESSION["city_order_checked"].', '.$arProperties["VALUE"];
                        }?>
                        <div class="bx_block r3x1">
                            <textarea rows="<?=$rows?>" cols="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>
                            <?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
                                <div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
                                <?endif?>
                            <span class="warningMessage"><?=GetMessage("INPUT_ERROR")?> <?=$arProperties["NAME"]?></span>
                        </div>
                        <?
                        } elseif ($arProperties["TYPE"] == "LOCATION") {
                           /* if($_SESSION["ALTASIB_GEOBASE_CODE"]["CITY"]["NAME"]){
                                $city = $_SESSION["ALTASIB_GEOBASE_CODE"]["CITY"]["NAME"];
                            } else {
                                $city = $_SESSION["ALTASIB_GEOBASE"]["CITY_NAME"];
                            }   */
                          if($arProperties["CODE"] != 'LOCATION_CITY'){
                            $value = 0;    
                            if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0){
                                foreach ($arProperties["VARIANTS"] as $arVariant){
                                    if ($arVariant["SELECTED"] == "Y"){
                                        $value = $arVariant["ID"];
                                        break;
                                    }

                                }
                                    /*if($arVariant["CITY_NAME"] == "Москва и МО" && $city == "Москва" || $arVariant["ID"] == $_POST["ORDER_PROP_2"] && $_POST["ORDER_PROP_2"] != 21278){
                                       $value = $arVariant["ID"];
                                       break;
                                    } */
                                if ($value == ""){
                                    $value = $arProperties["VALUE"];
                                }
                            }

                            // here we can get '' or 'popup'
                            // map them, if needed
                            if(CSaleLocation::isLocationProMigrated()){
                                $locationTemplateP = $locationTemplate == 'popup' ? 'search' : 'steps';
                                $locationTemplateP = $_REQUEST['PERMANENT_MODE_STEPS'] == 1 ? 'steps' : $locationTemplateP; // force to "steps"
                            }
                        ?>
                        <?if($locationTemplateP == 'steps'):?>
                            <input type="hidden" id="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" name="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" value="<?=($_REQUEST['LOCATION_ALT_PROP_DISPLAY_MANUAL'][intval($arProperties["ID"])] ? '1' : '0')?>" />
                            <?endif?>

                        <?CSaleLocation::proxySaleAjaxLocationsComponent(array(
                            "AJAX_CALL" => "N",
                            "COUNTRY_INPUT_NAME" => "COUNTRY",
                            "REGION_INPUT_NAME" => "REGION",
                            "CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
                            "CITY_OUT_LOCATION" => "Y",
                            "LOCATION_VALUE" => $value,
                            "ORDER_PROPS_ID" => $arProperties["ID"],
                            "ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
                            "SIZE1" => $arProperties["SIZE1"],
                            ),
                            array(
                                "ID" => $value,
                                "CODE" => "",
                                "SHOW_DEFAULT_LOCATIONS" => "Y",

                                // function called on each location change caused by user or by program
                                // it may be replaced with global component dispatch mechanism coming soon
                                "JS_CALLBACK" => "submitFormProxy",

                                // function window.BX.locationsDeferred['X'] will be created and lately called on each form re-draw.
                                // it may be removed when sale.order.ajax will use real ajax form posting with BX.ProcessHTML() and other stuff instead of just simple iframe transfer
                                "JS_CONTROL_DEFERRED_INIT" => intval($arProperties["ID"]),

                                // an instance of this control will be placed to window.BX.locationSelectors['X'] and lately will be available from everywhere
                                // it may be replaced with global component dispatch mechanism coming soon
                                "JS_CONTROL_GLOBAL_ID" => intval($arProperties["ID"]),

                                "DISABLE_KEYBOARD_INPUT" => "Y",
                                "PRECACHE_LAST_LEVEL" => "Y",
                                "PRESELECT_TREE_TRUNK" => "Y",
                                "SUPPRESS_ERRORS" => "Y"
                            ),
                            $locationTemplateP,
                            true,
                            'location-block-wrapper'
                        )?>

                        <?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
                            <div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
                            <?endif?>
                        <?
                        } else {
                            ?>

                            <div class="bx_block r3x1">
                                <?
                                $value = 0;
                                if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
                                {
                                    foreach ($arProperties["VARIANTS"] as $arVariant)
                                    {
                                        if ($arVariant["SELECTED"] == "Y")
                                        {
                                            $value = $arVariant["ID"];
                                            break;
                                        }
                                    }
                                }

                                // here we can get '' or 'popup'
                                // map them, if needed
                                if(CSaleLocation::isLocationProMigrated())
                                {
                                    $locationTemplateP = $locationTemplate == 'popup' ? 'search' : 'steps';
                                    $locationTemplateP = $_REQUEST['PERMANENT_MODE_STEPS'] == 1 ? 'steps' : $locationTemplateP; // force to "steps"
                                }
                                ?>

                                <?if($locationTemplateP == 'steps'):?>
                                    <input type="hidden" id="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" name="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" value="<?=($_REQUEST['LOCATION_ALT_PROP_DISPLAY_MANUAL'][intval($arProperties["ID"])] ? '1' : '0')?>" />
                                <?endif?>

                                <?CSaleLocation::proxySaleAjaxLocationsComponent(array(
                                    "AJAX_CALL" => "N",
                                    "COUNTRY_INPUT_NAME" => "COUNTRY",
                                    "REGION_INPUT_NAME" => "REGION",
                                    "CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
                                    "CITY_OUT_LOCATION" => "Y",
                                    "LOCATION_VALUE" => $value,
                                    "ORDER_PROPS_ID" => $arProperties["ID"],
                                    "ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
                                    "SIZE1" => $arProperties["SIZE1"],
                                ),
                                    array(
                                        "ID" => $value,
                                        "CODE" => "",
                                        "SHOW_DEFAULT_LOCATIONS" => "Y",

                                        // function called on each location change caused by user or by program
                                        // it may be replaced with global component dispatch mechanism coming soon
                                        "JS_CALLBACK" => "submitFormProxy",

                                        // function window.BX.locationsDeferred['X'] will be created and lately called on each form re-draw.
                                        // it may be removed when sale.order.ajax will use real ajax form posting with BX.ProcessHTML() and other stuff instead of just simple iframe transfer
                                        "JS_CONTROL_DEFERRED_INIT" => intval($arProperties["ID"]),

                                        // an instance of this control will be placed to window.BX.locationSelectors['X'] and lately will be available from everywhere
                                        // it may be replaced with global component dispatch mechanism coming soon
                                        "JS_CONTROL_GLOBAL_ID" => intval($arProperties["ID"]),

                                        "DISABLE_KEYBOARD_INPUT" => "Y",
                                        "PRECACHE_LAST_LEVEL" => "Y",
                                        "PRESELECT_TREE_TRUNK" => "Y",
                                        "SUPPRESS_ERRORS" => "Y"
                                    ),
                                    $locationTemplateP,
                                    true,
                                    'location-block-wrapper'
                                )?>

                                <?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
                                    <div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
                                <?endif?>
                            </div>
                            <?
                        }
                        } elseif ($arProperties["TYPE"] == "RADIO") {
                        ?>
                        <div class="bx_block r3x1">
                            <?
                                if (is_array($arProperties["VARIANTS"])){
                                    foreach($arProperties["VARIANTS"] as $arVariants):
                                    ?>
                                    <input
                                        type="radio"
                                        name="<?=$arProperties["FIELD_NAME"]?>"
                                        id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"
                                        value="<?=$arVariants["VALUE"]?>" <?if($arVariants["CHECKED"] == "Y") echo " checked";?> />

                                    <label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"><?=$arVariants["NAME"]?></label></br>
                                    <?
                                        endforeach;
                                }
                            ?>
                            <?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
                                <div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
                                <?endif?>
                        </div>
                        <?
                        } elseif ($arProperties["TYPE"] == "FILE"){
                        ?>
                        <div class="bx_block r3x1">
                            <?=showFilePropertyField("ORDER_PROP_".$arProperties["ID"], $arProperties, $arProperties["VALUE"], $arProperties["SIZE1"])?>
                            <?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
                                <div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
                                <?endif?>
                        </div>
                        <?
                        } elseif ($arProperties["TYPE"] == "DATE"){
                        ?>
                        <div>
                            <?
                                global $APPLICATION;

                                $APPLICATION->IncludeComponent('bitrix:main.calendar', '', array(
                                    'SHOW_INPUT' => 'Y',
                                    'INPUT_NAME' => "ORDER_PROP_".$arProperties["ID"],
                                    'INPUT_VALUE' => $arProperties["VALUE"],
                                    'SHOW_TIME' => 'N'
                                    ), null, array('HIDE_ICONS' => 'N'));
                            ?>
                            <?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
                                <div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
                                <?endif?>
                        </div>
                        <?
                        }
                    ?>

                </div>


                <?if(CSaleLocation::isLocationProEnabled()):?>

                    <?
                        $propertyAttributes = array(
                            'type' => $arProperties["TYPE"],
                            'valueSource' => $arProperties['SOURCE'] == 'DEFAULT' ? 'default' : 'form' // value taken from property DEFAULT_VALUE or it`s a user-typed value?
                        );

                        if(intval($arProperties['IS_ALTERNATE_LOCATION_FOR']))
                            $propertyAttributes['isAltLocationFor'] = intval($arProperties['IS_ALTERNATE_LOCATION_FOR']);

                        if(intval($arProperties['CAN_HAVE_ALTERNATE_LOCATION']))
                            $propertyAttributes['altLocationPropId'] = intval($arProperties['CAN_HAVE_ALTERNATE_LOCATION']);

                        if($arProperties['IS_ZIP'] == 'Y')
                            $propertyAttributes['isZip'] = true;
                    ?>

                    <script>

                        <?// add property info to have client-side control on it?>
                        (window.top.BX || BX).saleOrderAjax.addPropertyDesc(<?=CUtil::PhpToJSObject(array(
                            'id' => intval($arProperties["ID"]),
                            'attributes' => $propertyAttributes
                        ))?>);

                    </script>
                    <?endif?>
                <?
                }
            ?>

            <?
            }
        }
    }
?>