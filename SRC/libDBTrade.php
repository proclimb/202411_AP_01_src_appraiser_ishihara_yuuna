<?php
//
//業者一覧リスト
//
function fnSqlTradeList($flg, $sDel, $sName, $sBranch, $sZip, $sPrefecture, $sAddress1, $sAddress2, $sTel, $sFax, $sMobile, $sPage, $orderBy, $orderTo)
{
	switch ($flg) {
		case 0:
			$sql  = "SELECT COUNT(*)";
			break;
		case 1:
			$sql  = "SELECT TRADENO, NAME, BRANCH, ZIP, PREFECTURE, ADDRESS1, ADDRESS2, TEL, FAX, MOBILE";
			break;
	}
	$sql .= " FROM TBLTRADE";
	$sql .= " WHERE DEL = $sDel";
	if ($sName) {
		$sql .= " AND NAME LIKE '%$sName%'";
	}
	if ($sBranch) {
		$sql .= " AND BRANCH LIKE '%$sBranch%'";
	}
	if ($sZip) {
		$sql .= " AND ZIP LIKE '%$sZip%'";
	}
	if ($sPrefecture) {
		$sql .= " AND PREFECTURE LIKE '%$sPrefecture%'";
	}
	if ($sAddress1) {
		$sql .= " AND ADDRESS1 LIKE '%$sAddress1%'";
	}
	if ($sAddress2) {
		$sql .= " AND ADDRESS2 LIKE '%$sAddress2%'";
	}
	if ($sTel) {
		$sql .= " AND TEL LIKE '%$sTel%'";
	}
	if ($sFax) {
		$sql .= " AND FAX LIKE '%$sFax%'";
	}
	if ($sMobile) {
		$sql .= " AND MOBILE LIKE '%$sMobile%'";
	}
	if ($orderBy) {
		$sql .= " ORDER BY $orderBy $orderTo";
	}
	if ($flg) {
		$sql .= " LIMIT " . (($sPage - 1) * PAGE_MAX) . ", " . PAGE_MAX;
	}

	return ($sql);
}




//
//業者一覧情報
//
function fnSqlTradeEdit($tradeNo)
{
	$sql  = "SELECT NAME,NAMEFURI,BRANCH,BRANCHFURI,ZIP,PREFECTURE,ADDRESS1,ADDRESS2,TEL,FAX,MOBILE,INTERIOR,DEL";
	$sql .= " FROM TBLTRADE";
	$sql .= " WHERE TRADENO = $tradeNo";

	return ($sql);
}




//
//業者一覧情報更新
//
function fnSqlTradeUpdate($tradeNo, $name, $nameFuri, $branch, $branchFuri, $zip, $prefecture, $address1, $address2, $tel, $fax, $mobile, $interior, $del)
{
	$sql  = "UPDATE TBLTRADE";
	$sql .= " SET NAME = '$name'";
	$sql .= ",NAMEFURI = '$nameFuri'";
	$sql .= ",BRANCH = '$branch'";
	$sql .= ",BRANCHFURI = '$branchFuri'";
	$sql .= ",ZIP = '$zip'";
	$sql .= ",PREFECTURE = '$prefecture'";
	$sql .= ",ADDRESS1 = '$address1'";
	$sql .= ",ADDRESS2 = '$address2'";
	$sql .= ",TEL = '$tel'";
	$sql .= ",FAX = '$fax'";
	$sql .= ",MOBILE = '$mobile'";
	$sql .= ",INTERIOR = '$interior'";
	$sql .= ",DEL = '$del'";
	$sql .= " WHERE TRADENO = $tradeNo";

	return ($sql);
}




//
//業者一覧情報登録
//
function fnSqlTradeInsert($tradeNo, $name, $nameFuri, $branch, $branchFuri, $zip, $prefecture, $address1, $address2, $tel, $fax, $mobile, $interior, $del)
{
	$sql  = "INSERT INTO TBLTRADE(";
	$sql .= "TRADENO,NAME,NAMEFURI,BRANCH,BRANCHFURI,ZIP,PREFECTURE,ADDRESS1,ADDRESS2,TEL,FAX,MOBILE,INTERIOR,INSDT,UPDT,DEL";
	$sql .= ")VALUES(";
	$sql .= "'$tradeNo','$name','$nameFuri','$branch','$branchFuri','$zip','$prefecture','$address1','$address2','$tel','$fax','$mobile','$interior',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'$del')";

	return ($sql);
}




//
//業者一覧情報削除
//
function fnSqlTradeDelete($tradeNo)
{
	$sql  = "UPDATE TBLTRADE";
	$sql .= " SET DEL = -1";
	$sql .= ",UPDT = CURRENT_TIMESTAMP";
	$sql .= " WHERE TRADENO = '$tradeNo'";

	return ($sql);
}
