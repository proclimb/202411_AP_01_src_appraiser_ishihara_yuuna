<?php

//
// 仕入管理リスト
//
function fnSqlStockList($flg, $param)
{
    switch ($flg) {
        case 0:
            $select = "SELECT COUNT(*)";
            $order = "";
            $limit = "";
            break;
        case 1:
            $select  = "SELECT STOCKNO,CHARGE,`RANK`,DATE_FORMAT(INSDT,'%Y/%m/%d'),ARTICLE,ARTICLEFURI,ROOM,"
                . "IF(AREA > 0,AREA,''),STATION,DISTANCE,AGENT,STORE,COVER,IF(VISITDT > '0000-00-00',DATE_FORMAT(VISITDT,'%Y/%m/%d'),''),"
                . "IF(DESKPRICE > 0,DESKPRICE,''),IF(VENDORPRICE > 0,VENDORPRICE,''),NOTE";
            // 並び替えとデータ抽出数
            if ($param["orderBy"]) {
                $order = " ORDER BY " . $param["orderBy"] . " " . $param["orderTo"];
            }
            $limit = " LIMIT " . (($param["sPage"] - 1) * PAGE_MAX) . ", " . PAGE_MAX;
            break;
    }
    $from = " FROM TBLSTOCK";
    $where = " WHERE DEL = " . $param["sDel"];

    // 検索条件
    if ($param["sCharge"]) {
        $where .= " AND CHARGE LIKE '%" . $param["sCharge"] . "%'";
    }
    if ($param["sRank"]) {
        $where .= " AND (";
        $flg = 0;
        foreach ($param["sRank"] as $value) {
            if ($flg == 0) {
                $flg = 1;
            } else {
                $where .= " OR ";
            }
            $where .= "`RANK` = '$value'";
        }
        $where .= ")";
    }
    if ($param["sInsDTFrom"]) {
        $where .= " AND INSDT >= '" . $param["sInsDTFrom"] . "'";
    }
    if ($param["sInsDTTo"]) {
        $where .= " AND INSDT <= '" . $param["sInsDTTo"] . " 23:59:59'";
    }
    if ($param["sArticle"]) {
        $where .= " AND ARTICLE LIKE '%" . $param["sArticle"] . "%'";
    }
    if ($param["sArticleFuri"]) {
        $where .= " AND ARTICLEFURI LIKE '%" . $param["sArticleFuri"] . "%'";
    }
    if ($param["sAreaFrom"]) {
        $where .= " AND AREA >= '" . $param["sAreaFrom"] . "'";
    }
    if ($param["sAreaTo"]) {
        $where .= " AND AREA <= '" . $param["sAreaTo"] . "'";
    }
    if ($param["sStation"]) {
        $where .= " AND STATION = '" . $param["sStation"] . "'";
    }
    if ($param["sDistance"]) {
        $where .= " AND (";
        $flg = 0;
        foreach ($param["sDistance"] as $value) {
            if ($flg == 0) {
                $flg = 1;
            } else {
                $where .= " OR ";
            }
            $where .= "DISTANCE = '" . $value . "'";
        }
        $where .= ")";
    }
    if ($param["sAgent"]) {
        $where .= " AND AGENT LIKE '%" . $param["sAgent"] . "%'";
    }
    if ($param["sStore"]) {
        $where .= " AND STORE LIKE '%" . $param["sStore"] . "%'";
    }
    if ($param["sCover"]) {
        $where .= " AND COVER LIKE '%" . $param["sCover"] . "%'";
    }
    if ($param["sVisitDTFrom"]) {
        $where .= " AND VISITDT >= '" . $param["sVisitDTFrom"] . "'";
    }
    if ($param["sVisitDTTo"]) {
        $where .= " AND VISITDT <= '" . $param["sVisitDTTo"] . "'";
    }
    if ($param["sHow"]) {
        $where .= " AND (";
        $flg = 0;
        foreach ($param["sHow"] as $value) {
            if ($flg == 0) {
                $flg = 1;
            } else {
                $where .= " OR ";
            }
            $where .= "HOW = '" . $value . "'";
        }
        $where .= ")";
    }

    return $select . $from . $where . $order . $limit;
}

