<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;

$arResult['CATALOG'] = [
    'ACTIVE_ELEMENTS' => [
        
    ],
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

                DbCatalogUtils::fillActiveElement($depth-1, $arResult);
                $filter = \DbCatalogUtils::getFilerForDepth($depth, $arResult, $arParams);

//                $dbDepth = $arParams['ORM_TABLE_CLASS']::getList([
//                        'select' => [$arParams['CODE_COLUMN_' . $depth . '_LEVEL']],
//                        'filter' => [
//                            
//                        ],
//                        'group' => [$arParams['CODE_COLUMN_' . $depth . '_LEVEL']]
//                ]);
//
//                $resDepth = $dbDepth->fetchAll();
//
//                $arResult['CATALOG']['ITEMS_LEVEL_' . $depth] = $resDepth;
            }
        }
    }

}

class DbCatalogUtils {
    
    public static function fillActiveElement($depth, &$arResult)
    {
        if(!empty($arResult['CATALOG']['ITEMS_LEVEL_'.$depth])) {
            $arRequestChunks = self::getNowRequestChunks();
            
            $codeActiveElement = $arRequestChunks[$depth];
            
            foreach ($arResult['CATALOG']['ITEMS_LEVEL_'.$depth] as $value) {
                if($value['CODE'] === $codeActiveElement)
                {
                    $arResult['ACTIVE_ELEMENTS'][$depth] = $value;
                    break;
                }
            }
        }
    }

    public static function getFilerForDepth($depth, $arResult, $arParams) {
        $arFilter = [];

        if ($arResult['NOW_DEPTH'] > 1) {
            $arRequestChunks = self::getNowRequestChunks();
            
            if(!empty($arParams['CODE_COLUMN_'.$depth.'_LEVEL'])) {
                $arFilter[$arParams['CODE_COLUMN_'.$depth.'_LEVEL']] = $arResult['ACTIVE_ELEMENTS'][$depth-1]['NAME'];
            }
        }

        dre($depth);
        dre($arFilter);

        return $arFilter;
    }

    public static function determineСurrentDepth() {
        return sizeof(self::getNowRequestChunks());
    }

    public static function getNowRequestChunks() {
        return explode('/', trim($_SERVER['REQUEST_URI'], '/'));
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

    if (!empty($arParams['CODE_COLUMN_2_LEVEL'])) {
        $arResult['MAX_DEPTH'] = 2;

        if (!empty($arParams['CODE_COLUMN_3_LEVEL'])) {
            $arResult['MAX_DEPTH'] = 3;

            if (!empty($arParams['CODE_COLUMN_4_LEVEL'])) {
                $arResult['MAX_DEPTH'] = 4;
            }
        }
    }

    $arResult['NOW_DEPTH'] = \DbCatalogUtils::determineСurrentDepth();

    DbCatalogFiller::fill($arResult, $arParams);

    if ($arResult['NOW_DEPTH'] === 1) {
        $this->IncludeComponentTemplate('sections');
    } else {
        $this->IncludeComponentTemplate('section_depth_' . $arResult['NOW_DEPTH']);
    }
} catch (Exception $ex) {
    $APPLICATION->ThrowException($ex->getMessage());
    ShowError($ex->getMessage());
}
