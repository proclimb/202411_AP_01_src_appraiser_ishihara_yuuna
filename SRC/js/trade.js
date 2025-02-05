//
//業者一覧チェック
//
function fnTradeEditCheck() {
	tmp = form.name.value;
	if (tmp.length == 0) {
		alert('業者名を入力してください');
		return;
	}
	if (tmp.length > 100) {
		alert('業者名は100文字以内で入力してください');
		return;
	}

	tmp = form.nameFuri.value;
	if (tmp.length > 100) {
		alert('業者名（よみ）は100文字以内で入力してください');
		return;
	}

	tmp = form.branch.value;
	if (tmp.length > 100) {
		alert('支店名は100文字以内で入力してください');
		return;
	}

	tmp = form.branchFuri.value;
	if (tmp.length > 100) {
		alert('支店名（よみ）は100文字以内で入力してください');
		return;
	}

	tmp = form.zip.value;
	if (tmp.length > 0 && !tmp.match(/^\d{3}(\s*|-)\d{4}$/)) {
		alert("正しい郵便番号(***-**** 又は ******* )で\n入力してください");
		return;
	}

	tmp = form.prefecture.value;
	if (tmp.length > 10) {
		alert('住所（都道府県）は10文字以内で入力してください');
		return;
	}

	tmp = form.address1.value;
	if (tmp.length > 100) {
		alert('住所1（市区町村名）は100文字以内で入力してください');
		return;
	}

	tmp = form.address2.value;
	if (tmp.length > 100) {
		alert('住所2（番地・ビル名）は100文字以内で入力してください');
		return;
	}

	tmp = form.tel.value;
	if (tmp.length > 100) {
		alert('TELは100文字以内で入力してください');
		return;
	}

	tmp = form.fax.value;
	if (tmp.length > 100) {
		alert('FAXは100文字以内で入力してください');
		return;
	}

	tmp = form.mobile.value;
	if (tmp.length > 100) {
		alert('携帯電話は100文字以内で入力してください');
		return;
	}

	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'tradeEditComplete';
		form.submit();
	}
}



function fnTradeDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		form.tradeNo.value = no;
		form.act.value = 'tradeDelete';
		form.submit();
	}
}
