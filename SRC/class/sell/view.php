<?php
//
//売主物件画面
//
function subSellView($param)
{
?>
	<script type="text/javascript" src="./js/sell.js"></script>
	<script>
		var cal1 = new JKL.Calendar("cal1", "form", "sSearchFrom");
		var cal2 = new JKL.Calendar("cal2", "form", "sSearchTo");
	</script>
	<h1>売主物件一覧</h1>

	<form name="form" id="form" action="index.php" method="post">
		<input type="hidden" name="act" value="sellSearch" />
		<input type="hidden" name="orderBy" value="<?php print $param["orderBy"] ?>" />
		<input type="hidden" name="orderTo" value="<?php print $param["orderTo"] ?>" />
		<input type="hidden" name="sPage" value="<?php print $param["sPage"] ?>" />
		<input type="hidden" name="sellNo" />

		<a href="javascript:form.act.value='sellEdit';form.submit();"><img src="./images/btn_enter.png"></a>

		<div class="search">
			<table border="0" cellpadding="2" cellSpacing="0">
				<tr>
					<th>検索日</th>
					<td colspan="6">
						<input type="text" name="sSearchFrom" value="<?php print $param["sSearchFrom"] ?>" size="15" />
						<a href="javascript:cal1.write();" onChange="cal1.getFormValue(); cal1.hide();">
							<img src="./images/b_calendar.png">
						</a>
						<span id="cal1"></span>～
						<input type="text" name="sSearchTo" value="<?php print $param["sSearchTo"] ?>" size="15" />
						<a href="javascript:cal2.write();" onChange="cal2.getFormValue(); cal2.hide();">
							<img src="./images/b_calendar.png">
						</a>
						<span id="cal2"></span>
					</td>
				</tr>

				<tr>
					<th>物件名</th>
					<td colspan="6"><input type="text" name="sArticle" value="<?php print $param["sArticle"] ?>" size="100" /></td>
				</tr>

				<tr>
					<th>住所</th>
					<td colspan="6"><input type="text" name="sAddress" value="<?php print $param["sAddress"] ?>" size="100" /></td>
				</tr>

				<tr>
					<th>駅</th>
					<td><input type="text" name="sStation" value="<?php print $param["sStation"] ?>" size="30" /></td>
					<th>徒歩</th>
					<td>
						<select name="sFoot">
							<option value="0">-----</option>
							<?php
							for ($i = 5; $i <= 60; $i += 5) {
							?>
								<option value="<?php print $i ?>" <?php if ($i == $param["sFoot"]) print ' selected="selected"' ?>><?php print $i ?></option>
							<?php
							}
							?>
						</select>分
						<select name="sFootC">
							<option value="0">以下</option>
							<option value="1" <?php if ($param["sFootC"] == '1') print ' selected="selected"' ?>>以上</option>
							<option value="2" <?php if ($param["sFootC"] == '2') print ' selected="selected"' ?>>一致</option>
						</select>
					</td>

					<th>専有面積</th>
					<td>
						<input type="text" name="sAreaFrom" value="<?php print $param["sAreaFrom"] ?>" size="10" />㎡ ～
						<input type="text" name="sAreaTo" value="<?php print $param["sAreaTo"] ?>" size="10" />㎡
					</td>
				</tr>
				<tr>
					<th>築年</th>
					<td><input type="text" name="sYearsFrom" value="<?php print $param["sYearsFrom"] ?>" size="10" /> 年～
						<input type="text" name="sYearsTo" value="<?php print $param["sYearsTo"] ?>" size="10" /> 年
					</td>
					<th>価格</th>
					<td><input type="text" name="sPriceFrom" value="<?php print $param["sPriceFrom"] ?>" size="10" /> 万～
						<input type="text" name="sPriceTo" value="<?php print $param["sPriceTo"] ?>" size="10" /> 万
					</td>
				</tr>
				<tr>
					<th>売主</th>
					<td colspan="6"><input type="text" name="sSeller" value="<?php print $param["sSeller"] ?>" size="100" /></td>
				</tr>
			</table>
		</div>

		<input type="image" src="./images/btn_search.png" onclick="form.act.value='sellSearch';form.sPage.value=1;form.submit();" />

		<hr />

		<?php
		if ($_REQUEST['act'] == 'sell') {
			return;
		}

		$sql = fnSqlSellList(0, $param);
		$res = mysqli_query($param["conn"], $sql);
		$row = mysqli_fetch_array($res);

		$count = $row[0];

		$sPage = fnPage($count, $param["sPage"], 'sellSearch');
		?>

		<div class="list">
			<table border="0" cellpadding="5" cellspacing="1">
				<tr>
					<th class="list_head">日付<?php fnOrder('SEARCHDT', 'sellSearch') ?></th>
					<th class="list_head">物件名</th>
					<th class="list_head">住所<?php fnOrder('ADDRESS', 'sellSearch') ?></th>
					<th class="list_head">駅</th>
					<th class="list_head">徒歩</th>
					<th class="list_head">築年</th>
					<th class="list_head">階数</th>
					<th class="list_head">専有面積</th>
					<th class="list_head">売主<?php fnOrder('SELLER', 'sellSearch') ?></th>
					<th class="list_head">価格</th>
					<th class="list_head">備考</th>
					<th class="list_head">&nbsp;</th>
				</tr>
				<?php
				$sql  = fnSqlSellList(1, $param);
				$res  = mysqli_query($param["conn"], $sql);
				$i = 0;
				while ($row = mysqli_fetch_array($res)) {
					$sellNo   = htmlspecialchars($row[0]);
					$searchDT = htmlspecialchars($row[1]);
					$article  = htmlspecialchars($row[2]);
					$address  = htmlspecialchars($row[3]);
					$station  = htmlspecialchars($row[4]);
					$foot     = htmlspecialchars($row[5]);
					$years    = htmlspecialchars($row[6]);
					$floor    = htmlspecialchars($row[7]);
					$area     = htmlspecialchars($row[8]);
					$seller   = htmlspecialchars($row[9]);
					$price    = htmlspecialchars(fnNumFormat($row[10]));
					$note     = htmlspecialchars($row[11]);
				?>
					<tr>
						<td class="list_td<?php print $i ?>"><?php print $searchDT ?></td>
						<td class="list_td<?php print $i ?>"><?php print $article ?></td>
						<td class="list_td<?php print $i ?>"><?php print $address ?></td>
						<td class="list_td<?php print $i ?>"><?php print $station ?></td>
						<td class="list_td<?php print $i ?>"><?php print $foot ?></td>
						<td class="list_td<?php print $i ?>"><?php print $years ?></td>
						<td class="list_td<?php print $i ?>"><?php print $floor ?></td>
						<td class="list_td<?php print $i ?>" align="right"><?php print $area ?></td>
						<td class="list_td<?php print $i ?>"><?php print $seller ?></td>
						<td class="list_td<?php print $i ?>" align="right"><?php print $price ?>万</td>
						<td class="list_td<?php print $i ?>"><?php print $note ?></td>
						<td class="list_td<?php print $i ?>"><a href="javascript:form.act.value='sellEdit';form.sellNo.value=<?php print $sellNo ?>;form.submit();"><img src="./images/edit.png" /></a>
							<a href="javascript:fnSellDeleteCheck(<?php print $sellNo ?>,'<?php print $article ?>');"><img src="./images/delete.png" /></a>
						</td>
					</tr>
				<?php
					$i = ($i + 1) % 2;
				}
				?>
			</table>
		</div>

		<?php
		$sPage = fnPage($count, $param["sPage"], 'sellSearch');
		?>

	</form>
<?php
}




