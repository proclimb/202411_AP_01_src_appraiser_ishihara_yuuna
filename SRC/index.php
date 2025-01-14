<?php
// ライブラリの呼出し
require ('libDBInit.php');
require ('libDBConnect.php');
require ('libPage.php');

// ユーザ&メニュー
require ('libAdminUser.php');
require ('libLoginout.php');
require ('libMenu.php');

// 売主
require ('class/sell/control.php');

// 仕入
require ('class/stock/control.php');

// 物件
require ('libArticle.php');
require ('libDBArticle.php');

// 工事
require ('libConst.php');
require ('libDBConst.php');

// 業者
require ('libTrade.php');
require ('libDBTrade.php');

// 案内
require ('class/guide/control.php');

// ファイルマネージャー
require ('libFManager.php');
require ('libDBFManager.php');

// タイトル変更
require ('class/title/control.php');

// 一覧表示件数
define("PAGE_MAX", 100);

// ログインチェック
switch ($_REQUEST['act']) {
    // ログインチェック
    case 'loginCheck':
        subLoginCheck();
        break;

    // ログアウト
    case 'logout':
        $_COOKIE['cUserNo'] = '';
        $_COOKIE['authority'] = '';
        break;
}

// クッキー情報の取得
if ($_COOKIE['cUserNo'] != '' && $_COOKIE['authority'] != '') {
    setcookie('cUserNo', $_COOKIE['cUserNo'], time() + 60 * 60 * 24 * 365);
    setcookie('authority', $_COOKIE['authority'], time() + 60 * 60 * 24 * 365);
    if (! $_REQUEST['act']) {
        $_REQUEST['act'] = 'menu';
    }
} else {
    setcookie('cUserNo', $_COOKIE['cUserNo'], time() - 1);
    setcookie('authority', $_COOKIE['authority'], time() - 1);
    $_REQUEST['act'] = '';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="./css/style.css" />
<script type="text/javascript" src="./js/common.js"></script>
<script type="text/javascript" src="./js/jkl-calendar.js"></script>
</head>

<body>

<?php
switch ($_REQUEST['act']) {

    // ログイン
    case '':
    case 'reLogin':
        subLogin();
        break;

    // ログイン後のメニュー表示
    case 'menu':
        subMenu();
        break;

    // ユーザー情報
    case 'adminUser':
        subAdminUser();
        break;

    case 'adminUserEdit':
        subAdminUserEdit();
        break;

    case 'adminUserEditComplete':
        subAdminUserEditComplete();
        break;

    case 'adminUserDelete':
        subAdminUserDelete();
        break;

    // 売主物件
    case 'sell':
    case 'sellSearch':
    case 'sellEdit':
    case 'sellEditComplete':
    case 'sellDelete':
        sell_control();
        break;

    // 仕入管理
    case 'stock':
    case 'stockSearch':
    case 'stockEdit':
    case 'stockEditComplete':
    case 'stockDelete':
    case 'stockListDelete':
        stock_control();
        break;

    // 物件管理
    case 'article':
    case 'articleSearch':
        subArticle();
        break;

    case 'articleEdit':
        subArticleEdit();
        break;

    case 'articleEditComplete':
        subArticleEditComplete();
        break;

    case 'articleDelete':
        subArticleDelete();
        break;

    // 工事管理表関連処理
    case 'const':
    case 'constSearch':
        subConst();
        break;

    case 'constEdit':
        subConstEdit();
        break;

    case 'constEditComplete':
        subConstEditComplete();
        break;

    // 業者一覧関連処理
    case 'trade':
    case 'tradeSearch':
        subTrade();
        break;

    case 'tradeEdit':
        subTradeEdit();
        break;

    case 'tradeEditComplete':
        subTradeEditComplete();
        break;

    case 'tradeDelete':
        subTradeDelete();
        break;

    // 案内管理関連処理
    case 'guide':
    case 'guideSearch':
    case 'guideShowTrade':
    case 'guideShowKey':
    case 'guideChoice':
    case 'guideChoiceSearch':
    case 'guideEdit':
    case 'guideEditComplete':
    case 'guideDelete':
        guide_control();
        break;

    // ファイルマネージャ関連処理
    case 'fManager':
    case 'fManagerSearch':
        subFManager();
        break;

    case 'fManagerEdit':
        subFManagerEdit();
        break;

    case 'fManagerEditComplete':
        subFManagerEditComplete();
        break;

    case 'fManagerDelete':
        subFManagerDelete();
        break;

    case 'fManagerView':
        subFManagerView();
        break;

    case 'fManagerViewEdit':
        subFManagerViewEdit();
        break;

    case 'fManagerViewEditComplete':
        subFManagerViewEditComplete();
        break;

    case 'fManagerViewDelete':
        subFManagerViewDelete();
        break;

    // タイトル管理関連処理
    case 'fTitle':
    case 'fTitleSearch':
    case 'fTitleItemSearch':
    case 'fTitleEdit':
    case 'fTitleEditComplete':
    case 'fTitleDelete':
    case 'fTitleItemEdit':
        Ftitle_control();
        break;
}
?>

</body>
</html>
