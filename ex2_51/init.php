<?
//Обработчик в файле /bitrix/php_interface/init.php
AddEventHandler("main", "OnBeforeEventAdd", array("MyClass", "OnBeforeEventAddHandler"));
class MyClass
{
    public static function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
    {
       if ($event == "FEEDBACK_FORM"){
        global $USER;

        if($USER->IsAuthorized()){

            $arFields["AUTHOR"] = "Пользователь авторизован: ".$USER->GetID()." (".$USER->GetLogin().") ".$USER->GetFullName().", данные из формы: ".$arFields["AUTHOR"];
        }
        else
        {
            $arFields["AUTHOR"] = "Пользователь не авторизован, данные из формы: ".$arFields["AUTHOR"];
        }
        CEventLog::Add(array(
            "SEVERITY" => "SECURITY",
            "AUDIT_TYPE_ID" => "Замена данных письма",
            "MODULE_ID" => "main",
            "ITEM_ID" => 0,
            "DESCRIPTION" => "Замена данных в отсылаемом письме – [".$arFields["AUTHOR"]."].",
         ));

       }
    }
}
?>