<?php
//
//ファイルマネージャー画面
//
function subFManager()
{
	$conn = fnDbConnect();

	$sDel          = htmlspecialchars($_REQUEST['sDel']);
	$sSearchDTFrom = htmlspecialchars($_REQUEST['sSearchDTFrom']);
	$sSearchDTTo   = htmlspecialchars($_REQUEST['sSearchDTTo']);
	$sName         = htmlspecialchars($_REQUEST['sName']);
	$sRoom         = htmlspecialchars($_REQUEST['sRoom']);
	$sNote         = htmlspecialchars($_REQUEST['sNote']);

	$orderBy = $_REQUEST['orderBy'];
	$orderTo = $_REQUEST['orderTo'];
	$sPage   = $_REQUEST['sPage'];

	if ($sDel == '') {
		$sDel = 1;
	}

	if (!$sPage) {
		$sPage = 1;
	}

	if (!$orderBy || $orderBy == 'ARTICLENO') {
		$orderBy = 'FMNO';
		$orderTo = 'DESC';
	}

	subMenu();
?>
	<script>
		var cal1 = new JKL.Calendar("cal1", "form", "sSearchDTFrom");
		var cal2 = new JKL.Calendar("cal2", "form", "sSearchDTTo");
	</script>

	<h1>ファイルマネージャー画面</h1>

	<form name="form" id="form" action="index.php" method="post">
		<input type="hidden" name="act" value="fManagerSearch" />
		<input type="hidden" name="orderBy" value="<?php print $orderBy; ?>" />
		<input type="hidden" name="orderTo" value="<?php print $orderTo; ?>" />
		<input type="hidden" name="sPage" value="<?php print $sPage; ?>" />
		<input type="hidden" name="fMNo" />

		<a href="javascript:form.act.value='fManagerEdit';form.submit();"><img src="./images/btn_enter.png"></a>

		<div class="search">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr>
					<th>除外</th>
					<td><input type="checkbox" name="sDel" value="0" <?php if ($sDel == 0) print ' checked="checked"'; ?> /></td>
				</tr>
				<tr>
					<th>検索日</th>
					<td>
						<input type="text" name="sSearchDTFrom" value="<?php print $sSearchDTFrom; ?>" size="15" /><a href="javascript:cal1.write();" onChange="cal1.getFormValue(); cal1.hide();"><img src="./images/b_calendar.png"></a><span id="cal1"></span>
						～
						<input type="text" name="sSearchDTTo" value="<?php print $sSearchDTTo; ?>" size="15" /><a href="javascript:cal2.write();" onChange="cal2.getFormValue(); cal2.hide();"><img src="./images/b_calendar.png"></a><span id="cal2"></span>
					</td>
				</tr>
				<tr>
					<th>物件名</th>
					<td><input type="text" name="sName" value="<?php print $sName; ?>" size="50" /></td>
				</tr>
				<tr>
					<th>部屋</th>
					<td><input type="text" name="sRoom" value="<?php print $sRoom; ?>" size="30" /></td>
				</tr>
				<tr>
					<th>備考</th>
					<td><input type="text" name="sNote" value="<?php print $sNote; ?>" size="50" /></td>
				</tr>
			</table>
		</div>

		<input type="image" src="./images/btn_search.png" onclick="form.act.value='fManagerSearch';form.sPage.value=1;form.submit();" />

		<hr />

		<?php
		if ($_REQUEST['act'] == 'fManager') {
			return;
		}

		$sql = fnSqlFManagerList(0, $sDel, $sSearchDTFrom, $sSearchDTTo, $sName, $sRoom, $sNote, $sPage, $orderBy, $orderTo);
		$res = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($res);

		$count = $row[0];

		$sPage = fnPage($count, $sPage, 'fManagerSearch');
		?>

		<div class="list">
			<table border="0" cellpadding="5" cellspacing="1">
				<tr>
					<th class="list_head">登録日<?php fnOrder('INSDT', 'fManagerSearch'); ?></th>
					<th class="list_head">物件名<?php fnOrder('NAME', 'fManagerSearch'); ?></th>
					<th class="list_head">部屋<?php fnOrder('ROOM', 'fManagerSearch'); ?></th>
					<th class="list_head">備考<?php fnOrder('NOTE', 'fManagerSearch'); ?></th>
					<th class="list_head">表示</th>
				</tr>
				<?php
				$sql = fnSqlFManagerList(1, $sDel, $sSearchDTFrom, $sSearchDTTo, $sName, $sRoom, $sNote, $sPage, $orderBy, $orderTo);
				$res = mysqli_query($conn, $sql);
				$i = 0;
				while ($row = mysqli_fetch_array($res)) {
					$fMNo  = htmlspecialchars($row[0]);
					$name  = htmlspecialchars($row[1]);
					$room  = htmlspecialchars($row[2]);
					$note  = htmlspecialchars($row[3]);
					$insDT = htmlspecialchars($row[4]);
				?>
					<tr>
						<td class="list_td<?php print $i; ?>"><?php print $insDT; ?></td>
						<td class="list_td<?php print $i; ?>"><a href="javascript:form.act.value='fManagerEdit';form.fMNo.value=<?php print $fMNo; ?>;form.submit();"><?php print $name; ?></a></td>
						<td class="list_td<?php print $i; ?>"><?php print $room; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $note; ?></td>
						<td class="list_td<?php print $i; ?>"><a href="javascript:form.act.value='fManagerView';form.fMNo.value=<?php print $fMNo; ?>;form.submit();">＞＞＞この物件の書類一覧を表示する</a></td>
					</tr>
				<?php
					$i = ($i + 1) % 2;
				}
				?>
			</table>
		</div>
	<?php
}




