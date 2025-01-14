<?php
//
//ファイルマネージャー物件管理リスト
//
function fnSqlFManagerList($flg, $sDel, $sSearchDTFrom, $sSearchDTTo, $sName, $sRoom, $sNote, $sPage, $orderBy, $orderTo)
{
	switch ($flg) {
		case 0:
			$sql  = "SELECT COUNT(*)";
			break;
		case 1:
			$sql  = "SELECT FMNO,NAME,ROOM,NOTE,IF(INSDT > '0000-00-00',DATE_FORMAT(INSDT,'%Y/%m/%d'),'')";
			break;
	}
	$sql .= " FROM TBLFM";
	$sql .= " WHERE DEL = $sDel";
	if ($sSearchDTFrom) {
		$sql .= " AND INSDT >= '$sSearchDTFrom'";
	}
	if ($sSearchDTTo) {
		$sql .= " AND INSDT <= '$sSearchDTTo 23:59:59'";
	}
	if ($sName) {
		$sql .= " AND NAME LIKE '%$sName%'";
	}
	if ($sRoom) {
		$sql .= " AND ROOM LIKE '%$sRoom%'";
	}
	if ($sNote) {
		$sql .= " AND NOTE LIKE '%$sNote%'";
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
//ファイルマネージャー物件管理情報
//
function fnSqlFManagerEdit($fMNo)
{
	$sql  = "SELECT NAME,ROOM,NOTE,INSDT,DEL";
	$sql .= " FROM TBLFM";
	$sql .= " WHERE FMNO = $fMNo";

	return ($sql);
}



//
//ファイルマネージャー物件管理情報更新
//
function fnSqlFManagerUpdate($fMNo, $name, $room, $note, $del)
{
	$sql  = "UPDATE TBLFM";
	$sql .= " SET NAME = '$name'";
	$sql .= ",ROOM = '$room'";
	$sql .= ",NOTE = '$note'";
	$sql .= ",UPDT = CURRENT_TIMESTAMP";
	$sql .= ",DEL = '$del'";
	$sql .= " WHERE FMNO = $fMNo";

	return ($sql);
}



//
//ファイルマネージャー物件管理情報登録
//
function fnSqlFManagerInsert($fMNo, $name, $room, $note, $del)
{
	$sql  = "INSERT INTO TBLFM(";
	$sql .= "FMNO,NAME,ROOM,NOTE,INSDT,UPDT,DEL";
	$sql .= ")VALUES(";
	$sql .= "'$fMNo','$name','$room','$note',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'$del')";

	return ($sql);
}



//
//ファイルマネージャー物件管理情報削除
//
function fnSqlFManagerDelete($fMNo)
{
	$sql  = "UPDATE TBLFM";
	$sql .= " SET DEL = 0";
	$sql .= ",UPDT = CURRENT_TIMESTAMP";
	$sql .= " WHERE FMNO = '$fMNo'";

	return ($sql);
}



//
//ファイルマネージャー書類タイトル
//
function fnSqlFManagerViewTitle()
{
	$sql  = "SELECT CLASSNO,NAME FROM TBLDOC";
	$sql .= " WHERE DEL = 1";
	$sql .= " AND SEQNO = 0";
	$sql .= " ORDER BY CLASSNO ASC";

	return ($sql);
}



//
//ファイルマネージャー書類一覧
//
function fnSqlFManagerViewList($classNo)
{
	$sql  = "SELECT DOCNO,CLASSNO,SEQNO,NAME FROM TBLDOC";
	$sql .= " WHERE DEL = 1";
	if ($classNo) {
		$sql .= " AND CLASSNO = '$classNo'";
	}
	$sql .= " ORDER BY CLASSNO ASC,SEQNO ASC";

	return ($sql);
}



//
//ファイルマネージャー登録書類一覧
//
function fnSqlFManagerViewPDF($fMNo, $docNo)
{
	$sql  = "SELECT PDFNO,NOTE FROM TBLPDF";
	$sql .= " WHERE DEL = 1";
	$sql .= " AND FMNO = '$fMNo'";
	$sql .= " AND DOCNO = '$docNo'";

	return ($sql);
}



//
//ファイルマネージャー書類編集
//
function fnSqlFManagerViewEdit($pdfNo)
{
	$sql  = "SELECT NOTE FROM TBLPDF";
	$sql .= " WHERE DEL = 1";
	$sql .= " AND PDFNO = '$pdfNo'";

	return ($sql);
}



//
//ファイルマネージャー書類更新
//
function fnSqlFManagerViewUpdate($pdfNo, $note)
{
	$sql  = "UPDATE TBLPDF";
	$sql .= " SET note = '$note'";
	$sql .= ",UPDT = CURRENT_TIMESTAMP";
	$sql .= " WHERE PDFNO = $pdfNo";

	return ($sql);
}



//
//ファイルマネージャー書類登録
//
function fnSqlFManagerViewInsert($pdfNo, $fMNo, $docNo, $note)
{
	$sql  = "INSERT INTO TBLPDF(";
	$sql .= "PDFNO,FMNO,DOCNO,NOTE,INSDT,UPDT,DEL";
	$sql .= ")VALUES(";
	$sql .= "'$pdfNo','$fMNo','$docNo','$note',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1)";

	return ($sql);
}



//
//ファイルマネージャー書類削除
//
function fnSqlFManagerViewDelete($pdfNo)
{
	$sql  = "UPDATE TBLPDF";
	$sql .= " SET DEL = 0";
	$sql .= ",UPDT = CURRENT_TIMESTAMP";
	$sql .= " WHERE PDFNO = '$pdfNo'";

	return ($sql);
}
