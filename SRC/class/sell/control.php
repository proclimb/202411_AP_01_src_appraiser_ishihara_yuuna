<?php
require ('class/sell/logic.php');
require ('class/sell/model.php');
require ('class/sell/view.php');

function sell_control()
{
    switch ($_REQUEST['act']) {

        // 売主物件
        case 'sell':
        case 'sellSearch':
            subSell();
            break;

        case 'sellEdit':
            subSellEdit();
            break;

        case 'sellEditComplete':
            subSellEditComplete();
            break;

        case 'sellDelete':
            subSellDelete();
            break;
    }
}