//
//ファイルマネージャー編集画面
//
function subFManagerEdit()
{
	$conn = fnDbConnect();

	$sDel          = htmlspecialchars($_REQUEST['sDel']);
	$sSearchDTFrom = htmlspecialchars($_REQUEST['sSearchDTFrom']);
	$sSearchDTTo   = htmlspecialchars($_REQUEST['sSearchDTTo']);
	$sName         = htmlspecialchars($_REQUEST['sName']);
	$sRoom         = htmlspecialchars($_REQUEST['sRoom']);
	$sNote         = htmlspecialchars($_REQUEST['sNote']);

	$orderBy = $_REQUEST['orderBy'];
	$orderTo = $_REQUEST['orderTo'];
	$sPage   = $_REQUEST['sPage'];

	$fMNo = $_REQUEST['fMNo'];

	if ($fMNo) {
		$sql = fnSqlFManagerEdit($fMNo);
		$res = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($res);

		$name  = htmlspecialchars($row[0]);
		$room  = htmlspecialchars($row[1]);
		$note  = htmlspecialchars($row[2]);
		$del   = htmlspecialchars($row[4]);

		$purpose  = '更新';
		$btnImage = 'btn_load.png';
	} else {
		$purpose = '登録';
		$btnImage = 'btn_enter.png';
	}

	subMenu();
	?>
		<script type="text/javascript" src="./js/fmanager.js"></script>

		<h1>ファイルマネージャー物件<?php print $purpose; ?></h1>

		<form name="form" id="form" action="index.php" method="post">
			<input type="hidden" name="act" />
			<input type="hidden" name="sDel" value="<?php print $sDel; ?>" />
			<input type="hidden" name="sSearchDTFrom" value="<?php print $sSearchDTFrom; ?>" />
			<input type="hidden" name="sSearchDTTo" value="<?php print $sSearchDTTo; ?>" />
			<input type="hidden" name="sName" value="<?php print $sName; ?>" />
			<input type="hidden" name="sRoom" value="<?php print $sRoom; ?>" />
			<input type="hidden" name="sNote" value="<?php print $sNote; ?>" />
			<input type="hidden" name="orderBy" value="<?php print $orderBy; ?>" />
			<input type="hidden" name="orderTo" value="<?php print $orderTo; ?>" />
			<input type="hidden" name="sPage" value="<?php print $sPage; ?>" />
			<input type="hidden" name="fMNo" value="<?php print $fMNo; ?>" />

			<table border="0" cellpadding="5" cellspacing="1">
				<tr>
					<th>除外</th>
					<td><input type="radio" name="del" value="1" checked="checked" /> 非除外
						<input type="radio" name="del" value="0" <?php if ($del == '0') print ' checked="checked"'; ?> /> 除外
					</td>
				</tr>
				<tr>
					<th>物件名</th>
					<td><input type="text" name="name" value="<?php print $name; ?>" /></td>
				</tr>
				<tr>
					<th>部屋</th>
					<td><input type="text" name="room" value="<?php print $room; ?>" /></td>
				</tr>
				<tr>
					<th>備考</th>
					<td><textarea name="note" cols="50" rows="10"><?php print $note; ?></textarea></td>
				</tr>
			</table>

			<a href="javascript:fnFManagerEditCheck();"><img src="./images/<?php print $btnImage; ?>" /></a>　
			<a href="javascript:form.act.value='fManagerSearch';form.submit();"><img src="./images/btn_return.png" /></a>　
			<?php
			if ($fMNo) {
			?>
				<a href="javascript:fnFManagerDeleteCheck(<?php print $fMNo; ?>);"><img src="./images/btn_del.png" /></a>
			<?php
			}
			?>

		</form>
	<?php
}




