<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock"))
	return;

$arComponentParameters = array(
	"PARAMETERS" => array(
		"IBLOCK_ID_CATALOG" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CATALOG_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"IBLOCK_ID_CLASSIFIER" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASSIFIER_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"CLASSIFIER_PROPERTY_CODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASSIFIER_PROPERTY_CODE"),
			"TYPE" => "STRING",
		),
		"DETAIL_URL" => CIBlockParameters::GetPathTemplateParam(
			"DETAIL",
			"DETAIL_URL",
			GetMessage("SIMPLECOMP_EXAM2_CATALOG_IBLOCK_DETAIL_URL"),
			"",
			"URL_TEMPLATES"
		),
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000)
	)
);
?>
