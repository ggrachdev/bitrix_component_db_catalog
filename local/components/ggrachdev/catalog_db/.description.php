<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = [
    "NAME" => "Каталог поверх базы данных",
    "DESCRIPTION" => "Компонент выводит каталог поверх базы данных",
    "PATH" => [
        "ID" => "GGRACHDEV_SOLUTIONS",
        "NAME" => "Решения GGRACHDEV",
        "CHILD" => [
            "ID" => "GGRACHDEV_SOLUTIONS__CATALOG_DB",
            "NAME" => "Информация"
        ]
    ]
];