//
// 仕入管理情報
//
function fnSqlStockEdit($stockNo)
{
    $sql  = "SELECT CHARGE,RANK,ARTICLE,ARTICLEFURI,ROOM,IF(AREA > 0,AREA,''),STATION,DISTANCE,AGENT,STORE,COVER,"
        . "IF(VISITDT > '0000-00-00',DATE_FORMAT(VISITDT,'%Y/%m/%d'),''),IF(DESKPRICE > 0,DESKPRICE,''),"
        . "IF(VENDORPRICE > 0,VENDORPRICE,''),NOTE,HOW,DEL";
    $sql .= " FROM TBLSTOCK";
    $sql .= " WHERE STOCKNO = $stockNo";

    return ($sql);
}

//
// 仕入管理情報更新
//
function fnSqlStockUpdate($param)
{
    $sql = "UPDATE TBLSTOCK";
    $sql .= " SET CHARGE = '" . $param["charge"] . "'";
    $sql .= ",`RANK` = '" . $param["rank"] . "'";
    $sql .= ",ARTICLE = '" . $param["article"] . "'";
    $sql .= ",ARTICLEFURI = '" . $param["articleFuri"] . "'";
    $sql .= ",ROOM = '" . $param["room"] . "'";
    $sql .= ",AREA = '" . $param["area"] . "'";
    $sql .= ",STATION = '" . $param["station"] . "'";
    $sql .= ",DISTANCE = '" . $param["distance"] . "'";
    $sql .= ",AGENT = '" . $param["agent"] . "'";
    $sql .= ",STORE = '" . $param["store"] . "'";
    $sql .= ",COVER = '" . $param["cover"] . "'";
    $sql .= ",VISITDT = '" . $param["visitDT"] . "'";
    $sql .= ",DESKPRICE = '" . $param["deskPrice"] . "'";
    $sql .= ",VENDORPRICE = '" . $param["vendorPrice"] . "'";
    $sql .= ",NOTE = '" . $param["note"] . "'";
    $sql .= ",HOW = '" . $param["how"] . "'";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= ",DEL = '" . $param["del"] . "'";
    $sql .= " WHERE STOCKNO = " . $param["stockNo"];

    return ($sql);
}

//
// 仕入管理情報登録
//
function fnSqlStockInsert($param)
{
    $sql = "INSERT INTO TBLSTOCK(";
    $sql .= "STOCKNO,CHARGE,`RANK`,ARTICLE,ARTICLEFURI,ROOM,AREA,STATION,DISTANCE,AGENT,STORE,COVER,VISITDT,DESKPRICE,VENDORPRICE,NOTE,HOW,INSDT,UPDT,DEL";
    $sql .= ")VALUES(";
    $sql .= "'" . $param["stockNo"] . "','" . $param["charge"] . "','" . $param["rank"] . "','" . $param["article"] . "','"
        . $param["articleFuri"] . "','" . $param["room"] . "','" . $param["area"] . "','" . $param["station"] . "','"
        . $param["distance"] . "','" . $param["agent"] . "','" . $param["store"] . "','" . $param["cover"] . "','"
        . $param["visitDT"] . "','" . $param["deskPrice"] . "','" . $param["vendorPrice"] . "','" . $param["note"] . "','"
        . $param["how"] . "',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'" . $param["del"] . "')";

    return ($sql);
}

//
// 仕入管理情報削除
//
function fnSqlStockDelete($stockNo)
{
    $sql = "UPDATE TBLSTOCK";
    $sql .= " SET DEL = -1";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE STOCKNO = '$stockNo'";

    return ($sql);
}

//
// 仕入管理一括削除処理
//
function fnSqlStockListDelete($delStockListArray)
{
    $where = " WHERE STOCKNO IN (";
    $flg = 0;

    foreach ($delStockListArray as $value) {
        if ($flg == 0) {
            $flg = 1;
        } else {
            $where .= " , ";
        }
        $where .= "'" . $value . "'";
    }
    $where .= ")";

    $sql = "UPDATE TBLSTOCK";
    $sql .= " SET DEL = -1";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";

    return $sql . $where;
}

//
// 仕入管理1ヶ月経過レコードの除外
//
function fnSqlStockExclusion()
{
    $sql = "UPDATE TBLSTOCK";
    $sql .= " SET DEL = 0";
    $sql .= " WHERE UPDT < NOW() - INTERVAL 1 MONTH";

    return ($sql);
}
