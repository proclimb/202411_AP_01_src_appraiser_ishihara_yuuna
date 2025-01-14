<?php

//
// 案内管理リスト
//
function fnSqlGuideList($flg, $param)
{
    switch ($flg) {
        case 0:
            $select = "SELECT COUNT(*)";
            $order = "";
            $limit = "";
            break;

        case 1:
            $select = "SELECT A.GUIDENO, A.CONTENT, A.ARTICLENO, A.NAME, A.FAX, A.RESULT, A.ACCEPT, A.EXAM, A.PURCHASE, B.ARTICLE, B.ROOM,"
                           . "IF( A.GUIDESTARTDT > '0000-00-00', DATE_FORMAT( A.GUIDESTARTDT, '%Y/%m/%d'), '') AS GUIDESTARTDT,"
                           . "IF( A.GUIDEENDDT > '0000-00-00', DATE_FORMAT( A.GUIDEENDDT, '%Y/%m/%d'), '') AS GUIDEENDDT,"
                           . "IF (A.GUIDESTARTTM > '00:00:00', DATE_FORMAT( A.GUIDESTARTTM, '%H:%i' ), '') AS GUIDESTARTTM,"
                           . "IF (A.GUIDEENDTM > '00:00:00', DATE_FORMAT( A.GUIDEENDTM, '%H:%i' ), '') AS GUIDEENDTM,"
                           . "IF( A.ACCEPTDT > '0000-00-00', DATE_FORMAT( A.ACCEPTDT, '%Y/%m/%d'), '' ) AS ACCEPTDT"
                       ;

            // 並び替えとデータ抽出数
            if ($param["orderBy"]) {
                $order = " ORDER BY " . $param["orderBy"] . " " . $param["orderTo"];
            }
            $limit = " LIMIT " . (($param["sPage"] - 1) * PAGE_MAX) . ", " . PAGE_MAX;
            break;
    }

    $from = " FROM TBLGUIDE A, TBLARTICLE B";
    $where = " WHERE A.DEL = 1";
    $where .= " AND A.ARTICLENO = B.ARTICLENO";

    // 検索条件
    if ($param["sGuideDTFrom"]) {
        $where .= " AND A.GUIDESTARTDT >= '" . $param["sGuideDTFrom"] . "'";
    }
    if ($param["sGuideDTTo"]) {
        $where .= " AND A.GUIDESTARTDT <= '" . $param["sGuideDTTo"] . "'";
    }
    if ($param["sArticle"]) {
        $where .= " AND B.ARTICLE LIKE '%" . $param["sArticle"] . "%'";
    }
    if ($param["sRoom"]) {
        $where .= " AND B.ROOM LIKE '%" . $param["sRoom"] . "%'";
    }
    if ($param["sName"]) {
        $where .= " AND A.NAME LIKE '%" . $param["sName"] . "%'";
    }
    if ($param["sBranch"]) {
        $where .= " AND A.BRANCH LIKE '%" . $param["sBranch"] . "%'";
    }
    if ($param["sSellCharge"]) {
        $where .= " AND B.SELLCHARGE LIKE '%" . $param["sSellCharge"] . "%'";
    }
    if ($param["sTel"]) {
        $where .= " AND A.TEL LIKE '%" . $param["sTel"] . "%'";
    }
    if ($param["sFax"]) {
        $where .= " AND A.FAX LIKE '%" . $param["sFax"] . "%'";
    }
    if ($param["sCharge"]) {
        $where .= " AND A.CHARGE LIKE '%" . $param["sCharge"] . "%'";
    }
    if ($param["sAcceptDT"]) {
        $where .= " AND A.ACCEPTDT = '" . $param["sAcceptDT"] . "'";
    }
    if ($param["sAccept"]) {
        $where .= " AND A.ACCEPT LIKE '%" . $param["sAccept"] . "%'";
    }
    if ($param["sContent1"] || $param["sContent2"] || $param["sContent3"]) {
        $where .= " AND (";
        $tmp = "";
        if ($param["sContent1"]) {
            $where .= "A.CONTENT = 1";
            $tmp = " OR ";
        }
        if ($param["sContent2"]) {
            $where .= $tmp . "A.CONTENT = 2";
            $tmp = " OR ";
        }
        if ($param["sContent3"]) {
            $where .= $tmp . "A.CONTENT = 3";
        }
        $where .= ")";
    }
    if ($param["sExam"] || $param["sPurchase"]) {
        $where .= " AND (";
        $tmp = "";
        if ($param["sExam"]) {
            $where .= "A.EXAM = 1";
            $tmp = " OR ";
        }
        if ($param["sPurchase"]) {
            $where .= $tmp . "A.PURCHASE = 1";
        }
        $where .= ")";
    }

    return $select . $from . $where . $order . $limit;
}