//
//ファイルマネージャー物件編集完了処理
//
function subFManagerEditComplete()
{
	$conn = fnDbConnect();

	$sDel          = htmlspecialchars($_REQUEST['sDel']);
	$sSearchDTFrom = htmlspecialchars($_REQUEST['sSearchDTFrom']);
	$sSearchDTTo   = htmlspecialchars($_REQUEST['sSearchDTTo']);
	$sName         = htmlspecialchars($_REQUEST['sName']);
	$sRoom         = htmlspecialchars($_REQUEST['sRoom']);
	$sNote         = htmlspecialchars($_REQUEST['sNote']);

	$orderBy = $_REQUEST['orderBy'];
	$orderTo = $_REQUEST['orderTo'];
	$sPage   = $_REQUEST['sPage'];

	$fMNo = mysqli_real_escape_string($conn, $_REQUEST['fMNo']);
	$name = mysqli_real_escape_string($conn, $_REQUEST['name']);
	$room = mysqli_real_escape_string($conn, $_REQUEST['room']);
	$note = mysqli_real_escape_string($conn, $_REQUEST['note']);
	$del  = mysqli_real_escape_string($conn, $_REQUEST['del']);

	if ($fMNo) {
		$sql = fnSqlFManagerUpdate($fMNo, $name, $room, $note, $del);
		$res = mysqli_query($conn, $sql);
	} else {
		$sql = fnSqlFManagerInsert(fnNextNo('FM'), $name, $room, $note, $del);
		$res = mysqli_query($conn, $sql);
	}

	$_REQUEST['act'] = 'fManagerSearch';
	subFManager();
}




//
//ファイルマネージャー物件管理削除処理
//
function subFManagerDelete()
{
	$conn = fnDbConnect();

	$fMNo = $_REQUEST['fMNo'];

	$sql = fnSqlFManagerDelete($fMNo);
	$res = mysqli_query($conn, $sql);

	$_REQUEST['act'] = 'fManagerSearch';
	subFManager();
}




