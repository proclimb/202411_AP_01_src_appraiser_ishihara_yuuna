<?php

//
// 案内管理画面
//
function subGuide()
{
    $param = getGuideParam();
    if ($_REQUEST['act'] == 'guide') {
        // 案内日の開始日を1ヶ月前に設定
        $param["sGuideDTFrom"] = date('Y/m/d', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
    }

    if ($param["sDel"] == '') {
        $param["sDel"] = 1;
    }

    if (!$param["sPage"]) {
        $param["sPage"] = 1;
    }

    if (!$param["orderBy"]) {
        $param["orderBy"] = 'A.GUIDESTARTDT';
        $param["orderTo"] = 'DESC';
    }

    subMenu();
    subGuideView($param);
}

//
// 案内管理業者表示画面
//
function subGuideShowTrade()
{
    $conn = fnDbConnect();

    $guideNo = $_REQUEST['guideNo'];

    $sql = fnSqlGuideEdit($guideNo);
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);

    $param = array();
    $param["name"] = htmlspecialchars($row["NAME"]);
    $param["branch"] = htmlspecialchars($row["BRANCH"]);
    $param["tel"] = htmlspecialchars($row["TEL"]);
    $param["fax"] = htmlspecialchars($row["FAX"]);
    $param["charge"] = htmlspecialchars($row["CHARGE"]);

    subGuideShowTradeView($param);
}

//
// 案内管理物件表示画面
//
function subGuideShowKey()
{
    $param = array();
    $conn = fnDbConnect();

    $articleNo = $_REQUEST['articleNo'];

    $sql = fnSqlArticleEdit($articleNo);
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);

    $param["article"] = htmlspecialchars($row["ARTICLE"]);
    $param["room"] = htmlspecialchars($row["ROOM"]);
    $param["keyPlace"] = htmlspecialchars($row["KEYPLACE"]);
    $param["articleNote"] = htmlspecialchars($row["ARTICLENOTE"]);
    $param["keyBox"] = htmlspecialchars($row["KEYBOX"]);
    $param["drawing"] = htmlspecialchars($row["DRAWING"]);
    $param["sellCharge"] = htmlspecialchars($row["SELLCHARGE"]);

    $sql = fnSqlConstEdit($articleNo);
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);

    $param["workStartDT"] = htmlspecialchars($row["WORKSTARTDT"]);
    $param["workEndDT"] = htmlspecialchars($row["WORKENDDT"]);

    subGuideShowKeyView($param);
}

//
// 物件検索画面
//
function subGuideChoice()
{
    $param = getGuideParam();
    $param["cDel"] = htmlspecialchars($_REQUEST['cDel']);
    $param["cArticle"] = htmlspecialchars($_REQUEST['cArticle']);
    $param["cRoom"] = htmlspecialchars($_REQUEST['cRoom']);

    if ($param["cDel"] == '') {
        $param["cDel"] = 1;
    }

    $act = $_REQUEST['act'];
    if ($act === 'guideChoice') {
        $param["orderBy"] = 'ARTICLENO';
        $param["orderTo"] = 'desc';
        $param["sPage"] = 1;
    }

    subMenu();
    subGuideChoiceView($param);
}

//
// 案内管理編集画面
//
function subGuideEdit()
{
    $param = getGuideParam();

    $param["guideNo"] = $_REQUEST['guideNo']; // 案内管理一覧画面から(編集モード)
    $param["articleNo"] = $_REQUEST['articleNo']; // 物件検索画面から(新規作成)

    if ($param["guideNo"]) {
        // 編集モード
        $sql = fnSqlGuideEdit($param["guideNo"]);
        $res = mysqli_query($param["conn"], $sql);
        $row = mysqli_fetch_array($res);

        $param["content"] = htmlspecialchars($row["CONTENT"]);
        $param["guideStartDT"] = htmlspecialchars($row["GUIDESTARTDT"]);
        $param["guideEndDT"] = htmlspecialchars($row["GUIDEENDDT"]);
        $param["guideStartTM"] = htmlspecialchars($row["GUIDESTARTTM"]);
        $param["guideEndTM"] = htmlspecialchars($row["GUIDEENDTM"]);
        $param["charge"] = htmlspecialchars($row["CHARGE"]);
        $param["result"] = htmlspecialchars($row["RESULT"]);
        $param["acceptDT"] = htmlspecialchars($row["ACCEPTDT"]);
        $param["accept"] = htmlspecialchars($row["ACCEPT"]);
        $param["exam"] = htmlspecialchars($row["EXAM"]);
        $param["purchase"] = htmlspecialchars($row["PURCHASE"]);
        $param["name"] = htmlspecialchars($row["NAME"]);
        $param["branch"] = htmlspecialchars($row["BRANCH"]);
        $param["tel"] = htmlspecialchars($row["TEL"]);
        $param["fax"] = htmlspecialchars($row["FAX"]);

        $param["articleList"] = array();
        $param["articleList"][] = htmlspecialchars($row["ARTICLENO"]);

        $param["guideStartHour"] = substr($param["guideStartTM"], 0, 2);
        $param["guideStartMinute"] = substr($param["guideStartTM"], 3, 2);
        $param["guideEndHour"] = substr($param["guideEndTM"], 0, 2);
        $param["guideEndMinute"] = substr($param["guideEndTM"], 3, 2);

        $param["purpose"] = '更新';
        $param["btnImage"] = 'btn_load.png';
    } else {

        // 物件リストの取得
        $param["articleList"] = array();
        foreach ($_REQUEST["articleList"] as $row) {
            $param["articleList"][] = $row["articleNo"];
        }

        $param["purpose"] = '登録';
        $param["btnImage"] = 'btn_enter.png';
    }

    // 物件リストから物件名と部屋名を取得
    $sql = fnSqlArticleEditList(implode(",", $param["articleList"]));
    $res = mysqli_query($param["conn"], $sql);
    $param["articleList"] = array();
    while ($row = mysqli_fetch_array($res)) {
        $article = array();
        $article["articleNo"] = htmlspecialchars($row["ARTICLENO"]);
        $article["article"] = htmlspecialchars($row["ARTICLE"]);
        $article["room"] = htmlspecialchars($row["ROOM"]);

        $param["articleList"][] = $article;
    }

    subMenu();
    subGuideEditView($param);
}

