<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?

if (!empty($arResult['CATALOG']['ITEMS_LEVEL_3'])):
    
    dre($arResult, '+-a');
    ?>

    <div class="section_block section_block_brands">
        <div class="sections_wrapper ">
            <div class="list items">
                <div class="row margin0 flexbox">
                    <? foreach ($arResult['CATALOG']['ITEMS_LEVEL_3'] as $section): ?>
                        <div class="col-md-2 col-sm-2 col-xs-4">
                            <div class="item">
                                <div class="name">
                                    <a href="<?=$section['LINK']?>" class="dark_link"><?=$section['NAME']?></a>
                                </div>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <?
endif;
?>