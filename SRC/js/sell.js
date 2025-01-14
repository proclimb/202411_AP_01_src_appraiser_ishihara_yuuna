//
//売主物件チェック
//
function fnSellEditCheck() {

	tmp = form.searchDT.value;
	if (tmp.length == 0) {
		alert('日付を入力してください');
		return;
	}
	if (!fnYMDCheck("正しい日付", form.searchDT)) { return; }

	tmp = form.article.value;
	if (tmp.length == 0) {
		alert('物件名を入力してください');
		return;
	}
	if (tmp.length > 100) {
		alert('物件名は100文字以内で入力してください');
		return;
	}

	tmp = form.address.value;
	if (tmp.length == 0) {
		alert('住所を入力してください');
		return;
	}
	if (tmp.length > 100) {
		alert('住所は100文字以内で入力してください');
		return;
	}

	tmp = form.station.value;
	if (tmp.length > 100) {
		alert('駅は100文字以内で入力してください');
		return;
	}

	tmp = form.foot.value;
	if (tmp.length == 0) {
		alert('徒歩を入力してください');
		return;
	}
	if (tmp.length > 2 || tmp.match(/[^0-9]+/)) {
		alert('徒歩は2桁以内の半角数字で入力してください');
		return;
	}

	tmp = form.years.value;
	if (tmp.length == 0) {
		alert('築年を入力してください');
		return;
	}
	if (tmp.length != 4 || tmp.match(/[^0-9]+/)) {
		alert('築年は4桁の半角数字で入力してください');
		return;
	}

	tmp = form.floor.value;
	if (tmp.length == 0) {
		alert('階数を入力してください');
		return;
	}
	if (tmp.length > 2 || tmp.match(/[^0-9]+/)) {
		alert('階数は2桁以内の半角数字で入力してください');
		return;
	}

	tmp = form.area.value;
	if (tmp.length == 0) {
		alert('専有面積を入力してください');
		return;
	}
	if (tmp.length > 6 || tmp.match(/[^0-9\.]+/)) {
		alert('専有面積は3桁以内（小数点以下2桁以内）の半角数字で入力してください');
		return;
	}

	tmp = form.seller.value;
	if (tmp.length == 0) {
		alert('売主を入力してください');
		return;
	}
	if (tmp.length > 100) {
		alert('売主は100文字以内で入力してください');
		return;
	}

	tmp = form.price.value;
	if (tmp.length == 0) {
		alert('価格を入力してください');
		return;
	}
	if (tmp.length > 5 || tmp.match(/[^0-9]+/)) {
		alert('価格は5桁以内の半角数字で入力してください');
		return;
	}

	tmp = form.note.value;
	if (tmp.length > 200) {
		alert('備考は200文字以内で入力してください');
		return;
	}

	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'sellEditComplete';
		form.submit();
	}
}



function fnSellDeleteCheck(no, nm) {
	if (confirm('「' + nm + '」を削除します。よろしいですか？')) {
		form.sellNo.value = no;
		form.act.value = 'sellDelete';
		form.submit();
	}
}
