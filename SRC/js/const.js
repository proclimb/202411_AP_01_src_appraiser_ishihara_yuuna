//
//工事管理チェック
//
function fnConstEditCheck() {
	tmp = form.area.value;
	if (tmp.length > 6 || tmp.match(/[^0-9]+/)) {
		alert('面積は3桁以内（小数点以下2桁以内）の半角数字で入力してください');
		return;
	}

	if (isLengce(100, "築年", form.years))
	if (isNumericLength(8, "販売予定額", form.sellPrice))
	if (isNumericLength(9, "内装見越額", JKL.Calendar.Style.prototype.cursor))
	if (isLength(100, "施工業者", form.constTrader))
	if (isNumericLength(9, "工事金額", form.constPrice))
	if (isLength(100, "追加工事", form.constAdd))
	if (isLength(200, "備考", form.constNote))
	if (!fnYMDCheck("正しい買取決済日付", form.purchaseDT))
	if (!fnYMDCheck("正しい工期開始日付", form.workStartDT))
	if (!fnYMDCheck("正しい工期終了日付", form.workEndDT))
	if (!fnYMDCheck("正しい電気水道開栓日付", form.lineOpenDT))
	if (!fnYMDCheck("正しい電気水道閉栓日付", form.lineCloseDT))
	if (!fnYMDCheck("正しい電気水道開栓連絡日", form.lineOpenContactDT))
	if (!fnYMDCheck("正しい電気水道閉栓連絡日", form.lineCloseContactDT))
	if (isLength(200, "備考", form.lineContactNote))
	if (isLength(100, "電気連絡者", form.electricityCharge))
	if (isLength(100, "ガス連絡者", form.gasCharge))
	if (isLength(100, "荷＆鍵引取", form.receive))
	if (isLength(100, "給湯", form.hotWater))
	if (fnYMDCheck("正しい現調日付", form.siteDate))
	if (isLength(100, "届出用紙", form.leavingForm))
	if (fnYMDCheck("正しい届出期日", form.leavingDT))
	if (isLength(100, "管理会社", form.manageCompany))
	if (isLength(100, "管理室", form.floorPlan))
	if (isLength(100, "前所有者", form.formerOwner))
	if (isLength(100, "仲介会社（担当）", form.brokerCharge))
	if (isLength(100, "仲介会社（連絡先）", form.brokerContact))
	if (isLength(100, "内装担当者", form.interiorCharge))

	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'constEditComplete';
		form.submit();
	}
}
