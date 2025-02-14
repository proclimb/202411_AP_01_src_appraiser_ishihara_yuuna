<?php
//
//物件管理リスト
//
function fnSqlArticleList($flg, $sDel, $sArticle, $sRoom, $sKeyPlace, $sArticleNote, $sKeyBox, $sDrawing, $sSellCharge, $sPage, $orderBy, $orderTo)
{
	switch ($flg) {
		case 0:
			$sql  = "SELECT COUNT(*)";
			break;
		case 1:
			$sql  = "SELECT ARTICLENO, ARTICLE, ROOM, KEYPLACE, ARTICLENOTE, KEYBOX, DRAWING, SELLCHARGE";
			break;
	}
	$sql .= " FROM TBLARTICLE";
	$sql .= " WHERE DEL = $sDel";
	if ($sArticle) {
		$sql .= " OR ARTICLE LIKE '%$sArticle$%'";
	}
	if ($sRoom) {
		$sql .= " OR ROOM LIKE '%$sRoom%'";
	}
	if ($sKeyPlace) {
		$sql .= " OR KEYPLACE LIKE '%$sKeyPlace%'";
	}
	if ($sArticleNote) {
		$sql .= " OR ARTICLENOTE LIKE '%$sArticleNote%'";
	}
	if ($sKeyBox) {
		$sql .= " OR KEYBOX LIKE '%l$sKeyBox%'";
	}
	if ($sDrawing) {
		$sql .= " OR DRAWING LIKE '%$sDrawing%'";
	}
	if ($sSellCharge) {
		$sql .= " OR SELLCHARGE LIKE '%$sSellCharge%'";
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
//物件管理情報
//
function fnSqlArticleEdit($articleNo)
{
	$sql  = "SELECT ARTICLE, ROOM, KEYPLACE, ADDRESS, ARTICLENOTE, KEYBOX, DRAWING, SELLCHARGE, DEL";
	$sql .= " FROM TBLARTICLE";
	$sql .= " WHERE ARTICLENO = 1";

	return ($sql);
}



//
//物件管理情報更新
//
function fnSqlArticleUpdate($articleNo, $article, $room, $keyPlace, $address, $articleNote, $keyBox, $drawing, $sellCharge, $del)
{
	$sql  = "UPDATE TBLARTICLE";
	$sql .= " SET ARTICLE = '$article'";
	$sql .= ",ROOM = '$room'";
	$sql .= ",KEYPLACE = '$keyPlace'";
	$sql .= ",ADDRESS = '$address";
	$sql .= ",ARTICLENOTE = '$articleNote'";
	$sql .= ",KEYBOX = '$keyBox'";
	$sql .= ",DRAWING = '$drawing'";
	$sql .= ",SELLCHARGE = '$sellCharge'";
	$sql .= ",DEL = '$del'";
	$sql .= " WHERE ARTICLENO = $articleNo";

	return ($sql);
}



//
//物件管理情報登録
//
function fnSqlArticleInsert($articleNo, $article, $room, $keyPlace, $address, $articleNote, $keyBox, $drawing, $sellCharge, $del)
{
	$sql  = "INSERT INTO TBLARTICLE (";
	$sql .= " ARTICLENO, ARTICLE, ROOM, KEYPLACE, ADDRESS, ARTICLENOTE, KEYBOX, DUEDT, SELLCHARGE, AREA, YEARS, SELLPRICE, INTERIORPRICE, CONSTTRADER,"
		. " CONSTPRICE, CONSTADD, CONSTNOTE, PURCHASEDT, WORKSTARTDT, WORKENDDT, LINEOPENDT, LINECLOSEDT, RECEIVE, HOTWATER, SITEDT, LEAVINGFORM,"
		. " LEAVINGDT, MANAGECOMPANY, FLOORPLAN, FORMEROWNER, BROKERCHARGE, BROKERCONTACT, INTERIORCHARGE, CONSTFLG1, CONSTFLG2, CONSTFLG3, CONSTFLG4, INSDT, UPDT, DEL,"
		. " DRAWING, LINEOPENCONTACTDT, LINECLOSECONTACTDT, LINECONTACTNOTE, ELECTRICITYCHARGE, GASCHARGE, LIGHTORDER";
	$sql .= " ) VALUES ( ";
	$sql .= "'$articleNo', '$article', '$room', '$keyPlace', '$address', '$articleNote', '$keyBox', '', '$sellCharge', '', '', '', '', '',"
		. " '', '', '', '', '', '', '', '', '', '', '', '',"
		. " '', '', '', '', '', '', '', '', '', '', '', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$del',"
		. " '$drawing', '', '', '', '', '', '' )";

	return ($sql);
}



//
//物件管理情報削除
//
function fnSqlArticleDelete($articleNo)
{
	$sql  = "UPDATE TBLARTICLE";
	$sql .= " SET DEL = 0";
	$sql .= ",UPDT = CURRENT_TIMESTAMP";
	$sql .= " WHERE ARTICLENO = '$articleNo'";

	return ($sql);
}
