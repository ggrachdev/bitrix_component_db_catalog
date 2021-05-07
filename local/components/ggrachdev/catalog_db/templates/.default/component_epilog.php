<?php

if ($arResult['NOW_DEPTH'] === 2) {
    $APPLICATION->SetTitle(
       'Аккумуляторы для автомобилей '. $arResult['ACTIVE_ELEMENTS'][1]['CORRECT_NAME']
    );
    
    $APPLICATION->SetPageProperty("title", 
        'Купить аккумуляторы для автомобиля ' . $arResult['ACTIVE_ELEMENTS'][1]['CORRECT_NAME'] . ' в Ижевске. Цены на АКБ для автомобилей ' . $arResult['ACTIVE_ELEMENTS'][1]['CORRECT_NAME']
    );
} else if ($arResult['NOW_DEPTH'] === 3) {
    $APPLICATION->SetTitle(
       'Аккумуляторы для автомобилей '. $arResult['ACTIVE_ELEMENTS'][2]['CORRECT_NAME']
    );
    
    $APPLICATION->SetPageProperty("title", 
        'Купить аккумуляторы для автомобиля ' . $arResult['ACTIVE_ELEMENTS'][2]['CORRECT_NAME'] . ' в Ижевске. Цены на АКБ для автомобилей ' . $arResult['ACTIVE_ELEMENTS'][2]['CORRECT_NAME']
    );
} else if ($arResult['NOW_DEPTH'] === 4) {
    $APPLICATION->SetTitle(
       'Аккумуляторы для автомобилей '. $arResult['ACTIVE_ELEMENTS'][3]['CORRECT_NAME']
    );
    
    $APPLICATION->SetPageProperty("title", 
        'Купить аккумуляторы для автомобиля ' . $arResult['ACTIVE_ELEMENTS'][3]['CORRECT_NAME'] . ' в Ижевске. Цены на АКБ для автомобилей ' . $arResult['ACTIVE_ELEMENTS'][3]['CORRECT_NAME']
    );
} else if ($arResult['NOW_DEPTH'] === 5) {
    $APPLICATION->SetTitle(
       'Аккумуляторы для автомобилей '. $arResult['ACTIVE_ELEMENTS'][3]['CORRECT_NAME'].' с модификацией '. $arResult['ACTIVE_ELEMENTS'][4]['CORRECT_NAME']
    );
    
    $APPLICATION->SetPageProperty("title", 
        'Купить аккумуляторы для автомобиля ' . $arResult['ACTIVE_ELEMENTS'][3]['CORRECT_NAME'] . ' в Ижевске. Цены на АКБ для автомобилей ' . $arResult['ACTIVE_ELEMENTS'][3]['CORRECT_NAME'].' с модификацией '. $arResult['ACTIVE_ELEMENTS'][4]['CORRECT_NAME']
    );
}