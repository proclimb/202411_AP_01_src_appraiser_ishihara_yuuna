<?php
//
//業者管理画面
//
function subTrade()
{
	$conn = fnDbConnect();

	$sDel        = htmlspecialchars($_REQUEST['sDel']);
	$sName       = htmlspecialchars($_REQUEST['sName']);
	$sBranch     = htmlspecialchars($_REQUEST['sBranch']);
	$sZip        = htmlspecialchars($_REQUEST['sZip']);
	$sPrefecture = htmlspecialchars($_REQUEST['sPrefecture']);
	$sAddress1   = htmlspecialchars($_REQUEST['sAddress1']);
	$sAddress2   = htmlspecialchars($_REQUEST['sAddress2']);
	$sTel        = htmlspecialchars($_REQUEST['sTel']);
	$sFax        = htmlspecialchars($_REQUEST['sFax']);
	$sMobile     = htmlspecialchars($_REQUEST['sMobile']);

	$orderBy = $_REQUEST['orderBy'];
	$orderTo = $_REQUEST['orderTo'];
	$sPage   = $_REQUEST['sPage'];

	if ($sDel == '') {
		$sDel = 1;
	}

	if (!$sPage) {
		$sPage = 1;
	}

	if (!$orderBy) {
		$orderBy = 'TRADENO';
		$orderTo = 'DESC';
	}

	subMenu();
?>
	<h1>業者管理一覧</h1>

	<form name="form" id="form" action="index.php" method="post">
		<input type="hidden" name="act" value="tradeSearch" />
		<input type="hidden" name="orderBy" value="<?php print $orderBy; ?>" />
		<input type="hidden" name="orderTo" value="<?php print $orderTo; ?>" />
		<input type="hidden" name="sPage" value="<?php print $sPage; ?>" />
		<input type="hidden" name="tradeNo" />

		<a href="javascript:form.act.value='tradeEdit';form.submit();"><img src="./images/btn_enter.png"></a>

		<div class="search">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr>
					<th>除外</th>
					<td><input type="checkbox" name="sDel" value="0" <?php if ($sDel == 0) print ' checked="checked"'; ?> /></td>
					<th>郵便番号</th>
					<td><input type="text" name="sZip" value="<?php print $sZip; ?>" size="15" /></td>
				</tr>
				<tr>
					<th>業者名</th>
					<td><input type="text" name="sName" value="<?php print $sName; ?>" size="30" /></td>
					<th>都道府県</th>
					<td><input type="text" name="sPrefecture" value="<?php print $sPrefecture; ?>" size="15" /></td>
				</tr>
				<tr>
					<th>支店名</th>
					<td><input type="text" name="sBranch" value="<?php print $sBranch; ?>" size="30" /></td>
					<th>住所1</th>
					<td><input type="text" name="sAddress1" value="<?php print $sAddress1; ?>" size="30" /></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td>&nbsp;</td>
					<th>住所2</th>
					<td><input type="text" name="sAddress2" value="<?php print $sAddress2; ?>" size="50" /></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td>&nbsp;</td>
					<th>TEL</th>
					<td><input type="text" name="sTel" value="<?php print $sTel; ?>" size="30" /></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td>&nbsp;</td>
					<th>FAX</th>
					<td><input type="text" name="sFax" value="<?php print $sFax; ?>" size="30" /></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td>&nbsp;</td>
					<th>携帯電話</th>
					<td><input type="text" name="sMobile" value="<?php print $sMobile; ?>" size="30" /></td>
				</tr>
			</table>
		</div>

		<input type="image" src="./images/btn_search.png" onclick="form.act.value='tradeSearch';form.sPage.value=1;form.submit();" />

		<hr />

		<?php
		if ($_REQUEST['act'] == 'trade') {
			return;
		}

		$sql = fnSqlTradeList(0, $sDel, $sName, $sBranch, $sZip, $sPrefecture, $sAddress1, $sAddress2, $sTel, $sFax, $sMobile, $sPage, $orderBy, $orderTo);
		$res = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($res);

		$count = $row[0];

		$sPage = fnPage($count, $sPage, 'tradeSearch');
		?>

		<div class="list">
			<table border="0" cellpadding="5" cellspacing="1">
				<tr>
					<th class="list_head">業者名<?php fnOrder('NAME', 'tradeSearch'); ?></th>
					<th class="list_head">支店名<?php fnOrder('BRANCH', 'tradeSearch'); ?></th>
					<th class="list_head">郵便番号<?php fnOrder('ZIP', 'tradeSearch'); ?></th>
					<th class="list_head">都道府県<?php fnOrder('PREFECTURE', 'tradeSearch'); ?></th>
					<th class="list_head">住所1<?php fnOrder('ADDRESS1', 'tradeSearch'); ?></th>
					<th class="list_head">住所2<?php fnOrder('ADDRESS2', 'tradeSearch'); ?></th>
					<th class="list_head">TEL<?php fnOrder('TEL', 'tradeSearch'); ?></th>
					<th class="list_head">FAX<?php fnOrder('FAX', 'tradeSearch'); ?></th>
					<th class="list_head">携帯電話<?php fnOrder('MOBILE', 'tradeSearch'); ?></th>
				</tr>
				<?php
				$sql = fnSqlTradeList(1, $sDel, $sName, $sBranch, $sZip, $sPrefecture, $sAddress1, $sAddress2, $sTel, $sFax, $sMobile, $sPage, $orderBy, $orderTo);
				$res = mysqli_query($conn, $sql);
				$i = 0;
				while ($row = mysqli_fetch_array($res)) {
					$tradeNo    = htmlspecialchars($row[0]);
					$name       = htmlspecialchars($row[1]);
					$branch     = htmlspecialchars($row[2]);
					$zip        = htmlspecialchars($row[3]);
					$prefecture = htmlspecialchars($row[4]);
					$address1   = htmlspecialchars($row[5]);
					$address2   = htmlspecialchars($row[6]);
					$tel        = htmlspecialchars($row[7]);
					$fax        = htmlspecialchars($row[8]);
					$mobile     = htmlspecialchars($row[9]);
				?>
					<tr>
						<td class="list_td<?php print $i; ?>"><a href="javascript:form.act.value='tradeEdit';form.tradeNo.value=<?php print $tradeNo; ?>;form.submit();"><?php print $name; ?></a></td>
						<td class="list_td<?php print $i; ?>"><?php print $branch; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $zip; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $prefecture; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $address1; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $address2; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $tel; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $fax; ?></td>
						<td class="list_td<?php print $i; ?>"><?php print $mobile; ?></td>
					</tr>
				<?php
					$i = ($i + 1) % 2;
				}
				?>
			</table>
		</div>
	</form>
<?php
}