//
//売主物件編集画面
//
function subSellEditView($param)
{

?>
	<script type="text/javascript" src="./js/sell.js"></script>
	<script>
		var cal1 = new JKL.Calendar("cal1", "form", "searchDT");
	</script>

	<h1>売主物件<?php print $param["purpose"] ?></h1>

	<form name="form" id="form" action="index.php" method="post">
		<input type="hidden" name="act" />
		<input type="hidden" name="sSearchFrom" value="<?php print $param["sSearchFrom"] ?>" />
		<input type="hidden" name="sSearchTo" value="<?php print $param["sSearchTo"] ?>" />
		<input type="hidden" name="sArticle" value="<?php print $param["sArticle"] ?>" />
		<input type="hidden" name="sAddress" value="<?php print $param["sAddress"] ?>" />
		<input type="hidden" name="sStation" value="<?php print $param["sStation"] ?>" />
		<input type="hidden" name="sFoot" value="<?php print $param["sFoot"] ?>" />
		<input type="hidden" name="sFootC" value="<?php print $param["sFootC"] ?>" />
		<input type="hidden" name="sAreaFrom" value="<?php print $param["sAreaFrom"] ?>" />
		<input type="hidden" name="sAreaTo" value="<?php print $param["sAreaTo"] ?>" />
		<input type="hidden" name="sYearsFrom" value="<?php print $param["sYearsFrom"] ?>" />
		<input type="hidden" name="sYearsTo" value="<?php print $param["sYearsTo"] ?>" />
		<input type="hidden" name="sPriceFrom" value="<?php print $param["sPriceFrom"] ?>" />
		<input type="hidden" name="sPriceTo" value="<?php print $param["sPriceTo"] ?>" />
		<input type="hidden" name="sSeller" value="<?php print $param["sSeller"] ?>" />
		<input type="hidden" name="orderBy" value="<?php print $param["orderBy"] ?>" />
		<input type="hidden" name="orderTo" value="<?php print $param["orderTo"] ?>" />
		<input type="hidden" name="sPage" value="<?php print $param["sPage"] ?>" />
		<input type="hidden" name="sellNo" value="<?php print $param["sellNo"] ?>" />

		<table border="0" cellpadding="5" cellspacing="1">
			<tr>
				<th>日付<span class="red">（必須）</span></th>
				<td><input type="text" name="searchDT" value="<?php print $param["searchDT"] ?>" /> <a href="javascript:cal1.write();" onChange="cal1.getFormValue(); cal1.hide();"><img src="./images/b_calendar.png"></a><span id="cal1"></td>
			</tr>
			<tr>
				<th>物件名<span class="red">（必須）</span></th>
				<td><input type="text" name="article" value="<?php print $param["article"] ?>" /></td>
			</tr>
			<tr>
				<th>住所<span class="red">（必須）</span></th>
				<td><input type="text" name="address" value="<?php print $param["address"] ?>" /></td>
			</tr>
			<tr>
				<th>駅</th>
				<td><input type="text" name="station" value="<?php print $param["station"] ?>" /></td>
			</tr>
			<tr>
				<th>徒歩<span class="red">（必須）</span></th>
				<td><input type="text" name="foot" value="<?php print $param["foot"] ?>" />分</td>
			</tr>
			<tr>
				<th>築年<span class="red">（必須）</span></th>
				<td><input type="text" name="years" value="<?php print $param["years"] ?>" />年</td>
			</tr>
			<tr>
				<th>階数<span class="red">（必須）</span></th>
				<td><input type="text" name="floor" value="<?php print $param["floor"] ?>" />階</td>
			</tr>
			<tr>
				<th>専有面積<span class="red">（必須）</span></th>
				<td><input type="text" name="area" value="<?php print $param["area"] ?>" />㎡</td>
			</tr>
			<tr>
				<th>売主<span class="red">（必須）</span></th>
				<td><input type="text" name="seller" value="<?php print $param["seller"] ?>" /></td>
			</tr>
			<tr>
				<th>価格<span class="red">（必須）</span></th>
				<td><input type="text" name="price" value="<?php print $param["price"] ?>" />万円</td>
			</tr>
			<tr>
				<th>備考</th>
				<td><textarea name="note" cols="50" rows="10"><?php print $param["note"] ?></textarea></td>
			</tr>
		</table>

		<a href="javascript:fnSellEditCheck();"><img src="./images/<?php print $param["btnImage"] ?>" /></a>　<a href="javascript:form.act.value='sellSearch';form.submit();"><img src="./images/btn_return.png" /></a>

	</form>

<?php
}
?>