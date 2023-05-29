<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if ($this->StartResultCache(false, $USER->GetGroups(),"/simplecomp_cache")){
	global $CACHE_MANAGER;
	$CACHE_MANAGER->RegisterTag("iblock_id_7");
	if(!Loader::includeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
		return;
	}

	if((intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0) and (intval($arParams["CLASSIFIER_IBLOCK_ID"]) > 0))
	{
		
		//iblock sections
		$arSelectSect = array (
				"ID",
				"IBLOCK_ID",
				"NAME",
		);
		$arFilterSect = array (
				"IBLOCK_ID" => $arParams["CLASSIFIER_IBLOCK_ID"],
				"ACTIVE" => "Y",
				"CHECK_PERMISSIONS" => "Y"
		);
		$arResult["SECTIONS"] = array();
		$arResult["ELEMENTS"] = array();
		$sectionIds = array();
		$rsSections = CIBlockElement::GetList(false, $arFilterSect, false, false, $arSelectSect);
		while($arSection = $rsSections->GetNext())
		{
			$arResult["SECTIONS"][] = $arSection;
			$sectionIds[] = $arSection["ID"]; 
			$arResult["ELEMENTS"][$arSection["ID"]] = array();
		}

		
			//iblock elements
			$arSelectElems = array (
				"ID",
				"IBLOCK_ID",
				"NAME",
				"IBLOCK_SECTION_ID",
				"PROPERTY_".$arParams["CLASSIFIER_PROPERTY_CODE"],
				"PROPERTY_PRICE",
				"PROPERTY_MATERIAL",
				"PROPERTY_ARTNUMBER"
			);
			$arFilterElems = array (
				"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
				"ACTIVE" => "Y",
				"CHECK_PERMISSIONS" => "Y",
				"PROPERTY_".$arParams["CLASSIFIER_PROPERTY_CODE"] => $sectionIds
			);
			
			
			$rsElements = CIBlockElement::GetList(false, $arFilterElems, false, false, $arSelectElems);
			$rsElements->SetUrlTemplates($arParams["DETAIL_URL"]);
			while($arElement = $rsElements->GetNext())
			{

				$sectionId = $arElement["PROPERTY_".$arParams["CLASSIFIER_PROPERTY_CODE"]."_VALUE"];
				$arResult["ELEMENTS"][$sectionId][] = $arElement;
			}

		
		
	}
	$this->SetResultCacheKeys(array("SECTIONS"));
	$this->includeComponentTemplate();	
}
if (count($arResult["SECTIONS"])>0){
	$APPLICATION->SetTitle("Разделов: ".count($arResult["SECTIONS"]));
}
?>