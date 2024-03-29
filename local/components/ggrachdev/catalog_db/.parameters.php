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
        "ORM_TABLE_CLASS" => [
            "PARENT" => "BASE",
            "NAME" => 'Класс ORM формата \\A\\B\\C',
            "COLS" => 40,
            "TYPE" => "STRING"
        ],
        "SECTIONS_TEMPLATE" => [
            "PARENT" => "BASE",
            "NAME" => 'Путь до секций',
            "TYPE" => "STRING",
            "DEFAULT" => "/section/"
        ],
        "SECTION_TEMPLATE" => [
            "PARENT" => "BASE",
            "NAME" => 'Путь до секции',
            "TYPE" => "STRING",
            "DEFAULT" => "#SECTION_CODE_PATH#/",
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
        "CODE_COLUMN_5_LEVEL" => [
            "PARENT" => "BASE",
            "NAME" => 'Код колонки 5 уровня',
            "TYPE" => "STRING"
        ],
        "CODE_COLUMN_6_LEVEL" => [
            "PARENT" => "BASE",
            "NAME" => 'Код колонки 6 уровня',
            "TYPE" => "STRING"
        ],
        "SET_404" => [
            "PARENT" => "BASE",
            "NAME" => 'Устанавливать 404 статус при некорректном вводе элемента',
            "TYPE" => "CHECKBOX"
        ],
    ]
];