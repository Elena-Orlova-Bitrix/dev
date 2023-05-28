<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;


if ($this->StartResultCache(false, $USER->GetGroups()))
{
	if(!Loader::includeModule("iblock"))
	{
		$this->abortResultCache();
		ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
		return;
	}
	if(intval($arParams["IBLOCK_ID_CATALOG"]) > 0 and intval($arParams["IBLOCK_ID_CLASSIFIER"]) > 0) 
	{		
		//get list of section from classifier iblock 
		$arSelectSect = array (
			"ID",
			"IBLOCK_ID",
			"NAME",
		);
		$arFilterSect = array (
			"IBLOCK_ID" => $arParams["IBLOCK_ID_CLASSIFIER"],
			"ACTIVE" => "Y",
			"CHECK_PERMISSIONS" => "Y" 
		);
			
		$arResult["SECTIONS"] = array();
		$arResult["ELEMENTS"] = array();
		$arSectionIDs = array();
		$rsSect = CIBlockElement::GetList(false, $arFilterSect, false, false, $arSelectSect);
		
		while($arSect = $rsSect->GetNext())
		{
			$arResult["SECTIONS"][] = $arSect;
			$arSectionIDs[] = $arSect["ID"];   //list of section IDs, it will be used in query to get elements only for these sections
			$arResult["ELEMENTS"][$arSect["ID"]] = array(); //initialize empty array for elements of each section
		}

		if (count($arResult["SECTIONS"])>0){

			//get elements for all sections from iblock
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
				"IBLOCK_ID" => $arParams["IBLOCK_ID_CATALOG"],
				"ACTIVE" => "Y",
				"CHECK_PERMISSIONS" => "Y",
				"PROPERTY_".$arParams["CLASSIFIER_PROPERTY_CODE"] => $arSectionIDs  //filter by section ids
			);
				
			$arResult["ELEMENTS"] = array();
			$rsElements = CIBlockElement::GetList(false, $arFilterElems, false, false, $arSelectElems);
			$rsElements->SetUrlTemplates($arParams["DETAIL_URL"]);
			while($arElement = $rsElements->GetNext())
			{
				$sectionID = $arElement["PROPERTY_".$arParams["CLASSIFIER_PROPERTY_CODE"]."_VALUE"];
				$arResult["ELEMENTS"][$sectionID][] = $arElement; //group elements by sections
			}
		}

	}
	$this->setResultCacheKeys(array("SECTIONS")); //set only "SECTIONS" key so it will be possible to set in title count of sections even if component is gotten from cache
	$this->includeComponentTemplate();	
}
if (count($arResult["SECTIONS"])>0){
	$APPLICATION->SetTitle("Paзделов - ".count($arResult["SECTIONS"])); //set title
}
?>
