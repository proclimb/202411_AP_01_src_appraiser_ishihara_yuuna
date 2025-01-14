<?php
require ('class/stock/logic.php');
require ('class/stock/model.php');
require ('class/stock/view.php');

function stock_control()
{
    switch ($_REQUEST['act']) {

        // 仕入管理
        case 'stock':
        case 'stockSearch':
            subStock();
            break;

        case 'stockEdit':
            subStockEdit();
            break;

        case 'stockEditComplete':
            subStockEditComplete();
            break;

        case 'stockDelete':
            subStockDelete();
            break;

        case 'stockListDelete':
            subStockListDelete();
            break;
    }
}
