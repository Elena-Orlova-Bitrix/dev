<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b><? echo time(); ?></p>
<?
if (count($arResult["SECTIONS"])>0){
    ?><ul><?
    foreach ($arResult["SECTIONS"] as $arKey => $arSect){
        $arSectionElements = $arResult["ELEMENTS"][$arSect["ID"]];
        ?><li><?= $arSect["NAME"] ?></li><?
        if (count($arSectionElements)>0){
            ?><ul><?
            foreach ($arSectionElements as $arKeyElem => $arElem){
                ?><li><? print("<a href='".$arElem["DETAIL_PAGE_URL"]."' alt='".$arElem["NAME"]."'>".$arElem["NAME"]."</a> - ".$arElem["PROPERTY_PRICE_VALUE"]." - ".$arElem["PROPERTY_MATERIAL_VALUE"]." - ".$arElem["PROPERTY_ARTNUMBER_VALUE"]); ?></li><?
            }
            ?></ul><?
        }
    }
    ?></ul><?
}
?>