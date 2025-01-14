<?php

//
// 仕入管理画面
//
function subStock()
{
    $param = getStockParam();

    if ($_REQUEST['act'] == 'guide') {
        // 案内日の開始日を1ヶ月前に設定
        $param["sGuideDTFrom"] = date('Y/m/d', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
    }

    if ($param["sDel"] == '') {
        $param["sDel"] = 1;
    }

    if (! $param["sPage"]) {
        $param["sPage"] = 1;
    }

    if (! $param["orderBy"]) {
        $param["orderBy"] = 'STOCKNO';
        $param["orderTo"] = 'DESC';
    }

    subMenu();
    subStockView($param);
}

//
// 仕入管理編集画面
//
function subStockEdit()
{
    $param = getStockParam();

    $param["stockNo"] = $_REQUEST['stockNo'];

    if ($param["stockNo"]) {
        $sql = fnSqlStockEdit($param["stockNo"]);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $param["charge"] = htmlspecialchars($row[0]);
        $param["rank"] = htmlspecialchars($row[1]);
        $param["article"] = htmlspecialchars($row[2]);
        $param["articleFuri"] = htmlspecialchars($row[3]);
        $param["room"] = htmlspecialchars($row[4]);
        $param["area"] = htmlspecialchars($row[5]);
        $param["station"] = htmlspecialchars($row[6]);
        $param["distance"] = htmlspecialchars($row[7]);
        $param["agent"] = htmlspecialchars($row[8]);
        $param["store"] = htmlspecialchars($row[9]);
        $param["cover"] = htmlspecialchars($row[10]);
        $param["visitDT"] = htmlspecialchars($row[11]);
        $param["deskPrice"] = htmlspecialchars($row[12]);
        $param["vendorPrice"] = htmlspecialchars($row[13]);
        $param["note"] = htmlspecialchars($row[14]);
        $param["how"] = htmlspecialchars($row[15]);
        $param["del"] = htmlspecialchars($row[16]);

        $param["purpose"] = '更新';
        $param["btnImage"] = 'btn_load.png';
    } else {
        $param["purpose"] = '登録';
        $param["btnImage"] = 'btn_enter.png';
    }

    subMenu();
    subStockEditView($param);
}

//
// 仕入管理編集完了処理
//
function subStockEditComplete()
{
    $conn = fnDbConnect();

    $param["sDel"] = htmlspecialchars($_REQUEST['sDel']);
    $param["sInsDTFrom"] = htmlspecialchars($_REQUEST['sInsDTFrom']);
    $param["sInsDTTo"] = htmlspecialchars($_REQUEST['sInsDTTo']);
    $param["sCharge"] = htmlspecialchars($_REQUEST['sCharge']);
    $param["sRank"] = $_REQUEST['sRank'];
    $param["sArticle"] = htmlspecialchars($_REQUEST['sArticle']);
    $param["sArticleFuri"] = htmlspecialchars($_REQUEST['sArticleFuri']);
    $param["sAreaFrom"] = htmlspecialchars($_REQUEST['sAreaFrom']);
    $param["sAreaTo"] = htmlspecialchars($_REQUEST['sAreaTo']);
    $param["sStation"] = htmlspecialchars($_REQUEST['sStation']);
    $param["sDistance"] = $_REQUEST['sDistance'];
    $param["sAgent"] = htmlspecialchars($_REQUEST['sAgent']);
    $param["sStore"] = htmlspecialchars($_REQUEST['sStore']);
    $param["sCover"] = htmlspecialchars($_REQUEST['sCover']);
    $param["sVisitDTFrom"] = htmlspecialchars($_REQUEST['sVisitDTFrom']);
    $param["sVisitDTTo"] = htmlspecialchars($_REQUEST['sVisitDTTo']);
    $param["sHow"] = $_REQUEST['sHow'];

    $param["orderBy"] = $_REQUEST['orderBy'];
    $param["orderTo"] = $_REQUEST['orderTo'];
    $param["sPage"] = $_REQUEST['sPage'];

    $param["stockNo"] = mysqli_real_escape_string($conn, $_REQUEST['stockNo']);
    $param["charge"] = mysqli_real_escape_string($conn, $_REQUEST['charge']);
    $param["rank"] = mysqli_real_escape_string($conn, $_REQUEST['rank']);
    $param["article"] = mysqli_real_escape_string($conn, $_REQUEST['article']);
    $param["articleFuri"] = mysqli_real_escape_string($conn, $_REQUEST['articleFuri']);
    $param["room"] = mysqli_real_escape_string($conn, $_REQUEST['room']);
    $param["area"] = mysqli_real_escape_string($conn, $_REQUEST['area']);
    $param["station"] = mysqli_real_escape_string($conn, $_REQUEST['station']);
    $param["distance"] = mysqli_real_escape_string($conn, $_REQUEST['distance']);
    $param["agent"] = mysqli_real_escape_string($conn, $_REQUEST['agent']);
    $param["store"] = mysqli_real_escape_string($conn, $_REQUEST['store']);
    $param["cover"] = mysqli_real_escape_string($conn, $_REQUEST['cover']);
    $param["visitDT"] = mysqli_real_escape_string($conn, $_REQUEST['visitDT']);
    $param["deskPrice"] = mysqli_real_escape_string($conn, $_REQUEST['deskPrice']);
    $param["vendorPrice"] = mysqli_real_escape_string($conn, $_REQUEST['vendorPrice']);
    $param["note"] = mysqli_real_escape_string($conn, $_REQUEST['note']);
    $param["how"] = mysqli_real_escape_string($conn, $_REQUEST['how']);
    $param["del"] = mysqli_real_escape_string($conn, $_REQUEST['del']);

    if ($param["stockNo"]) {
        $sql = fnSqlStockUpdate($param);
        $res = mysqli_query($conn, $sql);
    } else {
        $param["stockNo"] = fnNextNo('STOCK');
        $sql = fnSqlStockInsert($param);
        $res = mysqli_query($conn, $sql);
    }

    $_REQUEST['act'] = 'stockSearch';
    subStock();
}

//
// 仕入管理削除処理
//
function subStockDelete()
{
    $conn = fnDbConnect();

    $param["stockNo"] = $_REQUEST['stockNo'];

    $sql = fnSqlStockDelete($param["stockNo"]);
    $res = mysqli_query($conn, $sql);

    $_REQUEST['act'] = 'stockSearch';
    subStock();
}

//
// 仕入管理一括削除処理
//
function subStockListDelete()
{
    $conn = fnDbConnect();

    $delStockList = $_REQUEST['delStockList'];
    $delStockListArray = array();

    $delStockListArray = explode(",", $delStockList);
    $sql = fnSqlStockListDelete($delStockListArray);
    $res = mysqli_query($conn, $sql);

    $_REQUEST['act'] = 'stockSearch';
    subStock();
}

//
// 画面間引継ぎ情報
//
function getStockParam()
{
    $param = array();

    // DB接続
    $param["conn"] = fnDbConnect();

    // 検索情報
    $param["sDel"] = htmlspecialchars($_REQUEST['sDel']);
    $param["sInsDTFrom"] = htmlspecialchars($_REQUEST['sInsDTFrom']);
    $param["sInsDTTo"] = htmlspecialchars($_REQUEST['sInsDTTo']);
    $param["sCharge"] = htmlspecialchars($_REQUEST['sCharge']);
    $param["sRank"] = $_REQUEST['sRank'];
    $param["sArticle"] = htmlspecialchars($_REQUEST['sArticle']);
    $param["sArticleFuri"] = htmlspecialchars($_REQUEST['sArticleFuri']);
    $param["sAreaFrom"] = htmlspecialchars($_REQUEST['sAreaFrom']);
    $param["sAreaTo"] = htmlspecialchars($_REQUEST['sAreaTo']);
    $param["sStation"] = htmlspecialchars($_REQUEST['sStation']);
    $param["sDistance"] = $_REQUEST['sDistance'];
    $param["sAgent"] = htmlspecialchars($_REQUEST['sAgent']);
    $param["sStore"] = htmlspecialchars($_REQUEST['sStore']);
    $param["sCover"] = htmlspecialchars($_REQUEST['sCover']);
    $param["sVisitDTFrom"] = htmlspecialchars($_REQUEST['sVisitDTFrom']);
    $param["sVisitDTTo"] = htmlspecialchars($_REQUEST['sVisitDTTo']);
    $param["sHow"] = $_REQUEST['sHow'];

    $param["orderBy"] = $_REQUEST['orderBy'];
    $param["orderTo"] = $_REQUEST['orderTo'];
    $param["sPage"] = $_REQUEST['sPage'];

    return $param;
}