//
//ファイルマネージャー書類一覧画面
//
function subFManagerView()
{
	$conn = fnDbConnect();

	$sDel          = htmlspecialchars($_REQUEST['sDel']);
	$sSearchDTFrom = htmlspecialchars($_REQUEST['sSearchDTFrom']);
	$sSearchDTTo   = htmlspecialchars($_REQUEST['sSearchDTTo']);
	$sName         = htmlspecialchars($_REQUEST['sName']);
	$sRoom         = htmlspecialchars($_REQUEST['sRoom']);
	$sNote         = htmlspecialchars($_REQUEST['sNote']);

	$orderBy = $_REQUEST['orderBy'];
	$orderTo = $_REQUEST['orderTo'];
	$sPage   = $_REQUEST['sPage'];

	$sClassNo = $_REQUEST['sClassNo'];

	$fMNo = $_REQUEST['fMNo'];

	$sql = fnSqlFManagerEdit($fMNo);
	$res = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($res);

	$name  = htmlspecialchars($row[0]);
	$room  = htmlspecialchars($row[1]);
	$note  = htmlspecialchars($row[2]);
	$insDT = htmlspecialchars($row[3]);

	subMenu();
	?>

		<h1>書類一覧</h1>

		<form name="form" id="form" action="index.php" method="post">
			<input type="hidden" name="act" />
			<input type="hidden" name="sDel" value="<?php print $sDel; ?>" />
			<input type="hidden" name="sSearchDTFrom" value="<?php print $sSearchDTFrom; ?>" />
			<input type="hidden" name="sSearchDTTo" value="<?php print $sSearchDTTo; ?>" />
			<input type="hidden" name="sName" value="<?php print $sName; ?>" />
			<input type="hidden" name="sRoom" value="<?php print $sRoom; ?>" />
			<input type="hidden" name="sNote" value="<?php print $sNote; ?>" />
			<input type="hidden" name="orderBy" value="<?php print $orderBy; ?>" />
			<input type="hidden" name="orderTo" value="<?php print $orderTo; ?>" />
			<input type="hidden" name="sPage" value="<?php print $sPage; ?>" />
			<input type="hidden" name="fMNo" value="<?php print $fMNo; ?>" />
			<input type="hidden" name="pdfNo" />
			<input type="hidden" name="docNo" />

			<div class="list">
				<table border="0" cellpadding="5" cellspacing="1">
					<tr>
						<th>登録日</th>
						<th>物件名</th>
						<th>部屋</th>
						<th>備考</th>
					</tr>
					<tr>
						<td><?php print $insDT; ?></td>
						<td><?php print $name; ?></td>
						<td><?php print $room; ?></td>
						<td><?php print $note; ?></td>
					</tr>
				</table>
			</div>

			<a href="javascript:form.act.value='fManagerSearch';form.submit();"><img src="./images/btn_return.png" /></a>

			<hr />

			<select name="sClassNo" onchange="form.act.value='fManagerView';form.submit();">
				<option value="0">すべて</option>
				<?php
				$sql = fnSqlFManagerViewTitle();
				$res = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_array($res)) {
					$classNo = htmlspecialchars($row[0]);
					$name    = htmlspecialchars($row[1]);
				?>
					<option value="<?php print $classNo; ?>" <?php if ($sClassNo == $classNo) print ' selected="selected"'; ?>><?php print $name; ?></option>
				<?php
				}
				?>
			</select>

			<div class="list">
				<table border="0" cellpadding="5" cellspacing="1">
					<?php
					$sql = fnSqlFManagerViewList($sClassNo);
					$res = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_array($res)) {
						$docNo   = htmlspecialchars($row[0]);
						$classNo = htmlspecialchars($row[1]);
						$seqNo   = htmlspecialchars($row[2]);
						$name    = htmlspecialchars($row[3]);

						if ($seqNo == 0) {
					?>
							<tr>
								<th colspan="5">－－－　<?php print $name; ?>　－－－</th>
							</tr>
						<?php
						} else {
							$sql  = fnSqlFManagerViewPDF($fMNo, $docNo);
							$res2 = mysqli_query($conn, $sql);
							$row2 = mysqli_fetch_array($res2);

							$pdfNo = htmlspecialchars($row2[0]);
							$note  = htmlspecialchars($row2[1]);
						?>
							<tr>
								<td width="35%"><?php print $name; ?></td>
								<td width="45%"><?php print $note; ?></td>
								<?php
								if ($pdfNo) {
								?>
									<td width="10%"><a href="./pdfs/<?php print substr('0000000000' . $pdfNo, -10) . '.pdf'; ?>" target="_blank">表示</a></td>
									<td width="10%"><a href="javascript:form.act.value='fManagerViewEdit';form.pdfNo.value=<?php print $pdfNo; ?>;form.submit();">編集</a></td>
								<?php
								} else {
								?>
									<td width="10%">&nbsp;</td>
									<td width="10%"><a href="javascript:form.act.value='fManagerViewEdit';form.docNo.value=<?php print $docNo; ?>;form.submit();">登録</a></td>
								<?php
								}
								?>
								</td>
							</tr>
					<?php
						}
					}
					?>
				</table>
			</div>

		</form>
	<?php
}




