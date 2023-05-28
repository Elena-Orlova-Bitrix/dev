<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? 
if (count($arResult["SECTIONS"])>0) { 
?>
    <p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
    <ul>
    <?
    foreach ($arResult["SECTIONS"] as $keySect => $arSect){
        $arSectionElements = $arResult["ELEMENTS"][$arSect["ID"]]
        ?>
        <li><b><?= $arSect["NAME"] ?></b></li>
        <?
        if (count($arSectionElements)>0){
            ?><ul><?
            foreach ($arSectionElements as $keyItem => $arItem){
                print("<li><a href='".$arItem["DETAIL_PAGE_URL"]."' alt='".$arItem["NAME"]."'>".$arItem["NAME"]."</a> - ".$arItem["PROPERTY_PRICE_VALUE"]." - ".$arItem["PROPERTY_MATERIAL_VALUE"]." - ".$arItem["PROPERTY_ARTNUMBER_VALUE"]."</li>");
            }
            ?></ul><?
        }
    }

    ?>
    </ul>
<? 
} 
?>