//
// 案内管理編集完了処理
//
function subGuideEditComplete()
{
    $conn = fnDbConnect();

    foreach ($_REQUEST['edit'] as $row) {
        $param = array();
        $param["guideNo"] = mysqli_real_escape_string($conn, $row['guideNo']);
        $param["articleNo"] = mysqli_real_escape_string($conn, $row['articleNo']);
        $param["content"] = mysqli_real_escape_string($conn, $row['content']);
        $param["guideStartDT"] = mysqli_real_escape_string($conn, $row['guideStartDT']);
        $param["guideEndDT"] = mysqli_real_escape_string($conn, $row['guideEndDT']);
        $param["name"] = mysqli_real_escape_string($conn, $row['name']);
        $param["branch"] = mysqli_real_escape_string($conn, $row['branch']);
        $param["tel"] = mysqli_real_escape_string($conn, $row['tel']);
        $param["fax"] = mysqli_real_escape_string($conn, $row['fax']);
        $param["charge"] = mysqli_real_escape_string($conn, $row['charge']);
        $param["result"] = mysqli_real_escape_string($conn, $row['result']);
        $param["acceptDT"] = mysqli_real_escape_string($conn, $row['acceptDT']);
        $param["accept"] = mysqli_real_escape_string($conn, $row['accept']);
        $param["exam"] = mysqli_real_escape_string($conn, $row['exam']);
        $param["purchase"] = mysqli_real_escape_string($conn, $row['purchase']);

        $guideStartHour = mysqli_real_escape_string($conn, $row['guideStartHour']);
        $guideStartMinute = mysqli_real_escape_string($conn, $row['guideStartMinute']);
        $guideEndHour = mysqli_real_escape_string($conn, $row['guideEndHour']);
        $guideEndMinute = mysqli_real_escape_string($conn, $row['guideEndMinute']);
        $param["guideStartTM"] = $guideStartHour . ':' . $guideStartMinute . ':00';
        $param["guideEndTM"] = $guideEndHour . ':' . $guideEndMinute . ':00';

        if ($param["guideNo"]) {
            $sql = fnSqlGuideUpdate($param);
            $res = mysqli_query($conn, $sql);
        } else {
            $param["guideNo"] = fnNextNo('GUIDE');
            $sql = fnSqlGuideInsert($param);
            $res = mysqli_query($conn, $sql);
        }
    }

    $_REQUEST['act'] = 'guideSearch';
    subGuide();
}

//
// 案内管理削除処理
//
function subGuideDelete()
{
    $conn = fnDbConnect();

    $guideNo = $_REQUEST['guideNo'];

    $sql = fnSqlGuideDelete($guideNo);
    $res = mysqli_query($conn, $sql);

    $_REQUEST['act'] = 'guideSearch';
    subGuide();
}

//
// 画面間引継ぎ情報
//
function getGuideParam()
{
    $param = array();

    // DB接続
    $param["conn"] = fnDbConnect();

    // 検索情報
    $param["sGuideDTFrom"] = htmlspecialchars($_REQUEST['sGuideDTFrom']);
    $param["sGuideDTTo"] = htmlspecialchars($_REQUEST['sGuideDTTo']);
    $param["sArticle"] = htmlspecialchars($_REQUEST['sArticle']);
    $param["sRoom"] = htmlspecialchars($_REQUEST['sRoom']);
    $param["sName"] = htmlspecialchars($_REQUEST['sName']);
    $param["sBranch"] = htmlspecialchars($_REQUEST['sBranch']);
    $param["sSellCharge"] = htmlspecialchars($_REQUEST['sSellCharge']);
    $param["sTel"] = htmlspecialchars($_REQUEST['sTel']);
    $param["sFax"] = htmlspecialchars($_REQUEST['sFax']);
    $param["sCharge"] = htmlspecialchars($_REQUEST['sCharge']);
    $param["sAcceptDT"] = htmlspecialchars($_REQUEST['sAcceptDT']);
    $param["sAccept"] = htmlspecialchars($_REQUEST['sAccept']);
    $param["sContent1"] = htmlspecialchars($_REQUEST['sContent1']);
    $param["sContent2"] = htmlspecialchars($_REQUEST['sContent2']);
    $param["sContent3"] = htmlspecialchars($_REQUEST['sContent3']);
    $param["sExam"] = htmlspecialchars($_REQUEST['sExam']);
    $param["sPurchase"] = htmlspecialchars($_REQUEST['sPurchase']);

    $param["orderBy"] = $_REQUEST['orderBy'];
    $param["orderTo"] = $_REQUEST['orderTo'];
    $param["sPage"] = $_REQUEST['sPage'];

    // 登録物件リスト
    $param["articleList"] = $_REQUEST['articleList'];

    return $param;
}
