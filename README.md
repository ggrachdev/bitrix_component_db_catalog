Компонент, который выводит каталог поверх базы данных с разделами, которые являются колонками БД. Протестировано на базе данных с 300 тысячами строками

Пример вызова компонента с каталогом:
```php
<?
$APPLICATION->IncludeComponent(
	"ggrachdev:catalog_db", 
	".default", 
	array(
		"CODE_COLUMN_1_LEVEL" => "vendor",
		"CODE_COLUMN_2_LEVEL" => "car_group",
		"CODE_COLUMN_3_LEVEL" => "car",
		"CODE_COLUMN_4_LEVEL" => "modification",
		"CODE_COLUMN_5_LEVEL" => "",
		"COMPONENT_TEMPLATE" => ".default",
		"TABLE_NAME" => "accumulators",
		"ORM_TABLE_CLASS" => "\\FRED\\Models\\BatteryTable",
		"SECTIONS_TEMPLATE" => "/auto/",
		"SECTION_TEMPLATE" => "#SECTION_CODE_PATH#/",
		"CODE_COLUMN_5_LEVEL" => "",
		"CODE_COLUMN_6_LEVEL" => "",
		"SET_404" => "Y"
	),
	false
);?>
```

В urlrewrite.php добавьте:

```php
9999 => array (
    'CONDITION' => '#^/auto/([a-z0-9-/\\_,]+)/.*#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/auto/index.php',
    'SORT' => 100,
)
```
