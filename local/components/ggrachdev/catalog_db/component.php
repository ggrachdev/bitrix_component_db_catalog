<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;

$arResult['ACTIVE_ELEMENTS'] = [];
$arResult['ACTIVE_ELEMENTS_CODE'] = [];
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

    public static function fill(&$arResult, &$arParams) {

        $arRequestChunks = DbCatalogUtils::getNowRequestChunks();
        $nowDepth = $arResult['NOW_DEPTH'];
        $maxLevelDepth = $arResult['MAX_DEPTH'];

        $dbDepth1 = $arParams['ORM_TABLE_CLASS']::getList([
                'select' => [$arParams['CODE_COLUMN_1_LEVEL']],
                'group' => [$arParams['CODE_COLUMN_1_LEVEL']]
        ]);

        $resDepth1 = $dbDepth1->fetchAll();

        if (!empty($resDepth1)) {
            $arResult['CATALOG']['ITEMS_LEVEL_1'] = $resDepth1;

            foreach ($arResult['CATALOG']['ITEMS_LEVEL_1'] as &$item) {
                $item['NAME'] = $item[$arParams['CODE_COLUMN_1_LEVEL']];
                unset($item[$arParams['CODE_COLUMN_1_LEVEL']]);
                $item['CODE'] = \Cutil::translit($item['NAME'], "ru");
                $item['LINK'] = $arParams['SECTIONS_TEMPLATE'] . str_replace('#SECTION_CODE_PATH#', $item['CODE'], $arParams['SECTION_TEMPLATE']);
            }
        } else {
            $arResult['CATALOG']['ITEMS_LEVEL_1'] = [];
        }

        if ($nowDepth > 1) {

            for ($depth = 2; $depth <= $maxLevelDepth; $depth++) {

                DbCatalogUtils::fillActiveElement($depth - 1, $arResult, $arParams);
                $dbDepth = $arParams['ORM_TABLE_CLASS']::getList([
                        'select' => [$arParams['CODE_COLUMN_' . $depth . '_LEVEL']],
                        'filter' => \DbCatalogUtils::getFilerForDepth($depth, $arResult, $arParams),
                        'group' => [$arParams['CODE_COLUMN_' . $depth . '_LEVEL']]
                ]);

                $resDepth = $dbDepth->fetchAll();

                if (!empty($resDepth)) {

                    $arResult['CATALOG']['ITEMS_LEVEL_' . $depth] = $resDepth;

                    foreach ($arResult['CATALOG']['ITEMS_LEVEL_' . $depth] as &$item) {
                        $item['NAME'] = $item[$arParams['CODE_COLUMN_' . $depth . '_LEVEL']];
                        unset($item[$arParams['CODE_COLUMN_' . $depth . '_LEVEL']]);
                        $item['CODE'] = \Cutil::translit($item['NAME'], "ru");
                        $item['LINK'] = '/' . implode('/', $arRequestChunks) . '/' . $item['CODE'] . '/';
                    }
                }
            }
            DbCatalogUtils::fillActiveElement($depth - 1, $arResult, $arParams);
        }
    }

}

class DbCatalogUtils {

    public static function fillActiveElement($depth, &$arResult, &$arParams) {
        if (!empty($arResult['CATALOG']['ITEMS_LEVEL_' . $depth])) {
            $arRequestChunks = self::getNowRequestChunks();

            $codeActiveElement = $arRequestChunks[$depth];

            foreach ($arResult['CATALOG']['ITEMS_LEVEL_' . $depth] as $value) {
                if ($value['CODE'] === $codeActiveElement) {
                    $arResult['ACTIVE_ELEMENTS'][$depth] = $value;
                    $arResult['ACTIVE_ELEMENTS_CODE'][$arParams['CODE_COLUMN_' . $depth . '_LEVEL']] = $value;
                    break;
                }
            }
        }
    }

    public static function getFilerForDepth($depth, $arResult, $arParams) {
        $arFilter = [];

        if ($arResult['NOW_DEPTH'] > 1) {
            if (!empty($arParams['CODE_COLUMN_' . $depth . '_LEVEL'])) {
                $arFilter[$arParams['CODE_COLUMN_' . ($depth - 1) . '_LEVEL']] = $arResult['ACTIVE_ELEMENTS'][$depth - 1]['NAME'];
            }
        }

        return $arFilter;
    }

    public static function determineMaxDepth(array $arParams) {

        $maxDepth = 1;

        if (!empty($arParams['CODE_COLUMN_2_LEVEL'])) {
            $maxDepth = 2;

            if (!empty($arParams['CODE_COLUMN_3_LEVEL'])) {
                $maxDepth = 3;

                if (!empty($arParams['CODE_COLUMN_4_LEVEL'])) {
                    $maxDepth = 4;

                    if (!empty($arParams['CODE_COLUMN_5_LEVEL'])) {
                        $maxDepth = 5;

                        if (!empty($arParams['CODE_COLUMN_6_LEVEL'])) {
                            $maxDepth = 6;
                        }
                    }
                }
            }
        }

        return $maxDepth;
    }

    public static function determineСurrentDepth() {
        return sizeof(self::getNowRequestChunks());
    }

    public static function getNowRequestChunks() {
        return explode('/', trim(strtok($_SERVER['REQUEST_URI'], '?'), '/'));
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

    $arResult['MAX_DEPTH'] = \DbCatalogUtils::determineMaxDepth($arParams);

    $arResult['NOW_DEPTH'] = \DbCatalogUtils::determineСurrentDepth();

    DbCatalogFiller::fill($arResult, $arParams);

    $arRequestChunks = DbCatalogUtils::getNowRequestChunks();

    $i = 0;
    foreach ($arResult['ACTIVE_ELEMENTS_CODE'] as $value) {
        $i++;
        $APPLICATION->AddChainItem($value['NAME'], '/' . implode('/', \array_slice($arRequestChunks, 0, $i)) . '/');
    }

    if ($arResult['NOW_DEPTH'] === $arResult['MAX_DEPTH'] + 1) {
        $this->IncludeComponentTemplate('detail');
    } else {
        $this->IncludeComponentTemplate('section_depth_' . $arResult['NOW_DEPTH']);
    }
    
} catch (Exception $ex) {
    $APPLICATION->ThrowException($ex->getMessage());
    ShowError($ex->getMessage());
}
