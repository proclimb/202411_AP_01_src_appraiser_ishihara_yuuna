//
//タイトル管理チェック
//
function fnFTitleEditCheck(zero) {

	tmp = form.classNo.value;
	if (tmp.length == 0) {
		alert('表示順を入力してください');
		return;
	}
	if (tmp.length > 2 || tmp.match(/[^0-9]+/)) {
		alert('表示順は2文字以内の半角数字で入力してください');
		return;
	}

	tmp = form.seqNo.value;
	if (zero !== 0) {
		if (tmp.length == 0) {
			alert('表示順を入力してください');
			return;
		}
		if (tmp == 0) {
			alert('0以外の数字を入力してください');
			return;
		}
		if (tmp.length > 2 || tmp.match(/[^0-9]+/)) {
			alert('表示順は2文字以内の半角数字で入力してください');
			return;
		}
	}

	tmp = form.name.value;
	if (tmp.length == 0) {
		alert('名前を入力してください');
		return;
	}
	if (tmp.length > 100) {
		alert('名前は100文字以内で入力してください');
		return;
	}

	if (confirm('この内容で登録します。よろしいですか？')) {
		form.act.value = 'fTitleEditComplete';
		form.submit();
	}
}



function fnFTitleDeleteCheck(no) {
	if (confirm('削除します。よろしいですか？')) {
		form.DocNo.value = no;
		form.act.value = 'fTitleDelete';
		form.submit();
	}
}
