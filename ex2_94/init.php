<?
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/constants.php")){
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/constants.php");
}

//Обработчик в файле /bitrix/php_interface/init.php
AddEventHandler("main", "OnEpilog", array("MyClass", "OnEpilogHandler"));
class MyClass
{

    public static function OnEpilogHandler()
    {
        if (CModule::IncludeModule("iblock")){
            global $APPLICATION;
            $current_link  = $APPLICATION->GetCurPage();

            //iblock elements
            $arSelectElems = array (
                "PROPERTY_TITLE",
                "PROPERTY_DESCRIPTION",
            );
            $arFilterElems = array (
                "IBLOCK_ID" => IBLOCK_SEO_SETTINGS_ID,
                "NAME" => $current_link,
                "ACTIVE" => "Y"
            );
            
            $rsElements = CIBlockElement::GetList(false, $arFilterElems, false, array("nTopCount"=>1), $arSelectElems);
            if ($arElement = $rsElements->GetNext())
            {
                $APPLICATION->SetPageProperty("description", $arElement["PROPERTY_DESCRIPTION_VALUE"]);
                $APPLICATION->SetTitle($arElement["PROPERTY_TITLE_VALUE"]);
            }

        } 

    }
}