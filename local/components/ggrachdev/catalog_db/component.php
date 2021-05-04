<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;

$arResult['CATALOG'] = [
    'ITEMS_LEVEL_1' => [
    ],
    'ITEMS_LEVEL_2' => [
    ],
    'ITEMS_LEVEL_3' => [
    ],
    'ITEMS_LEVEL_4' => [
    ]
];

$arResult['NOW_DEPTH'] = 1;

class DbCatalogFiller {

    public static function loadDepth1(&$arResult, &$arParams) {

        $dbres = $arParams['ORM_TABLE_CLASS']::getList([
                'select' => [$arParams['CODE_COLUMN_1_LEVEL']],
                'group' => [$arParams['CODE_COLUMN_1_LEVEL']]
        ]);

        $res = $dbres->fetchAll();

        if (!empty($res)) {
            $arResult['CATALOG']['ITEMS_LEVEL_1'] = $res;

            foreach ($arResult['CATALOG']['ITEMS_LEVEL_1'] as &$item) {
                $item['NAME'] = $item[$arParams['CODE_COLUMN_1_LEVEL']];
                unset($item[$arParams['CODE_COLUMN_1_LEVEL']]);
                $item['CODE'] = \Cutil::translit($item['NAME'], "ru");
                $item['LINK'] = $arParams['SECTIONS_TEMPLATE'] . str_replace('#SECTION_CODE_PATH#', $item['CODE'], $arParams['SECTION_TEMPLATE']);
            }
        }
    }

}

class DbCatalogUtils {
    public static function determineСurrentDepth()
    {
        $arRequestChunks = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        return sizeof($arRequestChunks);
    }
}

try {
    if (empty($arParams['ORM_TABLE_CLASS'])) {
        throw new Exception('Not found $arParams[\'ORM_TABLE_CLASS\']');
    }

    if (!\class_exists($arParams['ORM_TABLE_CLASS'])) {
        throw new Exception('Not found class ' . $arParams['ORM_TABLE_CLASS']);
    }

    if (empty($arParams['CODE_COLUMN_1_LEVEL'])) {
        throw new Exception('Not found class $arParams[\'CODE_COLUMN_1_LEVEL\']');
    }

    $arResult['NOW_DEPTH'] = \DbCatalogUtils::determineСurrentDepth();
    
    DbCatalogFiller::loadDepth1($arResult, $arParams);

    if ($arResult['NOW_DEPTH'] === 1) {
        $this->IncludeComponentTemplate('sections');
    }
} catch (Exception $ex) {
    $APPLICATION->ThrowException($ex->getMessage());
    ShowError($ex->getMessage());
}
