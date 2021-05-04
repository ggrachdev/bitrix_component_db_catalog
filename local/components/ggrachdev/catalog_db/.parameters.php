<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 * */

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS" => [
        "IBLOCK_ID" => [
            "PARENT" => "BASE",
            "NAME" => 'Название таблицы',
            "TYPE" => "STRING"
        ],
        "CODE_COLUMN_1_LEVEL" => [
            "PARENT" => "BASE",
            "NAME" => 'Код колонки 1 уровня',
            "TYPE" => "STRING"
        ],
        "CODE_COLUMN_2_LEVEL" => [
            "PARENT" => "BASE",
            "NAME" => 'Код колонки 2 уровня',
            "TYPE" => "STRING"
        ],
        "CODE_COLUMN_3_LEVEL" => [
            "PARENT" => "BASE",
            "NAME" => 'Код колонки 3 уровня',
            "TYPE" => "STRING"
        ],
        "CODE_COLUMN_4_LEVEL" => [
            "PARENT" => "BASE",
            "NAME" => 'Код колонки 4 уровня',
            "TYPE" => "STRING"
        ],
    ]
];