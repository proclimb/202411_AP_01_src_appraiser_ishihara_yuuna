<?php
require ('class/title/logic.php');
require ('class/title/model.php');
require ('class/title/view.php');

function fTitle_control()
{
    switch ($_REQUEST['act']) {

        // 案内管理一覧
        case 'fTitle':
        case 'fTitleSearch':
            subFTitle();
            break;

        case 'fTitleItemSearch':
            subFTitleItem();
            break;

        case 'fTitleEdit':
            subFTitleEdit();
            break;

        case 'fTitleEditComplete':
            subFTitleEditComplete();
            break;

        case 'fTitleItemEdit':
            subFTitleItemEdit();
            break;

        case 'fTitleDelete':
            subFTitleDelete();
            break;
    }
}
