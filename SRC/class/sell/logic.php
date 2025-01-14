<?php

//
// 売主物件画面
//
function subSell()
{
    $param = getSellParam();

    if ($param["sDel"] == '') {
        $param["sDel"] = 1;
    }

    if (! $param["sPage"]) {
        $param["sPage"] = 1;
    }

    if (! $param["orderBy"]) {
        $param["orderBy"] = 'SEARCHDT';
        $param["orderTo"] = 'desc';
    }

    subMenu();
    subSellView($param);
}

//
// 売主物件編集画面
//
function subSellEdit()
{
    $param = getSellParam();

    $param["sellNo"] = $_REQUEST['sellNo'];

    if ($param["sellNo"]) {
        $sql = fnSqlSellEdit($param["sellNo"]);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $param["searchDT"] = htmlspecialchars($row[0]);
        $param["article"] = htmlspecialchars($row[1]);
        $param["address"] = htmlspecialchars($row[2]);
        $param["station"] = htmlspecialchars($row[3]);
        $param["foot"] = htmlspecialchars($row[4]);
        $param["years"] = htmlspecialchars($row[5]);
        $param["floor"] = htmlspecialchars($row[6]);
        $param["area"] = htmlspecialchars($row[7]);
        $param["seller"] = htmlspecialchars($row[8]);
        $param["price"] = htmlspecialchars($row[9]);
        $param["note"] = htmlspecialchars($row[10]);

        $param["purpose"] = '更新';
        $param["btnImage"] = 'btn_load.png';
    } else {
        $param["purpose"] = '登録';
        $param["btnImage"] = 'btn_enter.png';
    }

    subMenu();
    subSellEditView($param);
}

//
// 売主物件編集完了処理
//
function subSellEditComplete()
{
    $param = getSellParam();

    $param["sellNo"] = mysqli_real_escape_string($param["conn"], $_REQUEST['sellNo']);
    $param["searchDT"] = mysqli_real_escape_string($param["conn"], $_REQUEST['searchDT']);
    $param["article"] = mysqli_real_escape_string($param["conn"], $_REQUEST['article']);
    $param["address"] = mysqli_real_escape_string($param["conn"], $_REQUEST['address']);
    $param["station"] = mysqli_real_escape_string($param["conn"], $_REQUEST['station']);
    $param["foot"] = mysqli_real_escape_string($param["conn"], $_REQUEST['foot']);
    $param["years"] = mysqli_real_escape_string($param["conn"], $_REQUEST['years']);
    $param["floor"] = mysqli_real_escape_string($param["conn"], $_REQUEST['floor']);
    $param["area"] = mysqli_real_escape_string($param["conn"], $_REQUEST['area']);
    $param["seller"] = mysqli_real_escape_string($param["conn"], $_REQUEST['seller']);
    $param["price"] = mysqli_real_escape_string($param["conn"], $_REQUEST['price']);
    $param["note"] = mysqli_real_escape_string($param["conn"], $_REQUEST['note']);

    if ($param["sellNo"]) {
        $sql = fnSqlSellUpdate($param);
        $res = mysqli_query($param["conn"], $sql);
    } else {
        $param["sellNo"] = fnNextNo('SELL');
        $sql = fnSqlSellInsert($param);
        $res = mysqli_query($param["conn"], $sql);
    }

    $_REQUEST['act'] = 'sellSearch';
    subSell();
}

//
// 売主物件削除処理
//
function subSellDelete()
{
    $conn = fnDbConnect();

    $param["sellNo"] = $_REQUEST['sellNo'];

    $sql = fnSqlSellDelete($param["sellNo"]);
    $res = mysqli_query($conn, $sql);

    $_REQUEST['act'] = 'sellSearch';
    subSell();
}

//
// 画面間引継ぎ情報
//
function getSellParam()
{
    $param = array();

    // DB接続
    $param["conn"] = fnDbConnect();

    // 検索情報
    $param["sSearchFrom"] = htmlspecialchars($_REQUEST['sSearchFrom']);
    $param["sSearchTo"] = htmlspecialchars($_REQUEST['sSearchTo']);
    $param["sArticle"] = htmlspecialchars($_REQUEST['sArticle']);
    $param["sAddress"] = htmlspecialchars($_REQUEST['sAddress']);
    $param["sStation"] = htmlspecialchars($_REQUEST['sStation']);
    $param["sFoot"] = htmlspecialchars($_REQUEST['sFoot']);
    $param["sFootC"] = htmlspecialchars($_REQUEST['sFootC']);
    $param["sAreaFrom"] = htmlspecialchars($_REQUEST['sAreaFrom']);
    $param["sAreaTo"] = htmlspecialchars($_REQUEST['sAreaTo']);
    $param["sYearsFrom"] = htmlspecialchars($_REQUEST['sYearsFrom']);
    $param["sYearsTo"] = htmlspecialchars($_REQUEST['sYearsTo']);
    $param["sPriceFrom"] = htmlspecialchars($_REQUEST['sPriceFrom']);
    $param["sPriceTo"] = htmlspecialchars($_REQUEST['sPriceTo']);
    $param["sSeller"] = htmlspecialchars($_REQUEST['sSeller']);

    $param["orderBy"] = $_REQUEST['orderBy'];
    $param["orderTo"] = $_REQUEST['orderTo'];
    $param["sPage"] = $_REQUEST['sPage'];

    return $param;
}