//
//業者一覧編集画面
//
function subTradeEdit()
{
	$conn = fnDbConnect();

	$sDel        = htmlspecialchars($_REQUEST['sDel']);
	$sName       = htmlspecialchars($_REQUEST['sName']);
	$sBranch     = htmlspecialchars($_REQUEST['sBranch']);
	$sZip        = htmlspecialchars($_REQUEST['sZip']);
	$sPrefecture = htmlspecialchars($_REQUEST['sPrefecture']);
	$sAddress1   = htmlspecialchars($_REQUEST['sAddress1']);
	$sAddress2   = htmlspecialchars($_REQUEST['sAddress2']);
	$sTel        = htmlspecialchars($_REQUEST['sTel']);
	$sFax        = htmlspecialchars($_REQUEST['sFax']);
	$sMobile     = htmlspecialchars($_REQUEST['sMobile']);
	$sInterior   = htmlspecialchars($_REQUEST['sInterior']);

	$orderBy = $_REQUEST['orderBy'];
	$orderTo = $_REQUEST['orderTo'];
	$sPage   = $_REQUEST['sPage'];

	$tradeNo = $_REQUEST['tradeNo'];

	if ($tradeNo) {
		$sql = fnSqlTradeEdit($tradeNo);
		$res = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($res);

		$name       = htmlspecialchars($row[0]);
		$nameFuri   = htmlspecialchars($row[1]);
		$branch     = htmlspecialchars($row[2]);
		$branchFuri = htmlspecialchars($row[3]);
		$zip        = htmlspecialchars($row[4]);
		$prefecture = htmlspecialchars($row[5]);
		$address1   = htmlspecialchars($row[6]);
		$address2   = htmlspecialchars($row[7]);
		$tel        = htmlspecialchars($row[8]);
		$fax        = htmlspecialchars($row[9]);
		$mobile     = htmlspecialchars($row[10]);
		$interior   = htmlspecialchars($row[11]);
		$del        = htmlspecialchars($row[12]);

		$purpose  = '更新';
		$btnImage = 'btn_load.png';
	} else {
		$purpose = '登録';
		$btnImage = 'btn_enter.png';
	}

	subMenu();
?>
	<script type="text/javascript" src="./js/trade.js"></script>

	<h1>業者<?php print $purpose; ?></h1>

	<form name="form" id="form" action="index.php" method="post">
		<input type="hidden" name="act" />
		<input type="hidden" name="sDel" value="<?php print $sDel; ?>" />
		<input type="hidden" name="sName" value="<?php print $sName; ?>" />
		<input type="hidden" name="sBranch" value="<?php print $sBranch; ?>" />
		<input type="hidden" name="sZip" value="<?php print $sZip; ?>" />
		<input type="hidden" name="sPrefecture" value="<?php print $sPrefecture; ?>" />
		<input type="hidden" name="sAddress1" value="<?php print $sAddress1; ?>" />
		<input type="hidden" name="sAddress2" value="<?php print $sAddress2; ?>" />
		<input type="hidden" name="sTel" value="<?php print $sTel; ?>" />
		<input type="hidden" name="sFax" value="<?php print $sFax; ?>" />
		<input type="hidden" name="sMobile" value="<?php print $sMobile; ?>" />
		<input type="hidden" name="sInterior" value="<?php print $sInterior; ?>" />
		<input type="hidden" name="orderBy" value="<?php print $orderBy; ?>" />
		<input type="hidden" name="orderTo" value="<?php print $orderTo; ?>" />
		<input type="hidden" name="sPage" value="<?php print $sPage; ?>" />
		<input type="hidden" name="tradeNo" value="<?php print $tradeNo; ?>" />

		<table border="0" cellpadding="5" cellspacing="1">
			<tr>
				<th>除外</th>
				<td><input type="radio" name="del" value="1" checked="checked" /> 非除外
					<input type="radio" name="del" value="0" <?php if ($del == '0') print ' checked="checked"'; ?> /> 除外
				</td>
			</tr>
			<tr>
				<th>業者名<span class="red">（必須）</span></th>
				<td><input type="text" name="name" value="<?php print $name; ?>" /></td>
			</tr>
			<tr>
				<th>業者名（よみ）</th>
				<td><input type="text" name="nameFuri" value="<?php print $nameFuri; ?>" /></td>
			</tr>
			<tr>
				<th>支店名</th>
				<td><input type="text" name="branch" value="<?php print $branch; ?>" /></td>
			</tr>
			<tr>
				<th>支店名（よみ）</th>
				<td><input type="text" name="branchFuri" value="<?php print $branchFuri; ?>" /></td>
			</tr>
			<tr>
				<th>郵便番号</th>
				<td><input type="text" name="zip" value="<?php print $zip; ?>" /></td>
			</tr>
			<tr>
				<th>住所（都道府県）</th>
				<td><input type="text" name="prefecture" value="<?php print $prefecture; ?>" /></td>
			</tr>
			<tr>
				<th>住所1（市区町村名）</th>
				<td><input type="text" name="address1" value="<?php print $address1; ?>" /></td>
			</tr>
			<tr>
				<th>住所2（番地・ビル名）</th>
				<td><input type="text" name="address2" value="<?php print $address2; ?>" /></td>
			</tr>
			<tr>
				<th>TEL</th>
				<td><input type="text" name="tel" value="<?php print $tel; ?>" /></td>
			</tr>
			<tr>
				<th>FAX</th>
				<td><input type="text" name="fax" value="<?php print $fax; ?>" /></td>
			</tr>
			<tr>
				<th>携帯電話</th>
				<td><input type="text" name="mobile" value="<?php print $mobile; ?>" /></td>
			</tr>
			<tr>
				<th>内装関係</th>
				<td><input type="checkbox" name="interior" value="1" <?php if ($interior == 1) print ' checked="checked"'; ?> /></td>
			</tr>

		</table>

		<a href="javascript:fnTradeEditCheck();"><img src="./images/<?php print $btnImage; ?>" /></a>　
		<a href="javascript:form.act.value='tradeSearch';form.submit();"><img src="./images/btn_return.png" /></a>　
		<?php
		if ($tradeNo) {
		?>
			<a href="javascript:fnTradeDeleteCheck(<?php print $tradeNo; ?>);"><img src="./images/btn_del.png" /></a>
		<?php
		}
		?>

	</form>
<?php
}