//
//ファイルマネージャー書類編集画面
//
function subFManagerViewEdit()
{
	$conn = fnDbConnect();

	$sDel          = htmlspecialchars($_REQUEST['sDel']);
	$sSearchDTFrom = htmlspecialchars($_REQUEST['sSearchDTFrom']);
	$sSearchDTTo   = htmlspecialchars($_REQUEST['sSearchDTTo']);
	$sName         = htmlspecialchars($_REQUEST['sName']);
	$sRoom         = htmlspecialchars($_REQUEST['sRoom']);
	$sNote         = htmlspecialchars($_REQUEST['sNote']);

	$orderBy = $_REQUEST['orderBy'];
	$orderTo = $_REQUEST['orderTo'];
	$sPage   = $_REQUEST['sPage'];

	$fMNo  = $_REQUEST['fMNo'];
	$pdfNo = $_REQUEST['pdfNo'];

	if ($pdfNo) {
		$sql = fnSqlFManagerViewEdit($pdfNo);
		$res = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($res);

		$note = htmlspecialchars($row[0]);

		$purpose = '更新';
		$btnImage = 'btn_load.png';
	} else {
		$docNo   = $_REQUEST['docNo'];
		$purpose = '登録';
		$btnImage = 'btn_enter.png';
	}

	subMenu();
	?>
		<script type="text/javascript" src="./js/fmanager.js"></script>

		<h1>ファイルマネージャー書類<?php print $purpose; ?></h1>

		<form name="form" id="form" action="index.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="act" />
			<input type="hidden" name="sDel" value="<?php print $sDel; ?>" />
			<input type="hidden" name="sSearchDTFrom" value="<?php print $sSearchDTFrom; ?>" />
			<input type="hidden" name="sSearchDTTo" value="<?php print $sSearchDTTo; ?>" />
			<input type="hidden" name="sName" value="<?php print $sName; ?>" />
			<input type="hidden" name="sRoom" value="<?php print $sRoom; ?>" />
			<input type="hidden" name="sNote" value="<?php print $sNote; ?>" />
			<input type="hidden" name="orderBy" value="<?php print $orderBy; ?>" />
			<input type="hidden" name="orderTo" value="<?php print $orderTo; ?>" />
			<input type="hidden" name="sPage" value="<?php print $sPage; ?>" />
			<input type="hidden" name="fMNo" value="<?php print $fMNo; ?>" />
			<input type="hidden" name="pdfNo" value="<?php print $pdfNo; ?>" />
			<input type="hidden" name="docNo" value="<?php print $docNo; ?>" />

			<table border="0" cellpadding="5" cellspacing="1">
				<tr>
					<th>備考</th>
					<td><textarea name="note" cols="50" rows="10"><?php print $note; ?></textarea></td>
				</tr>
				<tr>
					<th>PDFファイル<?php print $purpose; ?></th>
					<td><input type="file" name="pdfFile" /></td>
				</tr>
			</table>

			<a href="javascript:fnFManagerViewEditCheck();"><img src="./images/<?php print $btnImage; ?>" /></a>　
			<a href="javascript:form.act.value='fManagerView';form.submit();"><img src="./images/btn_return.png" /></a>　
			<?php
			if ($pdfNo) {
			?>
				<a href="javascript:fnFManagerViewDeleteCheck(<?php print $pdfNo; ?>);"><img src="./images/btn_del.png" /></a>
			<?php
			}
			?>

		</form>
	<?php
}




//
//ファイルマネージャー書類編集完了処理
//
function subFManagerViewEditComplete()
{
	$conn = fnDbConnect();

	$sDel          = htmlspecialchars($_REQUEST['sDel']);
	$sSearchDTFrom = htmlspecialchars($_REQUEST['sSearchDTFrom']);
	$sSearchDTTo   = htmlspecialchars($_REQUEST['sSearchDTTo']);
	$sName         = htmlspecialchars($_REQUEST['sName']);
	$sRoom         = htmlspecialchars($_REQUEST['sRoom']);
	$sNote         = htmlspecialchars($_REQUEST['sNote']);

	$orderBy = $_REQUEST['orderBy'];
	$orderTo = $_REQUEST['orderTo'];
	$sPage   = $_REQUEST['sPage'];

	$fMNo  = mysqli_real_escape_string($conn, $_REQUEST['fMNo']);
	$pdfNo = mysqli_real_escape_string($conn, $_REQUEST['pdfNo']);
	$docNo = mysqli_real_escape_string($conn, $_REQUEST['docNo']);
	$note  = mysqli_real_escape_string($conn, $_REQUEST['note']);

	if ($pdfNo) {
		$sql = fnSqlFManagerViewUpdate($pdfNo, $note);
		$res = mysqli_query($conn, $sql);
	} else {
		$sql = "SELECT COUNT(*) FROM TBLPDF WHERE DEL = 1 AND FMNO = '$fMNo' AND DOCNO = '$docNo'";
		$res = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($res);
		if (!$row[0]) {
			$pdfNo = fnNextNo('PDF');

			$sql = fnSqlFManagerViewInsert($pdfNo, $fMNo, $docNo, $note);
			$res = mysqli_query($conn, $sql);
		}
	}

	if ($_FILES['pdfFile']['tmp_name']) {
		move_uploaded_file($_FILES['pdfFile']['tmp_name'], './pdfs/' . $pdfNo . '.pdf');
	}

	$_REQUEST['act'] = 'fManagerView';
	subFManagerView();
}




//
//ファイルマネージャー書類削除処理
//
function subFManagerViewDelete()
{
	$conn = fnDbConnect();

	$pdfNo = $_REQUEST['pdfNo'];

	$sql = fnSqlFManagerViewDelete($pdfNo);
	$res = mysqli_query($conn, $sql);

	unlink('./pdfs/' . substr('0000000000' . $pdfNo, -10) . '.pdf');
	$_REQUEST['act'] = 'fManagerView';
	subFManagerView();
}
	?>