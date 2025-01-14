<?php
require ('class/guide/logic.php');
require ('class/guide/model.php');
require ('class/guide/view.php');
require ('class/guide/lib.php');

function guide_control()
{
    switch ($_REQUEST['act']) {

        // 案内管理一覧
        case 'guide':
        case 'guideSearch':
            subGuide();
            break;

        case 'guideShowTrade':
            subGuideShowTrade();
            break;

        case 'guideShowKey':
            subGuideShowKey();
            break;

        // 物件検索
        case 'guideChoice':
        case 'guideChoiceSearch':
            subGuideChoice();
            break;

        case 'guideEdit':
            subGuideEdit();
            break;

        case 'guideEditComplete':
            subGuideEditComplete();
            break;

        case 'guideDelete':
            subGuideDelete();
            break;
    }
}
