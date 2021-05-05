<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
$arResult['FILTER_AKB'] = null;

if ($arResult['NOW_DEPTH'] === 3 || $arResult['NOW_DEPTH'] === 4) {

    $arFilter = [];

    foreach ($arResult['ACTIVE_ELEMENTS_CODE'] as $k => $v) {
        $arFilter[$k] = $v['NAME'];
    }

    $dbres = $arParams['ORM_TABLE_CLASS']::getList([
            'select' => ['*'],
            'filter' => $arFilter
    ]);
    $res = $dbres->fetchAll();

    if (!empty($res)) {

        $minHeight = null;
        $maxHeight = null;

        $minWidth = null;
        $maxWidth = null;

        $minLength = null;
        $maxLength = null;

        $polarnost = [];

        foreach ($res as $row) {
            if ($minHeight === null || $minHeight > $row['visota']) {
                $minHeight = $row['visota'];
            }

            if ($maxHeight === null || $row['visota'] > $maxHeight) {
                $maxHeight = $row['visota'];
            }

            if ($minWidth === null || $minWidth > $row['shirina']) {
                $minWidth = $row['shirina'];
            }

            if ($maxWidth === null || $row['shirina'] > $maxWidth) {
                $maxWidth = $row['shirina'];
            }

            if ($minLength === null || $minLength > $row['dlina']) {
                $minLength = $row['dlina'];
            }

            if ($maxLength === null || $row['dlina'] > $maxLength) {
                $maxLength = $row['dlina'];
            }

            if ($row['polarnost'] == 1) {
                $polarnost_value = '1 прямая (+ -)';
                $polarnost_code = '1-pryamaya-';
            } elseif (row['polarnost'] == 0) {
                $polarnost_value = '0 обратная (- +)';
                $polarnost_code = '0-obratnaya-';
            } elseif (row['polarnost'] == 2) {
                $polarnost_value = 'симметрия';
                $polarnost_code = '1-pryamaya--or-0-obratnaya-';
            }

            if (!\in_array($polarnost_value, $polarnost)) {
                $polarnost[] = $polarnost_value;
            }
        }


        $arResult['FILTER_AKB'] = [
            'IBLOCK_ID' => 20,
            'ACTIVE' => 'Y',
//                        '<=PROPERTY_YEMKOST_ACH_' => $emkost_max,
            '=PROPERTY_POLYARNOST_VALUE' => $polarnost,
//                        '>=PROPERTY_YEMKOST_ACH_' => $emkost_min,
            '<=PROPERTY_DLINA' => $maxLength,
            '>=PROPERTY_DLINA' => $minLength,
            '<=PROPERTY_SHIRINA' => $maxWidth,
            '>=PROPERTY_SHIRINA' => $minWidth,
            '<=PROPERTY_VYSOTA' => $maxHeight,
            '>=PROPERTY_VYSOTA' => $minHeight,
            '>CATALOG_QUANTITY' => 0
        ];
    }
}