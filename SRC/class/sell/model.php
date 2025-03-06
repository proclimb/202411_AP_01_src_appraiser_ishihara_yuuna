<?php

//
// 売主物件リスト
//
function fnSqlSellList($flg, $param)
{
    switch ($flg) {
        case 0:
            $select = "SELECT COUNT(*)";
            $order = "";
            $limit = "";
            break;
        case 1:
            $select = "SELECT SELLNO,IF(SEARCHDT > '0000-00-00',DATE_FORMAT(SEARCHDT,'%Y/%m/%d'),''),ARTICLE,"
                . "ADDRESS,STATION,IF(FOOT > 0,FOOT,''),IF(YEARS > 0,YEARS,''),IF(FLOOR > 0,FLOOR,''),"
                . "IF(AREA > 0,AREA,''),SELLER,IF(PRICE > 0,PRICE,''),NOTE";
            // 並び替えとデータ抽出数
            if ($param["orderBy"]) {
                $order = " ORDER BY " . $param["orderBy"] . " " . $param["orderTo"];
            }
            $limit = " LIMIT " . (($param["sPage"] - 1) * PAGE_MAX) . ", " . PAGE_MAX;
            break;
    }
    $from = " FROM TBLSELL";
    $where = " WHERE DEL = 1";

    // 検索条件
    if ($param["sSearchFrom"]) {
        $where .= " AND SEARCHDT >= '" . $param["sSearchFrom"] . "'";
    }
    if ($param["sSearchTo"]) {
        $where .= " AND SEARCHDT <= '" . $param["sSearchTo"] . "'";
    }
    if ($param["sArticle"]) {
        $where .= " AND ARTICLE LIKE '%" . $param["sArticle"] . "%'";
    }
    if ($param["sAddress"]) {
        $where .= " AND ADDRESS LIKE '%" . $param["sAddress"] . "%'";
    }
    if ($param["sStation"]) {
        $where .= " AND STATION LIKE '%" . $param["sStation"] . "%'";
    }
    if ($param["sFoot"]) {
        switch ($param["sFootC"]) {
            case 0:
                $where .= " AND FOOT <= " . $param["sFoot"];
                break;
            case 1:
                $where .= " AND FOOT >= " . $param["sFoot"];
                break;
            case 2:
                $where .= " AND FOOT = " . $param["sFoot"];
                break;
        }
    }
    if ($param["sAreaFrom"]) {
        $where .= " AND AREA >= " . $param["sAreaFrom"];
    }
    if ($param["sAreaTo"]) {
        $where .= " AND AREA <= " . $param["sAreaTo"];
    }
    if ($param["sYearsFrom"]) {
        $where .= " AND YEARS >= '" . $param["sYearsFrom"] . "'";
    }
    if ($param["sYearsTo"]) {
        $where .= " AND YEARS <= '" . $param["sYearsTo"] . "'";
    }
    if ($param["sPriceFrom"]) {
        $where .= " AND PRICE >= '" . $param["sPriceFrom"] . "'";
    }
    if ($param["sPriceTo"]) {
        $where .= " AND PRICE <= '" . $param["sPriceTo"] . "'";
    }
    if ($param["sSeller"]) {
        $where .= " AND SELLER LIKE '%" . $param["sSeller"] . "%'";
    }

    return $select . $from . $where . $order . $limit;
}

//
// 売主物件情報
//
function fnSqlSellEdit($sellNo)
{
    $select  = "SELECT IF(SEARCHDT > '0000-00-00',DATE_FORMAT(SEARCHDT,'%Y/%m/%d'),''),ARTICLE,ADDRESS,STATION,IF(FOOT > 0,FOOT,''),"; // SEARCHDT(日付) ： '0000-00-00' より大きければ、その日付を 'YYYY/MM/DD' の形式で返す
    $select .= "IF(YEARS > 0,YEARS,''),IF(FLOOR > 0,FLOOR,''),IF(AREA > 0,AREA,''),SELLER,IF(PRICE > 0,PRICE,''),NOTE";
    $from = " FROM TBLSELL";
    $where = " WHERE DEL = 1";
    $where .= " AND SELLNO = $sellNo";

    return $select . $from . $where;
}

//
// 売主物件情報更新
//
function fnSqlSellUpdate($param)
{
    $sql = "UPDATE TBLSELL"; // 更新するテーブル(TBLSELL)を指定
    $sql .= " SET SEARCHDT = '" . $param["searchDT"] . "'"; // SERCHDTカラム更新（以下、カラムごとにSQL文を記載）
    $sql .= ",ARTICLE = '" . $param["article"] . "'";
    $sql .= ",ADDRESS = '" . $param["address"] . "'";
    $sql .= ",STATION = '" . $param["station"] . "'";
    $sql .= ",FOOT = '" . $param["foot"] . "'";
    $sql .= ",YEARS = '" . $param["years"] . "'";
    $sql .= ",FLOOR = '" . $param["floor"] . "'";
    $sql .= ",AREA = '" . $param["area"] . "'";
    $sql .= ",SELLER = '" . $param["seller"] . "'";
    $sql .= ",PRICE = '" . $param["price"] . "'";
    $sql .= ",NOTE = '" . $param["note"] . "'";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE SELLNO = " . $param["sellNo"];  // どのレコード(SELLNO)を更新するかを指定

    return $sql;
}

//
// 売主物件情報登録
//
function fnSqlSellInsert($param)
{
    $sql = "INSERT INTO TBLSELL(";
    $sql .= "SELLNO,SEARCHDT,ARTICLE,ADDRESS,STATION,FOOT,YEARS,FLOOR,AREA,SELLER,PRICE,NOTE,INSDT,UPDT,DEL";
    $sql .= ")VALUES(";
    $sql .= "'" . $param["sellNo"] . "','" . $param["searchDT"] . "','" . $param["article"] . "','" . $param["address"] . "',"
        . "'" . $param["station"] . "','" . $param["foot"] . "','" . $param["years"] . "','" . $param["floor"] . "',"
        . "'" . $param["area"] . "','" . $param["seller"] . "','" . $param["price"] . "','" . $param["note"] . "',"
        . "CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1)"; // 2つの日時カラム（登録日時と更新日時）に現在の日時を挿入し、更にDELカラムに1を挿入する
    return $sql;
}


//
// 売主物件情報削除
//
function fnSqlSellDelete($sellNo)
{
    $sql = "UPDATE TBLSELL"; // TBLSELLテーブルのデータを更新
    $sql .= " SET DEL = -1"; // DELカラムを-1に設定（論理削除）
    $sql .= ",UPDT = CURRENT_TIMESTAMP"; // UPDTカラムを現在の日時に設定
    $sql .= " WHERE SELLNO = '$sellNo'"; // $sellNoと一致するレコードに対して更新を実行

    return $sql;
}