//
// 案内管理検索物件リスト
//
function fnSqlGuideArticleList($flg, $param)
{
    switch ($flg) {
        case 0:
            $sql = "SELECT COUNT(*)";
            break;
        case 1:
            $sql = "SELECT ARTICLENO, ARTICLE, ROOM";
            break;
    }
    $sql .= " FROM TBLARTICLE";
    $sql .= " WHERE DEL = " . $param["cDel"];
    $sql .= " AND CONSTFLG4 <> 1";

    if ($param["cArticle"]) {
        $sql .= " AND ARTICLE LIKE '%" . $param["cArticle"] . "%'";
    }
    if ($param["cRoom"]) {
        $sql .= " AND ROOM LIKE '%" . $param["cRoom"] . "%'";
    }
    if ($param["orderBy"]) {
        $sql .= " ORDER BY " . $param["orderBy"] . " " . $param["orderTo"];
    }
    if ($flg) {
        $sql .= " LIMIT " . (($param["sPage"] - 1) * PAGE_MAX) . ", " . PAGE_MAX;
    }

    return $sql;
}

//
// 案内物件情報
//
function fnSqlGuideEdit($guideNo)
{
    $sql = "SELECT CONTENT, ACCEPT, EXAM, PURCHASE, GUIDESTARTTM, GUIDEENDTM,"
                   . "ARTICLENO, NAME, BRANCH, TEL, FAX, CHARGE, RESULT,"
                   . "IF( GUIDESTARTDT > '0000-00-00', DATE_FORMAT( GUIDESTARTDT, '%Y/%m/%d'), '' ) AS GUIDESTARTDT,"
                   . "IF( GUIDEENDDT > '0000-00-00', DATE_FORMAT( GUIDEENDDT, '%Y/%m/%d'), '' ) AS GUIDEENDDT,"
                   . "IF( ACCEPTDT > '0000-00-00', DATE_FORMAT( ACCEPTDT, '%Y/%m/%d'), '' ) AS ACCEPTDT"
               ;
    $sql .= " FROM TBLGUIDE";
    $sql .= " WHERE DEL = 1";
    $sql .= " AND GUIDENO = $guideNo";

    return $sql;
}

//
// 案内物件情報登録(新規用)
//
function fnSqlGuideInsert($param)
{
    $sql = "INSERT INTO TBLGUIDE ( ";
    $sql .= "GUIDENO, ARTICLENO, CONTENT, GUIDESTARTDT, GUIDEENDDT, GUIDESTARTTM, GUIDEENDTM, NAME, BRANCH,"
        . " TEL, FAX, CHARGE, RESULT, ACCEPTDT, ACCEPT, EXAM, PURCHASE, INSDT, UPDT, DEL";
    $sql .= " ) VALUES ( ";
    $sql .= "'" . $param["guideNo"] . "','" . $param["articleNo"] . "','" . $param["content"] . "','" . $param["guideStartDT"] . "','"
                . $param["guideEndDT"] . "','" . $param["guideStartTM"] . "','" . $param["guideEndTM"] . "','" . $param["name"] . "','"
                . $param["branch"] . "','" . $param["tel"] . "','" . $param["fax"] . "','" . $param["charge"] . "','" . $param["result"] . "','"
                . $param["acceptDT"] . "','" . $param["accept"] . "','" . $param["exam"] . "','" . $param["purchase"] . "', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1 )"
            ;

    return ($sql);
}

//
// 案内物件情報登録(更新用)
//
function fnSqlGuideUpdate($param)
{
    $sql = "UPDATE TBLGUIDE";
    $sql .= " SET ARTICLENO = '" . $param["articleNo"] . "'";
    $sql .= ",CONTENT = '" . $param["content"] . "'";
    $sql .= ",GUIDESTARTDT = '" . $param["guideStartDT"] . "'";
    $sql .= ",GUIDEENDDT = '" . $param["guideEndDT"] . "'";
    $sql .= ",GUIDESTARTTM = '" . $param["guideStartTM"] . "'";
    $sql .= ",GUIDEENDTM = '" . $param["guideEndTM"] . "'";
    $sql .= ",NAME = '" . $param["name"] . "'";
    $sql .= ",BRANCH = '" . $param["branch"] . "'";
    $sql .= ",TEL = '" . $param["tel"] . "'";
    $sql .= ",FAX = '" . $param["fax"] . "'";
    $sql .= ",CHARGE = '" . $param["charge"] . "'";
    $sql .= ",RESULT = '" . $param["result"] . "'";
    $sql .= ",ACCEPTDT = '" . $param["acceptDT"] . "'";
    $sql .= ",ACCEPT = '" . $param["accept"] . "'";
    $sql .= ",EXAM = '" . $param["exam"] . "'";
    $sql .= ",PURCHASE = '" . $param["purchase"] . "'";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE GUIDENO = " . $param["guideNo"];

    return $sql;
}

//
// 案内物件情報削除
//
function fnSqlGuideDelete($guideNo)
{
    $sql = "UPDATE TBLGUIDE";
    $sql .= " SET DEL = -1";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE GUIDENO = '$guideNo'";

    return $sql;
}

//
// 物件管理情報
//
function fnSqlArticleEditList($articleNo)
{
    $sql = "SELECT ARTICLENO, ARTICLE, ROOM, KEYPLACE, ADDRESS, ARTICLENOTE, KEYBOX, DRAWING, SELLCHARGE, DEL";
    $sql .= " FROM TBLARTICLE";
    $sql .= " WHERE ARTICLENO IN ( $articleNo )";

    return $sql;
}
