<?php
//
//工事管理リスト
//
function fnSqlConstList($flg, $sDel, $sArticle, $sConstTrader, $sConstFlg1, $sConstFlg2, $sConstFlg3, $sConstFlg4, $sInteriorCharge, $sPage, $orderBy, $orderTo)
{
	switch ($flg) {
		case 0:
			$sql  = "SELECT COUNT(*)";
			break;
		case 1:
			$sql  = "SELECT ARTICLENO, ARTICLE, ROOM, ADDRESS, CONSTTRADER, CONSTADD, RECEIVE, SELLCHARGE, INTERIORCHARGE, KEYPLACE, LIGHTORDER,"
				. "IF( INTERIORPRICE > 0, INTERIORPRICE, '' ) AS INTERIORPRICE,"
				. "IF( CONSTPRICE > 0, CONSTPRICE, '' ) AS CONSTPRICE,"
				. "IF( PURCHASEDT > '0000-00-00', DATE_FORMAT( PURCHASEDT, '%Y/%m/%d'), '' ) AS PURCHASEDT,"
				. "IF( WORKSTARTDT > '0000-00-00', DATE_FORMAT( WORKSTARTDT, '%Y/%m/%d'), '' ) AS WORKSTARTDT,"
				. "IF( WORKENDDT > '0000-00-00', DATE_FORMAT( WORKENDDT, '%Y/%m/%d'), '' ) AS WORKENDDT,"
				. "IF( LINEOPENDT > '0000-00-00', DATE_FORMAT( LINEOPENDT, '%Y/%m/%d'), '' ) AS LINEOPENDT,"
				. "IF( LINECLOSEDT > '0000-00-00',DATE_FORMAT( LINECLOSEDT,'%Y/%m/%d'),'') AS LINECLOSEDT,"
				. "IF( SITEDT > '0000-00-00', DATE_FORMAT( SITEDT,'%Y/%m/%d'), '' ) AS SITEDT,"
				. "IF( LINEOPENCONTACTDT > '0000-00-00', DATE_FORMAT( LINEOPENCONTACTDT, '%Y/%m/%d'), '' ) AS LINEOPENCONTACTDT,"
				. "IF( LINECLOSECONTACTDT > '0000-00-00',DATE_FORMAT( LINECLOSECONTACTDT,'%Y/%m/%d'),'') AS LINECLOSECONTACTDT";
			break;
	}

	$sql .= " FROM TBLARTICLE";
	$sql .= " WHERE DEL = $sDel";

	// 各項目の検索条件の抽出
	if ($sArticle) {
		$sql .= " AND ARTICLE LIKE '%$sArticle%'";
	}
	if ($sRoom) {
		$sql .= " AND ROOM LIKE '%$sRoom%'";
	}
	if ($sAddress) {
		$sql .= " AND ADDRESS LIKE '%$sAddress%'";
	}
	if ($sConstTrader) {
		$sql .= " AND CONSTTRADER LIKE '%$sConstTrader%'";
	}
	if ($sConstFlg1 || $sConstFlg2 || $sConstFlg3 || $sConstFlg4) {
		$sql .= " AND (";
		$tmp = "";
		if ($sConstFlg1) {
			$sql .= "CONSTFLG1 = 1";
			$tmp = " OR ";
		}
		if ($sConstFlg2) {
			$sql .= $tmp . "CONSTFLG2 = 1";
			$tmp = " OR ";
		}
		if ($sConstFlg3) {
			$sql .= $tmp . "CONSTFLG3 = 1";
			$tmp = " OR ";
		}
		if ($sConstFlg4) {
			$sql .= $tmp . "CONSTFLG4 = 1";
		}
		$sql .= ")";
	}
	if ($sInteriorCharge) {
		$sql .= " AND INTERIORCHARGE LIKE '%$sInteriorCharge%'";
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
//工事管理情報
//
function fnSqlConstEdit($articleNo)
{
	$sql  = "SELECT ARTICLE, ROOM, ADDRESS, YEARS,"
		. "CONSTTRADER, CONSTADD, CONSTNOTE, RECEIVE, HOTWATER,"
		. "KEYPLACE, MANAGECOMPANY, FLOORPLAN, FORMEROWNER, BROKERCHARGE, BROKERCONTACT, INTERIORCHARGE,"
		. "SELLCHARGE, CONSTFLG1, CONSTFLG2, CONSTFLG3, CONSTFLG4, LEAVINGFORM,"
		. "ELECTRICITYCHARGE, GASCHARGE, LIGHTORDER, LINECONTACTNOTE,"
		. "IF( AREA > 0, AREA, '' ) AS AREA,"
		. "IF( SELLPRICE > 0, SELLPRICE, '' ) AS SELLPRICE,"
		. "IF( INTERIORPRICE > 0, INTERIORPRICE, '' ) AS INTERIORPRICE,"
		. "IF( CONSTPRICE > 0, CONSTPRICE, '') AS CONSTPRICE,"
		. "IF( SITEDT > '0000-00-00', SITEDT, '' ) AS SITEDT,"
		. "IF( LEAVINGDT > '0000-00-00', DATE_FORMAT( LEAVINGDT, '%Y/%m/%d'), '' ) AS LEAVINGDT,"
		. "IF( PURCHASEDT > '0000-00-00', DATE_FORMAT( PURCHASEDT, '%Y/%m/%d'), '' ) AS PURCHASEDT,"
		. "IF( WORKSTARTDT > '0000-00-00', DATE_FORMAT( WORKSTARTDT, '%Y/%m/%d'), '' ) AS WORKSTARTDT,"
		. "IF( WORKENDDT > '0000-00-00', DATE_FORMAT( WORKENDDT, '%Y/%m/%d'), '' ) AS WORKENDDT,"
		. "IF( LINEOPENDT > '0000-00-00', DATE_FORMAT( LINEOPENDT, '%Y/%m/%d'), '' ) AS LINEOPENDT,"
		. "IF( LINECLOSEDT > '0000-00-00', DATE_FORMAT( LINECLOSEDT, '%Y/%m/%d'), '' ) AS LINECLOSEDT,"
		. "IF( LINEOPENCONTACTDT > '0000-00-00', DATE_FORMAT( LINEOPENCONTACTDT, '%Y/%m/%d'), '' ) AS LINEOPENCONTACTDT,"
		. "IF( LINECLOSECONTACTDT > '0000-00-00', DATE_FORMAT( LINECLOSECONTACTDT, '%Y/%m/%d'), '' ) AS LINECLOSECONTACTDT";
	$sql .= " FROM TBLARTICLE";
	$sql .= " WHERE ARTICLENO = $articleNo";

	return ($sql);
}



//
//工事管理情報更新
//
function fnSqlConstUpdate(
	$articleNo,
	$area,
	$years,
	$sellPrice,
	$interiorPrice,
	$constTrader,
	$constPrice,
	$constAdd,
	$constNote,
	$purchaseDT,
	$workStartDT,
	$workEndDT,
	$lineOpenDT,
	$lineCloseDT,
	$receive,
	$hotWater,
	$siteDT,
	$leavingForm,
	$leavingDT,
	$manageCompany,
	$floorPlan,
	$formerOwner,
	$brokerCharge,
	$brokerContact,
	$interiorCharge,
	$constFlg1,
	$constFlg2,
	$constFlg3,
	$constFlg4,
	$lineOpenContactDT,
	$lineCloseContactDT,
	$lineContactnote,
	$electricityCharge,
	$gasCharge,
	$lightOrder
) {
	$sql  = "UPDATE TBLARTICLE";
	$sql .= " SET AREA = '$area'";
	$sql .= ",YEARS = '$years'";
	$sql .= ",SELLPRICE = '$sellPrice'";
	$sql .= ",INTERIORPRICE = '$interiorPrice'";
	$sql .= ",CONSTTRADER = '$constTrader'";
	$sql .= ",CONSTPRICE = '$constPrice'";
	$sql .= ",CONSTADD = '$constAdd'";
	$sql .= ",CONSTNOTE = '$constNote'";
	$sql .= ",PURCHASEDT = '$purchaseDT'";
	$sql .= ",WORKSTARTDT = '$workStartDT'";
	$sql .= ",WORKENDDT = '$workEndDT'";
	$sql .= ",LINEOPENDT = '$lineOpenDT'";
	$sql .= ",LINECLOSEDT = '$lineCloseDT'";
	$sql .= ",RECEIVE = '$receive'";
	$sql .= ",HOTWATER = '$hotWater'";
	$sql .= ",SITEDT = '$siteDT'";
	$sql .= ",LEAVINGFORM = '$leavingForm'";
	$sql .= ",LEAVINGDT = '$leavingDT'";
	$sql .= ",MANAGECOMPANY = '$manageCompany'";
	$sql .= ",FLOORPLAN = '$floorPlan'";
	$sql .= ",FORMEROWNER = '$formerOwner'";
	$sql .= ",BROKERCHARGE = '$brokerCharge'";
	$sql .= ",BROKERCONTACT = '$brokerContact'";
	$sql .= ",INTERIORCHARGE = '$interiorCharge'";
	$sql .= ",CONSTFLG1 = '$constFlg1'";
	$sql .= ",CONSTFLG2 = '$constFlg2'";
	$sql .= ",CONSTFLG3 = '$constFlg3'";
	$sql .= ",CONSTFLG4 = '$constFlg4'";
	$sql .= ",LINEOPENCONTACTDT = '$lineOpenContactDT'";
	$sql .= ",LINECLOSECONTACTDT = '$lineCloseContactDT'";
	$sql .= ",LINECONTACTNOTE = '$lineContactnote'";
	$sql .= ",ELECTRICITYCHARGE = '$electricityCharge'";
	$sql .= ",GASCHARGE = '$gasCharge'";
	$sql .= ",LIGHTORDER = '$lightOrder'";
	$sql .= " WHERE ARTICLENO = $articleNo";

	return ($sql);
}