//
//業者一覧編集完了処理
//
function subTradeEditComplete()
{
	$conn = fnDbConnect();

	$sDel        = htmlspecialchars($_REQUEST['sDel']);
	$sName       = htmlspecialchars($_REQUEST['sName']);
	$sBranch     = htmlspecialchars($_REQUEST['sBranch']);
	$sZip        = htmlspecialchars($_REQUEST['sZip']);
	$sPrefecture = htmlspecialchars($_REQUEST['sPrefecture']);
	$sAddress1   = htmlspecialchars($_REQUEST['sAddress1']);
	$sAddress2   = htmlspecialchars($_REQUEST['sAddress2']);
	$sTel        = htmlspecialchars($_REQUEST['sTel']);
	$sFax        = htmlspecialchars($_REQUEST['sFax']);
	$sMobile     = htmlspecialchars($_REQUEST['sMobile']);
	$sInterior   = htmlspecialchars($_REQUEST['sInterior']);

	$orderBy = $_REQUEST['orderBy'];
	$orderTo = $_REQUEST['orderTo'];
	$sPage   = $_REQUEST['sPage'];

	$tradeNo    = mysqli_real_escape_string($conn, $_REQUEST['tradeNo']);
	$name       = mysqli_real_escape_string($conn, $_REQUEST['name']);
	$nameFuri   = mysqli_real_escape_string($conn, $_REQUEST['nameFuri']);
	$branch     = mysqli_real_escape_string($conn, $_REQUEST['branch']);
	$branchFuri = mysqli_real_escape_string($conn, $_REQUEST['branchFuri']);
	$zip        = mysqli_real_escape_string($conn, $_REQUEST['zip']);
	$prefecture = mysqli_real_escape_string($conn, $_REQUEST['prefecture']);
	$address1   = mysqli_real_escape_string($conn, $_REQUEST['address1']);
	$address2   = mysqli_real_escape_string($conn, $_REQUEST['address2']);
	$tel        = mysqli_real_escape_string($conn, $_REQUEST['tel']);
	$fax        = mysqli_real_escape_string($conn, $_REQUEST['fax']);
	$mobile     = mysqli_real_escape_string($conn, $_REQUEST['mobile']);
	$interior   = mysqli_real_escape_string($conn, $_REQUEST['interior']);
	$del        = mysqli_real_escape_string($conn, $_REQUEST['del']);

	if ($tradeNo) {
		$sql = fnSqlTradeUpdate($tradeNo, $name, $nameFuri, $branch, $branchFuri, $zip, $prefecture, $address1, $address2, $tel, $fax, $mobile, $interior, $del);
		$res = mysqli_query($conn, $sql);
	} else {
		$sql = fnSqlTradeInsert(fnNextNo('TRADE'), $name, $nameFuri, $branch, $branchFuri, $zip, $prefecture, $address1, $address2, $tel, $fax, $mobile, $interior, $del);
		$res = mysqli_query($conn, $sql);
	}

	$_REQUEST['act'] = 'tradeSearch';
	subTrade();
}




//
//業者一覧削除処理
//
function subTradeDelete()
{
	$conn = fnDbConnect();

	$tradeNo = $_REQUEST['tradeNo'];

	$sql = fnSqlTradeDelete($tradeNo);
	$res = mysqli_query($conn, $sql);

	$_REQUEST['act'] = 'tradeSearch';
	subTrade();
}
?>