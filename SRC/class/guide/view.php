<?php
//
//案内管理画面
//
function subGuideView($param)
{
?>
	<script type="text/javascript" src="./js/guide.js"></script>
	<script>
		var cal1 = new JKL.Calendar("cal1", "form", "sGuideDTFrom");
		var cal2 = new JKL.Calendar("cal2", "form", "sGuideDTTo");
		var cal3 = new JKL.Calendar("cal3", "form", "sAcceptDT");
	</script>

	<h1>案内管理一覧</h1>

	<form name="form" id="form" action="index.php" method="post">
		<input type="hidden" name="act" value="guideSearch" />
		<input type="hidden" name="orderBy" value="<?php print $param["orderBy"] ?>" />
		<input type="hidden" name="orderTo" value="<?php print $param["orderTo"] ?>" />
		<input type="hidden" name="sPage" value="<?php print $param["sPage"] ?>" />
		<input type="hidden" name="guideNo" />
		<input type="hidden" name="articleNo" />
		<input type="hidden" name="examNo[]" />
		<input type="hidden" name="purchaseNo[]" />

		<a href="javascript:form.act.value='guideChoice';form.submit();"><img src="./images/btn_enter.png"></a>

		<div class="search">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr>
					<th>案内日</th>
					<td>
						<input type="text" name="sGuideDTFrom" value="<?php print $param["sGuideDTFrom"] ?>" size="15" />
						<a href="javascript:cal1.write();" onChange="cal1.getFormValue(); cal1.hide();"><img src="./images/b_calendar.png"></a><span id="cal1"></span>～
						<input type="text" name="sGuideDTTo" value="<?php print $param["sGuideDTTo"] ?>" size="15" />
						<a href="javascript:cal2.write();" onChange="cal2.getFormValue(); cal2.hide();"><img src="./images/b_calendar.png"></a><span id="cal2"></span>
					</td>
					<th>TEL</th>
					<td><input type="text" name="sTel" value="<?php print $param["sTel"] ?>" size="30" /></td>
				</tr>
				<tr>
					<th>物件名</th>
					<td><input type="text" name="sArticle" value="<?php print $param["sArticle"] ?>" size="50" /></td>
					<th>FAX</th>
					<td><input type="text" name="sFax" value="<?php print $param["sFax"] ?>" size="30" /><br />
				</tr>
				<tr>
					<th>部屋番号</th>
					<td><input type="text" name="sRoom" value="<?php print $param["sRoom"] ?>" size="30" /></td>
					<th>担当</th>
					<td><input type="text" name="sCharge" value="<?php print $param["sCharge"] ?>" size="30" /></td>
				</tr>
				<tr>
					<th>業者名</th>
					<td><input type="text" name="sName" value="<?php print $param["sName"] ?>" size="30" /></td>
					<th>受付日</th>
					<td>
						<input type="text" name="sAcceptDT" value="<?php print $param["sAcceptDT"] ?>" size="15" />
						<a href="javascript:cal3.write();" onChange="cal3.getFormValue(); cal3.hide();"><img src="./images/b_calendar.png"></a><span id="cal3"></span>
					</td>
				</tr>
				<tr>
					<th>営業店</th>
					<td><input type="text" name="sBranch" value="<?php print $param["sBranch"] ?>" size="30" /></td>
					<th>受付</th>
					<td><input type="text" name="sAccept" value="<?php print $param["sAccept"] ?>" size="30" /></td>
				</tr>
				<tr>
					<th>営業担当者</th>
					<td><input type="text" name="sSellCharge" value="<?php print $param["sSellCharge"] ?>" size="30" /></td>
					<th>内容</th>
					<td>
						<input type="checkbox" name="sContent1" value="1" <?php if ($param["sContent1"] == 1) {
																				print ' checked="checked"';
																			} ?> /> <?php print fnContentName(0) ?>
						<input type="checkbox" name="sContent2" value="1" <?php if ($param["sContent2"] == 1) {
																				print ' checked="checked"';
																			} ?> /> <?php print fnContentName(1) ?>
						<input type="checkbox" name="sContent3" value="1" <?php if ($param["sContent3"] == 1) {
																				print ' checked="checked"';
																			} ?> /> <?php print fnContentName(2) ?>
					</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td>&nbsp;</td>
					<th>検討・買付</th>
					<td><input type="checkbox" name="sExam" value="1" <?php if ($param["sExam"] == 1) {
																			print ' checked="checked"';
																		} ?> /> 検討
						<input type="checkbox" name="sPurchase" value="1" <?php if ($param["sPurchase"] == 1) {
																				print ' checked="checked"';
																			} ?> /> 買付
					</td>
				</tr>
			</table>
		</div>

		<input type="image" src="./images/btn_search.png" onclick="form.act.value='guideSearch';form.sPage.value=1;form.submit();" />

		<hr />
	</form>
	<?php
	if ($_REQUEST['act'] == 'guide') {
		return;
	}

	$sql = fnSqlGuideList(0, $param);
	$res = mysqli_query($param["conn"], $sql);
	$row = mysqli_fetch_array($res);

	$count = $row[0];

	$param["sPage"] = fnPage($count, $param["sPage"], 'guideSearch');
	?>

	<div class="list">
		<table border="0" cellpadding="5" cellspacing="1">
			<tr>
				<th class="list_head">内容<?php fnOrder('A.CONTENT', 'guideSearch'); ?></th>
				<th class="list_head">案内日<?php fnOrder('GUIDESTARTDT', 'guideSearch'); ?></th>
				<th class="list_head">物件名<?php fnOrder('B.ARTICLE', 'guideSearch'); ?></th>
				<th class="list_head">部屋番号<?php fnOrder('B.ROOM', 'guideSearch'); ?></th>
				<th class="list_head">業者名<?php fnOrder('A.NAME', 'guideSearch'); ?></th>
				<th class="list_head">FAX</th>
				<th class="list_head">結果</th>
				<th class="list_head">受付日<br />受付</th>
				<th class="list_head">鍵詳細</th>
				<th class="list_head">検討</th>
				<th class="list_head">買付</th>
			</tr>
			<?php
			$sql = fnSqlGuideList(1, $param);
			$res = mysqli_query($param["conn"], $sql);
			$i = 0;
			while ($row = mysqli_fetch_array($res)) {
				$guideNo      = htmlspecialchars($row["GUIDENO"]);
				$content      = htmlspecialchars($row["CONTENT"]);
				$guideStartDT = htmlspecialchars($row["GUIDESTARTDT"]);
				$guideEndDT   = htmlspecialchars($row["GUIDEENDDT"]);
				$guideStartTM = htmlspecialchars($row["GUIDESTARTTM"]);
				$guideEndTM   = htmlspecialchars($row["GUIDEENDTM"]);
				$articleNo    = htmlspecialchars($row["ARTICLENO"]);
				$name         = htmlspecialchars($row["NAME"]);
				$fax          = htmlspecialchars($row["FAX"]);
				$result       = htmlspecialchars($row["RESULT"]);
				$acceptDT     = htmlspecialchars($row["ACCEPTDT"]);
				$accept       = htmlspecialchars($row["ACCEPT"]);
				$exam         = htmlspecialchars($row["EXAM"]);
				$purchase     = htmlspecialchars($row["PURCHASE"]);
				$article      = htmlspecialchars($row["ARTICLE"]);
				$room         = htmlspecialchars($row["ROOM"]);

			?>
				<tr>
					<td class="list_td<?php print $i ?>"><?php print fnContentName($content - 1) ?></td>
					<td class="list_td<?php print $i ?>">
						<?php print $guideStartDT ?>
						<?php
						if ($guideEndDT != '') {
							print " ～ ";
						}
						print $guideEndDT;
						?>
						<?php
						if ($guideStartTM != '') print "<br />";
						print $guideStartTM;
						?>
						<?php
						if ($guideEndTM != '') print ' ～ ' . $guideEndTM;
						?>
					</td>
					<td class="list_td<?php print $i ?>"><a href="javascript:form.act.value='guideEdit';form.guideNo.value=<?php print $guideNo ?>;form.submit();"><?php print $article ?></a></td>
					<td class="list_td<?php print $i ?>"><?php print $room ?></td>
					<td class="list_td<?php print $i ?>">
						<a href="#" onclick="window.open('./index.php?act=guideShowTrade&guideNo=<?php print $guideNo ?>','情報詳細','width=500,height=400');return false;"><?php print $name ?></a>
					</td>
					<td class="list_td<?php print $i ?>"><?php print $fax ?></td>
					<td class="list_td<?php print $i ?>"><?php print $result ?></td>
					<td class="list_td<?php print $i ?>"><?php print $acceptDT ?><br /><?php print $accept ?></td>
					<td class="list_td<?php print $i ?>">
						<a href="#" onclick="window.open('./index.php?act=guideShowKey&articleNo=<?php print $articleNo ?>','情報詳細','width=500,height=400');return false;">鍵詳細</a>
					</td>
					<td class="list_td<?php print $i ?>"><?php if ($exam == 1) print '○' ?></td>
					<td class="list_td<?php print $i ?>"><?php if ($purchase == 1) print '○' ?></td>
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
//案内管理業者表示画面
//
function subGuideShowTradeView($param)
{
?>
	<div class="list">
		<table border="0" cellpadding="5" cellspacing="1">
			<tr>
				<th class="list_head">業者名</th>
				<td><?php print $param["name"] ?></td>
			</tr>
			<tr>
				<th class="list_head">営業店</th>
				<td><?php print $param["branch"] ?></td>
			</tr>
			<tr>
				<th class="list_head">TEL</th>
				<td><?php print $param["tel"] ?></td>
			</tr>
			<tr>
				<th class="list_head">FAX</th>
				<td><?php print $param["fax"] ?></td>
			</tr>
			<tr>
				<th class="list_head">担当</th>
				<td><?php print $param["charge"] ?></td>
			</tr>
		</table>
	</div>
<?php
}



//
//案内管理物件表示画面
//
function subGuideShowKeyView($param)
{
?>
	<div class="list">
		<table border="0" cellpadding="5" cellspacing="1">
			<tr>
				<th class="list_head">物件名</th>
				<td><?php print $param["article"] ?></td>
			</tr>
			<tr>
				<th class="list_head">部屋番号</th>
				<td><?php print $param["room"] ?></td>
			</tr>
			<tr>
				<th class="list_head">鍵場所</th>
				<td><?php print $param["keyPlace"] ?></td>
			</tr>
			<tr>
				<th class="list_head">備考</th>
				<td><?php print $param["articleNote"] ?></td>
			</tr>
			<tr>
				<th class="list_head">キーBox番号</th>
				<td><?php print $param["keyBox"] ?></td>
			</tr>
			<tr>
				<th class="list_head">3Dパース</th>
				<td><?php print $param["drawing"] ?></td>
			</tr>
			<tr>
				<th class="list_head">工期</th>
				<td><?php print $param["workStartDT"] ?>～<?php print $param["workEndDT"] ?></td>
			</tr>
			<tr>
				<th class="list_head">営業担当者</th>
				<td><?php print $param["sellCharge"] ?></td>
			</tr>
		</table>
	</div>
<?php
}



//
// 物件検索選択画面
//
function subGuideChoiceView($param)
{
?>
	<script type="text/javascript" src="./js/guide.js"></script>
	<script type="text/javascript" src="./js/jquery-1.4.min.js"></script>

	<h1>物件検索</h1>

	<form name="form" id="form" action="index.php" method="post">

		除外：<input type="checkbox" name="cDel" value="0" <?php if ($param["cDel"] == 0) print ' checked="checked"' ?> /><br />

		物件名：<input type="text" name="cArticle" value="<?php print $param["cArticle"] ?>" /><br />

		部屋番号：<input type="text" name="cRoom" value="<?php print $param["cRoom"] ?>" /><br />

		<input type="image" src="./images/btn_search.png" onclick="form.sPage.value=1;form.submit();" />

		<hr />
		<?php
		if ($_REQUEST['act'] == 'guideChoiceSearch') {

			$sql = fnSqlGuideArticleList(0, $param);
			$res = mysqli_query($param["conn"], $sql);
			$row = mysqli_fetch_array($res);

			$count = $row[0];

			$sPage = fnPage($count, $param['sPage'], 'guideChoiceSearch');
		?>

			<table border="0" cellpadding="0" cellspacing="0" width="820px">
				<tr>
					<td valign="top">
						<div class="list">
							<table id="search" border="0" cellpadding="5" cellspacing="1" width="400px">
								<tr>
									<th class="list_head">物件名<?php fnOrder('ARTICLE', 'guideChoiceSearch'); ?></th>
									<th class="list_head">部屋<?php fnOrder('ROOM', 'guideChoiceSearch'); ?></th>
									<th class="list_head">鍵場所</th>
									<th class="list_head">登録</th>
								</tr>
								<?php
								$sql = fnSqlGuideArticleList(1, $param);
								$res = mysqli_query($param["conn"], $sql);
								$i = 0;
								while ($row = mysqli_fetch_array($res)) {
									$articleNo = htmlspecialchars($row["ARTICLENO"]);
									$article   = htmlspecialchars($row["ARTICLE"]);
									$room      = htmlspecialchars($row["ROOM"]);
								?>
									<tr id="s<?php print $articleNo ?>">
										<td class="list_td<?php print $i ?>"><?php print $article ?></td>
										<td class="list_td<?php print $i ?>"><?php print $room ?></td>
										<td class="list_td<?php print $i ?>">
											<a href="#" onclick="window.open('./index.php?act=guideShowKey&articleNo=<?php print $articleNo ?>','情報詳細','width=500,height=400');return false;">鍵詳細</a>
										</td>
										<td class="list_td<?php print $i ?>">
											<input type="button" value="&gt;" onClick="fnGuideMove( 'toRight', <?php print $articleNo ?> );" />
										</td>
									</tr>
								<?php
									$i = ($i + 1) % 2;
								}
								?>
							</table>
						</div>
					</td>

					<td width="20px">&nbsp;</td>

					<td valign="top">

						<div class="list">
							<table id="regist" border="0" cellpadding="5" cellspacing="1" width="400px">
								<tr>
									<th class="list_head">削除</th>
									<th class="list_head">物件名</th>
									<th class="list_head">部屋</th>
									<th class="list_head">鍵場所</th>
								</tr>
								<?php
								$i = 0;
								if (!empty($param["articleList"])) {
									foreach ($param["articleList"] as $row) {
								?>
										<tr id="r<?php print $row["articleNo"] ?>">
											<td class="list_td<?php print $i ?>">
												<input type="button" value="&lt;" onClick="fnGuideMove( 'toLeft', <?php print $row['articleNo'] ?> );" />
												<input type="hidden" name="articleList[<?php print $row["articleNo"] ?>][articleNo]" value="<?php print $row["articleNo"] ?>" />
												<input type="hidden" name="articleList[<?php print $row["articleNo"] ?>][article]" value="<?php print $row["article"] ?>" />
												<input type="hidden" name="articleList[<?php print $row["articleNo"] ?>][room]" value="<?php print $row["room"] ?>" />
											</td>
											<td class="list_td<?php print $i ?>"><?php print $row["article"] ?></td>
											<td class="list_td<?php print $i ?>"><?php print $row["room"] ?></td>
											<td class="list_td<?php print $i ?>">
												<a href="#" onclick="window.open('./index.php?act=guideShowKey&articleNo=<?php print $row["articleNo"] ?>','情報詳細','width=500,height=400');return false;">鍵詳細</a>
											</td>
										</tr>
								<?php
										$i = ($i + 1) % 2;
									}
								}
								?>
							</table>
							<a href="javascript:fnGuideRegistCheck();"><img src="./images/btn_enter.png"></a>
						</div>
					</td>
				</tr>
			</table>
		<?php
		}
		?>
		<input type="hidden" name="act" value="guideChoiceSearch" />
		<input type="hidden" name="articleNo" />
		<input type="hidden" name="sPage" value="<?php print $param["sPage"] ?>" />
		<input type="hidden" name="orderBy" value="<?php print $param["orderBy"] ?>" />
		<input type="hidden" name="orderTo" value="<?php print $param["orderTo"] ?>" />
		<?php
		$black_list = array("conn", "articleList", "cDel", "cArticle", "cRoom", "orderBy", "orderTo", "sPage");
		hiddenForm($param, $black_list);
		?>
	</form>
<?php
}



//
//案内管理編集画面
//
function subGuideEditView($param)
{
?>
	<script type="text/javascript" src="./js/guide.js"></script>
	<script type="text/javascript" src="./js/jquery-1.4.min.js"></script>

	<h1>案内<?php print $param["purpose"] ?></h1>

	<form name="form" id="form" action="index.php" method="post">
		<?php
		$cnt = count($param["articleList"]);
		if ($cnt > 1) {
			// 複数登録を行う時は、一括入力画面を表示する
		?>
			<script>
				var inputCal = new JKL.Calendar("inputCal", "form", "input[acceptDT]");
				$(function() {

					$("#inputName").focus().blur(function() {
						setItem(this, "name");
					});

					$("#inputBranch").blur(function() {
						setItem(this, "branch");
					});

					$("#inputTel").blur(function() {
						setItem(this, "tel");
					});

					$("#inputFax").blur(function() {
						setItem(this, "fax");
					});

					$("#inputCharge").blur(function() {
						setItem(this, "charge");
					});

					$("#inputAcceptDT").blur(function() {
						setItem(this, "acceptDT");
					}).change(function() {
						setItem(this, "acceptDT");
					});

					$("#inputAccept").blur(function() {
						setItem(this, "accept");
					});
				});

				function setItem(obj, name) {
					var cnt = document.form.cnt.value;
					for (i = 0; i < cnt; i++) {
						var editObj = getEditObject(i, name);
						editObj.value = obj.value;
					}
				}
			</script>
			<table border="0" cellspacing="5" cellpadding="1">
				<tr>
					<th>業者名</th>
					<td><input type="text" name="input[name]" id="inputName" value="<?php print($param["input"]["name"]) ?>" /></td>
					<th>営業店</th>
					<td><input type="text" name="input[branch]" id="inputBranch" value="<?php print($param["input"]["branch"]) ?>" /></td>
				</tr>
				<tr>
					<th>TEL</th>
					<td><input type="text" name="input[tel]" id="inputTel" value="<?php print($param["input"]["tel"]) ?>" /></td>
					<th>FAX</th>
					<td><input type="text" name="input[fax]" id="inputFax" value="<?php print($param["input"]["fax"]) ?>" /></td>
				</tr>
				<tr>
					<th>担当</th>
					<td colspan="3"><input type="text" name="input[charge]" id="inputCharge" value="<?php print($param["input"]["charge"]) ?>" /></td>
				</tr>
				<tr>
					<th>受付日</th>
					<td colspan="3">
						<input type="text" name="input[acceptDT]" id="inputAcceptDT" value="<?php print($param["input"]["acceptDT"]) ?>" />
						<a href="javascript:inputCal.write();" onChange="inputCal.getFormValue(); inputCal.hide();">
							<img src="./images/b_calendar.png"></a><span id="inputCal"></span>
					</td>
				</tr>
				<tr>
					<th>受付</th>
					<td colspan="3"><input type="text" name="input[accept]" id="inputAccept" value="<?php print($param["input"]["accept"]) ?>" /></td>
				</tr>
			</table>
			<hr />
		<?php
		}
		$cnt = 0;
		$calCnt = 0;
		foreach ($param["articleList"] as $row) {
			if ($cnt != 0) {
				print("<hr />");
			}
			$cal1 = "cal" . ($calCnt + 1);
			$cal2 = "cal" . ($calCnt + 2);
			$cal3 = "cal" . ($calCnt + 3);
			$nameAttr = "edit[" . $cnt . "]";
		?>

			<script>
				var <?php print $cal1 ?> = new JKL.Calendar("<?php print $cal1 ?>", "form", "<?php print($nameAttr . "[guideStartDT]") ?>");
				var <?php print $cal2 ?> = new JKL.Calendar("<?php print $cal2 ?>", "form", "<?php print($nameAttr . "[guideEndDT]") ?>");
				var <?php print $cal3 ?> = new JKL.Calendar("<?php print $cal3 ?>", "form", "<?php print($nameAttr . "[acceptDT]") ?>");
			</script>

			<input type="hidden" name="<?php print($nameAttr . "[guideNo]") ?>" value="<?php print $param["guideNo"] ?>" />
			<input type="hidden" name="<?php print($nameAttr . "[articleNo]") ?>" value="<?php print $row["articleNo"] ?>" />
			<table border="0" cellpadding="5" cellspacing="1">
				<tbody>
					<tr>
						<th>内容</th>
						<td colspan="3">
							<input type="radio" name="<?php print($nameAttr . "[content]") ?>" value="1" checked="checked" /> <?php print fnContentName(0) ?>
							<?php for ($i = 1; $i < 3; $i++) { ?>
								<input type="radio" name="<?php print($nameAttr . "[content]") ?>" value="<?php print $i + 1 ?>" <?php if ($param["content"] == $i + 1) print ' checked="checked"' ?> /> <?php print fnContentName($i) ?>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<th>案内日<span class="red">（必須）</span></th>
						<td colspan="3">
							<input type="text" name="<?php print($nameAttr . "[guideStartDT]") ?>" value="<?php print $param["guideStartDT"] ?>" />
							<a href="javascript:<?php print $cal1 ?>.write();" onChange="<?php print $cal1 ?>.getFormValue(); <?php print $cal1 ?>.hide();">
								<img src="./images/b_calendar.png"></a><span id="<?php print $cal1 ?>"></span>&nbsp;～&nbsp;
							<input type="text" name="<?php print($nameAttr . "[guideEndDT]") ?>" value="<?php print $param["guideEndDT"] ?>" />
							<a href="javascript:<?php print $cal2 ?>.write();" onChange="<?php print $cal2 ?>.getFormValue(); <?php print $cal2 ?>.hide();">
								<img src="./images/b_calendar.png"></a><span id="<?php print $cal2 ?>"></span>
						</td>
					</tr>
					<tr>
						<th>時間</th>
						<td colspan="3">
							<select name="<?php print($nameAttr . "[guideStartHour]") ?>">
								<?php for ($i = 0; $i < 24; $i++) { ?>
									<option value="<?php print $i ?>" <?php if ($i == $param["guideStartHour"]) print ' selected="selected"' ?>><?php print $i ?></option>
								<?php } ?>
							</select>：
							<select name="<?php print($nameAttr . "[guideStartMinute]") ?>">
								<?php for ($i = 0; $i < 60; $i++) { ?>
									<option value="<?php print $i ?>" <?php if ($i == $param["guideStartMinute"]) print ' selected="selected"' ?>><?php print $i ?></option>
								<?php } ?>
							</select>～
							<select name="<?php print($nameAttr . "[guideEndHour]") ?>">
								<?php for ($i = 0; $i < 24; $i++) { ?>
									<option value="<?php print $i ?>" <?php if ($i == $param["guideEndHour"]) print ' selected="selected"' ?>><?php print $i ?></option>
								<?php } ?>
							</select>：
							<select name="<?php print($nameAttr . "[guideEndMinute]") ?>">
								<?php for ($i = 0; $i < 60; $i++) { ?>
									<option value="<?php print $i ?>" <?php if ($i == $param["guideEndMinute"]) print ' selected="selected"' ?>><?php print $i ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<th>物件名</th>
						<td><?php print $row["article"] ?></td>
						<th>部屋番号</th>
						<td><?php print $row["room"] ?></td>
					</tr>
					<tr>
						<th>業者名</th>
						<td><input type="text" name="<?php print($nameAttr . "[name]") ?>" value="<?php print $param["name"] ?>" /></td>
						<th>営業店</th>
						<td><input type="text" name="<?php print($nameAttr . "[branch]") ?>" value="<?php print $param["branch"] ?>" /></td>
					</tr>
					<tr>
						<th>TEL</th>
						<td><input type="text" name="<?php print($nameAttr . "[tel]") ?>" value="<?php print $param["tel"] ?>" /></td>
						<th>FAX</th>
						<td><input type="text" name="<?php print($nameAttr . "[fax]") ?>" value="<?php print $param["fax"] ?>" /></td>
					</tr>
					<tr>
						<th>担当</th>
						<td colspan="3"><input type="text" name="<?php print($nameAttr . "[charge]") ?>" value="<?php print $param["charge"] ?>" /></td>
					</tr>
					<tr>
						<th>結果</th>
						<td colspan="3"><textarea name="<?php print($nameAttr . "[result]") ?>" cols="50" rows="10"><?php print $param["result"] ?></textarea></td>
					</tr>
					<tr>
						<th>受付日</th>
						<td colspan="3">
							<input type="text" name="<?php print($nameAttr . "[acceptDT]") ?>" value="<?php print $param["acceptDT"] ?>" />
							<a href="javascript:<?php print $cal3 ?>.write();" onChange="<?php print $cal3 ?>.getFormValue(); <?php print $cal3 ?>.hide();">
								<img src="./images/b_calendar.png"></a><span id="<?php print $cal3 ?>"></span>
						</td>
					</tr>
					<tr>
						<th>受付</th>
						<td colspan="3"><input type="text" name="<?php print($nameAttr . "[accept]") ?>" value="<?php print $param["accept"] ?>" /></td>
					</tr>
					<tr>
						<th>検討</th>
						<td><input type="checkbox" name="<?php print($nameAttr . "[exam]") ?>" value="1" <?php if ($param["exam"] == 1) print ' checked="checked"' ?> /></td>
						<th>買付</th>
						<td><input type="checkbox" name="<?php print($nameAttr . "[purchase]") ?>" value="1" <?php if ($param["purchase"] == 1) print ' checked="checked"' ?> /></td>
					</tr>
				</tbody>
			</table>
		<?php
			$cnt++;
			$calCnt += 3;
		}
		?>
		<a href="javascript:fnGuideEditCheck();"><img src="./images/<?php print $param["btnImage"] ?>" /></a>　
		<a href="javascript:form.act.value='guideSearch';form.submit();"><img src="./images/btn_return.png" /></a>　
		<?php if ($param["guideNo"]) { ?>
			<a href="javascript:fnGuideDeleteCheck(<?php print $param["guideNo"] ?>);"><img src="./images/btn_del.png" /></a>
		<?php } ?>

		<input type="hidden" name="cnt" value="<?php print $cnt ?>" />
		<input type="hidden" name="act" />
		<?php
		$black_list = array("conn", "articleList");
		hiddenForm($param, $black_list);
		?>
	</form>
<?php
}
?>